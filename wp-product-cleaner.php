<?php
/**
 * Plugin Name: WP Product Cleaner
 * Plugin URI: https://github.com/tzyredai/WP-Product-Cleaner
 * Description: Exact WooCommerce product and image searches, visual review, CSV export and guarded batch cleanup with Trash-first safety.
 * Version: 2.1.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: TZYRED AI
 * Author URI: https://github.com/tzyredai
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-product-cleaner
 */

defined( 'ABSPATH' ) || exit;

define( 'WPPC_VERSION', '2.1.0' );
define( 'WPPC_FILE', __FILE__ );
define( 'WPPC_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPPC_URL', plugin_dir_url( __FILE__ ) );
define( 'WPPC_REPO_URL', 'https://github.com/tzyredai/WP-Product-Cleaner' );
define( 'WPPC_AUTHOR_URL', 'https://github.com/tzyredai' );

require_once WPPC_DIR . 'includes/class-matcher.php';
require_once WPPC_DIR . 'includes/class-admin.php';

WPPC_Admin::boot();
