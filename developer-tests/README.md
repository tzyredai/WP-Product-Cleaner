# Developer checks

From the plugin directory:

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

The PHP matcher fixtures use a small in-memory stand-in for WordPress functions. They test exact titles and URLs, generated-size handling, status changes, variation exclusion, fallback matching and changed placeholder settings. They do not test a real database, AJAX permissions, WordPress hooks, WooCommerce product deletion or third-party extensions. They were authored but could not be executed in the packaging environment because PHP was unavailable. The JavaScript suite was executed successfully.

For staging validation: create two similarly named products with different images, one product using the searched attachment, one with that image only in its gallery, one with no featured image, and one variable parent. Confirm the preview includes only the intended exact matches. Trash one selected item, pause/resume a multi-item run, change a product image after preview and confirm it is skipped, restore through Products → Trash, then validate permanent deletion on disposable trashed fixtures. Verify that unauthorized requests and invalid/expired nonces are rejected.
