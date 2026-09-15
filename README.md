# ayberksadic.com

Personal website for Ayberk Sadıç, using the existing Simone theme with Bootstrap, jQuery, and the bundled theme plugins. There is no build step.

## Branches

- `main`: production website.
- `develop`: website updates and review before merging into `main`.

Keep GitHub Pages configured to publish from `main` at the repository root. Pushing `develop` must not change the production publishing source.

## Preview

Run `python -m http.server 8000 --bind 127.0.0.1` from the repository root and open http://127.0.0.1:8000.

## Content

- `index.html`: homepage and publication metadata.
- `css/stylesheet.css`, `js/theme.js`: the original theme styles and scripts.
- `css/site-fixes.css`: small accessibility and responsive fixes; preserves the theme's layout and palette.
- `resume.html`: the public HTML resume.
- `images/profile.png`: the existing portrait, also used for social sharing.
- `blog/`: archived site with its existing assets.

The homepage uses the general and embedded resumes from `aysadic/ayberksadic_cv`, checked against revision `04b54a6`, as content sources. The website does not offer a downloadable resume. Springer chapter metadata was checked against the Crossref record for `10.1007/978-3-032-34511-0_5` on September 15, 2026.

Before publishing, check navigation at mobile and desktop widths, keyboard access, no-JavaScript navigation, reduced motion, local asset links, and publication links.
