# Build on Quillwork

Quillwork is a free WordPress theme. This file is the rest of the gift: the architecture underneath it, written down plainly enough that you can build your own themes on the same bones.

There is no upsell here. No Pro version waiting behind a button, no "unlock the good parts" tier, no newsletter wall between you and the useful bit. I gave away the theme, and this guide gives away how it's made. If you read it and ship something better, that's the whole point — you don't need my permission, and I'd love to see it.

A note on who this is for: you write WordPress themes, or you'd like to. I'll assume you know what `theme.json` is and why a block theme has a `templates/` folder. I won't assume you've ever tried to keep *five* themes consistent at once, because that's the problem this architecture solves, and it's a stranger problem than it first looks.

## Why it's built this way

I've made WordPress themes and plugins since 2007, and for most of that time I built each theme as its own little world. That works right up until you want a second theme that shares the first one's bones. Then you're either copying files and praying they stay in sync, or you're reaching for a parent theme and inheriting a dependency you'll regret.

Quillwork is the first theme in a small free line, and I wanted the line to share a real core without any of that pain. The decisions below all come from a few things I care about more than cleverness:

- **The next developer matters more than the current trick.** Every shortcut you take is a bill the next person pays, and often that person is you in eight months. So the core is built to be *read*, not admired.
- **Give the work away, and give away how it's made.** A free theme that hides its method isn't really free — it's a demo. The method is the gift.
- **Leave a record.** The comments in this theme explain *why*, not just *what*, because the why is the part that rots when nobody writes it down.

If those sound like principles, they are — they're a few of mine, and they're public. But you don't have to share them to use the core. The code doesn't care why you're here.

## The one idea: copied, not inherited

Here's the decision everything else hangs on. **The themes in this line do not inherit from a parent theme. They copy a shared core and re-skin it.**

That probably sounds backwards. Child themes exist precisely so you *don't* copy. So let me tell you why I went the other way.

A parent/child setup means every theme in the line carries a runtime dependency on the parent. The child can't be installed without it. On WordPress.org that's a published-theme requirement and a support headache, and it couples themes that should be able to live and die on their own. I wanted each theme — Quillwork, and the ones after it — to be a single, self-contained thing you can install, audit, and trust without dragging a parent along.

So the "core" here is a *development-time* core, not a runtime one. You build theme number two by copying theme number one's tree and re-skinning it. The shared bones evolve in one place while you're working; the shipped themes share DNA without sharing a dependency. Each one stands alone.

The cost of that choice is duplication, and duplication is usually a smell. The trick — the thing that makes it pay — is that the duplication is *mechanical*. Re-skinning is a checklist, not a redesign. The next two sections are how.

## Core and skin

Every file in the theme is one of two kinds, and the boundary is commented in-file so you never have to guess:

- **Core** is portable and design-agnostic. The reset, the cascade-layer order, the accessibility scaffolding, the Core Web Vitals discipline, the `theme.json` *structure*, the template skeletons, the font-loading mechanism. You lift this verbatim into the next theme.
- **Skin** is the personality. The colour palette, the type families, the spacing and type scales, the pattern content, the component styling. This is what you re-author per theme.

The rule of thumb I use, and the one the comments lean on: *if changing it changes how the theme looks, it's skin. If changing it changes how the theme works, stays accessible, or stays fast, it's core.* Where a file holds both — `theme.json` and `style.css` do — a banner comment marks the line so the next builder can see it without this document open.

## The file you rename

WordPress.org won't accept a theme that reuses another theme's function prefix or text domain, and rightly so — two themes fighting over the same prefix is a real bug waiting for the day both are installed. Most theme lines solve this by find-and-replacing `oldtheme_` to `newtheme_` across a dozen files and every hook-callback string, which is exactly the kind of job where one missed string silently breaks a hook and you find out in production.

Quillwork uses a PHP namespace instead, and concentrates the whole identity into one file: `inc/bootstrap.php`.

```php
namespace Quillwork;

const SLUG    = 'quillwork';   // text domain + asset handles + pattern prefix
const VERSION = '1.0.0';
```

Callbacks register as `__NAMESPACE__ . '\\setup'`, so when you rename the namespace at the top of each file, every hook follows along behind it. There's no second list of callback strings to keep in sync, because there's no list at all — the namespace *is* the prefix. Functions get short, readable names (`setup`, not `quillwork_setup`) because the namespace already does the disambiguating.

To re-skin into theme number two, you change the namespace and the `SLUG` constant, re-namespace the other `inc/` files (one line each, top of file), and you're prefixed. That's most of the mechanical half done in about five edits.

## Where "tidy" is a bug

There's exactly one spot where the code looks repetitive on purpose, and I want to warn you before you clean it up, because I didn't get this warning and it cost me an afternoon.

Text domains in `__()`, `_e()`, `esc_html__()` and friends are written out as the literal string `'quillwork'`, *not* the `SLUG` constant — even though `SLUG` holds the same value and DRY is screaming at you to use it.

The reason is `wp i18n make-pot`. The string extractor reads your source statically, with its eyes half-closed, and it only recognises a *literal string* as the text-domain argument. Hand it a constant and it extracts nothing, and you ship a theme that looks translation-ready and quietly isn't. So the rule is split on purpose: the text domain stays a literal everywhere, and everything else identity-shaped (asset handles, pattern prefixes, the cache-bust version) reads from the constants. When you re-skin, the literal is one more find-and-replace — `'quillwork'` to `'yourslug'` — and `make-pot` will tell you the moment you miss one, because the POT comes back empty. Learned that the hard way so you don't have to.

## Building on it without editing it

If you just want to *use* Quillwork and bend it a little, you don't need to fork anything. The theme exposes a few hooks, all named in the `quillwork/` convention:

- `do_action( 'quillwork/setup' )` — fires after the theme registers its supports and menus, late on `after_setup_theme`. Hang your own setup here.
- `apply_filters( 'quillwork/copyright_text', $text )` — the footer copyright line, changeable without touching a template.
- `apply_filters( 'quillwork/footer_credit', $credit )` — the "Built with Quillwork" line. Return an empty string and it's gone. (More on that below — I mean it.)
- `apply_filters( 'quillwork/preload_fonts', $fonts )` — the list of fonts preloaded for the largest-paint headline. Off-origin and non-string entries are dropped, so a filter can't be turned into an injection point.

Four hooks isn't many, and that's deliberate. I added the ones a real integrator reaches for and stopped. If you find yourself wanting a fifth, that's good feedback — tell me.

## About the footer credit

Quillwork leaves a small credit in your footer. I'd be glad if you kept it, and I've made it genuinely easy to remove, because a credit you're forced to keep isn't a thank-you, it's a tax.

Two clicks does it: open the Site Editor, edit the footer template part, delete the line. No code, no setting that re-enables itself on the next update, no hard feelings. Or if you're working in code, return an empty string from `quillwork/footer_credit_text`. A credit that's easy to remove is the one people actually leave up — and either way, the theme is yours now.

## Who made this, and why you can build on it

I'm Christopher Ross. I've been building the web since 1996 and working in WordPress since 2007. Along the way I've shipped 19 plugins to the WordPress.org repository and spoken at more than 18 WordCamps, which mostly means I've made a lot of the mistakes this architecture is designed to keep you from making. Earlier I was a senior web developer at Corel and a director of technology at Yorkville. These days I lead a training centre, and the teaching is the part of the work I love most.

I tell you this not to pad the page but because it's the honest answer to a fair question: *why trust this core enough to build on it?* The answer is that you don't have to take my word for any of it. Quillwork is built against the WordPress.org Theme Review requirements, and you can check how against the code sitting right next to this guide. Don't trust the architecture because I described it well. Read it.

## Go build something

Quillwork is GPL, and so is everything in this guide. Copy the core, re-skin it, ship your own theme line, sell it if you like — the licence allows it and I won't be offended. I'm not selling the architecture; I'm giving it to a community that gave me a career.

If you build on it, I'd genuinely like to know. And if you find the place where I was wrong — there's always a place where I was wrong — tell me that too. That's how the next version gets better.

— Christopher
