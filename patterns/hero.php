<?php
/**
 * Title: Hero — Light Serif Headline
 * Slug: quillwork/hero
 * Categories: quillwork-sections
 * Description: Full-bleed hero with a light Cormorant headline, an italic teal accent line, a calm ochre float accent, and a two-button call to action.
 * Keywords: hero, headline, intro, front page, writer
 * Block Types: core/group
 * Viewport Width: 1280
 *
 * [SKIN] Quillwork hero content. The float accent is decorative (aria-hidden)
 * and honours prefers-reduced-motion via the reset layer in style.css.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"className":"qw-hero qw-section qw-section--cream","layout":{"type":"constrained","contentSize":"1280px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16"}}}} -->
<div class="wp-block-group qw-hero qw-section qw-section--cream" style="padding-top:var(--wp--preset--spacing--16);padding-bottom:var(--wp--preset--spacing--16)">

	<!-- wp:html -->
	<div class="qw-float-accent" aria-hidden="true"></div>
	<!-- /wp:html -->

	<!-- wp:group {"className":"qw-hero__content","style":{"spacing":{"blockGap":"var:preset|spacing|6"}},"layout":{"type":"constrained","contentSize":"900px","justifyContent":"left"}} -->
	<div class="wp-block-group qw-hero__content">

		<!-- wp:paragraph {"className":"is-style-qw-eyebrow qw-eyebrow"} -->
		<p class="is-style-qw-eyebrow qw-eyebrow"><?php esc_html_e( 'Essayist &middot; Your City', 'quillwork' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"fontSize":"display"} -->
		<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Ideas that stay.', 'quillwork' ); ?><em class="qw-hero__accent"><?php esc_html_e( 'Essays worth returning to.', 'quillwork' ); ?></em></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"md","style":{"typography":{"lineHeight":"1.8"}}} -->
		<p class="has-md-font-size" style="line-height:1.8"><?php esc_html_e( 'Personal essays, cultural criticism, and narrative nonfiction for publications that still believe in the sentence. Precise on the first pass and worth a second.', 'quillwork' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|4"}}} -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Start a project', 'quillwork' ); ?></a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#services"><?php esc_html_e( 'View services', 'quillwork' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
