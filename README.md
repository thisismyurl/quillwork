# Quillwork

A free, calligraphy-informed full-site-editing WordPress theme for design studios and type-driven creative brands.

[Download from WordPress.org](https://wordpress.org/themes/quillwork/) · [Releases](https://github.com/thisismyurl/quillwork/releases) · [Built on Colophon](https://github.com/thisismyurl/colophon)

---

## Why I built it this way

Quillwork gets its name from the Indigenous North American craft of decorating objects with dyed porcupine quills — intricate, slow, bead-by-bead work where the material constraint is also the beauty. Design studios work the same way. The finished thing is all surface, and every surface decision is deliberate.

The problem I kept running into with WordPress themes for design studios was that the theme competed with the work. Big stock photography hero, gradient overlays, a blog-first architecture — the structure assumed the studio needed to explain itself before showing anything. It doesn't. The work does the explaining.

So I built Quillwork around a simple premise: your studio name at display scale IS the hero. No photography required for the home page to land. The Cormorant Garamond headline is doing the work that would normally be a $3,000 photography session. If you want to add imagery later, you can, but you don't have to start there.

The colour system is minimal on purpose. Teal accent, ochre numerals, near-white field. Those are the only colours that carry voice — everything else follows. The type pairs Cormorant Garamond (an open-source revival of a sixteenth-century French humanist face) with Newsreader for long reading and DM Sans for UI labels. Each one earned its place by improving something the others couldn't do better.

The grid is based on a golden ratio column — 61.8% content to 38.2% margin at full width. It looks deliberate because it is.

---

## Design decisions

- **Studio name as hero, not photography** — design studios are often between photoshoots or working under NDA. The theme reads as complete without a single image.
- **Cormorant Garamond at display weight** — a typeface with visible calligraphic origins reads as "made by hand" without saying so. That matters for studios where craft is the value proposition.
- **Works directory on the front page** — portfolio entries are standard WordPress posts, so any existing content migrates without a custom field migration. The front page template pulls published posts automatically.
- **Five patterns, not twenty** — Service Cards, Studio Bio, Case Study Lead, Contact Row, and Works Grid. Enough to build a complete studio site, not so many that choosing becomes the task.
- **No sidebar, ever** — design studios don't have sidebars. The single-column reading experience with generous margins is a design statement, not a limitation.

---

## Getting started

1. Install Quillwork from Appearance → Themes, or upload the zip from [Releases](https://github.com/thisismyurl/quillwork/releases).
2. Go to Appearance → Editor → Site Identity. Set your studio name. That's your hero.
3. Open the Block Inserter, choose Patterns, and find the Quillwork group. Start with the Works Grid and Service Cards patterns.

---

## Technical notes

- WordPress 6.4 or newer, PHP 8.1 or newer
- Full-site editing (FSE/Gutenberg) — no Classic Editor support
- WCAG 2.2 AA compliant
- Zero JavaScript — block interactivity uses the WordPress Interactivity API when needed
- OFL-licensed fonts: Cormorant Garamond, Newsreader, DM Sans
- Self-hosted fonts — no Google Fonts requests

## License

GPLv2 or later. See [LICENSE](LICENSE).

The fonts bundled in `assets/fonts/` are licensed under the SIL Open Font License (OFL) 1.1. See each font directory for the individual license file.
