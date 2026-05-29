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

namespace quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * Register theme feature supports, the text domain, and navigation menus.
 */
function setup(): void {

	// i18n. The domain is the literal 'quillwork' (a constant would break
	// make-pot — see bootstrap.php); the path uses DIR so it travels with a
	// re-skin. The CLI rewrites the literal when it generates a theme.
	load_theme_textdomain( 'quillwork', DIR . '/languages' );

	/**
	 * Filters the fallback content width for oEmbeds.
	 *
	 * The default 720 matches the reading-column contentSize in theme.json and
	 * singular.html. A re-skin with a wider column should override this so
	 * oEmbed providers (YouTube, Vimeo, Twitter) size their output correctly.
	 *
	 * @since 1.6150
	 *
	 * @param int $width Content width in pixels.
	 */
	$GLOBALS['content_width'] = (int) apply_filters( 'quillwork/content_width', 720 );

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
			'quillwork/register_nav_menus',
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
	do_action( 'quillwork/setup' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

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
 * carries only the ::before/::after personality theme.json cannot express. The
 * file is skin-owned (assets/css/editor-style.css); a missing file is harmless.
 */
function editor_styles(): void {
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\editor_styles' );

/**
 * Drop the emoji-detection script and its styles.
 *
 * Core injects a render-blocking inline script plus a stylesheet to polyfill
 * emoji on older platforms. Modern browsers render emoji natively, so this is
 * dead weight on the critical path — removing it is a Core Web Vitals line
 * standard.
 */
function disable_emoji_assets(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', __NAMESPACE__ . '\\disable_emoji_assets' );

/**
 * Add autocomplete and enterkeyhint hints to the comment-form fields.
 *
 * Lets mobile keyboards offer the right input mode and autofill, and gives the
 * on-screen Enter key a sensible label — a small a11y + mobile-UX win at no cost.
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

/**
 * Output a skip-to-content link immediately after the opening <body> tag.
 *
 * WCAG 2.4.1 (Bypass Blocks). The .skip-link rule in assets/css/core/base.css
 * hides it off-screen until focused; it targets #main-content, which every
 * template's <main> carries.
 */
function skip_link(): void {
	/**
	 * Filters the skip-link anchor target ID (without the leading #).
	 *
	 * The default 'main-content' matches the id="main-content" on the <main>
	 * element in every core template. Override if you rename that id.
	 *
	 * @since 1.6150
	 *
	 * @param string $target Element ID, without the leading #.
	 */
	$target = (string) apply_filters( 'quillwork/skip_link_target', 'main-content' );

	/**
	 * Filters the visible skip-link label.
	 *
	 * Override to match the language or phrasing of your site without editing
	 * a translation file — useful for single-language sites or custom copy.
	 *
	 * @since 1.6150
	 *
	 * @param string $label The link text.
	 */
	$label = (string) apply_filters( 'quillwork/skip_link_label', __( 'Skip to content', 'quillwork' ) );

	echo '<a class="skip-link" href="#' . esc_attr( $target ) . '">'
		. esc_html( $label )
		. '</a>';
}
add_action( 'wp_body_open', __NAMESPACE__ . '\\skip_link' );
