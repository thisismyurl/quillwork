<?php
/**
 * Title: Contact — Centred CTA
 * Slug: quillwork/contact
 * Categories: quillwork-sections
 * Description: A centred contact band — heading, subtitle, two contact methods (email and location), and a single primary call to action.
 * Keywords: contact, get in touch, cta, email, location, footer
 * Block Types: core/group
 * Viewport Width: 1280
 *
 * [SKIN] Quillwork contact band. Centred constrained column on cream. Contact
 * methods are labelled links (no emoji-as-icon, so screen readers and Theme
 * Check stay clean). Single h2 for the section; the method labels are h3.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","className":"qw-section qw-section--cream","anchor":"contact","layout":{"type":"constrained","contentSize":"1000px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16"},"blockGap":"var:preset|spacing|6"}},"backgroundColor":"cream"} -->
<section id="contact" class="wp-block-group qw-section qw-section--cream has-cream-background-color has-background" style="padding-top:var(--wp--preset--spacing--16);padding-bottom:var(--wp--preset--spacing--16)">

	<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"2xl"} -->
	<h2 class="wp-block-heading has-text-align-center has-2-xl-font-size"><?php esc_html_e( 'Let’s create something worth reading', 'quillwork' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"md","textColor":"ink-medium","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}}} -->
	<p class="has-text-align-center has-ink-medium-color has-text-color has-md-font-size" style="margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'For commissions, editing inquiries, workshop bookings, or just a conversation about the work — get in touch.', 'quillwork' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"qw-contact-methods","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|12","margin":{"bottom":"var:preset|spacing|10"}}}} -->
	<div class="wp-block-group qw-contact-methods" style="margin-bottom:var(--wp--preset--spacing--10)">

		<!-- wp:group {"className":"qw-contact-method","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|1"}}} -->
		<div class="wp-block-group qw-contact-method">
			<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"sm","textColor":"teal"} -->
			<h3 class="wp-block-heading has-text-align-center has-teal-color has-text-color has-sm-font-size"><?php esc_html_e( 'Email', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","fontSize":"base"} -->
			<p class="has-text-align-center has-base-font-size"><a href="mailto:hello@example.com">hello@example.com</a></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"ink-muted"} -->
			<p class="has-text-align-center has-ink-muted-color has-text-color has-sm-font-size"><?php esc_html_e( 'Email me directly', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"qw-contact-method","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|1"}}} -->
		<div class="wp-block-group qw-contact-method">
			<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"sm","textColor":"teal"} -->
			<h3 class="wp-block-heading has-text-align-center has-teal-color has-text-color has-sm-font-size"><?php esc_html_e( 'Location', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","fontSize":"base"} -->
			<p class="has-text-align-center has-base-font-size"><?php esc_html_e( 'Your Region', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"ink-muted"} -->
			<p class="has-text-align-center has-ink-muted-color has-text-color has-sm-font-size"><?php esc_html_e( 'Available for assignment worldwide', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="mailto:hello@example.com"><?php esc_html_e( 'Get in touch', 'quillwork' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</section>
<!-- /wp:group -->
