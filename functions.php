<?php
/**
 * Quillwork — theme entry point (thin loader, nothing more).
 *
 * All behaviour lives in inc/, split one concern per file, so this file stays a
 * table of contents you can read in five seconds. The single re-prefixing point
 * is inc/bootstrap.php (the namespace + the SLUG/VERSION constants).
 *
 * [CORE] This is the portable loader. The `colophon` CLI rewrites the namespace
 * and slug on the way into each theme it generates, so a shipped theme's
 * functions.php is byte-for-byte this file with `Colophon`/`colophon` swapped
 * for the theme's own name. Don't add theme-specific behaviour here — it belongs
 * in inc/skin.php, the one file the CLI never overwrites.
 *
 * @package quillwork
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/inc/bootstrap.php'; // [CORE] namespace + identity constants — the one swap point.
require_once __DIR__ . '/inc/setup.php';     // [CORE] theme supports, i18n, nav menus.
require_once __DIR__ . '/inc/assets.php';    // [CORE] cascade-ordered stylesheet enqueue + font preload.
require_once __DIR__ . '/inc/bindings.php';  // [CORE] footer copyright-year + removable credit (block bindings).
require_once __DIR__ . '/inc/skin.php';      // [SKIN] Quillwork's image sizes, fonts, block styles, onboarding.

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__ . '/inc/cli.php'; // [CORE] CLI-only, zero front-end cost.
}

if ( is_admin() ) {
	require_once __DIR__ . '/inc/admin.php'; // [CORE] WP.org-compliant Get-started page + welcome notice.
}
