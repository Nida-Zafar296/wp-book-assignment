<?php
function wpbook_create_custom_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'book_meta';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id BIGINT(20) UNSIGNED NOT NULL,
        meta_key VARCHAR(255) NOT NULL,
        meta_value LONGTEXT,
        PRIMARY KEY (id),
        KEY post_id (post_id),
        KEY meta_key (meta_key)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action( 'plugins_loaded', 'wpbook_create_custom_table' );

