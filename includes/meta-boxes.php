<?php

function wpbook_add_book_meta_box() {
    add_meta_box(
        'wpbook_book_details',
        'Book Details',
        'wpbook_render_book_meta_box',
        'book',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'wpbook_add_book_meta_box' );


function wpbook_render_book_meta_box( $post ) {
    global $wpdb;

    
    $table_name = $wpdb->prefix . 'book_meta';

    
    $fields = ['_wpbook_author_name', '_wpbook_price', '_wpbook_publisher', '_wpbook_year', '_wpbook_edition', '_wpbook_url'];
    $meta_values = [];

    foreach ( $fields as $field ) {
        $meta_values[$field] = $wpdb->get_var( $wpdb->prepare(
            "SELECT meta_value FROM $table_name WHERE post_id = %d AND meta_key = %s",
            $post->ID,
            $field
        ) );
    }
    ?>
    <p>
        <label for="wpbook_author_name">Author Name:</label>
        <input type="text" id="wpbook_author_name" name="wpbook_author_name" value="<?php echo esc_attr( $meta_values['_wpbook_author_name'] ); ?>" />
    </p>
    <p>
        <label for="wpbook_price">Price:</label>
        <input type="number" id="wpbook_price" name="wpbook_price" value="<?php echo esc_attr( $meta_values['_wpbook_price'] ); ?>" step="0.01" />
    </p>
    <p>
        <label for="wpbook_publisher">Publisher:</label>
        <input type="text" id="wpbook_publisher" name="wpbook_publisher" value="<?php echo esc_attr( $meta_values['_wpbook_publisher'] ); ?>" />
    </p>
    <p>
        <label for="wpbook_year">Year:</label>
        <input type="number" id="wpbook_year" name="wpbook_year" value="<?php echo esc_attr( $meta_values['_wpbook_year'] ); ?>" />
    </p>
    <p>
        <label for="wpbook_edition">Edition:</label>
        <input type="text" id="wpbook_edition" name="wpbook_edition" value="<?php echo esc_attr( $meta_values['_wpbook_edition'] ); ?>" />
    </p>
    <p>
        <label for="wpbook_url">URL:</label>
        <input type="url" id="wpbook_url" name="wpbook_url" value="<?php echo esc_url( $meta_values['_wpbook_url'] ); ?>" />
    </p>
    <?php

    
    wp_nonce_field( 'wpbook_save_book_meta_box_data', 'wpbook_nonce' );
}

function wpbook_save_book_meta_box_data( $post_id ) {
    global $wpdb;

    if ( ! isset( $_POST['wpbook_nonce'] ) || ! wp_verify_nonce( $_POST['wpbook_nonce'], 'wpbook_save_book_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $table_name = $wpdb->prefix . 'book_meta';

    $fields = [
        '_wpbook_author_name' => sanitize_text_field( $_POST['wpbook_author_name'] ),
        '_wpbook_price' => sanitize_text_field( $_POST['wpbook_price'] ),
        '_wpbook_publisher' => sanitize_text_field( $_POST['wpbook_publisher'] ),
        '_wpbook_year' => sanitize_text_field( $_POST['wpbook_year'] ),
        '_wpbook_edition' => sanitize_text_field( $_POST['wpbook_edition'] ),
        '_wpbook_url' => esc_url_raw( $_POST['wpbook_url'] )
    ];

    foreach ( $fields as $meta_key => $meta_value ) {
        $wpdb->replace(
            $table_name,
            [
                'post_id' => $post_id,
                'meta_key' => $meta_key,
                'meta_value' => $meta_value
            ],
            [
                '%d',
                '%s',
                '%s',
            ]
        );
    }
}
add_action( 'save_post', 'wpbook_save_book_meta_box_data' );


