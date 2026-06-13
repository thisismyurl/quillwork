=== Quillwork ===
Contributors: thisismyurl
Tags: portfolio, blog, one-column, two-columns, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, block-patterns, accessibility-ready, rtl-language-support, translation-ready, wide-blocks
Requires at least: 6.7
Tested up to: 6.8
Requires PHP: 8.1
Stable tag: 1.6163.2237
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A calligraphy-informed FSE theme for independent design studios, brand consultancies, and editorial agencies.


== Description ==

Quillwork is built for independent design studios and brand consultancies. The Cormorant Garamond display headline at the hero scale IS the brand statement — no hero photograph required. Numbered service cards, a restrained teal/ochre palette, and generous whitespace reflect the deliberate pace of high-craft studio work.

Built on the Colophon CORE/SKIN architecture.


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


== Changelog ==

= 1.6163.2237 =
* Accessibility (WCAG 2.1 1.3.1): the archive and search titles are now explicit
  h1 headings; the index template gains an h1 page heading; the blank-canvas page
  template gains an empty, editor-fillable h1. (Front page and 404 already had one.)
* Hardened comment-form attribute injection: a guarded preg_replace (single
  replacement, null-check, no-match fallback) replaces a naive str_replace that
  could double-inject or mangle markup.
* oEmbed content width now reads theme.json contentSize (pixel-validated, 720px
  fallback) instead of a hardcoded literal.
* The Get started developer-guide URL is filterable via quillwork/developer_guide_url.

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
