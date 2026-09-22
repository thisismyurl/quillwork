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
 * names derive from QUILLWORK_SLUG, so a theme installed beside its siblings never
 * collides. The credit text reads the theme's own Name and Theme URI from the
 * style.css header, so this file carries no theme-specific string and stays
 * pure core.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the copyright, site-strings and publication-date binding sources.
 *
 * Guarded on register_block_bindings_source() so the theme degrades cleanly on
 * any pre-6.5 install that slips past the "Requires at least" header.
 */
function quillwork_register_bindings(): void {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		QUILLWORK_SLUG . '/copyright',
		array(
			'label'              => esc_html__( 'Copyright line', 'quillwork' ),
			'get_value_callback' => 'quillwork_get_copyright_value',
			'uses_context'       => array(),
		)
	);

	register_block_bindings_source(
		QUILLWORK_SLUG . '/site-strings',
		array(
			'label'              => esc_html__( 'Theme strings', 'quillwork' ),
			'get_value_callback' => 'quillwork_get_site_string_value',
			'uses_context'       => array(),
		)
	);

	register_block_bindings_source(
		QUILLWORK_SLUG . '/publication-date',
		array(
			'label'              => esc_html__( 'Publication date', 'quillwork' ),
			'get_value_callback' => 'quillwork_get_publication_date_value',
			'uses_context'       => array(),
		)
	);
}
add_action( 'init', 'quillwork_register_bindings' );

/**
 * Resolve a translatable theme string or URL for a block binding.
 *
 * Template files cannot call __(), so the few UI strings the default templates
 * need (the breaking-news label, the 404 "back to the front page" link) come
 * through this binding, translated and escaped here.
 *
 * @param array $source_args Binding args; `key` selects the value.
 * @return string The escaped string or URL, or an empty string for an unknown key.
 */
function quillwork_get_site_string_value( array $source_args ): string {
	switch ( $source_args['key'] ?? '' ) {
		case 'breaking-label':
			return esc_html__( 'Breaking', 'quillwork' );
		case 'home-label':
			return esc_html__( 'Back to the front page', 'quillwork' );
		case 'home-url':
			return esc_url( home_url( '/' ) );
		case 'not-found-title':
			return esc_html__( 'Page not found', 'quillwork' );
		case 'posts-title':
			$posts_page = (int) get_option( 'page_for_posts' );
			return $posts_page ? esc_html( get_the_title( $posts_page ) ) : esc_html__( 'Latest news', 'quillwork' );
	}
	return '';
}

/**
 * Resolve the copyright line: © {current year} {Site Title}. All rights reserved.
 *
 * Year comes from current_time() so it follows the site's timezone, not UTC.
 *
 * @return string The composed copyright sentence.
 */
function quillwork_get_copyright_value(): string {
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
	$format = (string) apply_filters( QUILLWORK_SLUG . '/copyright_date_format', 'Y' );
	$year   = (string) current_time( $format );

	$copyright = sprintf(
		/* translators: 1: four-digit year, 2: site title. */
		esc_html__( '© %1$s %2$s. All rights reserved.', 'quillwork' ),
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
	$copyright = (string) apply_filters( QUILLWORK_SLUG . '/copyright_text', $copyright );

	// Sanitized to the same minimal anchor allow-list as the footer credit below.
	// Both take a filtered value straight into a rendered block; they had two
	// different answers to one threat model, which is how the looser of the pair
	// stops being noticed.
	return wp_kses(
		$copyright,
		array(
			'a' => array(
				'href'   => array(),
				'rel'    => array(),
				'target' => array(),
			),
		)
	);
}

/**
 * Resolve the utility-bar publication date, in the site's own date format.
 *
 * WHY THIS IS SERVER-RENDERED: the utility bar previously carried
 * `data-wp-text="context.siteDate"` on an empty paragraph and relied on the
 * Interactivity API to fill it in. That never rendered anything, for two
 * independent reasons: `siteDate` is registered through wp_interactivity_state()
 * so it is state, not context, and the utility bar has no data-wp-interactive
 * attribute, so it is not an interactivity island and no directive on it can
 * resolve. The result was an empty <p> at the very top of every page, above the
 * nameplate — part of what WP.org ticket #280625 read as a layout that "does not
 * flow gracefully".
 *
 * A quillwork date is not interactive; it is the paper's dateline. Rendering it
 * on the server means it is present in the markup, present without JavaScript,
 * and correct in the site's timezone and date format.
 *
 * @since 1.6201.0911
 *
 * @return string The current date in the site's configured format.
 */
function quillwork_get_publication_date_value(): string {
	/**
	 * Filters the date format used in the utility bar.
	 *
	 * Defaults to the site's own Settings → General date format.
	 *
	 * @since 1.6201.0911
	 *
	 * @param string $format A PHP date format string.
	 */
	$format = (string) apply_filters( QUILLWORK_SLUG . '/publication_date_format', (string) get_option( 'date_format' ) ); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

	// Escaped here for the same reason the reading-time callback is: a bindings
	// get_value_callback return goes straight into the rendered block, and the
	// format above is filterable.
	return esc_html( wp_date( $format ) );
}
