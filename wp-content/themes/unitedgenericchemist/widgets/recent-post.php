<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Adds widget: RecentPost
class RecentPost extends WP_Widget {

    public function __construct() {

        $widget_ops = array('classname' => 'emallshop_widget_posts', 'description' => esc_html__("Display a list of posts.", 'pl-emallshop-extensions'));
        $control_ops = array('id_base' => 'emallshop-posts');
        parent::__construct('emallshop-posts', esc_html__('Post Display', 'pl-emallshop-extensions'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? false : $instance['title']);
        $product_type = (!empty($instance['product_type'])) ? $instance['product_type'] : 'recent-products';
        $orderby = (!empty($instance['orderby'])) ? $instance['orderby'] : 'date';
        $order = (!empty($instance['order'])) ? $instance['order'] : 'desc';
        $number = (!empty($instance['number'])) ? (int) $instance['number'] : 5;
        //Get post       

        $recent_posts = wp_get_recent_posts(array(
            'post_type' => 'post',
            'numberposts' => $number, // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
            'orderby' => $orderby,
            'order' => $order,
            'exclude' => get_the_ID(),
        ));

        if ($recent_posts) :
            ?>

            <?php
            echo $before_widget;
            if ($title)
                echo $before_title . $title . $after_title;
            ?>

            <ul class="product_list_widget_ woocommerce">
                <?php
                foreach ($recent_posts as $post) {
//                    echo "<pre>";
//                    print_r($post);
                    ?>
                    <li>
                        <div class="product-image">
                            <a href="<?php echo get_permalink($post['ID']); ?>" title="<?php echo esc_attr($post['post_title']); ?>">
                                <?php echo get_the_post_thumbnail($post['ID'], 'thumbnail'); ?>
                            </a>
                        </div>
                        <div class="product-details">
                            <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>" title="<?php echo esc_attr($post['post_title']); ?>">
                                <span class="product-title"><?php echo $post['post_title']; ?></span>
                            </a>    
                            <span class="product-price">
                                <?php echo date('jS F, Y', strtotime($post['post_date'])); ?>
                            </span>
                        </div>



                    </li>    
                    <?php
                }
                ?>
            </ul>
            <?php echo $after_widget; ?>
            <?php
            wp_reset_query();
            wp_reset_postdata();  // Restore global post data stomped by the_post().
        endif;
    }

    public function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : esc_html__('Recent Posts', 'pl-emallshop-extensions');
        $orderby = isset($instance['orderby']) ? esc_attr($instance['orderby']) : 'date';
        $order = isset($instance['order']) ? esc_attr($instance['order']) : 'desc';
        $number = isset($instance['number']) ? (int) $instance['number'] : 5;

        emallshop_widget_input_text(esc_html__('Title:', 'pl-emallshop-extensions'), $this->get_field_id('title'), $this->get_field_name('title'), $title);
        emallshop_widget_input_text(esc_html__('Show number of products:', 'pl-emallshop-extensions'), $this->get_field_id('number'), $this->get_field_name('number'), $number);
        $orderby_options = array('date' => esc_html__('Date', 'pl-emallshop-extensions'), 'title' => esc_html__('Title', 'pl-emallshop-extensions'), 'name' => esc_html__('Name(Slug)', 'pl-emallshop-extensions'), 'rand' => esc_html__('Rand', 'pl-emallshop-extensions'), 'id' => esc_html__('ID', 'pl-emallshop-extensions'));
        emallshop_widget_select(esc_html__('Order By:', 'pl-emallshop-extensions'), $this->get_field_id('orderby'), $this->get_field_name('orderby'), $orderby, $orderby_options);
        $order_options = array('desc' => 'Descending', 'asc' => 'Ascending');
        emallshop_widget_select(esc_html__('Order:', 'pl-emallshop-extensions'), $this->get_field_id('order'), $this->get_field_name('order'), $order, $order_options);
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['product_type'] = strip_tags($new_instance['product_type']);
        $instance['orderby'] = strip_tags($new_instance['orderby']);
        $instance['order'] = strip_tags($new_instance['order']);
        $instance['number'] = (int) $new_instance['number'];
        return $instance;
    }

}

/* Forms
  -------------------------------------------------------------- */

//
//function emallshop_widget_textarea($label, $id, $name, $value) {
//    echo "\n\t\t\t<p>";
//    emallshop_widget_label($label, $id);
//    echo "<textarea id='{$id}' name='{$name}' rows='3' cols='10' class='widefat'>" . strip_tags($value) . "</textarea>";
//    echo '</p>';
//}
//
//function emallshop_widget_input_text($label, $id, $name, $value) {
//    echo "\n\t\t\t<p>";
//    emallshop_widget_label($label, $id);
//    echo "<input type='text' id='{$id}' name='{$name}' value='" . strip_tags($value) . "' class='widefat' />";
//    echo '</p>';
//}
//
//function emallshop_widget_select($label, $id, $name, $value, $options) {
//    echo "\n\t\t\t<p>";
//    emallshop_widget_label($label, $id);
//    echo "<select name='{$name}' id='{$id}' class='widefat'>";
//    foreach ($options as $key => $option) {
//        echo "<option value=$key" . selected($value, $key) . ">$option</option>";
//    }
//    echo '</select>';
//    echo '</p>';
//}

function register_recent_view_post_widget() {
    register_widget('RecentPost');
}

add_action('widgets_init', 'register_recent_view_post_widget');
