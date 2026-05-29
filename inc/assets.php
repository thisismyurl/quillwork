<?php
/**
 * [CORE] Asset enqueue — the cascade, in order.
 *
 * Block themes do not auto-load CSS on the front end, so the stylesheets are
 * enqueued explicitly here. They load in cascade order: the reset sheet first
 * (it declares the @layer order for the whole theme), then the core base, then
 * the skin. Because the layer order is declared once up front, rule arrival
 * order is actually irrelevant to the cascade — but each sheet still hangs off
 * the previous one as a dependency so the <link> order in the page is
 * deterministic and easy to read in View Source.
 *
 * Fonts load via theme.json @font-face (no render-blocking <link>), so there is
 * no font enqueue here — only an optional preload for the largest-paint glyph.
 *
 * Portable: every handle derives from the SLUG constant, so a re-skin needs no
 * edit. The list of sheets is fixed core; the skin sheet's CONTENT is the
 * theme's, but its path is stable.
 *
 * @package quillwork
 */

namespace quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the front-end stylesheets in cascade order.
 *
 * Cache-buster is each file's modification time, not the VERSION constant, so a
 * CSS edit busts caches immediately during iteration without a version bump.
 */
function enqueue_assets(): void {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	// Screen sheets, in cascade order. core/* is owned by Colophon and synced;
	// skin.css is the theme's own layout/components/blocks/utilities + its
	// binding of the --cl-* semantic tokens. Each depends on the previous so
	// the link order is deterministic.
	$sheets = array(
		'reset' => 'assets/css/core/reset.css', // [CORE] @layer order declaration + reset.
		'base'  => 'assets/css/core/base.css',  // [CORE] a11y scaffolding + semantic-token contract.
		'skin'  => 'assets/css/skin.css',       // [SKIN] this theme's personality.
	);

	$deps = array();
	foreach ( $sheets as $name => $rel ) {
		$path = $dir . '/' . $rel;
		if ( ! file_exists( $path ) ) {
			continue;
		}

		$handle = SLUG . '-' . $name;
		wp_enqueue_style( $handle, $uri . '/' . $rel, $deps, (string) filemtime( $path ) );
		$deps = array( $handle ); // Next sheet loads after this one.
	}

	// Print proof — media="print" so it never touches the screen render or the
	// @layer cascade. Browsers fetch print sheets lazily, so it adds no screen
	// cost. Its own filemtime cache-buster, same iteration story.
	$print = $dir . '/assets/css/core/print.css';
	if ( file_exists( $print ) ) {
		wp_enqueue_style(
			SLUG . '-print',
			$uri . '/assets/css/core/print.css',
			array(),
			(string) filemtime( $print ),
			'print'
		);
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );

/**
 * Preload the LCP-critical font, if the theme names one.
 *
 * Preloading the font that paints the largest headline shaves the swap-in.
 * Which font that is depends on the design, so core preloads nothing by default
 * and lets each theme declare its LCP font through the filter below (inc/skin.php
 * is the conventional home for that one-line opt-in). crossorigin is required
 * even for same-origin font fetches — fonts are always CORS-fetched.
 *
 * Entries are theme-root-relative paths (no leading slash); non-string and
 * off-origin entries are dropped so a filter can never become an injection or
 * an off-origin fetch.
 */
function preload_fonts(): void {
	/**
	 * Filters the list of fonts preloaded in the document head.
	 *
	 * Each entry is a theme-root-relative WOFF2 path (e.g.
	 * 'assets/fonts/family/file.woff2'). Default is empty — a theme opts in.
	 *
	 * @since 1.0.0
	 *
	 * @param string[] $fonts Theme-root-relative WOFF2 paths to preload.
	 */
	$fonts = (array) apply_filters( 'quillwork/preload_fonts', array() );

	foreach ( $fonts as $font ) {
		if ( ! is_string( $font ) || '' === $font || str_contains( $font, '://' ) ) {
			continue;
		}

		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( URI . '/' . ltrim( $font, '/' ) )
		);
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\\preload_fonts', 1 );
