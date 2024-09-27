<?php
function wp_book_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'wp_book_top_categories',
        __('Top 5 Book Categories', 'wp-book'),
        'wp_book_top_categories_dashboard_widget'
    );
}
add_action('wp_dashboard_setup', 'wp_book_add_dashboard_widgets');

function wp_book_top_categories_dashboard_widget() {
    $terms = get_terms(array(
        'taxonomy' => 'book_category',
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 5
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<ul>';
        foreach ($terms as $term) {
            echo '<li>' . esc_html($term->name) . ' (' . $term->count . ')</li>';
        }
        echo '</ul>';
    } else {
        echo __('No categories found.', 'wp-book');
    }
}
