<?php
/*
Plugin Name: WP Book
Plugin URI:  https://yourwebsite.com/wp-book
Description: A plugin to manage and display books in WordPress.
Version:     1.0.0
Author:      Nida Zafar
Author URI:  https://yourwebsite.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-book
Domain Path: /languages
*/
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/install.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/dashboard.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/taxonomy.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/wp-book-widget.php';



function wpbook_activation(){
    //Add functionality to run on plugin activation.
}
register_activation_hook(__FILE__,'wpbook_activation');

function wpbook_deactivation(){
    //Add functionality torun on plugin deactivation.
}
register_deactivation_hook(__FILE__,'wpbook_deactivation');


