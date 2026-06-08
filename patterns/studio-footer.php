<?php
/**
 * Title: Studio Footer
 * Slug: quillwork/studio-footer
 * Categories: quillwork-editorial
 * Viewport Width: 1280
 * Inserter: true
 * Description: Three-column footer on ink-deep teal — studio name and a one-line description in Cormorant Garamond, a navigation column, and a contact column, closed by a copyright and trademark line.
 *
 * @package quillwork
 */
?>
<!-- wp:group {"className":"qw-section qw-section--ink qw-footer","metadata":{"categories":["quillwork-editorial"],"name":"Studio Footer"},"tagName":"footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|10","left":"var:preset|spacing|8","right":"var:preset|spacing|8"}},"color":{"background":"var:preset|color|ink-deep","text":"var:preset|color|cream"}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<footer class="wp-block-group qw-section qw-section--ink qw-footer has-text-color has-background" style="background-color:var(--wp--preset--color--ink-deep);color:var(--wp--preset--color--cream)">

	<!-- wp:columns {"isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|10"}}}} -->
	<div class="wp-block-columns">

		<!-- wp:column {"width":"45%"} -->
		<div class="wp-block-column" style="flex-basis:45%">

			<!-- wp:heading {"level":2,"style":{"typography":{"fontFamily":"var:preset|font-family|cormorant","fontStyle":"italic","fontWeight":"300","fontSize":"var:preset|font-size|2xl","lineHeight":"1","letterSpacing":"-0.02em"},"color":{"text":"var:preset|color|cream"},"spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
			<h2 class="wp-block-heading" style="font-family:var(--wp--preset--font-family--cormorant);font-size:var(--wp--preset--font-size--2xl);font-style:italic;font-weight:300;line-height:1;letter-spacing:-0.02em;color:var(--wp--preset--color--cream)">Quillwork</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|sm","lineHeight":"1.7"},"color":{"text":"var:preset|color|teal-tint"}}} -->
			<p style="color:var(--wp--preset--color--teal-tint);line-height:1.7">An editorial studio for writers, independent publishers, and literary magazines &#8212; words set with care, on paper and on screen.</p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">

			<!-- wp:paragraph {"className":"qw-eyebrow","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|2xs","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.18em"},"color":{"text":"var:preset|color|ochre"},"spacing":{"margin":{"bottom":"var:preset|spacing|5"}}}} -->
			<p class="qw-eyebrow" style="color:var(--wp--preset--color--ochre)">Studio</p>
			<!-- /wp:paragraph -->

			<!-- wp:navigation {"overlayMenu":"never","className":"qw-footer-nav","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|sm"},"color":{"text":"var:preset|color|cream"},"spacing":{"blockGap":"var:preset|spacing|3"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<!-- wp:navigation-link {"label":"Services","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Work","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Journal","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"About","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">

			<!-- wp:paragraph {"className":"qw-eyebrow","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|2xs","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.18em"},"color":{"text":"var:preset|color|ochre"},"spacing":{"margin":{"bottom":"var:preset|spacing|5"}}}} -->
			<p class="qw-eyebrow" style="color:var(--wp--preset--color--ochre)">Get in touch</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|sm","lineHeight":"1.9"},"color":{"text":"var:preset|color|cream"}}} -->
			<p style="color:var(--wp--preset--color--cream);line-height:1.9"><a href="mailto:hello@example.com">hello@example.com</a><br><a href="#">Instagram</a><br><a href="#">LinkedIn</a></p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"className":"is-style-wide","style":{"color":{"background":"var:preset|color|ink-medium"},"spacing":{"margin":{"top":"var:preset|spacing|12","bottom":"var:preset|spacing|6"}}}} -->
	<hr class="wp-block-separator has-text-color has-alpha-channel-opacity has-background is-style-wide" style="background-color:var(--wp--preset--color--ink-medium);color:var(--wp--preset--color--ink-medium)"/>
	<!-- /wp:separator -->

	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|2xs","letterSpacing":"0.04em"},"color":{"text":"var:preset|color|ink-muted"}}} -->
	<p class="has-text-align-center" style="color:var(--wp--preset--color--ink-muted)">&copy; 2026 Quillwork Editorial Studio. All rights reserved. Quillwork&trade; is a trademark of the studio.</p>
	<!-- /wp:paragraph -->

</footer>
<!-- /wp:group -->
