<?php
function wpbook_register_book_post_type() {
    $args = array(
        'label' => 'Books',
        'public' => true,
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'books' ),
        'show_in_rest' => true,
        'menu_icon'             => 'dashicons-book',
    );
    register_post_type( 'book', $args );
}
add_action( 'init', 'wpbook_register_book_post_type' );
?>