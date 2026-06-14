<?php
/**
 * [CORE] Block-bindings sources — the footer's living copyright year and a
 * credit line that's genuinely easy to remove.
 *
 * A static template part can't compute the current year, and hardcoding one is
 * a quiet way to look abandoned every January. So parts/footer.html binds its
 * copyright paragraph to the `quillwork/copyright` source registered here (WP
 * 6.5+ block bindings) — one small, removable callback instead of a render
 * filter reinventing what the bindings API already does.
 *
 * The "Built with …" credit binds to a second source so an integrator can
 * rewrite or drop it through a filter without editing a template. Both source
 * names derive from SLUG, so a theme installed beside its siblings never
 * collides. The credit text reads the theme's own Name and Theme URI from the
 * style.css header, so this file carries no theme-specific string and stays
 * pure core.
 *
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * Register the copyright and footer-credit binding sources.
 *
 * Guarded on register_block_bindings_source() so the theme degrades cleanly on
 * any pre-6.5 install that slips past the "Requires at least" header.
 */
function register_bindings(): void {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		SLUG . '/copyright',
		array(
			'label'              => __( 'Copyright line', 'quillwork' ),
			'get_value_callback' => __NAMESPACE__ . '\\get_copyright_value',
			'uses_context'       => array(),
		)
	);

	register_block_bindings_source(
		SLUG . '/footer-credit',
		array(
			'label'              => __( 'Footer credit line', 'quillwork' ),
			'get_value_callback' => __NAMESPACE__ . '\\get_footer_credit_value',
			'uses_context'       => array(),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_bindings' );

/**
 * Resolve the copyright line: © {current year} {Site Title}. All rights reserved.
 *
 * Year comes from current_time() so it follows the site's timezone, not UTC.
 *
 * @return string The composed copyright sentence.
 */
function get_copyright_value(): string {
	/**
	 * Filters the date format used for the copyright year.
	 *
	 * Default 'Y' produces a four-digit year. Return a PHP date-format string
	 * — e.g. 'Y' for a single year, or supply a static string like '2022–2026'
	 * for a year range. The value is passed to current_time() so the result
	 * follows the site's timezone setting.
	 *
	 * @since 1.6148
	 *
	 * @param string $format PHP date format string, or a literal string.
	 */
	$format = (string) apply_filters( SLUG . '/copyright_date_format', 'Y' );
	$year   = (string) current_time( $format );

	$copyright = sprintf(
		/* translators: 1: four-digit year, 2: site title. */
		__( '© %1$s %2$s. All rights reserved.', 'quillwork' ),
		$year,
		esc_html( get_bloginfo( 'name' ) )
	);

	/**
	 * Filters the footer copyright sentence.
	 *
	 * Lets a child theme or companion plugin replace the copyright line without
	 * editing the footer template part.
	 *
	 * @since 1.0.0
	 *
	 * @param string $copyright The composed "© {year} {site}. All rights reserved." line.
	 */
	return (string) apply_filters( SLUG . '/copyright_text', $copyright );
}

/**
 * Resolve the "Built with the {Theme} theme." footer credit.
 *
 * The theme name and home link come from the style.css header (Name + Theme
 * URI), so this stays generic across the line — no theme types its own name
 * here. Bound by parts/footer.html so the credit is filterable without a
 * template edit; return an empty string from the filter to drop it entirely.
 * Output is run through wp_kses to a minimal anchor allow-list so a filtered
 * value can't inject arbitrary tags.
 *
 * @return string The credit line markup (possibly empty).
 */
function get_footer_credit_value(): string {
	$theme = wp_get_theme();
	$name  = $theme->get( 'Name' );
	$home  = $theme->get( 'ThemeURI' );

	$linked = $home
		? '<a href="' . esc_url( $home ) . '" rel="nofollow">' . esc_html( $name ) . '</a>'
		: esc_html( $name );

	$credit = sprintf(
		/* translators: %s: linked theme name. */
		__( 'Built with the %s theme.', 'quillwork' ),
		$linked
	);

	/**
	 * Filters the footer credit line.
	 *
	 * Return an empty string to remove the credit, or any string to replace it.
	 * Output is sanitized with wp_kses to a minimal anchor allow-list.
	 *
	 * @since 1.0.0
	 *
	 * @param string $credit The default "Built with the {Theme} theme." markup.
	 */
	$credit = (string) apply_filters( SLUG . '/footer_credit', $credit );

	return wp_kses(
		$credit,
		array(
			'a' => array(
				'href'   => array(),
				'rel'    => array(),
				'target' => array(),
			),
		)
	);
}
