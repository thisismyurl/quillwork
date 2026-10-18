=== Quillwork ===
Contributors: thisismyurl
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.6291.1554
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, portfolio, one-column, two-columns, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, block-patterns, rtl-language-support, wide-blocks, threaded-comments

Quillwork WordPress Theme, Copyright 2026 Christopher Ross
Quillwork is distributed under the terms of the GNU GPL v2 or later.

An elegant, type-led full-site-editing theme for writers, editors, and personal brands.

== Description ==

Quillwork is a full-site-editing theme built for people whose work is words —
freelance writers, editors, copywriters, and anyone running a personal brand
around their writing. The name is about type-craft: the quill is the writer's
tool, and the theme is shaped around the reading experience rather than around
widgets or page-builder scaffolding.

The look is editorial and calm. Light Cormorant Garamond display headlines, with
italic accents for emphasis, sit above a quiet Newsreader reading column, and DM
Sans handles the eyebrows, navigation, and metadata. The palette pairs a deep
teal and a warm ochre with a coral highlight on a cream ground — restrained
enough to keep the writing in the foreground.

Quillwork is a block theme: every template, template part, and page layout is
editable in the Site Editor with no code. It ships with a small set of block
patterns that translate a complete writer-portfolio home page into core blocks —
a hero, a numbered services grid, a testimonials band, an about-and-stats
section, and a contact band — so a new site can be assembled in minutes and then
re-written to taste.

There are no plugin dependencies. The theme uses only WordPress core blocks, so
nothing breaks when a plugin is deactivated, and there is no lock-in.

== Key features ==

* Full-site editing — every template and template part editable in the Site Editor.
* Six block patterns translating a complete writer-portfolio home page (see below).
* Four custom block styles — Eyebrow, Service Card, Stat Block, and Highlight.
* Built on WordPress core blocks only — zero plugin dependencies.
* Accessibility-minded — skip link, visible focus outlines, semantic heading order.
* Light on the front end — self-hosted fonts with `font-display: swap`, no third-party requests, no front-end JavaScript framework.
* Self-hosted fonts under the SIL Open Font License 1.1 — no calls to Google Fonts, no third-party connections.
* Fluid typography and spacing scales that adapt from mobile to desktop without breakpoints.
* RTL-ready through CSS logical properties throughout.
* Translatable — PHP and pattern strings use the `quillwork` text domain; some template headings are plain text you can edit in the Site Editor.
* Decorative motion (the hero's floating accents) honours `prefers-reduced-motion`.

== Installation ==

1. In your WordPress admin, go to Appearance > Themes > Add New.
2. Click Upload Theme and choose the Quillwork .zip file, then click Install Now.
   (Or upload the `quillwork` folder to `wp-content/themes/` over SFTP.)
3. Click Activate.
4. Go to Appearance > Editor to edit templates, or create a page and insert the
   Quillwork patterns from the block inserter (the "Quillwork: Sections" category).

No additional plugins are required.

== Fonts ==

Quillwork self-hosts three font families. None are loaded from Google Fonts or
any third-party host — the WOFF2 files ship with the theme and are declared as
`@font-face` rules in `theme.json` with `font-display: swap`. Each family also
ships its license file. The font stacks list Georgia and system fallbacks, so
text still renders if a file is ever removed.

* Cormorant Garamond (variable, normal + italic) — display headlines.
* Newsreader (variable, normal + italic) — body and reading column.
* DM Sans (variable) — UI, eyebrows, navigation, and metadata.

All three are licensed under the SIL Open Font License 1.1
(https://scripts.sil.org/OFL), which is compatible with the GPL. The per-family
`OFL.txt` files live alongside the WOFF2 files under `assets/fonts/`.

== Block Patterns ==

All patterns use core blocks only and appear under the "Quillwork: Sections"
category in the block inserter:

* Hero — Light Serif Headline (`quillwork/hero`): an eyebrow, a light Cormorant headline with an italic teal accent, a subtitle, a dual call to action, and a decorative ochre float accent.
* Services — Numbered Cards (`quillwork/services`): a four-card grid with large ghost numerals, serif titles, descriptions, and arrow-bulleted feature lists.
* Testimonials — Ink Band (`quillwork/testimonials`): a deep-teal section with three quote cards, each carrying an oversized ochre quote glyph, an italic quote, and a credited author.
* About + Stats — Two Column (`quillwork/about-stats`): editorial copy with a coral-bordered pull-quote highlight beside a 2x2 grid of stat cards.
* Contact — Centred CTA (`quillwork/contact`): a centred band with a heading, subtitle, email and location methods, and a single primary call to action.

== Upgrade Notice ==

= 1.6291.1554 =
Redesign compared with 1.6165.1300: five style variations, two templates, one template part and five patterns are removed. Check your site on a staging copy before updating if you use any of them.

== Changelog ==

= 1.6291.1554 =
* Pre-release review fixes. The preview/ folder (4 MB of screenshots and pages that loaded Google Fonts) is now explicitly excluded from the theme package. The 404 "Back to home" button now uses the site's home URL instead of a fixed "/", so it works on subdirectory installs. Side padding on the page root and footer used keys WordPress ignores (start/end); it now uses left/right.
* theme.json now validates against the WordPress schema. Non-schema comment keys and two unsupported settings were removed; the notes are in ARCHITECTURE.md.
* Corrected tags and claims. The sticky-post and translation-ready tags are removed because neither is fully implemented, and the unmeasured WCAG 2.2 AA and Core Web Vitals claims are gone.
* Theme URI and footer credit links now point to themes.thisismyurl.com.
* Compared with 1.6165.1300, the version previously on WordPress.org, this release is a redesign, not a patch. Removed: the page-blank and search templates, the post-meta template part, the five style variations (Hazel, Minimal, Nightfall, Parchment, Studio Dark), and the main-navigation, service-grid, services-cta, studio-footer and studio-hero patterns. Added: the about-stats, contact, front-page, hero, services and testimonials patterns. Pages assigned the page-blank template will use the default page template until you pick another.
* 1.6291 changes (fixed invalid block markup in the Site Editor) are included.

= 1.6291 =
* Fixed "Block contains unexpected or invalid content" in the Site Editor. Some templates, template parts and patterns held hand-written block markup that did not match what the block would save, so the editor flagged those blocks as invalid and offered to recover them. All block markup in this theme now matches the editor's own output.
* Removed stray HTML comments that sat between or inside blocks. The editor treats text outside a block as an unrecognised block, which is what WordPress.org's theme review check reports as an incomplete template.
* No visual change.

= 1.6265.1630 =
* Fixed a rendering bug: theme.json and several patterns referenced
  --wp--preset--font-size--2xl/--3xl directly, but WordPress kebab-cases
  that to --2-xl/--3-xl when it emits the custom property, so affected
  headings were silently falling back to an inherited size. Corrected
  throughout.
* Fixed a fatal-error risk: inc/cli.php was required whenever WP_CLI was
  defined, with no file_exists() guard. Any build that left the file out
  would fatal on every WP-CLI command. The require is now guarded, and
  the file is also excluded from the distribution package.
* inc/bindings.php now registers the quillwork/footer-credit block-bindings
  source that parts/footer.html has bound its credit line to since the line
  existed. The source was never registered, so the credit rendered as an
  empty paragraph in every footer.
* settings.typography.defaultFontSizes and
  settings.spacing.defaultSpacingSizes set to false, so the editor's own
  auto-generated presets stop merging with this theme's own curated set.
* Internal PHP in inc/bootstrap.php, inc/setup.php, inc/assets.php,
  inc/bindings.php and inc/admin.php now uses a flat quillwork_ function
  prefix instead of namespace declarations, matching the pattern
  WordPress.org theme review approved on Masthead (a namespace is accepted
  only at the class level). No visible change.
* The bundled self-updater (inc/github-updater.php) is gone. Themes hosted
  on WordPress.org get their updates from WordPress.org, not their own
  code.
* SECURITY.md, CODE_OF_CONDUCT.md and CONTRIBUTING.md are excluded from
  the distribution package. They belong on GitHub, not in the installed
  theme.

= 1.6152.0832 =
* Added GPL copyright notice to style.css for Theme Check compliance.
* Removed UTM parameters from Theme URI.
* Lowered Requires at least to 6.6 (actual minimum: theme.json v3).

= 1.6148 =
* Updated Theme URI to https://thisismyurl.com/quillwork.
* Fixed Services — Numbered Cards pattern: removed aria-hidden from number paragraphs to resolve block validation recovery prompt.
* Removed external video iframes from the admin onboarding page for WordPress.org compliance.

= 1.6147 =
* Unified versioning to the x.Yddd calendar scheme used across the This Is My URL family.
* Confirmed compatibility with WordPress 7.0.


= 1.0.0 =
* Initial release.

== Credits ==

Bundled fonts, all under the SIL Open Font License 1.1
(https://scripts.sil.org/OFL):

* Cormorant Garamond — Christian Thalmann (Catharsis Fonts). https://fonts.google.com/specimen/Cormorant+Garamond
* Newsreader — Production Type. https://fonts.google.com/specimen/Newsreader
* DM Sans — Colophon Foundry and the Indian Type Foundry. https://fonts.google.com/specimen/DM+Sans

Theme design and development — Christopher Ross (https://thisismyurl.com).

== Copyright ==

Quillwork WordPress Theme, (C) 2026 Christopher Ross.
Quillwork is distributed under the terms of the GNU General Public License v2 or later.

This theme bundles the following third-party resources:

Cormorant Garamond font
Copyright 2015 The Cormorant Project Authors (https://github.com/CatharsisFonts/Cormorant)
License: SIL Open Font License 1.1 (https://scripts.sil.org/OFL)

Newsreader font
Copyright 2020 The Newsreader Project Authors (https://github.com/productiontype/Newsreader)
License: SIL Open Font License 1.1 (https://scripts.sil.org/OFL)

DM Sans font
Copyright 2014 The DM Sans Project Authors (https://github.com/googlefonts/dm-fonts)
License: SIL Open Font License 1.1 (https://scripts.sil.org/OFL)
