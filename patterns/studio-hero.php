<?php
/**
 * Title: Studio Hero
 * Slug: quillwork/studio-hero
 * Categories: quillwork-hero
 * Viewport Width: 1280
 * Inserter: true
 * Description: Full-height cream hero with Cormorant Garamond display headline and decorative ochre float accent. No photography required — the type is the hero.
 *
 * [SKIN] The Quillwork signature feature: the studio name or headline at
 * display scale in Cormorant Garamond weight 300 IS the hero. No stock photo.
 * No decorative mesh gradient. Restrained ochre circles (CSS-only, no image
 * asset required) provide movement without distraction.
 *
 * @package quillwork
 */
?>
<!-- wp:group {"className":"qw-section qw-section--cream","metadata":{"categories":["quillwork-hero"],"name":"Studio Hero"},"style":{"dimensions":{"minHeight":"85dvh"},"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|12","left":"var:preset|spacing|8","right":"var:preset|spacing|8"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group qw-section qw-section--cream" style="min-height:85dvh">

	<!-- wp:group {"layout":{"type":"constrained","contentSize":"780px","justifyContent":"left"},"style":{"spacing":{"blockGap":"var:preset|spacing|6"}}} -->
	<div class="wp-block-group">

		<!-- wp:paragraph {"className":"qw-eyebrow","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|xs","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.18em"},"color":{"text":"var:preset|color|teal"}}} -->
		<p class="qw-eyebrow" style="color:var(--wp--preset--color--teal)">Brand &middot; Type &middot; Identity</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"style":{"typography":{"fontFamily":"var:preset|font-family|cormorant","fontWeight":"300","fontSize":"var:preset|font-size|display","lineHeight":"1.0","letterSpacing":"-0.03em"},"color":{"text":"var:preset|color|ink-deep"}}} -->
		<h1 style="font-family:var(--wp--preset--font-family--cormorant);font-size:var(--wp--preset--font-size--display);font-weight:300;line-height:1.0;letter-spacing:-0.03em;color:var(--wp--preset--color--ink-deep)">Design for<br><em style="color:var(--wp--preset--color--teal)">enduring</em><br>work.</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|lg","lineHeight":"1.7"},"color":{"text":"var:preset|color|ink-medium"},"spacing":{"margin":{"top":"var:preset|spacing|2"}}}} -->
		<p style="color:var(--wp--preset--color--ink-medium);line-height:1.7">An independent studio specialising in visual identities, editorial systems, and type-led design for publishers, cultural institutions, and independent makers.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|4"}}}} -->
		<div class="wp-block-buttons">
			<!-- wp:button {"style":{"color":{"background":"var:preset|color|ink-deep","text":"var:preset|color|cream"},"border":{"radius":"0"},"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"var:preset|font-size|xs"},"spacing":{"padding":{"top":"0.875rem","bottom":"0.875rem","left":"2.5rem","right":"2.5rem"}}}} -->
			<div class="wp-block-button">
				<a class="wp-block-button__link wp-element-button" href="#" style="border-radius:0;background-color:var(--wp--preset--color--ink-deep);color:var(--wp--preset--color--cream)">View Selected Work</a>
			</div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
