<?php
/**
 * Title: Services — Numbered Cards (4-up)
 * Slug: quillwork/services
 * Categories: quillwork-sections
 * Description: A four-column grid of numbered service cards — large ghost-ochre numeral, serif title, descriptive paragraph, and an arrow-bulleted feature list, with a left-border accent on hover.
 * Keywords: services, offerings, cards, grid, numbered, features
 * Block Types: core/group
 * Viewport Width: 1280
 *
 * [SKIN] Quillwork services grid. Card personality (ghost numeral, arrow
 * bullets, left-border hover) lives in style.css @layer components; this
 * pattern supplies structure, tokens, and copy. Headings stay h2 (section) >
 * h3 (cards) for correct document order.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","className":"qw-section qw-section--white","anchor":"services","layout":{"type":"constrained","contentSize":"1280px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16"},"blockGap":"var:preset|spacing|12"}}} -->
<section id="services" class="wp-block-group qw-section qw-section--white" style="padding-top:var(--wp--preset--spacing--16);padding-bottom:var(--wp--preset--spacing--16)">

	<!-- wp:group {"layout":{"type":"constrained","contentSize":"800px","justifyContent":"left"},"style":{"spacing":{"blockGap":"var:preset|spacing|4"}}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"className":"is-style-qw-eyebrow qw-eyebrow","textColor":"teal"} -->
		<p class="is-style-qw-eyebrow qw-eyebrow has-teal-color has-text-color"><?php esc_html_e( 'What I do', 'quillwork' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e( 'What I write', 'quillwork' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"layout":{"type":"grid","minimumColumnWidth":"18rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|6"}}} -->
	<div class="wp-block-group">

		<!-- wp:group {"className":"is-style-qw-service-card qw-service-card","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|3"}}} -->
		<div class="wp-block-group is-style-qw-service-card qw-service-card">
			<!-- wp:paragraph {"className":"qw-service-card__number"} -->
			<p class="qw-service-card__number">01</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Essays and criticism', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Personal essays and cultural criticism for literary journals, magazines, and independent publications. Work that earns its space on the page.', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"qw-service-features"} -->
			<ul class="wp-block-list qw-service-features">
				<!-- wp:list-item --><li><?php esc_html_e( 'Personal and lyric essays', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Cultural and book criticism', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Literary memoir', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Magazine and journal commissions', 'quillwork' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-qw-service-card qw-service-card","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|3"}}} -->
		<div class="wp-block-group is-style-qw-service-card qw-service-card">
			<!-- wp:paragraph {"className":"qw-service-card__number"} -->
			<p class="qw-service-card__number">02</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Narrative journalism', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Reported features, profiles, and longform nonfiction that take the subject seriously and trust the reader to stay.', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"qw-service-features"} -->
			<ul class="wp-block-list qw-service-features">
				<!-- wp:list-item --><li><?php esc_html_e( 'Longform reported features', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Profiles and interviews', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Travel and place writing', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Print and digital publications', 'quillwork' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-qw-service-card qw-service-card","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|3"}}} -->
		<div class="wp-block-group is-style-qw-service-card qw-service-card">
			<!-- wp:paragraph {"className":"qw-service-card__number"} -->
			<p class="qw-service-card__number">03</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Editing and development', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Close reading and structural editing for writers who need a careful second set of eyes before submission or publication.', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"qw-service-features"} -->
			<ul class="wp-block-list qw-service-features">
				<!-- wp:list-item --><li><?php esc_html_e( 'Manuscript critique', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Developmental and line editing', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Query letter review', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Submission strategy', 'quillwork' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-qw-service-card qw-service-card","layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|3"}}} -->
		<div class="wp-block-group is-style-qw-service-card qw-service-card">
			<!-- wp:paragraph {"className":"qw-service-card__number"} -->
			<p class="qw-service-card__number">04</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php esc_html_e( 'Workshops and teaching', 'quillwork' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Craft-focused workshops for writers at every stage — in universities, literary festivals, and online. The essay as a form worth mastering.', 'quillwork' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"qw-service-features"} -->
			<ul class="wp-block-list qw-service-features">
				<!-- wp:list-item --><li><?php esc_html_e( 'Essay craft workshops', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Literary festival sessions', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'University guest lectures', 'quillwork' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php esc_html_e( 'Online writing intensives', 'quillwork' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
