<?php
/**
 * [CORE] Theme setup — feature supports, i18n, navigation, a11y scaffolding.
 *
 * Every value in this file is the same for every theme in the line — it is the
 * shared floor. Anything design-specific (image crop sizes, which fonts to
 * preload, block styles) lives in inc/skin.php instead, so this file can be
 * overwritten by `colophon sync` without ever clobbering a theme's personality.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme feature supports, the text domain, and navigation menus.
 */
function quillwork_setup(): void {

	// i18n. The domain is the literal 'quillwork' (a constant would break
	// make-pot — see bootstrap.php); the path uses QUILLWORK_DIR so it travels with a
	// re-skin. The CLI rewrites the literal when it generates a theme.
	load_theme_textdomain( 'quillwork', QUILLWORK_DIR . '/languages' );

	/**
	 * Filters the fallback content width for oEmbeds.
	 *
	 * The default 720 matches the reading-column contentSize in theme.json and
	 * the single-post templates. A re-skin with a wider column should override this so
	 * oEmbed providers (YouTube, Vimeo, Twitter) size their output correctly.
	 *
	 * @since 1.6150
	 *
	 * @param int $width Content width in pixels.
	 */
	$GLOBALS['content_width'] = (int) apply_filters( QUILLWORK_SLUG . '/content_width', 720 );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	/**
	 * Filters the navigation menu registrations.
	 *
	 * Add, rename, or remove menu locations without editing core. The array
	 * maps location slug => translatable label; every entry is passed directly
	 * to register_nav_menus().
	 *
	 * @since 1.6150
	 *
	 * @param array $menus Location-slug => label pairs.
	 */
	register_nav_menus(
		(array) apply_filters(
			QUILLWORK_SLUG . '/register_nav_menus',
			array(
				'primary' => esc_html__( 'Primary Navigation', 'quillwork' ),
				'footer'  => esc_html__( 'Footer Navigation', 'quillwork' ),
			)
		)
	);

	/**
	 * Fires after the theme has registered its supports and menus.
	 *
	 * The extension point for companion plugins and a theme's own inc/skin.php
	 * to add supports, image sizes, or menus without editing core. Runs late on
	 * after_setup_theme, so everything the theme declares is already in place.
	 *
	 * @since 1.0.0
	 */
	do_action( QUILLWORK_SLUG . '/setup' );
}
add_action( 'after_setup_theme', 'quillwork_setup' );

/**
 * Declare minimum WooCommerce support so a shop renders without conflict.
 *
 * None of the themes in this line are shop designs — but "not a shop design"
 * must never mean "broken shop." On a block theme, WooCommerce ships its own
 * block-based fallback templates and resolves them automatically when the theme
 * provides none, so layout is covered and the product pages inherit the theme's
 * theme.json tokens. What is left is the support declaration: without it
 * WooCommerce shows a persistent "theme does not declare WooCommerce support"
 * notice and disables the product-gallery zoom/lightbox/slider. Declaring
 * support (plus the three gallery features) clears the notice and lets the
 * gallery work, with no template authoring.
 *
 * Guarded on the WooCommerce class so the supports are only declared when the
 * plugin is active.
 */
function quillwork_woocommerce_support(): void {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'quillwork_woocommerce_support' );

/**
 * Register the editor stylesheet so the block editor mirrors the front end.
 *
 * The theme.json file supplies the editor's tokens and global styles; the editor sheet
 * carries only the ::before/::after personality theme.json cannot express. The
 * file is skin-owned (assets/css/editor-style.css); a missing file is harmless.
 */
function quillwork_editor_styles(): void {
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
add_action( 'after_setup_theme', 'quillwork_editor_styles' );

/**
 * Add autocomplete and enterkeyhint hints to the comment-form fields.
 *
 * Lets mobile keyboards offer the right input mode and autofill, and gives the
 * on-screen Enter key a sensible label — a small a11y + mobile-UX win at no cost.
 *
 * @param array $fields The default comment-form field markup, keyed by field.
 * @return array The fields with input attributes added.
 */
function quillwork_comment_form_field_attributes( array $fields ): array {
	$attributes = array(
		'author' => 'autocomplete="name" enterkeyhint="next"',
		'email'  => 'autocomplete="email" inputmode="email" enterkeyhint="next"',
		'url'    => 'autocomplete="url" inputmode="url" enterkeyhint="done"',
	);

	foreach ( $attributes as $field => $attrs ) {
		if ( ! isset( $fields[ $field ] ) ) {
			continue;
		}

		$pattern     = '/<input\s+([^>]*)/';
		$replacement = '<input ' . $attrs . ' $1';
		$count       = 0;
		$updated     = preg_replace( $pattern, $replacement, $fields[ $field ], 1, $count );

		// Regex error: preg_replace returns null on failure (e.g., invalid regex).
		// Skip this field to preserve the original HTML; no attributes added.
		if ( null === $updated ) {
			continue;
		}

		// Pattern matched: $count will be 1 (limit of 1 replacement).
		// Update the field with the modified HTML.
		if ( $count > 0 ) {
			$fields[ $field ] = $updated;
		}
		// Non-match ($count === 0): the field HTML doesn't contain the expected <input tag.
		// This is safe: field stays unchanged, no attributes added.
		// Silent fallback preserves the field's original markup.
	}

	return $fields;
}
add_filter( 'comment_form_default_fields', 'quillwork_comment_form_field_attributes' );

