<?php
/**
 * [CORE] Asset enqueue — the cascade, in order.
 *
 * Block themes do not auto-load CSS on the front end, so stylesheets are
 * enqueued explicitly here in cascade order. The order is: reset (declares the
 * @layer order for the whole theme), then core base (a11y scaffolding), then
 * the skin (Quillwork's personality). Each sheet depends on the previous so the
 * <link> order in the page is deterministic.
 *
 * Fonts load via theme.json @font-face declarations — no render-blocking <link>
 * for fonts. An optional preload for the LCP-critical font fires separately via
 * the quillwork/preload_fonts filter (registered in inc/skin.php).
 *
 * Portable: every handle derives from the QUILLWORK_SLUG constant, so a re-skin needs no
 * edit. The sheet list is fixed [CORE]; the skin sheet's content is the theme's,
 * but its path is stable.
 *
 * Pillar 8 (Kodawari): cache-busting by file mtime, not QUILLWORK_VERSION, means a CSS
 * edit invalidates caches on the next save during development — no version bumps
 * required mid-iteration.
 * Pillar 9 (Archaeological Records): [CORE] tag marks what the CLI owns.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the front-end stylesheets in cascade order.
 *
 * Pillar 6 (Resilience): file_exists() guard means a missing sheet skips
 * gracefully rather than producing a broken 404 asset in the waterfall.
 */
function quillwork_enqueue_assets(): void {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	$sheets = array(
		'reset' => 'assets/css/core/reset.css', // [CORE] @layer declaration + reset.
		'base'  => 'assets/css/core/base.css',  // [CORE] a11y scaffolding + --cl-* token contract.
		'skin'  => 'assets/css/skin.css',       // [SKIN] Quillwork's layout, components, blocks, utilities.
	);

	$deps = array();
	foreach ( $sheets as $name => $rel ) {
		$path = $dir . '/' . $rel;
		if ( ! file_exists( $path ) ) {
			continue;
		}

		$handle = QUILLWORK_SLUG . '-' . $name;
		wp_enqueue_style( $handle, $uri . '/' . $rel, $deps, (string) filemtime( $path ) );
		$deps = array( $handle );
	}

	// Print proof — media="print" never touches the screen render path.
	$print = $dir . '/assets/css/core/print.css';
	if ( file_exists( $print ) ) {
		wp_enqueue_style(
			QUILLWORK_SLUG . '-print',
			$uri . '/assets/css/core/print.css',
			array(),
			(string) filemtime( $print ),
			'print'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'quillwork_enqueue_assets' );

/**
 * Preload the LCP-critical font.
 *
 * The font that paints the largest headline is the LCP-critical font; preloading
 * its WOFF2 shaves the swap-in flash. Which font that is depends on the design,
 * so core declares nothing by default and each skin opts in via the filter below.
 * inc/skin.php adds Cormorant Garamond (the h1/display font) via this filter.
 *
 * crossorigin is required even for same-origin font fetches — browsers fetch
 * fonts via CORS regardless of origin.
 *
 * @param string[] $fonts Theme-root-relative WOFF2 paths to preload.
 */
function quillwork_preload_fonts(): void {
	/**
	 * Filters the list of fonts preloaded in the document head.
	 *
	 * Each entry is a theme-root-relative WOFF2 path. Default is empty.
	 *
	 * @since 1.0.0
	 * @param string[] $fonts Theme-root-relative WOFF2 paths.
	 */
	$fonts = (array) apply_filters( 'quillwork/preload_fonts', array() );

	foreach ( $fonts as $font ) {
		if ( ! is_string( $font ) || '' === $font || false !== strpos( $font, '://' ) ) {
			continue;
		}

		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( QUILLWORK_URI . '/' . ltrim( $font, '/' ) )
		);
	}
}
add_action( 'wp_head', 'quillwork_preload_fonts', 1 );
