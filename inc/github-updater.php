<?php
/**
 * [CORE][REMOVABLE] GitHub release updater — self-update from a GitHub repo's
 * "latest release" without a plugin, a service, or any external dependency.
 *
 * WordPress.org supplies updates for themes hosted there, and self-updaters are
 * disallowed in a .org submission. This file is the answer for the *other* case:
 * a theme distributed from a GitHub repo (private client work, a paid line, a
 * pre-.org beta) that still wants the one-click update banner in Appearance →
 * Themes. It speaks WordPress's own theme-update-transient protocol — no
 * Plugin/Theme Update Checker library, no phoning home anywhere but GitHub.
 *
 * HOW TO REMOVE IT — the headline feature, in one sentence: delete this file.
 * The loader in functions.php is wrapped in `file_exists( … )`, so removing
 * inc/github-updater.php disables the updater completely and safely, with no
 * other edit anywhere. Nothing else references this file at runtime.
 *
 * BEFORE A WORDPRESS.ORG SUBMISSION — remove it. .org provides the update path
 * there, and a theme that ships its own updater is rejected. Delete the file (and
 * drop the manifest `core` entry on the next CLI sync); the `file_exists` guard
 * means the deletion needs no companion change to functions.php.
 *
 * OPT-IN — silent until a theme names its repo. Core ships this dormant: it
 * no-ops unless `colophon/github_updater_repo` returns a non-empty 'owner/name'.
 * A theme opts in with one filter in its (CLI-never-overwritten) inc/skin.php:
 *
 *     add_filter( 'quillwork/github_updater_repo', static function () {
 *         return 'owner/repo';
 *     } );
 *
 * RELEASE CONTRACT — the GitHub release must carry a real `.zip` *asset* whose
 * filename starts with the theme slug (e.g. `colophon-1.3.0.zip`). We never fall
 * back to GitHub's auto-generated `zipball_url`: its archive's top-level folder
 * is `{owner}-{repo}-{sha}`, so WordPress would unpack the update into the wrong
 * directory and orphan the install. No matching asset → no update offered.
 *
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * How long a fetched "latest release" answer is cached, in seconds.
 *
 * GitHub allows 60 unauthenticated requests per hour per IP; the theme-update
 * transient is checked often (admin views and the twice-daily cron), so the
 * answer is cached to stay well clear of that ceiling. Six hours keeps updates
 * timely without ever approaching the limit.
 */
const GITHUB_UPDATER_CACHE_TTL = 6 * HOUR_IN_SECONDS;

/**
 * Resolve the configured 'owner/name' GitHub repo for self-updates.
 *
 * Empty by default — a theme opts in through the filter. The value is trimmed
 * and shape-checked to a single `owner/name` segment so a malformed filter
 * return can never become part of an API URL.
 *
 * @return string The validated 'owner/name', or '' when not opted in / invalid.
 */
function github_updater_repo(): string {
	/**
	 * Filters the GitHub repository this theme self-updates from.
	 *
	 * Return 'owner/name' (e.g. 'thisismyurl/thisismyurl-colophon') to enable
	 * GitHub-release updates; return '' (the default) to leave the updater
	 * dormant. Conventionally set in inc/skin.php, the per-theme file the CLI
	 * never overwrites.
	 *
	 * @since 1.3.0
	 *
	 * @param string $repo The 'owner/name' slug, or '' to disable.
	 */
	$repo = (string) apply_filters( 'quillwork/github_updater_repo', '' );
	$repo = trim( $repo );

	if ( ! preg_match( '#^[\w.-]+/[\w.-]+$#', $repo ) ) {
		return '';
	}

	return $repo;
}

/**
 * Inject an available GitHub release into the theme-update transient.
 *
 * Runs no-op fast when the theme hasn't opted in, so the early return is the
 * common path on every site that doesn't use the updater.
 *
 * @param mixed $transient The update_themes transient (object on a real check,
 *                         other types early in the request — passed through).
 * @return mixed The transient, unchanged unless a newer release is on offer.
 */
function github_updater_check( $transient ) {
	if ( ! is_object( $transient ) ) {
		return $transient;
	}

	$repo = github_updater_repo();
	if ( '' === $repo ) {
		return $transient;
	}

	$release = github_updater_fetch_release( $repo );
	if ( null === $release ) {
		return $transient;
	}

	$stylesheet      = get_stylesheet();
	$current_version = wp_get_theme()->get( 'Version' );
	$new_version     = ltrim( (string) $release['tag_name'], 'vV' );

	if ( '' === $new_version || version_compare( $new_version, (string) $current_version, '<=' ) ) {
		return $transient;
	}

	$package = github_updater_find_zip_asset( $release, $stylesheet );
	if ( '' === $package ) {
		// A newer tag exists but ships no slug-matching .zip asset; offering
		// GitHub's zipball would unpack into the wrong directory. No-op.
		return $transient;
	}

	$transient->response[ $stylesheet ] = array(
		'theme'       => $stylesheet,
		'new_version' => $new_version,
		'url'         => esc_url_raw( (string) ( $release['html_url'] ?? '' ) ),
		'package'     => $package,
	);

	return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', __NAMESPACE__ . '\\github_updater_check' );

/**
 * Fetch and cache the repo's latest release, returning the parsed payload.
 *
 * The whole method is failure-tolerant by design: a network error, a rate-limit,
 * a non-200, or malformed JSON all resolve to null, and the caller no-ops. The
 * answer is cached for GITHUB_UPDATER_CACHE_TTL under a SLUG-keyed transient so
 * repeated update checks make at most one request per cache window.
 *
 * @param string $repo Validated 'owner/name'.
 * @return array<string,mixed>|null The decoded release, or null on any failure.
 */
function github_updater_fetch_release( string $repo ): ?array {
	$cache_key = 'quillwork_gh_release_' . md5( SLUG . '|' . $repo );
	$cached    = get_transient( $cache_key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$response = wp_remote_get(
		'https://api.github.com/repos/' . $repo . '/releases/latest',
		array(
			'timeout'   => 5,
			'sslverify' => true,
			'headers'   => array(
				// GitHub rejects requests without a User-Agent; the Accept
				// header pins the stable v3 release media type.
				'User-Agent' => 'Colophon-Theme-Updater/' . VERSION,
				'Accept'     => 'application/vnd.github+json',
			),
		)
	);

	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		// Cache the miss briefly so a hard-down API or a rate-limit doesn't
		// re-fetch on every transient check until the window passes.
		set_transient( $cache_key, array(), 15 * MINUTE_IN_SECONDS );
		return null;
	}

	$release = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! is_array( $release ) || empty( $release['tag_name'] ) ) {
		set_transient( $cache_key, array(), 15 * MINUTE_IN_SECONDS );
		return null;
	}

	set_transient( $cache_key, $release, GITHUB_UPDATER_CACHE_TTL );

	return $release;
}

/**
 * Find the release's downloadable .zip asset whose name starts with the slug.
 *
 * Only a real uploaded asset is accepted — never GitHub's `zipball_url`, whose
 * archive nests everything under `{owner}-{repo}-{sha}` and would make WordPress
 * install the update into the wrong stylesheet directory.
 *
 * @param array<string,mixed> $release    Decoded release payload.
 * @param string              $stylesheet The installed theme's stylesheet slug.
 * @return string The asset's browser_download_url, or '' if none matches.
 */
function github_updater_find_zip_asset( array $release, string $stylesheet ): string {
	if ( empty( $release['assets'] ) || ! is_array( $release['assets'] ) ) {
		return '';
	}

	$prefix = strtolower( $stylesheet );

	foreach ( $release['assets'] as $asset ) {
		if ( ! is_array( $asset ) || empty( $asset['name'] ) || empty( $asset['browser_download_url'] ) ) {
			continue;
		}

		$name = strtolower( (string) $asset['name'] );

		if ( str_ends_with( $name, '.zip' ) && str_starts_with( $name, $prefix ) ) {
			return esc_url_raw( (string) $asset['browser_download_url'] );
		}
	}

	return '';
}

/**
 * Bust the cached release after any update completes.
 *
 * Without this, the just-installed version would keep showing as available until
 * the cache window lapsed. Fires on the WP_Upgrader completion hook regardless of
 * what was updated — cheap, and keeps the banner honest.
 */
function github_updater_flush_cache(): void {
	$repo = github_updater_repo();
	if ( '' === $repo ) {
		return;
	}

	delete_transient( 'quillwork_gh_release_' . md5( SLUG . '|' . $repo ) );
}
add_action( 'upgrader_process_complete', __NAMESPACE__ . '\\github_updater_flush_cache' );
