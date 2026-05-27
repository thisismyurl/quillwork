<?php
/**
 * [SKIN] The skin layer — the one PHP file the `colophon` CLI never overwrites.
 *
 * Quillwork's PHP-side personality: the editorial image crops, the LCP font
 * preload (Cormorant Garamond paints the h1, the largest glyph on every page),
 * the block styles its patterns lean on, the pattern categories, and the
 * Get-started copy in Christopher's voice. The core inc/ files stay portable
 * because none of this leaks into them — that's the whole point of the split.
 *
 * @package quillwork
 */

namespace Quillwork;

defined( 'ABSPATH' ) || exit;

/**
 * Opt in to GitHub-release self-updates.
 *
 * Names the repo the [CORE][REMOVABLE] inc/github-updater.php watches for new
 * releases. Empty by default in core; set here so a Quillwork installed from a
 * GitHub release gets the one-click update banner in Appearance → Themes. Delete
 * inc/github-updater.php (and this filter) before a WordPress.org submission.
 */
add_filter(
	'quillwork/github_updater_repo',
	static function (): string {
		return 'thisismyurl/thisismyurl-colophon-quillwork';
	}
);

/**
 * Register Quillwork's image crop sizes.
 *
 * 16:9 for the hero/wide editorial images; 3:2 for the portfolio card grids.
 * Hooked on after_setup_theme so a re-skin changes crops here without touching
 * inc/setup.php.
 */
function skin_image_sizes(): void {
	add_image_size( 'quillwork-hero', 1600, 900, true ); // 16:9 hero.
	add_image_size( 'quillwork-card', 720, 480, true );  // 3:2 portfolio card.
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\skin_image_sizes' );

/**
 * Preload Cormorant Garamond — the largest-paint glyph on every page.
 *
 * Cormorant renders the h1, which is the LCP element on every template, so the
 * variable WOFF2 is preloaded site-wide to shave the swap-in. Only the upright
 * variable file is preloaded — the italic is a decorative accent (the hero
 * accent line, the testimonial quote glyph) and never on the critical path.
 */
add_filter(
	'quillwork/preload_fonts',
	static function ( array $fonts ): array {
		$fonts[] = 'assets/fonts/cormorant-garamond/cormorant-garamond-variable.woff2';
		return $fonts;
	}
);

/**
 * Register Quillwork's block styles (the is-style-{name} options in the editor).
 *
 * Each style is the editor-facing handle for a CSS treatment defined in
 * assets/css/skin.css @layer components. They are the vocabulary the patterns
 * apply via className; an editor can also reach for them by hand. The CSS —
 * never the registration — carries the visual weight.
 */
function skin_block_styles(): void {

	// [SKIN] Paragraph as an uppercase DM Sans eyebrow above a heading.
	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'qw-eyebrow',
			'label' => __( 'Eyebrow', 'quillwork' ),
		)
	);

	// [SKIN] Group as a numbered service card (ochre numeral, teal hover rule).
	register_block_style(
		'core/group',
		array(
			'name'  => 'qw-service-card',
			'label' => __( 'Service Card', 'quillwork' ),
		)
	);

	// [SKIN] Group as a stat block (large Cormorant numeral + caption label).
	register_block_style(
		'core/group',
		array(
			'name'  => 'qw-stat',
			'label' => __( 'Stat Block', 'quillwork' ),
		)
	);

	// [SKIN] Quote as an italic coral-ruled highlight.
	register_block_style(
		'core/quote',
		array(
			'name'  => 'qw-highlight',
			'label' => __( 'Highlight', 'quillwork' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\skin_block_styles' );

/**
 * Register Quillwork's pattern categories.
 *
 * Prefixed with SLUG so a theme installed beside its siblings never collides.
 * Pattern files in /patterns/*.php declare which category they slot into.
 */
function skin_pattern_categories(): void {

	register_block_pattern_category(
		SLUG . '-pages',
		array(
			'label'       => __( 'Quillwork: Pages', 'quillwork' ),
			'description' => __( 'Full-page layout patterns for the editorial home and about pages.', 'quillwork' ),
		)
	);

	register_block_pattern_category(
		SLUG . '-sections',
		array(
			'label'       => __( 'Quillwork: Sections', 'quillwork' ),
			'description' => __( 'Hero, services, testimonials, and contact section patterns.', 'quillwork' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\skin_pattern_categories' );

/**
 * Replace the Get-started copy with Quillwork's voice.
 *
 * Same array shape as the core default (see inc/admin.php get_started_content()).
 * The mechanism is portable core; the words below are Christopher's — warm,
 * first-person, WHY before HOW — supplied through this filter so the synced
 * admin.php stays free of theme strings.
 */
add_filter(
	'quillwork/get_started_content',
	static function ( array $default ): array {

		$default['lead'] = __( "Quillwork is a quiet, literary theme for people whose work is words — writers, editors, and anyone building a personal brand around what they have to say. I built it to get out of the way: a calm reading column, type that breathes, and nothing on the page fighting your sentences. It's given freely, in the hope it earns you a few more readers. Here's how to make it yours.", 'quillwork' );

		// Each step links the place the reader needs to go. The links are built
		// here with admin_url() (PHP) and the synced inc/admin.php renders them
		// through a link-only kses allow-list — so a click takes the new owner
		// straight to Settings, the Site Editor, or their posts.
		$default['steps'] = array(
			array(
				'title' => __( 'Choose what people land on.', 'quillwork' ),
				'body'  => sprintf(
					/* translators: %s: linked "Settings → Reading" admin screen. */
					__( "A visitor's first second decides whether they stay. If you have a piece you're proud of, or a short introduction to who you are, send them there first. Set a static front page under %s, and point your posts page somewhere of its own.", 'quillwork' ),
					'<a href="' . esc_url( admin_url( 'options-reading.php' ) ) . '">' . esc_html__( 'Settings → Reading', 'quillwork' ) . '</a>'
				),
			),
			array(
				'title' => __( 'Give people a way around.', 'quillwork' ),
				'body'  => sprintf(
					/* translators: %s: linked "Site Editor" admin screen. */
					__( 'A site without a menu is a room without doors. Open the %s, edit the header, and assign your menu to Primary Navigation so readers can find the rest of your work.', 'quillwork' ),
					'<a href="' . esc_url( admin_url( 'site-editor.php' ) ) . '">' . esc_html__( 'Site Editor', 'quillwork' ) . '</a>'
				),
			),
			array(
				'title' => __( 'Start from a good page, not a blank one.', 'quillwork' ),
				'body'  => sprintf(
					/* translators: %s: linked "new page" admin screen. */
					__( "A blank page is the hardest place to begin. Quillwork ships with patterns — pre-built sections you can drop in and edit. %s, click the block inserter, open Patterns, and look for the Quillwork group. Start there and change the words.", 'quillwork' ),
					'<a href="' . esc_url( admin_url( 'post-new.php?post_type=page' ) ) . '">' . esc_html__( 'Start a new page', 'quillwork' ) . '</a>'
				),
			),
			array(
				'title' => __( 'Make it sound like you.', 'quillwork' ),
				'body'  => sprintf(
					/* translators: %s: linked "Site Editor → Styles" admin screen. */
					__( "The default palette and fonts are a starting point, not a verdict. In the Site Editor, open %s to change colours and typefaces until the site feels like your voice and not mine. Nothing you do here can break the theme — it's a safe place to experiment.", 'quillwork' ),
					'<a href="' . esc_url( admin_url( 'site-editor.php?path=%2Fwp_global_styles' ) ) . '">' . esc_html__( 'Styles', 'quillwork' ) . '</a>'
				),
			),
			array(
				'title' => __( 'Add featured images so the card grids sing.', 'quillwork' ),
				'body'  => sprintf(
					/* translators: %s: linked "Posts" admin screen. */
					__( 'Quillwork lays your posts out as cards, and a card without an image is a card with a hole in it. Add a featured image to each of %s — even a simple, calm one — and the grids come to life.', 'quillwork' ),
					'<a href="' . esc_url( admin_url( 'edit.php' ) ) . '">' . esc_html__( 'your posts', 'quillwork' ) . '</a>'
				),
			),
		);

		$default['optimize'] = array(
			__( "Here's the honest part: Quillwork is already fast, and that's by design, not by accident. It ships zero JavaScript, hosts its own fonts so nothing phones home to Google, and is tuned against the Core Web Vitals that search engines actually measure. You don't have to do anything to get that.", 'quillwork' ),
			__( "To keep it that way: be gentle with plugins that add scripts to every page, size your images before you upload them, and resist the urge to bolt on a page builder — the theme is the layout. On accessibility, Quillwork meets WCAG 2.2 AA: real focus outlines, a skip link, sensible heading order, and motion that respects a visitor's reduce-motion setting. Keep your own copy and images to that bar and the whole site stays welcoming to everyone.", 'quillwork' ),
		);

		$default['credit'] = sprintf(
			/* translators: %s: linked "Site Editor" admin screen. */
			__( "Quillwork leaves a small credit in your footer. It's a thank-you, not a tax — it helps people find the theme, which is the only payment I ask. If it doesn't suit your site, remove it in two clicks: open the %s, edit the Footer, and delete the line. Developers can filter quillwork/footer_credit instead. No hard feelings either way.", 'quillwork' ),
			'<a href="' . esc_url( admin_url( 'site-editor.php' ) ) . '">' . esc_html__( 'Site Editor', 'quillwork' ) . '</a>'
		);

		$default['developers'] = array(
			/* translators: %s: linked "build-on-Quillwork guide" anchor. */
			'text'  => __( 'Quillwork is built on a small, documented core meant to be reused. If you want to build your own theme on top of it, the %s walks through how.', 'quillwork' ),
			'url'   => 'https://thisismyurl.com/themes/quillwork/develop',
			'label' => __( 'build-on-Quillwork guide', 'quillwork' ),
		);

		return $default;
	}
);

/**
 * Point the Get-started page's two video slots at the published course tutorials.
 *
 * The core renders a "coming soon" placeholder for any empty UID; these are the
 * Cloudflare Stream UIDs for the matching course-5601 lessons — "Setting up your
 * site" and "Optimizing your site" — so the page shows the real videos.
 */
add_filter(
	'quillwork/get_started_videos',
	static function (): array {
		return array(
			array( 'uid' => 'b79d9bd4564c2651d24dbe52127dbfb8', 'title' => __( 'Setting up your site', 'quillwork' ) ),
			array( 'uid' => 'ee88879539bbfaef2cba32d92547c451', 'title' => __( 'Optimizing your site', 'quillwork' ) ),
		);
	}
);
