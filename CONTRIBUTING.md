# Contributing to Quillwork

Quillwork is a free, GPL-licensed WordPress theme. Contributions — bug reports, accessibility issues, translations, and code — are welcome.

## Before you open an issue

- Search [open issues](../../issues) first; the bug may already be tracked.
- Check [Discussions](../../discussions) for questions and feature conversations.

## Bug reports

Use the Issues tab. Include:

1. WordPress version
2. Quillwork version (Appearance → Themes shows it)
3. Active plugins (a conflict check helps)
4. Steps to reproduce
5. What you expected vs. what happened

Screenshots and browser/device information help.

## Accessibility reports

Accessibility is a first-class concern. If something fails WCAG 2.2 AA — contrast, keyboard navigation, screen reader behaviour, focus management — file it as a bug, not a feature request. Include the WCAG criterion number if you know it.

## Pull requests

1. Fork the repo and create a branch off `main`.
2. Keep changes focused: one fix or feature per PR.
3. Test against the latest stable WordPress and PHP 8.1+.
4. Do not introduce front-end JavaScript — the theme is intentionally zero-JS.
5. Do not introduce Google Fonts or any external font requests — fonts are self-hosted OFL files.
6. If you change `style.css`, do not change the `Version:` field — version bumps are handled at release time.

PRs for the shared Colophon core (the files listed in `colophon.json` under `core[]`) belong in [thisismyurl/colophon](https://github.com/thisismyurl/colophon), not here.

## Translations

Quillwork is translation-ready with a `quillwork` text domain. Translation contributions can be submitted via [WordPress.org translate](https://translate.wordpress.org/projects/wp-themes/quillwork/).

## Code of conduct

This project follows the [Contributor Covenant](CODE_OF_CONDUCT.md). Be direct and constructive. Personal attacks, harassment, and bad-faith engagement are not tolerated.

## License

By contributing, you agree that your contribution is licensed under the same GPL v2 or later terms as the project.
