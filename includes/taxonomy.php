<?php
add_action( 'init', 'wp_book_create_taxonomies', 0 );
function wp_book_create_taxonomies() {
    $labels = array(
        'name'              => _x( 'Book Categories', 'taxonomy general name', 'wp-book' ),
        'singular_name'     => _x( 'Book Category', 'taxonomy singular name', 'wp-book' ),
        'search_items'      => __( 'Search Book Categories', 'wp-book' ),
        'all_items'         => __( 'All Book Categories', 'wp-book' ),
        'parent_item'       => __( 'Parent Book Category', 'wp-book' ),
        'parent_item_colon' => __( 'Parent Book Category:', 'wp-book' ),
        'edit_item'         => __( 'Edit Book Category', 'wp-book' ),
        'update_item'       => __( 'Update Book Category', 'wp-book' ),
        'add_new_item'      => __( 'Add New Book Category', 'wp-book' ),
        'new_item_name'     => __( 'New Book Category Name', 'wp-book' ),
        'menu_name'         => __( 'Book Category', 'wp-book' ),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'book-category' ),
    );
    register_taxonomy( 'book_category', array( 'book' ), $args );
    $labels = array(
        'name'                       => _x( 'Book Tags', 'taxonomy general name', 'wp-book' ),
        'singular_name'              => _x( 'Book Tag', 'taxonomy singular name', 'wp-book' ),
        'search_items'               => __( 'Search Book Tags', 'wp-book' ),
        'popular_items'              => __( 'Popular Book Tags', 'wp-book' ),
        'all_items'                  => __( 'All Book Tags', 'wp-book' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Book Tag', 'wp-book' ),
        'update_item'                => __( 'Update Book Tag', 'wp-book' ),
        'add_new_item'               => __( 'Add New Book Tag', 'wp-book' ),
        'new_item_name'              => __( 'New Book Tag Name', 'wp-book' ),
        'separate_items_with_commas' => __( 'Separate book tags with commas', 'wp-book' ),
        'add_or_remove_items'        => __( 'Add or remove book tags', 'wp-book' ),
        'choose_from_most_used'      => __( 'Choose from the most used book tags', 'wp-book' ),
        'not_found'                  => __( 'No book tags found.', 'wp-book' ),
        'menu_name'                  => __( 'Book Tags', 'wp-book' ),
    );
    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'book-tag' ),
    );
    register_taxonomy( 'book_tag', 'book', $args );
}