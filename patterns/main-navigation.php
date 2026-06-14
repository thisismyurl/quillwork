<?php
/**
 * Title: Main Navigation
 * Slug: quillwork/main-navigation
 * Categories: quillwork-editorial
 * Viewport Width: 1280
 * Inserter: true
 * Description: Editorial header bar on cream — a Cormorant Garamond italic "Quillwork" wordmark to the left, DM Sans navigation links and a "Start a project" button to the right, closed by a thin teal underline.
 *
 * @package quillwork
 */
?>
<!-- wp:group {"className":"qw-section qw-section--cream qw-nav","metadata":{"categories":["quillwork-editorial"],"name":"Main Navigation"},"tagName":"header","style":{"spacing":{"padding":{"top":"var:preset|spacing|6","bottom":"var:preset|spacing|6","left":"var:preset|spacing|8","right":"var:preset|spacing|8"}},"color":{"background":"var:preset|color|cream","text":"var:preset|color|ink-deep"},"border":{"bottom":{"color":"var:preset|color|teal","style":"solid","width":"1px"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<header class="wp-block-group qw-section qw-section--cream qw-nav has-text-color has-background" style="border-bottom-color:var(--wp--preset--color--teal);border-bottom-style:solid;border-bottom-width:1px;background-color:var(--wp--preset--color--cream);color:var(--wp--preset--color--ink-deep)">

	<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|8"}}} -->
	<div class="wp-block-group">

		<!-- The wordmark is site identity, not a page heading. Kept as a styled
		     paragraph (not an h1) so inserting this header bar never creates a
		     second h1 alongside a template's page title (WCAG 2.1 1.3.1). -->
		<!-- wp:paragraph {"className":"qw-wordmark","style":{"typography":{"fontFamily":"var:preset|font-family|cormorant","fontStyle":"italic","fontWeight":"300","fontSize":"var:preset|font-size|2xl","lineHeight":"1","letterSpacing":"-0.02em"},"color":{"text":"var:preset|color|ink-deep"}}} -->
		<p class="qw-wordmark" style="font-family:var(--wp--preset--font-family--cormorant);font-size:var(--wp--preset--font-size--2xl);font-style:italic;font-weight:300;line-height:1;letter-spacing:-0.02em;color:var(--wp--preset--color--ink-deep)">Quillwork</p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|7"}}} -->
		<div class="wp-block-group">

			<!-- wp:navigation {"overlayMenu":"mobile","className":"qw-nav-links","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|sm","fontWeight":"500"},"color":{"text":"var:preset|color|ink-deep"},"spacing":{"blockGap":"var:preset|spacing|7"}},"layout":{"type":"flex","orientation":"horizontal"}} -->
				<!-- wp:navigation-link {"label":"Services","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Work","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Journal","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"About","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"style":{"color":{"background":"var:preset|color|teal","text":"var:preset|color|cream"},"border":{"radius":"0"},"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|2xs"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.75rem","right":"1.75rem"}}}} -->
				<div class="wp-block-button">
					<a class="wp-block-button__link wp-element-button" href="#" style="border-radius:0;background-color:var(--wp--preset--color--teal);color:var(--wp--preset--color--cream)"><?php esc_html_e( 'Start a project', 'quillwork' ); ?></a>
				</div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</header>
<!-- /wp:group -->
