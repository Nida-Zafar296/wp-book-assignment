<?php
class WP_Book_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wp_book_widget', 
            __('Books by Category', 'wp-book'), 
            array('description' => __('Displays books from a selected category.', 'wp-book'))
        );
    }
    public function widget($args, $instance) {
        global $wpdb;

        
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

    
        $category = !empty($instance['category']) ? $instance['category'] : '';

        if ($category) {
            $books = new WP_Query(array(
                'post_type' => 'book',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'book_category',
                        'field'    => 'slug',
                        'terms'    => $category,
                    ),
                ),
                'posts_per_page' => -1, 
            ));

            if ($books->have_posts()) {
                echo '<ul>';
                while ($books->have_posts()) {
                    $books->the_post();
                    echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                }
                echo '</ul>';
                wp_reset_postdata();
            } else {
                echo '<p>' . __('No books found.', 'wp-book') . '</p>';
            }
        } else {
            echo '<p>' . __('Select a category to display books.', 'wp-book') . '</p>';
        }

        echo $args['after_widget'];
    }


    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Books by Category', 'wp-book');
        $category = !empty($instance['category']) ? $instance['category'] : '';

        $categories = get_terms(array(
            'taxonomy' => 'book_category',
            'hide_empty' => false,
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-book'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'wp-book'); ?></label>
            <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat">
                <option value=""><?php _e('Select Category', 'wp-book'); ?></option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($category, $cat->slug); ?>><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = !empty($new_instance['category']) ? strip_tags($new_instance['category']) : '';
        return $instance;
    }
}


function wpbook_register_widget() {
    register_widget('WP_Book_Widget');
}
add_action('widgets_init', 'wpbook_register_widget');

?>

