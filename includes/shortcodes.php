<?php

function wpbook_register_shortcode() {
    add_shortcode('book', 'wpbook_display_book_info');
}
add_action('init', 'wpbook_register_shortcode');


function wpbook_display_book_info($atts) {
    global $wpdb;

    
    $atts = shortcode_atts(
        array(
            'id' => '',           
            'author_name' => '',  
            'year' => '',         
            'category' => '',     
            'tag' => '',          
            'publisher' => ''     
        ),
        $atts,
        'book'
    );


    if (!empty($atts['id'])) {
        $post_id = intval($atts['id']);
        $post = get_post($post_id);

        if ($post && $post->post_type === 'book') {

            $table_name = $wpdb->prefix . 'book_meta';
            $meta_values = array();

            $fields = ['_wpbook_author_name', '_wpbook_price', '_wpbook_publisher', '_wpbook_year', '_wpbook_edition', '_wpbook_url'];

            foreach ($fields as $field) {
                $meta_values[$field] = $wpdb->get_var($wpdb->prepare(
                    "SELECT meta_value FROM $table_name WHERE post_id = %d AND meta_key = %s",
                    $post_id,
                    $field
                ));
            }

            ob_start();
            ?>
            <div class="book-info">
                <h2><?php echo esc_html($post->post_title); ?></h2>
                <p><strong>Author Name:</strong> <?php echo esc_html($meta_values['_wpbook_author_name']); ?></p>
                <p><strong>Price:</strong> <?php echo esc_html($meta_values['_wpbook_price']); ?></p>
                <p><strong>Publisher:</strong> <?php echo esc_html($meta_values['_wpbook_publisher']); ?></p>
                <p><strong>Year:</strong> <?php echo esc_html($meta_values['_wpbook_year']); ?></p>
                <p><strong>Edition:</strong> <?php echo esc_html($meta_values['_wpbook_edition']); ?></p>
                <p><strong>URL:</strong> <a href="<?php echo esc_url($meta_values['_wpbook_url']); ?>"><?php echo esc_html($meta_values['_wpbook_url']); ?></a></p>
            </div>
            <?php
            return ob_get_clean();
        } else {
            return '<p>No book found with this ID.</p>';
        }
    } else {
        return '<p>Please provide a valid book ID.</p>';
    }
}
