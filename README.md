# WP Product Cleaner

**Safer WooCommerce catalog cleanup by TZYRED AI.**

[![WordPress](https://img.shields.io/badge/WordPress-6.2%2B-111111?logo=wordpress&logoColor=white)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-111111?logo=php&logoColor=white)](https://www.php.net/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-required-111111?logo=woocommerce&logoColor=white)](https://woocommerce.com/)
[![License](https://img.shields.io/badge/License-GPL--2.0%2B-111111)](LICENSE)

WP Product Cleaner helps store administrators find exact WooCommerce catalog matches, visually review them, export a record, and then move selected products to Trash or permanently remove already-trashed products in controlled batches.

## Download

**Current version: 2.1.0**

- [Download the installable WordPress ZIP](./dist/wp-product-cleaner-2.1.0.zip?raw=1)
- Or clone this repository if you want to inspect/develop the source.

Install through **WordPress → Plugins → Add New Plugin → Upload Plugin**. Take a database backup and test on staging before bulk cleanup.

## What it does

- Exact **product name** matching.
- Exact current **product permalink** matching.
- Exact **main-image filename** matching across recorded image sizes.
- Exact **main-image URL** matching for original and registered/generated image sizes.
- Finds products with **no usable main image** before WooCommerce applies its fallback placeholder.
- Visual review with thumbnail, product ID, SKU, status, image ID and match reason.
- CSV export with spreadsheet-formula injection protection.
- Selected-product or all-result actions.
- Batched cleanup with pause/resume and 24-hour session state.
- Saved searches and workspace branding.
- Recent cleanup history for the current WordPress user.
- System-status panel for WordPress, WooCommerce, PHP and Trash retention.

## Safety model

WP Product Cleaner is intentionally conservative:

1. **Nothing runs automatically.** Search and cleanup require explicit clicks.
2. **Every AJAX request requires a valid WordPress nonce and an authorized WooCommerce manager/admin.**
3. **Each product is permission-checked again** with WordPress's `delete_post` capability before mutation.
4. **The original exact search criterion is re-evaluated immediately before each change.** If the product changed after preview, it is skipped.
5. **Move to Trash is the default.** It is blocked when WordPress Trash is disabled.
6. **Permanent deletion works only on products already in Trash** and requires the exact typed phrase `PERMANENTLY DELETE N`.
7. Images are not explicitly deleted by this plugin.
8. Unexpected server errors are not exposed verbatim to the browser.
9. Request payloads are capped to reduce accidental/hostile oversized requests.
10. No telemetry, tracking scripts, remote cleanup APIs or subscription keys are used.

## Search behavior

| Search type | Input | Match rule |
|---|---|---|
| Exact product name | Complete stored title | Case-sensitive complete title; no partial matching |
| Exact product URL | Current product permalink on the same site | Must resolve to the current canonical product URL |
| Exact image filename | Full filename including extension | Case-sensitive filename against recorded original/generated image URLs |
| Exact image URL | Complete HTTP/HTTPS URL | Exact normalized URL against known WordPress attachment renditions |
| No usable main image | No text | WooCommerce cannot render a main image before adding its fallback |

The image candidate lookup may use a broad filename stem internally for discovery, but a product qualifies only after the final exact URL/filename check.

## Cleanup workflow

1. Choose a search type and product statuses.
2. Run the search and let the scanner complete.
3. Review every relevant result or export CSV.
4. Select specific products, or intentionally choose all exact results.
5. Move products to Trash in controlled batches.
6. Restore through WordPress's native Products → Trash screen if needed.
7. For permanent deletion, search Trash again, review the list, and type the exact confirmation phrase.

## Requirements

- WordPress 6.2+
- PHP 7.4+
- WooCommerce active
- An account with WooCommerce management access (or WordPress administrator access) and delete permission for the affected products
- A modern browser

## Privacy

WP Product Cleaner runs inside your WordPress admin. It does not send catalog data to TZYRED AI or another external service, does not include analytics/telemetry, and does not require an API key.

## TZYRED AI

- [TZYRED AI on GitHub](https://github.com/tzyredai)
- [Plugin repository](https://github.com/tzyredai/WP-Product-Cleaner)
- [Issues / bug reports](https://github.com/tzyredai/WP-Product-Cleaner/issues)

Additional official social links can be added to the plugin through the `wp_product_cleaner_author_links` filter without editing the dashboard template.

## Development

```bash
node --check assets/admin.js
node developer-tests/core.test.js
php -l wp-product-cleaner.php
php -l includes/class-admin.php
php -l includes/class-matcher.php
php -l views/dashboard.php
php -l uninstall.php
php developer-tests/matching.test.php
```

Build a release package:

```bash
bash scripts/build-zip.sh
```

## Security

Please read [SECURITY.md](SECURITY.md). Do not publish sensitive exploit details in a public issue.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
