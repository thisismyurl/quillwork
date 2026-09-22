<?php
/**
 * Quillwork — theme entry point (thin loader, nothing more).
 *
 * All behaviour lives in inc/, split one concern per file, so this file stays a
 * table of contents you can read in five seconds. The single re-prefixing point
 * is inc/bootstrap.php (the namespace + the QUILLWORK_SLUG/QUILLWORK_VERSION constants).
 *
 * [CORE] This is the portable loader. The `quillwork` CLI rewrites the namespace
 * and slug on the way into each theme it generates, so a shipped theme's
 * functions.php is byte-for-byte this file with `Quillwork`/`quillwork` swapped
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
require_once __DIR__ . '/inc/skin.php';      // [SKIN] this theme's image sizes, fonts, block styles, onboarding copy.

if ( is_admin() ) {
	require_once __DIR__ . '/inc/admin.php'; // [CORE] WP.org-compliant Get-started page + welcome notice.
}

// [CORE] WP-CLI commands (`wp {slug} version|info|flush`). inc/cli.php's own
// docblock has described this exact guard since the file was written, and
// .distignore already excludes it from the WP.org zip, but functions.php never
// actually required it — found 2026-09-22 while auditing Kerf and Halyard,
// where `wp kerf version` / `wp halyard version` simply did not exist.
if ( defined( 'WP_CLI' ) && \WP_CLI && file_exists( __DIR__ . '/inc/cli.php' ) ) {
	require_once __DIR__ . '/inc/cli.php';
}
