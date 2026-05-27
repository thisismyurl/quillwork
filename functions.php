<?php
/**
 * Colophon — theme entry point (thin loader, nothing more).
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
require_once __DIR__ . '/inc/setup.php';     // [CORE] theme supports, i18n, nav menus, skip link.
require_once __DIR__ . '/inc/assets.php';    // [CORE] cascade-ordered stylesheet enqueue + font preload.
require_once __DIR__ . '/inc/bindings.php';  // [CORE] footer copyright-year + removable credit (block bindings).
require_once __DIR__ . '/inc/skin.php';      // [SKIN] this theme's image sizes, fonts, block styles, onboarding copy.

// [CORE][REMOVABLE] GitHub release updater. Delete inc/github-updater.php to
// remove it entirely (this guard makes deletion safe). Remove before a
// WordPress.org submission — see the file header. Loaded unconditionally, not in
// the is_admin() block: the theme-update transient is also checked on front-end
// cron, so admin-only loading would skip the scheduled check.
if ( file_exists( __DIR__ . '/inc/github-updater.php' ) ) {
	require_once __DIR__ . '/inc/github-updater.php';
}

if ( is_admin() ) {
	require_once __DIR__ . '/inc/admin.php'; // [CORE] WP.org-compliant Get-started page + welcome notice.
}
