# Quillwork architecture — the shared theme-line core

Quillwork is the first theme built on a **portable development-time core** that
later themes in the line will reuse. This document is the
contract. If you are building theme #2, read this top to bottom; the re-skin
steps at the end are the whole job.

> **The core is copied, never inherited.** Each theme is an independent
> WordPress.org submission. There is no runtime parent theme, no `Template:`
> header, no `get_template_part()` reaching across themes. The shared code is
> *lifted into* each new theme's tree and re-skinned. That keeps every theme
> self-contained — installable beside its siblings with zero shared runtime
> state — while letting the bones evolve in one place during development.

---

## 1. The core / skin split

Every file in the theme is one of two kinds. The boundary is commented in-file
so the next builder can see it without this document.

### Core (portable, design-agnostic) — lift verbatim, re-prefix, keep

| Concern | Where it lives | Why it is core |
| --- | --- | --- |
| Single re-prefixing point | `inc/bootstrap.php` | One namespace + four constants. The entire portability story. |
| Theme setup / supports | `inc/setup.php` | Identical feature set every theme wants (title-tag, html5, post-thumbnails, editor styles, nav menus, i18n). |
| Asset + font enqueue | `inc/assets.php` | Mechanism is design-agnostic; *which* fonts load is data in `theme.json`. |
| Block-style + pattern registration | `inc/blocks.php` | Registration plumbing is shared; the *list* of styles/categories is skin data. |
| A11y scaffolding | `inc/setup.php` skip link + `style.css` `@layer base` focus rules | WCAG 2.2 AA floor is non-negotiable and identical across the line. |
| CWV machinery | `theme.json` (fluid type, no render-blocking JS), `style.css` reset layer | Performance discipline is a line standard, not a per-theme choice. |
| CSS layer order | `style.css` `@layer reset, base, layout, components, blocks, utilities;` | The cascade contract every theme's CSS slots into. |
| `theme.json` *structure* | top-level keys, `settings` shape, `templateParts`/`customTemplates` skeleton | The schema scaffold; values are skin. |
| Template structure | `templates/*.html`, `parts/header.html`, `parts/footer.html` | Markup skeleton (landmarks, query loop, skip-target) is shared; styling classes are skin-named but structurally stable. |

### Skin (Quillwork-specific) — re-author per theme

| Concern | Where it lives |
| --- | --- |
| Design tokens — palette, type families, type/spacing scale | `theme.json` `settings.color` / `settings.typography` / `settings.spacing` |
| Element + block styling | `theme.json` `styles` |
| Personality CSS — hero accents, service-card numerals, float motion | `style.css` `@layer components` |
| Font *files* + which families exist | `assets/fonts/<family>/` + `theme.json` `fontFamilies` |
| Pattern content | `patterns/*.php` |
| Block-style + pattern-category *names* | the arrays inside `inc/blocks.php` |
| `style.css` header, `readme.txt`, `screenshot.png` | per-theme identity |

**Rule of thumb:** if changing it would change how the theme *looks*, it is skin.
If changing it would change how the theme *works or stays accessible/fast*, it is
core. When a file mixes both (e.g. `theme.json`, `style.css`), a banner comment
marks the boundary.

---

## 2. The single re-prefixing point

WordPress.org rejects a theme that reuses another theme's function prefix or
text domain. The line solves this with **one file to edit** — `inc/bootstrap.php`
— and a PHP namespace instead of a hand-rolled function prefix.

### Why a namespace, not a `tu_np_`-style prefix

The newspaper theme (prior art) names every function `thisismyurl_newspaper_*`
and every constant `TIMU_NP_*`. Lifting it into theme #2 is a find-replace across
a dozen files and every hook-callback string — fragile, and a missed callback
string silently breaks a hook. Quillwork uses a **namespace**:

```php
namespace Quillwork;

function setup(): void { /* … */ }
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );
```

`__NAMESPACE__ . '\\setup'` resolves to the fully-qualified callback string
automatically. Rename the namespace once at the top of each file and **every
hook registration follows** — there is no second list of callback strings to
keep in sync. Functions get short, readable names (`setup`, not
`thisismyurl_newspaper_setup`) because the namespace does the disambiguation.

### The four constants

`inc/bootstrap.php` defines everything theme-identity-shaped in one place:

```php
namespace Quillwork;

const SLUG    = 'quillwork';                 // text domain + asset handles + pattern prefix
const VERSION = '1.0.0';                     // cache-bust + WP.org version
const DIR     = get_template_directory();    // filesystem base
const URI     = get_template_directory_uri(); // URL base
```

`SLUG` is the load-bearing one. It is the **text domain**, the **asset-handle
prefix**, the **block-style/pattern-category prefix**, and the
**block-bindings-source namespace**. Every place a sibling theme would differ,
the code reads `SLUG` (or the `quillwork` literal where WordPress requires a
*string literal* for i18n tooling — see §4) rather than hardcoding.

---

## 3. How a future theme reuses the core

Theme #2 ("Margin", say) is a copy of this tree with a re-skin. The mechanical
half:

1. **Copy** `clients/thisismyurl/themes/quillwork/` → `…/themes/margin/`.
2. **`inc/bootstrap.php`** — change `namespace Quillwork;` → `namespace Margin;`
   and `const SLUG = 'quillwork';` → `const SLUG = 'margin';`. (`VERSION` resets
   to the new theme's version.)
3. **Re-namespace the other `inc/*.php` files** — each opens with
   `namespace Quillwork;`. Change that one line per file. Because callbacks use
   `__NAMESPACE__`, nothing else in those files changes.
4. **Text-domain literals** — the i18n string literals (`'quillwork'` inside
   `__()`, `_e()`, etc.) must become `'margin'`. These are *string literals on
   purpose* (see §4); a single editor find-replace of `'quillwork'` → `'margin'`
   inside `inc/`, `patterns/`, and the `style.css` header `Text Domain:` line
   does it. Verify with `wp i18n make-pot . languages/margin.pot` — a wrong
   domain produces an empty POT.
5. **`style.css` header** — Theme Name, Theme URI, Description, Text Domain, Tags.
6. **`readme.txt`** — name, slug, description, changelog reset.
7. **`screenshot.png`** — new 1200×900 capture.

The re-skin half (the creative work, not mechanical):

8. **`theme.json`** — replace the palette, `fontFamilies`, `fontSizes`, spacing,
   and the `styles` block below the marked core-structure banner.
9. **`assets/fonts/`** — drop the new family folders (WOFF2 + `OFL.txt`) and
   repoint `theme.json` `fontFace.src`.
10. **`style.css` `@layer components`** — re-author the personality CSS.
11. **`patterns/*.php`** — re-author pattern content; rename the `Slug:` header
    prefix from `quillwork/` to `margin/`.

Steps 1–7 are find-replace-grade mechanical. Steps 8–11 are the design. That
ratio — most of the file count is mechanical — is the point of the core.

> **A find-replace checklist lives at the bottom of this file (§6).** Run it and
> the theme passes the WordPress.org "unique prefix / unique domain" checks.

---

## 4. Why text-domain literals are NOT `SLUG`

`__( 'Read more', SLUG )` looks DRYer but **breaks `wp i18n make-pot`**. The POT
extractor parses source statically and needs a *string literal* as the text
domain argument; a constant or variable yields no extraction and ships an
untranslatable theme. So the rule is deliberate and split:

- **Text domain in `__()`/`_e()`/`esc_html__()` etc.** → string literal
  `'quillwork'`. Re-skin step #4 find-replaces it.
- **Everything else identity-shaped** (asset handles, pattern prefixes, bindings
  namespace, cache-bust version) → the `SLUG` / `VERSION` constants.

This is the one place the "single swap point" is two swaps (constant + literal),
and it is for a hard tooling reason, not laziness. It is called out at every i18n
call site convention so the next builder does not "tidy" it into a bug.

---

## 5. Font strategy (self-hosted OFL, line standard)

All three Quillwork families — **Cormorant Garamond** (display), **Newsreader**
(body), **DM Sans** (UI/eyebrows) — are Google Fonts under SIL OFL 1.1, which is
GPL-compatible. They are **self-hosted**, never `fonts.googleapis.com`-linked:

- WOFF2 files in `assets/fonts/<family>/`, one `OFL.txt` per family folder
  (WordPress.org requires the license to ship with the font).
- `@font-face` declared in `theme.json` `settings.typography.fontFamilies[].fontFace`
  with `file:./assets/fonts/…` `src` and `"fontDisplay": "swap"`.
- Every `fontFamily` stack lists Georgia / system fallbacks so type still
  cascades if a file is ever removed.
- No render-blocking `<link>`, no third-party connection, no FOIT — `swap` plus
  fallbacks keeps LCP text painting immediately. This is the CWV core, expressed
  as data.

Files are the upstream Google Fonts / Fontsource WOFF2 subsets. See
`assets/fonts/README.md` for the per-family roster and credits.

---

## 6. Re-skin find-replace checklist (theme #2)

Run from the new theme's root after copying the tree. Order matters: do the
namespace first, then the domain literal, then identity.

```
# 1. Namespace (one line per inc/*.php — they all open `namespace Quillwork;`)
inc/*.php :  namespace Quillwork;   →   namespace <NewName>;

# 2. Bootstrap constants
inc/bootstrap.php :  const SLUG = 'quillwork';   →   const SLUG = '<newslug>';
inc/bootstrap.php :  const VERSION = '1.0.0';    →   const VERSION = '<new>';

# 3. Text-domain string literals (i18n — must stay literals, see §4)
inc/ patterns/ :  '<space>quillwork'  →  '<newslug>'   (the second arg of __, _e, esc_html__, _x, _n …)
style.css      :  Text Domain: quillwork  →  Text Domain: <newslug>

# 4. Pattern slug prefix (header line in every patterns/*.php)
patterns/*.php :  Slug: quillwork/…   →   Slug: <newslug>/…

# 5. Identity surfaces (hand-edit, not find-replace)
style.css   header :  Theme Name / Theme URI / Description / Tags
readme.txt         :  name / slug / description / changelog
screenshot.png     :  regenerate
```

### Verification gate (must pass before WP.org submission)

```
php -l                          # every edited PHP file
composer run lint:phpcs         # WordPress-Extra, clean
grep -rn "quillwork"  inc/ patterns/ style.css   # ZERO hits in theme #2
grep -rn "Quillwork"  inc/                        # ZERO hits in theme #2
wp i18n make-pot . languages/<newslug>.pot        # non-empty POT, correct domain
```

A single surviving `quillwork` / `Quillwork` string in theme #2 is a WP.org
rejection (duplicate prefix/domain). The two `grep` lines are the whole safety
net — they are why the prefixing is concentrated, not scattered.

---

## 7. Notes for aligning the newspaper theme to this core (flag, don't fix)

The newspaper theme (`themes/thisismyurl-newspaper/`) predates this core and
diverges in ways a future alignment pass should close. Flagged, not fixed —
that theme ships and must not be destabilised here:

- **No namespace.** Functions are `thisismyurl_newspaper_*`, constants `TIMU_NP_*`.
  Aligning means wrapping `inc/*.php` in `namespace ThisismyurlNewspaper;` and
  collapsing the constants into `SLUG`/`VERSION`. This removes the per-callback
  find-replace risk that motivated Quillwork's namespace.
- **No `bootstrap.php`.** Identity constants live in `functions.php` directly;
  the line standard is to isolate them in one bootstrap file.
- **Text-domain literals already correct** (`'thisismyurl-newspaper'`), so its
  i18n is sound — only the function-prefix story needs the namespace upgrade.
- **CSS layer order matches** (`reset, base, layout, components, blocks,
  utilities`) — already core-aligned; no change needed.
- **Font mechanism matches** (self-hosted OFL via `theme.json` `fontFace`) —
  already core-aligned.

The newspaper theme is ~80% core-aligned already; the namespace + bootstrap
split is the only structural gap. That is a low-risk follow-up, not a blocker.
```

## 8. Template design notes

Prose HTML comments must never appear inside block markup in `templates/`,
`parts/` or `patterns/`. Core re-saves each block in the editor and compares
the result with the stored markup; a comment inside a block's body makes that
comparison fail and the editor reports "Block contains unexpected or invalid
content" (the WordPress.org review of Colophon, ticket #292760). A loose
comment above the first block is read as an unrecognised block, which the
Theme Review Action reports as an incomplete template. `tools/check-templates.py`
enforces both. The rationale that used to sit in those comments lives here.

* **front-page.html:** the hero comes from the `quillwork/hero` pattern, so it
  lives in exactly one place; editing `patterns/hero.php` updates every use.
  Below it, the recent writing band is a calm card layout of the latest posts.
* **single.html:** a teal-tint rule separates the byline from the content when
  no featured image stands between them; with an image present it reads as a
  frame. A static section heading always precedes the comment list and form, so
  the document outline never jumps from H1 to H3 when a post has no comments
  (`comments-title` only renders once at least one comment exists).

## 9. theme.json design notes

The notes below used to sit in theme.json as `_comment` keys. They are not part of the theme.json schema, so they live here instead.

* **root** — [CORE] The top-level keys, settings shape, templateParts and customTemplates skeleton are the portable structure — a sibling theme keeps this scaffold. [SKIN] The VALUES inside color/typography/spacing/styles are Quillwork's design and are re-authored per theme. Boundary is marked at each section.
* **/settings/color** — [SKIN] Quillwork palette — deep teal / warm ochre / coral on cream. defaultPalette off so the editor offers only the theme's tokens.
* **/settings/typography** — [SKIN] Cormorant Garamond (display, light + italic), Newsreader (body, light + italic), DM Sans (UI/eyebrows). All SIL OFL 1.1, self-hosted under assets/fonts/. fontFamily stacks carry Georgia/system fallbacks per the CORE font strategy (ARCHITECTURE.md §5).
* **/settings/spacing** — [CORE] structure — [SKIN] values. A linear step scale; bands use the large steps for the source design's generous whitespace.
* **/settings/layout** — [CORE structure / SKIN values] contentSize = literary reading measure; wideSize mirrors --qw-full-max in style.css.
* **/settings** — true above; root padding set in styles.spacing.padding
* **/styles** — [SKIN] All of styles is Quillwork's design expression. A sibling theme replaces this whole block.
