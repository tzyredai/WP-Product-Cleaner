<?php
// Removing this plugin clears only its own settings and temporary sessions.
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
global $wpdb;
delete_option( 'wppc_brand' );
delete_metadata( 'user', 0, 'wppc_presets_' . get_current_blog_id(), '', true );
delete_metadata( 'user', 0, 'wppc_last_action_' . get_current_blog_id(), '', true );
delete_metadata( 'user', 0, 'wppc_history_' . get_current_blog_id(), '', true );
foreach ( array( '_transient_wppc_', '_transient_timeout_wppc_', 'wppc_lock_' ) as $prefix ) {
    $names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $wpdb->esc_like( $prefix ) . '%' ) );
    foreach ( $names as $name ) { delete_option( $name ); }
}
