<?php
// Standalone matcher regression fixtures. Run with: php matching.test.php
if ( PHP_SAPI !== 'cli' ) { exit; }
define( 'ABSPATH', __DIR__ );
$GLOBALS['pc_fixture_placeholder'] = 'https://shop.test/uploads/placeholder-600x600.webp';
$GLOBALS['pc_fixture_products'] = array(
    1 => array( 'type' => 'product', 'status' => 'publish', 'title' => 'Cola 330ml', 'image' => 10, 'html' => '<img src="cola.webp">' ),
    2 => array( 'type' => 'product', 'status' => 'publish', 'title' => 'Cola 330ml multipack', 'image' => 11, 'html' => '<img src="other.webp">' ),
    3 => array( 'type' => 'product', 'status' => 'publish', 'title' => 'Missing', 'image' => 0, 'html' => '' ),
    4 => array( 'type' => 'product', 'status' => 'publish', 'title' => 'Explicit placeholder', 'image' => 12, 'html' => '<img src="placeholder.webp">' ),
    5 => array( 'type' => 'product', 'status' => 'trash', 'title' => 'Cola 330ml', 'image' => 10, 'html' => '<img src="cola.webp">' ),
    6 => array( 'type' => 'product_variation', 'status' => 'publish', 'title' => 'Cola 330ml', 'image' => 10, 'html' => '<img>' ),
    7 => array( 'type' => 'product', 'status' => 'publish', 'title' => 'Remote-image plugin', 'image' => 0, 'html' => '<img src="https://remote.test/image.jpg">' ),
);
function wp_parse_url( $url, $component = -1 ) { return parse_url( $url, $component ); }
function wp_basename( $value ) { return basename( $value ); }
function get_post_type( $id ) { return $id >= 10 ? 'attachment' : ( $GLOBALS['pc_fixture_products'][ $id ]['type'] ?? false ); }
function get_post_status( $id ) { return $GLOBALS['pc_fixture_products'][ $id ]['status'] ?? false; }
function get_post_field( $field, $id, $context ) { return $GLOBALS['pc_fixture_products'][ $id ]['title'] ?? ''; }
function get_permalink( $id ) { return 'https://shop.test/product/' . $id . '/'; }
function wp_attachment_is_image( $id ) { return in_array( $id, array( 10, 11, 12 ), true ); }
function wp_get_attachment_url( $id ) { return array( 10 => 'https://shop.test/uploads/cola.webp', 11 => 'https://shop.test/uploads/other.webp', 12 => 'https://shop.test/uploads/placeholder.webp' )[ $id ] ?? false; }
function wp_get_original_image_url( $id ) { return wp_get_attachment_url( $id ); }
function get_intermediate_image_sizes() { return array( 'woocommerce_thumbnail' ); }
function wp_get_attachment_image_src( $id, $size ) {
    $url = wp_get_attachment_url( $id );
    return $url ? array( 'full' === $size ? $url : str_replace( '.webp', '-600x600.webp', $url ), 600, 600 ) : false;
}
function wp_get_attachment_metadata( $id ) { return array( 'file' => basename( wp_get_attachment_url( $id ) ), 'sizes' => array( 'woocommerce_thumbnail' => array( 'file' => str_replace( '.webp', '-600x600.webp', basename( wp_get_attachment_url( $id ) ) ) ) ) ); }
function wp_get_upload_dir() { return array( 'baseurl' => 'https://shop.test/uploads', 'error' => false ); }
function trailingslashit( $value ) { return rtrim( $value, '/' ) . '/'; }
function get_option( $key, $default = false ) { return 'woocommerce_placeholder_image' === $key ? 12 : $default; }
function wc_placeholder_img_src( $size ) { return $GLOBALS['pc_fixture_placeholder']; }
function wc_get_product( $id ) {
    if ( ! isset( $GLOBALS['pc_fixture_products'][ $id ] ) ) { return false; }
    return new class( $GLOBALS['pc_fixture_products'][ $id ] ) {
        private $data;
        function __construct( $data ) { $this->data = $data; }
        function get_image_id( $context ) { return $this->data['image']; }
        function get_image( $size, $attributes, $placeholder ) { return $this->data['html']; }
    };
}
require __DIR__ . '/../includes/class-matcher.php';
$count = 0;
function check( $condition, $label ) { global $count; if ( ! $condition ) { throw new RuntimeException( $label ); } ++$count; }
function criteria_fixture( $mode, $value, $fallback = false ) { return array( 'mode' => $mode, 'value' => $value, 'statuses' => array( 'publish' ), 'fallback_match' => $fallback ); }
$name = criteria_fixture( 'product_name', 'Cola 330ml' );
check( !! WPPC_Matcher::match( 1, $name ), 'Whole title matches' );
check( ! WPPC_Matcher::match( 2, $name ), 'Title prefix does not match' );
check( ! WPPC_Matcher::match( 1, criteria_fixture( 'product_name', 'cola 330ml' ) ), 'Title comparison is case sensitive' );
check( ! WPPC_Matcher::match( 5, $name ), 'Status changes are rechecked' );
check( ! WPPC_Matcher::match( 6, $name ), 'Variations are excluded' );
check( !! WPPC_Matcher::match( 1, criteria_fixture( 'product_url', 'https://shop.test/product/1' ) ), 'Canonical URL accepts trailing slash difference' );
check( ! WPPC_Matcher::match( 1, criteria_fixture( 'product_url', 'https://shop.test/product/10' ) ), 'Similar product URL does not match' );
check( !! WPPC_Matcher::match( 1, criteria_fixture( 'image_url', 'https://shop.test/uploads/cola-600x600.webp' ) ), 'Recorded rendition resolves to assigned image' );
check( ! WPPC_Matcher::match( 1, criteria_fixture( 'image_url', 'https://shop.test/uploads/cola-999x999.webp' ) ), 'Invented size is not matched by stripping suffix' );
check( ! WPPC_Matcher::match( 1, criteria_fixture( 'image_url', 'https://other.test/uploads/cola.webp' ) ), 'Image URL host matters' );
check( !! WPPC_Matcher::match( 1, criteria_fixture( 'image_name', 'cola.webp' ) ), 'Exact filename matches' );
check( ! WPPC_Matcher::match( 1, criteria_fixture( 'image_name', 'Cola.webp' ) ), 'Filename is case sensitive' );
check( !! WPPC_Matcher::match( 3, criteria_fixture( 'missing_image', '' ) ), 'Missing main image detected' );
check( ! WPPC_Matcher::match( 7, criteria_fixture( 'missing_image', '' ) ), 'Rendered remote image is not treated as missing' );
$placeholder = criteria_fixture( 'image_url', 'https://shop.test/uploads/placeholder-600x600.webp', true );
check( !! WPPC_Matcher::match( 3, $placeholder ), 'Active fallback URL matches product with no image' );
check( !! WPPC_Matcher::match( 4, $placeholder ), 'Explicit placeholder attachment also matches' );
check( ! WPPC_Matcher::match( 1, $placeholder ), 'Real image is not included in placeholder cleanup' );
check( ! WPPC_Matcher::match( 3, criteria_fixture( 'image_url', $placeholder['value'], false ) ), 'Fallback checkbox is honoured' );
$GLOBALS['pc_fixture_placeholder'] = 'https://shop.test/uploads/new-placeholder.webp';
check( ! WPPC_Matcher::match( 3, $placeholder ), 'Changed placeholder configuration is rechecked before mutation' );
check( WPPC_Matcher::normalize_url( 'HTTPS://SHOP.TEST/image.webp#fragment' ) === 'https://shop.test/image.webp', 'URL normalization preserves path and normalizes host' );
echo "PASS: $count exact-match checks.
";
