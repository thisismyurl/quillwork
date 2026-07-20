=== Quillwork ===
Contributors: thisismyurl
Tags: portfolio, blog, one-column, two-columns, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, block-patterns, rtl-language-support, translation-ready, wide-blocks
Requires at least: 6.7
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.6201.1029
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Quillwork WordPress Theme, Copyright 2026 Christopher Ross
Quillwork is distributed under the terms of the GNU GPL v2 or later.

A calligraphy-informed FSE theme for independent design studios — the type is the hero, no photograph required.


== Description ==

The type is the hero — no photograph required. Quillwork leads with a Cormorant Garamond display headline at full scale, so a studio's name and voice carry the front page on their own. That single thesis shapes everything: numbered service cards, a restrained teal/ochre palette, and generous whitespace that reflect the deliberate pace of high-craft studio work.

It is built for independent design studios, brand consultancies, and editorial agencies — anyone whose work is the proof, who would rather set their name in letterforms than borrow a stock image. Five style variations (Parchment, Hazel, Nightfall, Studio Dark, Minimal) let you reset the mood without touching a template.

Built on the Colophon CORE/SKIN architecture — a small, documented core meant to be reused, so the theme is as readable for the next developer as it is for the visitor.


== Installation ==

1. In your WordPress dashboard, go to Appearance → Themes → Add New.
2. Upload quillwork.zip or search for "Quillwork" in the theme directory.
3. Activate the theme.
4. Go to Appearance → Get started for the quick-setup walkthrough.

Fonts are bundled — no external font downloads required.


== Frequently Asked Questions ==

= Where is the hero image? =

Quillwork uses the studio name or a Cormorant Garamond headline as the hero. Design studios lead with type, not stock photography.

= How do I add portfolio work? =

Publish posts — they appear in the front-page grid automatically.

= Is this free? =

Yes. Quillwork is licensed under GPL v2 or later.


== Accessibility ==

Quillwork is built with accessibility in mind rather than against a certified
audit. Concretely, the theme ships:

* A "Skip to content" link as the first focusable element on every page.
* A single, explicit h1 on every template (archive and search titles are
  level:1; the blank-canvas and wide page templates carry an editor-fillable
  h1; the front page's h1 comes from the studio-hero pattern).
* Landmark structure on every template: role="banner" header, a <main> with
  id="main-content" for the skip link target, and a footer.
* Visible focus states on interactive elements (not removed in CSS).
* Layout built on CSS logical properties, which keeps focus order and spacing
  correct in both LTR and RTL.
* Contrast-audited style variations: all five variations (Parchment, Hazel,
  Nightfall, Studio Dark, Minimal) and the default were checked element-by-element
  against the ground each text and UI pair renders on once the variation's palette
  inverts. Every normal-size text pair clears 4.5:1 and every large-text and
  non-text UI pair clears 3:1, across templates, header, footer, patterns, and
  hover/focus states.

This is guidance about what the theme does, not a claim of formal WCAG 2.2 AA
certification. If you have a conformance requirement, audit your finished site
with your own content, colours, and plugins in place.


== Compatibility ==

* Requires WordPress 6.7+ and PHP 8.1+.
* Block bindings (the footer copyright and credit lines) require WordPress 6.5+;
  6.7+ is required overall for full FSE stability.
* RTL-ready via CSS logical properties (margin-inline, padding-inline, inset-*).
  WordPress 6.7+ handles block-level direction conversion automatically, so no
  separate rtl.css is shipped. Caveat: logical-property support depends on the
  visitor's browser; if RTL rendering looks wrong, confirm WordPress 6.7+ and a
  current browser. The theme has not been formally tested against specific RTL
  locales — treat RTL as logical-property-based support, not certified output.


== Developers ==

Quillwork exposes a small set of filters from the Colophon core. All examples
are PHP 7.4-compatible (the theme requires PHP 8.1, but the hooks themselves
carry no version-specific syntax).

= Building a child theme =

Quillwork is a normal block theme, so a child theme needs only a style.css
header and (optionally) a functions.php. Create a folder named
quillwork-child beside quillwork and add:

    /* style.css */
    /*
    Theme Name:  Quillwork Child
    Template:    quillwork
    Version:     1.0.0
    */

Drop a templates/ or parts/ file with the same name as a parent file to
override it, add patterns under patterns/, or hook a filter from functions.php:

    add_filter(
        'quillwork/footer_credit',
        function ( $credit ) {
            return ''; // Remove the footer credit in the child theme.
        }
    );

The CORE/SKIN split means parent updates never clobber your child's overrides.

= Filter: quillwork/developer_guide_url =

URL of the "developer guide" link shown in the Appearance → Get started panel.
Default: https://thisismyurl.com/colophon. Fires from inc/admin.php when the
Get started screen renders. Return any URL string to point it elsewhere.

    add_filter(
        'quillwork/developer_guide_url',
        function ( $url ) {
            return 'https://example.com/our-internal-theme-guide';
        }
    );

= Filter: quillwork/copyright_date_format =

PHP date-format string for the footer copyright year. Default: 'Y' (four-digit
year). Fires from inc/bindings.php when the bound copyright line renders.

    add_filter(
        'quillwork/copyright_date_format',
        function ( $format ) {
            return 'Y'; // or a literal like '2022–2026'.
        }
    );

= Filter: quillwork/copyright_text =

The fully composed copyright sentence. Default:
"© {year} {Site Title}. All rights reserved." Return any string to replace it.

    add_filter(
        'quillwork/copyright_text',
        function ( $copyright ) {
            return '© Studio Name';
        }
    );

= Filter: quillwork/footer_credit =

The "Built with the Quillwork theme." footer credit. Return an empty string to
remove it, or any string to replace it. Output is sanitised with wp_kses to a
minimal anchor allow-list.

    add_filter(
        'quillwork/footer_credit',
        function ( $credit ) {
            return ''; // Remove the credit entirely.
        }
    );


== Changelog ==

= 1.6201.1029 =
Prefixing and escaping, brought in line with the WordPress.org Theme Review Team's
current reading of the global-scope prefix requirement. Quillwork was approved
before this rule was applied to the shared core it is built on; this release
brings it forward rather than waiting for a future review to raise it.

There is no visual, layout, or content change in this release. Nothing an editor
sees or clicks is different.

* Prefixing: removed the `namespace Quillwork;` declaration from every file in inc/
  and gave each global-scope symbol the theme's own prefix: 26 functions to
  `quillwork_*`, 7 constants to `QUILLWORK_*` (file-scope `const` converted to
  `define()` so none remain bare global consts), and the WP-CLI class to
  `Quillwork_CLI_Command`. All callback registrations were rewritten to match. Hook
  names are unchanged, so any filter or action registered against this theme keeps
  working. The review team's position is that a namespace is acceptable only at the
  class level, because a WordPress site loads a large number of vendor functions
  into the global scope and a bare `function setup()` inside a namespace still
  reads as unprefixed.
* Escaping: converted 39 translated strings from `__()` to `esc_html__()`. Six keep
  bare `__()` deliberately, because each is escaped with `esc_html()` at the point of echo,
  so converting them too would escape twice and render an apostrophe as a literal
  `&#039;`. Each carries an inline comment explaining why, so the exception is not
  mistaken for an oversight.

= 1.6165.1300 =
Style-variation contrast audit (WCAG 2.1 1.4.3 / 1.4.11 / 2.4.7):
Every text and UI pair was recomputed for all five style variations plus the
default, against the colour each element actually renders on once that
variation's palette inverts. Six surfaces were below the floor and are fixed; no
palette was flattened and no variation removed.
* Fixed (Hazel): the variation's root background was Teal Light (a mid-ochre),
  so on every post, page, archive, and search view the body links (2.40:1),
  post meta (2.15:1), and eyebrows inherited a ground too dark to clear 4.5:1.
  Hazel's root now uses its own warm Cream, and the variation declares explicit
  link, heading, button, site-title, and navigation colours instead of silently
  inheriting the default theme's element styles — which meant something
  different once Hazel's palette redefined the tokens. The warm-ochre identity
  is unchanged; only the reading ground lightened.
* Fixed (header band, Nightfall + Studio Dark): the sticky header background was
  a hardcoded cream, but the site title and navigation text invert to light in
  the dark variations — light text on a light band (1.12–1.64:1). The band now
  reads from the variation's own light anchor via color-mix, so it inverts with
  the text and keeps the translucent-glass look.
* Fixed (footer tagline): the site tagline composited Cream at opacity 0.55,
  which dropped to 3.40:1 / 3.57:1 on the inverted-light footer band in Nightfall
  and Studio Dark. Raised to 0.70 (5.24:1+ everywhere) — still secondary, now
  legible across all variations.
* Fixed (footer link hover/focus): the navigation hover used Ochre
  unconditionally, which fell to 1.59:1 / 1.78:1 on the inverted-light footer
  band. Footer navigation and credit hovers now both use Paper White, which
  inverts with the band and clears 4.5:1 on every variation's footer.
* Fixed (focus ring on dark bands): the inverse focus ring was bound to Ochre,
  which failed the 3:1 non-text floor (1.59:1 / 1.78:1) on the footer and
  --section--ink bands once they inverted to light in Nightfall and Studio Dark.
  It now binds to the variation's light anchor, the band's inverse partner in
  every variation, clearing 3:1 (11–18:1) on all five.

= 1.6165.0812 =
Onboarding fix and a full contrast + i18n self-audit:
* Fixed (onboarding): the Get-started page now shows Quillwork's own copy. The
  skin filter was registered on the literal 'colophon/get_started_content', but
  the page fires the SLUG-derived 'quillwork/get_started_content' hook, so the
  bespoke lead and four setup steps never reached the page — visitors saw the
  generic core default. The skin now hooks SLUG . '/get_started_content', so the
  whole onboarding path resolves to Quillwork's voice.
* Fixed (contrast, WCAG 2.1 1.4.3): the footer copyright/trademark line in the
  Studio Footer pattern was Ink Muted on the Ink Deep band (2.23:1, below the
  4.5:1 floor for body text). It now uses Teal Tint (10.75:1). The two footer
  eyebrow labels ("Studio", "Get in touch") moved from Ochre to Teal Tint for
  the same reason, so they pass on the footer band in every style variation.
* Fixed (contrast): the footer's fine-print row in parts/footer.html was set to
  opacity 0.4, compositing Cream on Ink Deep down to 3.18:1. Raised to 0.7
  (6.48:1) — still visibly secondary, now legible.
* Fixed (contrast, style variations): the Studio Dark variation rendered its
  light sections as dark text on dark grounds (~1.3:1) because the text-role
  colours had not been inverted with the backgrounds. Rebuilt so text roles are
  light, grounds are dark, and accents are tuned — every text pair clears AA.
  Nightfall's Teal accent was lightened so eyebrows and links clear 4.5:1 on its
  dark grounds; Parchment's Ink Muted and Hazel's Teal were darkened to clear
  4.5:1 on their cream grounds. No palette was flattened; each variation keeps
  its mood.

= 1.6164.1200 =
Submission-readiness pass:
* Removed: the optional GitHub self-updater (inc/github-updater.php) and its
  opt-in filter. WordPress.org supplies theme updates, and a self-updating theme
  is not directory-eligible — the file is gone, not just disabled.
* Fixed (i18n): the index template's no-results state contained literal PHP
  (<?php esc_html_e(...) ?>) inside a block paragraph, which block templates
  never execute. Replaced with a translatable search form, matching the search
  template's retry pattern.
* Fixed (i18n): the "Skip to content" link is now rendered in PHP on
  wp_body_open via esc_html_e(), so it is translatable. It previously lived in a
  wp:html block in the header part as hardcoded English. There is still exactly
  one skip link in the rendered DOM.
* Docs: reframed the Get-started "Optimize" copy and the GitHub README away from
  an unverified "WCAG 2.2 AA" certification claim and a "zero front-end
  JavaScript" claim, to match the verifiable guidance the readme already uses.
* Docs: led the Description with the "type is the hero, no photograph" thesis;
  added a child-theme example to the Developers section.
* Cleanup: reconciled the navigation-menu and image-size registrations between
  CORE and SKIN, corrected stale parent-theme references in code comments
  (Fraunces → Cormorant Garamond, colophon/copyright → quillwork/copyright,
  Kern → the skin), and removed an awkward double-brace closure.

= 1.6163.2237 =
* Accessibility (WCAG 2.1 1.3.1): the archive and search titles are now explicit
  h1 headings; the index template gains an h1 page heading; the blank-canvas and
  wide page templates gain an empty, editor-fillable h1. (Front page and 404
  already had one.)
* Accessibility (WCAG 2.1 1.3.1): the wordmark in the Main Navigation pattern is
  now a styled paragraph, not an h1, so inserting the header bar no longer
  produces a second h1 alongside a template's page title.
* i18n: removed hardcoded English visitor prose from the 404 template (the
  "page has moved" sentence) and the search no-results state ("No results. Try a
  different search term."). The 404 page now offers the search form plus a
  core/home-link whose label WordPress supplies and translates; the search
  no-results state offers the search form to retry.
* Docs: reframed the accessibility wording from a bare "WCAG 2.2 AA accessible"
  claim to specific, verifiable guidance (skip link, explicit h1 per template,
  landmarks, visible focus, logical properties). Added an Accessibility section.
* Docs: documented the public filters (quillwork/developer_guide_url,
  quillwork/copyright_date_format, quillwork/copyright_text,
  quillwork/footer_credit) with runnable PHP 7.4-compatible examples, plus a
  Compatibility section covering the WordPress 6.5+ block-bindings requirement
  and the RTL logical-properties caveat.
* Hardened comment-form attribute injection: a guarded preg_replace (single
  replacement, null-check, no-match fallback) replaces a naive str_replace that
  could double-inject or mangle markup.
* oEmbed content width now reads theme.json contentSize (pixel-validated, 720px
  fallback) instead of a hardcoded literal.
* Versioning: synced inc/bootstrap.php VERSION constant to match style.css and
  the readme Stable tag.

= 1.6148 =
* Initial release.


== Credits ==

= Cormorant Garamond =
* Copyright 2015 Christian Thalmann (https://github.com/CatharsisFonts/Cormorant)
* License: SIL OFL 1.1 (https://openfontlicense.org/open-font-license-official-text/)
* Source: https://github.com/CatharsisFonts/Cormorant

= Newsreader =
* Copyright 2020 Production Type (https://github.com/productiontype/Newsreader)
* License: SIL OFL 1.1 (https://openfontlicense.org/open-font-license-official-text/)
* Source: https://github.com/productiontype/Newsreader

= DM Sans =
* Copyright 2014 Colophon Foundry (https://github.com/googlefonts/dm-fonts)
* License: SIL OFL 1.1 (https://openfontlicense.org/open-font-license-official-text/)
* Source: https://github.com/googlefonts/dm-fonts

= Colophon CORE/SKIN Architecture =
* Author: Christopher Ross (https://thisismyurl.com)
* License: GNU General Public License v2 or later
