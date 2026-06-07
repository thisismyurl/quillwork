<?php
/**
 * Title: Service Grid
 * Slug: quillwork/service-grid
 * Categories: quillwork-services
 * Viewport Width: 1280
 * Inserter: true
 * Description: Four-column numbered service cards with teal left-border hover accent and ochre Cormorant numeral. Replace the card copy with your own services.
 *
 * [SKIN] Numbered service cards — each carries an ochre Cormorant numeral
 * (opacity 0.3, weight 300, display scale) and a teal left-border hover state.
 * The 4-column grid collapses to 2 on tablet and 1 on mobile via theme.json
 * responsive behaviour.
 *
 * @package quillwork
 */
?>
<!-- wp:group {"className":"qw-section qw-section--white","metadata":{"categories":["quillwork-services"],"name":"Service Grid"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16","left":"var:preset|spacing|8","right":"var:preset|spacing|8"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group qw-section qw-section--white">

	<!-- wp:paragraph {"className":"qw-eyebrow","style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|xs","fontWeight":"500","textTransform":"uppercase","letterSpacing":"0.18em"},"color":{"text":"var:preset|color|teal"},"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}}} -->
	<p class="qw-eyebrow" style="color:var(--wp--preset--color--teal)">Services</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|6"}}}} -->
	<div class="wp-block-columns">

		<?php
		$services = [
			[ '01', 'Brand Identity',    'Wordmarks, visual systems, and brand guidelines built to last twenty years, not two.' ],
			[ '02', 'Type Direction',    'Custom type pairing and variable-font implementation — the typographic voice of your brand.' ],
			[ '03', 'Editorial Design',  'Book series templates, magazine grids, annual reports — print and digital in one system.' ],
			[ '04', 'Web & Screen',      'WordPress FSE themes and component systems that carry the identity online without losing it.' ],
		];
		foreach ( $services as [$num, $title, $body] ) :
		?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"qw-service-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|8","right":"var:preset|spacing|8"}},"color":{"background":"var:preset|color|cream"},"border":{"left":{"style":"solid","width":"4px","color":"transparent"}}},"layout":{"type":"default"}} -->
			<div class="wp-block-group qw-service-card">

				<!-- wp:heading {"level":3,"style":{"typography":{"fontFamily":"var:preset|font-family|cormorant","fontSize":"var:preset|font-size|3xl","fontWeight":"300","lineHeight":"1"},"color":{"text":"var:preset|color|ochre"},"opacity":"0.3","spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
				<h3 style="font-family:var(--wp--preset--font-family--cormorant);font-size:var(--wp--preset--font-size--3xl);font-weight:300;line-height:1;color:var(--wp--preset--color--ochre);opacity:0.3"><?php echo esc_html( $num ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:heading {"level":4,"style":{"typography":{"fontFamily":"var:preset|font-family|cormorant","fontSize":"var:preset|font-size|xl","fontWeight":"600","letterSpacing":"-0.01em"},"color":{"text":"var:preset|color|ink-deep"},"spacing":{"margin":{"bottom":"var:preset|spacing|3"}}}} -->
				<h4 style="font-family:var(--wp--preset--font-family--cormorant);font-size:var(--wp--preset--font-size--xl);font-weight:600;color:var(--wp--preset--color--ink-deep)"><?php echo esc_html( $title ); ?></h4>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"style":{"typography":{"fontFamily":"var:preset|font-family|dm-sans","fontSize":"var:preset|font-size|sm"},"color":{"text":"var:preset|color|ink-muted"}}} -->
				<p style="color:var(--wp--preset--color--ink-muted)"><?php echo esc_html( $body ); ?></p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
