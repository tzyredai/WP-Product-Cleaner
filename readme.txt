=== WP Product Cleaner ===
Contributors: tzyredai
Tags: woocommerce, products, cleanup, catalog, images
Requires at least: 6.2
Requires PHP: 7.4
Stable tag: 2.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Exact WooCommerce product/image search, visual review, CSV export and guarded Trash-first batch cleanup.

== Description ==

WP Product Cleaner is a conservative WooCommerce catalog cleanup tool by TZYRED AI. It provides exact product name/URL/image matching, visual review, CSV export, selected/all-result actions, pause/resume and typed confirmation before permanent deletion.

Safety is the design priority: nothing runs automatically, requests require a valid nonce and authorized user, every product is permission-checked and re-matched immediately before mutation, and permanent deletion is limited to already-trashed products.

No telemetry, tracking or external cleanup API is used.

== Installation ==

1. Back up your database and use a staging site for bulk cleanup when possible.
2. Upload `wp-product-cleaner-2.1.0.zip` through Plugins → Add New Plugin → Upload Plugin.
3. Activate WooCommerce and WP Product Cleaner.
4. Open Products → WP Product Cleaner.

== Frequently Asked Questions ==

= Does the plugin delete images? =
No. It does not explicitly delete Media Library attachments.

= Does it automatically delete products? =
No. Search and cleanup require explicit actions in the admin UI.

= Can it permanently delete products? =
Only products already in Trash, after a typed confirmation phrase and server-side permission/re-match checks.

= Does it send store data to TZYRED AI? =
No. There is no telemetry or remote catalog-cleanup API.

== Changelog ==

= 2.1.0 =
* Public rename to WP Product Cleaner.
* Security hardening and safer error handling.
* Stronger permanent-delete confirmation.
* System status and cleanup history.
* TZYRED AI support/repository links.

= 2.0.0 =
* Exact matching, visual review, batching, CSV export, saved searches and workspace branding.
