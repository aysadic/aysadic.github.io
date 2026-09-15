# ayberksadic.com

Personal website for Ayberk Sadıç. The homepage is static HTML, CSS, and JavaScript with no build step or external runtime dependencies.

## Branches

- `main`: production website.
- `develop`: website updates and review before merging into `main`.

Keep GitHub Pages configured to publish from `main` at the repository root. Pushing `develop` must not change the production publishing source.

## Preview

Run `python -m http.server 8000 --bind 127.0.0.1` from the repository root and open http://127.0.0.1:8000.

## Content

- `index.html`: homepage and publication metadata.
- `css/portfolio.css`, `js/portfolio.js`: responsive layout and optional navigation enhancement.
- `resume.html`: editable public resume; print to A4 PDF with backgrounds enabled and browser headers/footers disabled to update `ayberksadic_cv.pdf`.
- `images/social-preview.png`: social sharing image.
- `blog/`: archived site with its existing assets.

The homepage and public resume use the general and embedded resumes from `aysadic/ayberksadic_cv`, checked against revision `04b54a6`. Springer chapter metadata was checked against the Crossref record for `10.1007/978-3-032-34511-0_5` on September 15, 2026.

Before publishing, check navigation at mobile and desktop widths, keyboard access, no-JavaScript navigation, reduced motion, local asset links, PDF text, and publication links. Keep the PDF consistent with the HTML resume.
