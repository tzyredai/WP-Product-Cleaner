# Changelog

## 2.1.0 — 2026-10-03

- Renamed the public plugin to **WP Product Cleaner** and moved to the `wp-product-cleaner` package slug.
- Added official TZYRED AI author/repository/support links.
- Added WooCommerce-manager capability support while preserving administrator access.
- Hardened AJAX handling with payload-size limits and safer unexpected-error responses.
- Strengthened permanent-delete confirmation to `PERMANENTLY DELETE N`.
- Added a compact system-status panel and recent cleanup activity history.
- Added plugin action links for quick access to the cleaner and GitHub repository.
- Kept exact-match revalidation, per-product delete capability checks, nonces, session tokens and Trash-first behavior.
- Removed site-specific examples from public documentation.
- Added standard WordPress `readme.txt`, security policy, contribution guide and reproducible packaging script.

## 2.0.0

- Exact product name, product URL, image filename, image URL and missing-main-image searches.
- Visual result review with product/image metadata.
- Selected/all-result cleanup, automatic batching and pause/resume.
- CSV export, saved searches and workspace branding.
- Permanent deletion restricted to already-trashed products with typed confirmation.
