<?php
/**
 * [CORE] WP-CLI commands — operational handles for the theme.
 *
 * Loaded only in WP-CLI context (functions.php guards the require_once on
 * `defined( 'WP_CLI' ) && WP_CLI`), so there is zero front-end or admin overhead
 * from this file. The whole file is also self-guarded as a belt-and-braces measure
 * against a future loader change that drops the guard.
 *
 * Registers:
 *   wp quillwork version  — theme name and version, read from SLUG + VERSION.
 *   wp quillwork info     — name, version, active template, .pot presence.
 *   wp quillwork flush    — wp_cache_flush().
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;

if ( ! ( defined( 'WP_CLI' ) && \WP_CLI ) ) {
	return;
}

/**
 * Colophon: theme operations from the command line.
 */
class CLI_Command {

	/**
	 * Output the theme name and version.
	 *
	 * ## EXAMPLES
	 *
	 *     wp quillwork version
	 *
	 * @when after_wp_load
	 */
	public function version(): void {
		$theme = wp_get_theme();
		\WP_CLI::log( sprintf( '%s %s', (string) $theme->get( 'Name' ), VERSION ) );
	}

	/**
	 * Output theme name, version, active template, and translation status.
	 *
	 * ## EXAMPLES
	 *
	 *     wp quillwork info
	 *
	 * @when after_wp_load
	 */
	public function info(): void {
		$theme         = wp_get_theme();
		$template      = (string) get_template();
		$languages_dir = DIR . '/languages';
		$pot_path      = $languages_dir . '/' . SLUG . '.pot';
		$has_pot       = is_dir( $languages_dir ) && file_exists( $pot_path );

		\WP_CLI::log( 'Name:            ' . (string) $theme->get( 'Name' ) );
		\WP_CLI::log( 'Slug:            ' . SLUG );
		\WP_CLI::log( 'Version:         ' . VERSION );
		\WP_CLI::log( 'Active template: ' . $template );
		\WP_CLI::log( 'languages/.pot:  ' . ( $has_pot ? 'present' : 'missing — run: wp i18n make-pot . languages/' . SLUG . '.pot' ) );
	}

	/**
	 * Flush the object cache.
	 *
	 * ## EXAMPLES
	 *
	 *     wp quillwork flush
	 *
	 * @when after_wp_load
	 */
	public function flush(): void {
		wp_cache_flush();
		\WP_CLI::success( 'Done. Object cache flushed.' );
	}
}

\WP_CLI::add_command( 'quillwork', __NAMESPACE__ . '\\CLI_Command' );
