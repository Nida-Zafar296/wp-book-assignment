<?php

function wpbook_add_settings_page() {
    add_submenu_page(
        'edit.php?post_type=book',  
        'Book Settings',           
        'Settings',              
        'manage_options',         
        'wpbook-settings',        
        'wpbook_render_settings_page' 
    );
}
add_action( 'admin_menu', 'wpbook_add_settings_page' );


function wpbook_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Book Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wpbook_settings_group' );
            do_settings_sections( 'wpbook-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function wpbook_register_settings() {
    register_setting(
        'wpbook_settings_group', 
        'wpbook_currency'
    );

    register_setting(
        'wpbook_settings_group',
        'wpbook_books_per_page'
    );

    add_settings_section(
        'wpbook_settings_section',
        'Book Settings',
        null,
        'wpbook-settings'
    );

    add_settings_field(
        'wpbook_currency_field',
        'Currency',
        'wpbook_currency_field_callback',
        'wpbook-settings',
        'wpbook_settings_section'
    );

    add_settings_field(
        'wpbook_books_per_page_field',
        'Books per Page',
        'wpbook_books_per_page_field_callback',
        'wpbook-settings',
        'wpbook_settings_section'
    );
}
add_action( 'admin_init', 'wpbook_register_settings' );

function wpbook_currency_field_callback() {
    $currency = get_option( 'wpbook_currency', 'USD' );
    ?>
    <input type="text" name="wpbook_currency" value="<?php echo esc_attr( $currency ); ?>" />
    <?php
}

function wpbook_books_per_page_field_callback() {
    $books_per_page = get_option( 'wpbook_books_per_page', 10 );
    ?>
    <input type="number" name="wpbook_books_per_page" value="<?php echo esc_attr( $books_per_page ); ?>" min="1" />
    <?php
}

