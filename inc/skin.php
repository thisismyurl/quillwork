<?php
/**
 * [SKIN] Quillwork — menus, image sizes, font preload, block styles, pattern
 * categories, and the Get-started page copy.
 *
 * This is the one PHP file `colophon sync` never overwrites. All
 * Quillwork-specific hooks live here, not in functions.php.
 *
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;
// Opt this theme into GitHub-release self-updates (see inc/github-updater.php).
add_filter( 'quillwork/github_updater_repo', static function (): string {{
	return 'thisismyurl/quillwork';
}} );

// =========================================================================
// SETUP — navigation menus
// =========================================================================

function skin_setup(): void {
	register_nav_menus( [
		'primary' => esc_html__( 'Primary Navigation', 'quillwork' ),
		'footer'  => esc_html__( 'Footer Navigation',  'quillwork' ),
		'social'  => esc_html__( 'Social Links',       'quillwork' ),
	] );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\skin_setup' );

// =========================================================================
// IMAGE SIZES
// =========================================================================

function skin_image_sizes(): void {
	add_image_size( 'quillwork-hero',    1440, 810,  true );  // 16:9 full-bleed hero.
	add_image_size( 'quillwork-feature', 780,  520,  true );  // 3:2 project header.
	add_image_size( 'quillwork-card',    600,  450,  true );  // 4:3 portfolio card.
	add_image_size( 'quillwork-mark',    800,  800,  true );  // 1:1 logotype / mark.
	add_image_size( 'quillwork-wide',    1280, 540,  true );  // wide panoramic.
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\skin_image_sizes' );

function skin_image_size_names( array $sizes ): array {
	return array_merge( $sizes, [
		'quillwork-hero'    => esc_html__( 'Quillwork Hero (1440×810)',    'quillwork' ),
		'quillwork-feature' => esc_html__( 'Quillwork Feature (780×520)', 'quillwork' ),
		'quillwork-card'    => esc_html__( 'Quillwork Card (600×450)',     'quillwork' ),
		'quillwork-mark'    => esc_html__( 'Quillwork Mark (800×800)',     'quillwork' ),
	] );
}
add_filter( 'image_size_names_choose', __NAMESPACE__ . '\\skin_image_size_names' );

// =========================================================================
// FONT PRELOAD — LCP-critical font
// =========================================================================

add_filter(
	'quillwork/preload_fonts',
	static function ( array $fonts ): array {
		// Cormorant Garamond paints every h1 — the largest glyph on the
		// studio-hero front page. Preloading the upright variable file shaves
		// the FOUT on the largest-contentful-paint element.
		$fonts[] = 'assets/fonts/cormorant-garamond/cormorant-garamond-variable.woff2';
		return $fonts;
	}
);

// =========================================================================
// BLOCK STYLES
// =========================================================================

function skin_block_styles(): void {

	// Group: the studio hero — cream ground, generous block padding.
	register_block_style( 'core/group', [ 'name' => 'quillwork-hero',       'label' => __( 'Studio Hero',       'quillwork' ) ] );

	// Group: numbered service card — cream bg, teal left-border on hover.
	register_block_style( 'core/group', [ 'name' => 'quillwork-service',    'label' => __( 'Service Card',      'quillwork' ) ] );

	// Group: testimonial card on ink-deep band.
	register_block_style( 'core/group', [ 'name' => 'quillwork-testimonial','label' => __( 'Testimonial Card',  'quillwork' ) ] );

	// Group: stats highlight row.
	register_block_style( 'core/group', [ 'name' => 'quillwork-stats',      'label' => __( 'Stats Block',       'quillwork' ) ] );

	// Paragraph: eyebrow label — DM Sans uppercase, teal, tracked.
	register_block_style( 'core/paragraph', [ 'name' => 'quillwork-eyebrow','label' => __( 'Eyebrow Label',     'quillwork' ) ] );

	// Heading: Cormorant Garamond display — weight 300, italic accent variant.
	register_block_style( 'core/heading',   [ 'name' => 'quillwork-display','label' => __( 'Display Heading',   'quillwork' ) ] );
}
add_action( 'init', __NAMESPACE__ . '\\skin_block_styles' );

// =========================================================================
// PATTERN CATEGORIES
// =========================================================================

function skin_pattern_categories(): void {
	$categories = [
		'quillwork-hero'      => [
			'label'       => __( 'Quillwork: Hero',       'quillwork' ),
			'description' => __( 'Studio hero and landing sections.', 'quillwork' ),
		],
		'quillwork-studio'    => [
			'label'       => __( 'Quillwork: Studio',     'quillwork' ),
			'description' => __( 'About, bio, and studio identity patterns.', 'quillwork' ),
		],
		'quillwork-work'      => [
			'label'       => __( 'Quillwork: Work',       'quillwork' ),
			'description' => __( 'Portfolio and case study patterns.', 'quillwork' ),
		],
		'quillwork-services'  => [
			'label'       => __( 'Quillwork: Services',   'quillwork' ),
			'description' => __( 'Service cards and offering patterns.', 'quillwork' ),
		],
		'quillwork-cta'       => [
			'label'       => __( 'Quillwork: CTA',        'quillwork' ),
			'description' => __( 'Calls to action and contact patterns.', 'quillwork' ),
		],
		'quillwork-editorial' => [
			'label'       => __( 'Quillwork: Editorial',  'quillwork' ),
			'description' => __( 'Navigation, footer, and site-chrome patterns.', 'quillwork' ),
		],
	];
	foreach ( $categories as $slug => $args ) {
		register_block_pattern_category( $slug, $args );
	}
}
add_action( 'init', __NAMESPACE__ . '\\skin_pattern_categories' );

// =========================================================================
// ONBOARDING — Get-started page copy
// =========================================================================

add_filter(
	'colophon/get_started_content',
	static function ( array $default ): array {
		return array_merge( $default, [
			'lead'  => __( 'Quillwork is built for independent design studios that want a site as considered as their work. Here is how to make it yours.', 'quillwork' ),
			'steps' => [
				[
					'title' => __( 'Set your studio name.', 'quillwork' ),
					'body'  => __( 'Your studio name at display scale IS the hero — no photography needed. Go to Appearance → Editor → Site Identity and enter your studio name.', 'quillwork' ),
				],
				[
					'title' => __( 'Publish your first project.', 'quillwork' ),
					'body'  => __( 'Projects are standard WordPress posts. Publish one and it will appear in the works directory on the front page automatically.', 'quillwork' ),
				],
				[
					'title' => __( 'Replace the pattern placeholders.', 'quillwork' ),
					'body'  => __( 'In any page or post, open the block inserter, choose Patterns, and find the Quillwork group. The Service Cards and Studio Bio patterns are the fastest starting points.', 'quillwork' ),
				],
				[
					'title' => __( 'Tune the palette.', 'quillwork' ),
					'body'  => __( 'In the Site Editor, open Styles. The teal accent and ochre numerals are the only colours that change your design voice — everything else follows.', 'quillwork' ),
				],
			],
		] );
	}
);
