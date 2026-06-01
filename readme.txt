=== Quillwork ===
Contributors: thisismyurl
Requires at least: 6.6
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.6153
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, portfolio, one-column, two-columns, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, block-patterns, accessibility-ready, rtl-language-support, translation-ready, wide-blocks, sticky-post, threaded-comments

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
* Five block patterns translating a complete writer-portfolio home page (see below).
* Four custom block styles — Eyebrow, Service Card, Stat Block, and Highlight.
* Built on WordPress core blocks only — zero plugin dependencies.
* WCAG 2.2 AA accessibility — skip link, visible focus, semantic heading order, sufficient colour contrast.
* Core Web Vitals optimised — self-hosted fonts with `font-display: swap`, no render-blocking third-party requests, no front-end JavaScript framework.
* Self-hosted fonts under the SIL Open Font License 1.1 — no calls to Google Fonts, no third-party connections.
* Fluid typography and spacing scales that adapt from mobile to desktop without breakpoints.
* RTL-ready through CSS logical properties throughout.
* Translation-ready — every user-facing string is internationalised against the `quillwork` text domain.
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

== Changelog ==

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
