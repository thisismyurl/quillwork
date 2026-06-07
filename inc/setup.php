<?php
/**
 * [CORE] Theme setup — feature supports, i18n, navigation, a11y scaffolding.
 *
 * Every value in this file is the same for every theme in the Colophon line —
 * it is the shared floor. Anything design-specific (image crop sizes, which
 * fonts to preload, block styles) lives in inc/skin.php instead, so this file
 * can be overwritten by `colophon sync` without ever clobbering a theme's
 * personality. The separation is intentional and load-bearing.
 *
 * Pillar 5 (Safe by Default): the WooCommerce guard and emoji
 * removal are here by default — every theme gets them for free.
 * Pillar 9 (Archaeological Records): [CORE] tag marks what the CLI owns.
 *
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * Register theme feature supports, the text domain, and navigation menus.
 */
function setup(): void {

	// i18n. The domain is the literal 'quillwork' (a constant would break make-pot —
	// see bootstrap.php); the path uses DIR so it travels with a re-skin. The
	// CLI rewrites the literal when it generates a theme.
	load_theme_textdomain( 'quillwork', DIR . '/languages' );

	// Fallback content width for oEmbeds in the reading column.
	// Matches theme.json contentSize (720px).
	$GLOBALS['content_width'] = 720;

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

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Navigation', 'quillwork' ),
			'footer'  => esc_html__( 'Footer Navigation', 'quillwork' ),
		)
	);

	/**
	 * Fires after the theme has registered its supports and menus.
	 *
	 * Extension point for companion plugins and inc/skin.php to add supports,
	 * image sizes, or menus without editing this CORE file.
	 *
	 * @since 1.0.0
	 */
	do_action( 'quillwork/setup' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Declare WooCommerce support.
 *
 * Quillwork is not a shop design, but "not a shop design" must never mean "broken
 * shop." On a block theme, WooCommerce ships its own block-based fallback
 * templates and resolves them automatically; declaring support clears the
 * persistent admin notice and enables the product-gallery features.
 *
 * Guarded on the WooCommerce class so the declaration only fires when the
 * plugin is active — no dead code on the common case.
 *
 * Pillar 6 (Resilience): we handle the 'when', not the 'if'.
 */
function woocommerce_support(): void {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\woocommerce_support' );

/**
 * Register the editor stylesheet so the block editor mirrors the front end.
 *
 * theme.json supplies the editor's tokens and global styles; the editor sheet
 * carries only the ::before/::after and custom-block personality that
 * theme.json cannot express.
 */
function editor_styles(): void {
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\editor_styles' );

/**
 * Drop the emoji-detection script and its styles.
 *
 * Modern browsers render emoji natively. Core's polyfill is a render-blocking
 * inline script plus a stylesheet — dead weight on the critical path.
 * Removing it is a Core Web Vitals baseline improvement at zero cost.
 *
 * Pillar 2 (Innovation over Compliance): we don't ship dead weight because
 * it ships by default.
 */
function disable_emoji_assets(): void {
	// Front-end only — leave the admin emoji picker intact.
	// Themes must not alter admin-area behaviour users haven't opted into.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', __NAMESPACE__ . '\\disable_emoji_assets' );

/**
 * Add autocomplete and enterkeyhint hints to the comment-form fields.
 *
 * Lets mobile keyboards offer the right input mode and autofill, and gives the
 * on-screen Enter key a sensible label — a small a11y + mobile-UX win at zero cost.
 *
 * Pillar 5 (Safe by Default): accessibility and mobile UX improvements are
 * on by default, not opt-in.
 *
 * @param array $fields The default comment-form field markup, keyed by field.
 * @return array The fields with input attributes added.
 */
function comment_form_field_attributes( array $fields ): array {
	$attributes = array(
		'author' => 'autocomplete="name" enterkeyhint="next"',
		'email'  => 'autocomplete="email" inputmode="email" enterkeyhint="next"',
		'url'    => 'autocomplete="url" inputmode="url" enterkeyhint="done"',
	);

	foreach ( $attributes as $field => $attrs ) {
		if ( isset( $fields[ $field ] ) ) {
			$fields[ $field ] = str_replace( '<input', '<input ' . $attrs, $fields[ $field ] );
		}
	}

	return $fields;
}
add_filter( 'comment_form_default_fields', __NAMESPACE__ . '\\comment_form_field_attributes' );

/*
 * Skip link — NOT registered here.
 *
 * Every theme template carries the skip link in its header template part
 * (parts/header.html), rendered via wp:html. Registering a second one here
 * via wp_body_open produced a duplicate in the rendered DOM — two visible
 * "Skip to content" links on Tab keypress, one of which targeted a
 * non-existent anchor. The template-part approach is correct: it is always
 * in the rendered markup, it is in the right DOM position, and there is
 * exactly one of it.
 *
 * See parts/header.html for the authoritative skip link.
 */
