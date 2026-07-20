<?php
/**
 * [CORE] Admin onboarding — a "Get started" page and a dismissible welcome notice.
 *
 * This is the mechanism, and it's portable. Every theme in the line inherits a
 * WordPress.org-compliant onboarding flow for free; the WORDS on the page come
 * from the theme, supplied through the `QUILLWORK_SLUG . '/get_started_content'` filter
 * (inc/skin.php is the conventional home for it). Core ships a plain, honest default so the page is coherent even
 * before a theme writes its own copy.
 *
 * WordPress.org compliance note (load-bearing — do not "improve" this away):
 * activation sets a one-time flag and shows a *dismissible admin notice* that
 * links to the page. It does NOT redirect the admin on activation. The Theme
 * Review Team rejects activation redirects; the user clicks through only if
 * they want to. The single wp_safe_redirect() below is in the post-dismiss
 * handler, after a state change — never on activation.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option name for the one-time welcome flag.
 *
 * An option, not a transient: it must survive an object-cache flush and clear
 * deterministically. Stored autoload=no — it is read only on wp-admin requests.
 */
define( 'QUILLWORK_WELCOME_FLAG', 'quillwork_welcome_notice' );

/**
 * admin_post action + nonce action string for dismissing the welcome notice.
 */
define( 'QUILLWORK_DISMISS_ACTION', 'quillwork_dismiss_welcome' );

/**
 * Admin-menu slug for the Get-started page.
 */
define( 'QUILLWORK_GET_STARTED_SLUG', 'quillwork-get-started' );

/**
 * Raise the one-time welcome flag when the theme becomes active.
 *
 * after_switch_theme fires once, on the activating request — the correct hook
 * for a one-time cue. autoload=no keeps it off the front-end option bundle.
 */
function quillwork_flag_welcome_notice(): void {
	add_option( QUILLWORK_WELCOME_FLAG, '1', '', 'no' );
}
add_action( 'after_switch_theme', 'quillwork_flag_welcome_notice' );

/**
 * Clear the welcome flag — from the dismiss handler, and once the user reaches
 * the Get-started page (seeing it is its own dismissal).
 */
function quillwork_clear_welcome_notice(): void {
	delete_option( QUILLWORK_WELCOME_FLAG );
}

/**
 * Register the "Get started" page under Appearance.
 *
 * The required capability comes from quillwork_get_onboarding_capability() — default is
 * edit_theme_options (users who can switch themes and configure global styles),
 * filterable via QUILLWORK_SLUG . '/onboarding_capability'.
 */
function quillwork_register_get_started_page(): void {
	add_theme_page(
		/* translators: %s: theme name. */
		sprintf( esc_html__( '%s: Get started', 'quillwork' ), quillwork_get_theme_name() ),
		quillwork_get_theme_name(),
		quillwork_get_onboarding_capability(),
		QUILLWORK_GET_STARTED_SLUG,
		'quillwork_render_get_started_page'
	);
}
add_action( 'admin_menu', 'quillwork_register_get_started_page' );

/**
 * The active theme's display name, for headings and notices.
 *
 * @return string The theme Name from the style.css header.
 */
function quillwork_get_theme_name(): string {
	return (string) wp_get_theme()->get( 'Name' );
}

/**
 * The WordPress capability required to view and dismiss the onboarding flow.
 *
 * Centralised so the filter changes the check in all four places at once — the
 * menu registration, the notice render, the dismiss handler, and the page render.
 * Default 'edit_theme_options' targets users who can switch themes and configure
 * global styles: the right audience for onboarding copy.
 *
 * @return string WordPress capability slug.
 */
function quillwork_get_onboarding_capability(): string {
	/**
	 * Filters the capability required to see the Get-started page and welcome notice.
	 *
	 * Raise to 'manage_options' on multi-author sites where editors should not
	 * see theme onboarding. Lower to any custom capability for a tighter fit.
	 *
	 * @since 1.6150
	 *
	 * @param string $capability WordPress capability slug.
	 */
	return (string) apply_filters( QUILLWORK_SLUG . '/onboarding_capability', 'edit_theme_options' );
}

/**
 * Enqueue the Get-started stylesheet on its own screen only.
 *
 * The $hook_suffix for an add_theme_page() screen is 'appearance_page_{slug}';
 * gating on it means nothing here loads on any other admin screen.
 *
 * @param string $hook_suffix The current admin page's hook suffix.
 */
function quillwork_enqueue_get_started_assets( string $hook_suffix ): void {
	if ( 'appearance_page_' . QUILLWORK_GET_STARTED_SLUG !== $hook_suffix ) {
		return;
	}

	$sheet = QUILLWORK_DIR . '/assets/css/admin-get-started.css';
	if ( ! file_exists( $sheet ) ) {
		return;
	}

	wp_enqueue_style(
		QUILLWORK_SLUG . '-get-started',
		QUILLWORK_URI . '/assets/css/admin-get-started.css',
		array(),
		(string) filemtime( $sheet )
	);
}
add_action( 'admin_enqueue_scripts', 'quillwork_enqueue_get_started_assets' );

/**
 * Show the dismissible welcome notice while the flag is set.
 *
 * Shown only to users who pass quillwork_get_onboarding_capability(), and never on the Get-started
 * page itself. A standard `notice is-dismissible`, so core renders the close
 * button and handles keyboard dismissal; the persistent server-side dismissal
 * rides the nonce link.
 */
function quillwork_render_welcome_notice(): void {
	if ( ! current_user_can( quillwork_get_onboarding_capability() ) ) {
		return;
	}

	if ( '1' !== get_option( QUILLWORK_WELCOME_FLAG ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( $screen instanceof \WP_Screen && 'appearance_page_' . QUILLWORK_GET_STARTED_SLUG === $screen->id ) {
		return;
	}

	$page_url  = admin_url( 'themes.php?page=' . QUILLWORK_GET_STARTED_SLUG );
	$theme     = quillwork_get_theme_name();
	$dismiss   = wp_nonce_url( admin_url( 'admin-post.php?action=' . QUILLWORK_DISMISS_ACTION ), QUILLWORK_DISMISS_ACTION );
	?>
	<div class="notice notice-info is-dismissible quillwork-welcome-notice">
		<p>
			<strong>
				<?php
				/* translators: %s: theme name. */
				printf( esc_html__( 'Welcome to %s.', 'quillwork' ), esc_html( $theme ) );
				?>
			</strong>
			<?php esc_html_e( 'Thanks for giving it a home. A few small steps will have your site reading the way it should.', 'quillwork' ); ?>
		</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $page_url ); ?>">
				<?php
				/* translators: %s: theme name. */
				printf( esc_html__( 'Set up %s →', 'quillwork' ), esc_html( $theme ) );
				?>
			</a>
			<a class="quillwork-welcome-notice__dismiss" href="<?php echo esc_url( $dismiss ); ?>">
				<?php esc_html_e( 'Dismiss', 'quillwork' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'quillwork_render_welcome_notice' );

/**
 * Handle the persistent dismissal of the welcome notice.
 *
 * State-changing request, so the order holds: capability check, nonce, then the
 * mutation. Redirects back to the dashboard so a refresh does not replay it.
 */
function quillwork_handle_welcome_dismiss(): void {
	if ( ! current_user_can( quillwork_get_onboarding_capability() ) ) {
		wp_die( esc_html__( 'You do not have permission to do that.', 'quillwork' ) );
	}

	check_admin_referer( QUILLWORK_DISMISS_ACTION );
	quillwork_clear_welcome_notice();
	wp_safe_redirect( admin_url() );
	exit;
}
add_action( 'admin_post_' . QUILLWORK_DISMISS_ACTION, 'quillwork_handle_welcome_dismiss' );

/**
 * The Get-started page content.
 *
 * Core supplies a plain, honest default so the page is coherent out of the box.
 * A theme overrides any part of it through the `QUILLWORK_SLUG . '/get_started_content'`
 * filter in inc/skin.php — that is where each theme's voice lives, kept out of
 * this synced file.
 *
 * @return array{lead:string,steps:array<int,array{title:string,body:string}>,optimize:string[],credit:string,developers:array{text:string,url:string,label:string}} The page content.
 */
function quillwork_get_started_content(): array {
	$theme = quillwork_get_theme_name();

	$default = array(
		'lead'     => sprintf(
			/* translators: %s: theme name. */
			esc_html__( '%s is a free, full-site-editing theme built to get out of the way of your content. Here is how to make it yours.', 'quillwork' ),
			$theme
		),
		/*
		 * Step titles, the developer-guide label, and the developer-guide text below
		 * stay bare __() ON PURPOSE. Each is escaped with esc_html() at the point of
		 * echo in quillwork_render_get_started_page() (the 'title' at the <strong>,
		 * the 'label' inside the anchor, the 'text' as the sprintf format). Wrapping
		 * them in esc_html__() here would escape the same string twice, so an
		 * apostrophe would render on screen as a literal &#039;. Every other
		 * translated string in this theme uses esc_html__(); these are the
		 * escape-at-output exceptions.
		 *
		 * WP.org ticket #280625 (Masthead, same shared core) asked for esc_html__
		 * everywhere. It is right almost everywhere — but not where the value is
		 * escaped again at output, so these are annotated rather than converted.
		 */
		'steps'    => array(
			array(
				'title' => __( 'Choose what people land on.', 'quillwork' ),
				'body'  => esc_html__( "A visitor's first second decides whether they stay. Set a static front page under Settings → Reading, and give your posts a page of their own.", 'quillwork' ),
			),
			array(
				'title' => __( 'Give people a way around.', 'quillwork' ),
				'body'  => esc_html__( 'A site without a menu is a room without doors. Open the Site Editor, edit the header, and assign your menu to Primary Navigation.', 'quillwork' ),
			),
			array(
				'title' => __( 'Start from a pattern, not a blank page.', 'quillwork' ),
				'body'  => esc_html__( 'In any page or post, open the block inserter, choose Patterns, and find this theme\'s group. Drop one in and change the words.', 'quillwork' ),
			),
			array(
				'title' => __( 'Make it sound like you.', 'quillwork' ),
				'body'  => esc_html__( 'In the Site Editor, open Styles to change colours and typefaces. Nothing you do there can break the theme — experiment freely.', 'quillwork' ),
			),
		),
		'optimize' => array(
			esc_html__( "This theme is built to stay light: self-hosted fonts that don't phone home, and styling tuned against the Core Web Vitals search engines actually measure. Keep your own images sized for the web and the site stays fast.", 'quillwork' ),
			esc_html__( 'Accessibility is designed in, not bolted on — visible focus outlines, a skip link, sensible heading order, and motion that respects a reduce-motion setting. This is guidance about what the theme provides, not a formal conformance certification; audit your finished site with your own content and plugins in place.', 'quillwork' ),
		),
		'credit'   => esc_html__( "There's a small credit in your footer. It's a thank-you, not a tax — remove it in two clicks in the Site Editor → Footer, or filter it out in code. No hard feelings either way.", 'quillwork' ),
		'developers' => array(
			/* translators: %s: linked developer-guide anchor. */
			'text'  => __( 'This theme is built on Colophon, a small documented core meant to be reused. The %s walks through how to build your own theme on it.', 'quillwork' ),
			'url'   => apply_filters( QUILLWORK_SLUG . '/developer_guide_url', 'https://thisismyurl.com/colophon' ), // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
			'label' => __( 'developer guide', 'quillwork' ),
		),
	);

	/**
	 * Filters the Get-started page content.
	 *
	 * A theme replaces any key with its own voice. See quillwork_get_started_content() for
	 * the array shape.
	 *
	 * @since 1.0.0
	 *
	 * @param array $default The default page content.
	 */
	return (array) apply_filters( QUILLWORK_SLUG . '/get_started_content', $default );
}

/**
 * Render the "Get started" page.
 *
 * One <h1>, then <h2> sections in reading order. All dynamic output is escaped
 * at the point of echo. Reaching this page clears the welcome flag.
 */
function quillwork_render_get_started_page(): void {
	if ( ! current_user_can( quillwork_get_onboarding_capability() ) ) {
		return;
	}

	quillwork_clear_welcome_notice();

	$theme   = quillwork_get_theme_name();
	$content = quillwork_get_started_content();

	// Step / lead / optimize / credit bodies may carry inline links to admin
	// destinations (a theme links its setup steps to Settings, the Site Editor,
	// and so on), so they render through a link-only kses allow-list rather than
	// esc_html. Step titles stay plain text.
	$cl_inline = array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) );
	?>
	<div class="wrap quillwork-get-started">

		<h1>
			<?php
			/* translators: %s: theme name. */
			printf( esc_html__( '%s: Get started', 'quillwork' ), esc_html( $theme ) );
			?>
		</h1>

		<?php if ( ! empty( $content['lead'] ) ) : ?>
			<p class="quillwork-get-started__lead"><?php echo wp_kses( $content['lead'], $cl_inline ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $content['steps'] ) && is_array( $content['steps'] ) ) : ?>
			<h2><?php esc_html_e( 'Set up', 'quillwork' ); ?></h2>
			<ol class="quillwork-get-started__steps">
				<?php foreach ( $content['steps'] as $step ) : ?>
					<li>
						<strong><?php echo esc_html( $step['title'] ?? '' ); ?></strong>
						<?php echo wp_kses( $step['body'] ?? '', $cl_inline ); ?>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>

		<?php if ( ! empty( $content['optimize'] ) && is_array( $content['optimize'] ) ) : ?>
			<h2><?php esc_html_e( 'Optimize', 'quillwork' ); ?></h2>
			<?php foreach ( $content['optimize'] as $para ) : ?>
				<p><?php echo wp_kses( $para, $cl_inline ); ?></p>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if ( ! empty( $content['credit'] ) ) : ?>
			<h2><?php esc_html_e( 'The footer credit', 'quillwork' ); ?></h2>
			<p><?php echo wp_kses( $content['credit'], $cl_inline ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $content['developers']['text'] ) ) : ?>
			<h2><?php esc_html_e( 'For developers', 'quillwork' ); ?></h2>
			<p>
				<?php
				$dev  = $content['developers'];
				$link = '<a href="' . esc_url( $dev['url'] ?? '' ) . '" target="_blank" rel="noopener noreferrer">'
					. esc_html( $dev['label'] ?? '' ) . '</a>';
				// sprintf builds the composed string; wp_kses then sanitizes the
				// result against the minimal anchor allow-list. Both the format
				// string and the link are escaped before composition, and the
				// composed output is filtered after — belt-and-braces, no suppression.
				echo wp_kses(
					sprintf( esc_html( $dev['text'] ?? '' ), $link ),
					array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) )
				);
				?>
			</p>
		<?php endif; ?>

	</div>
	<?php
}
