<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Adds widget: RecentViewProduct
class RecentViewProduct extends WP_Widget {

    public function __construct() {

        $widget_ops = array('classname' => 'emallshop_widget_products', 'description' => esc_html__("Display a list of products with slider.", 'pl-emallshop-extensions'));
        $control_ops = array('id_base' => 'emallshop-products');
        parent::__construct('emallshop-products', esc_html__('Products Display', 'pl-emallshop-extensions'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? false : $instance['title']);
        $product_type = (!empty($instance['product_type'])) ? $instance['product_type'] : 'recent-products';
        $orderby = (!empty($instance['orderby'])) ? $instance['orderby'] : 'date';
        $order = (!empty($instance['order'])) ? $instance['order'] : 'desc';
        $number = (!empty($instance['number'])) ? (int) $instance['number'] : 5;
        //Get Products
        global $woocommerce_loop;

        global $product;
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $number,
        );
        $args['meta_query'] = WC()->query->get_meta_query();
        $tax_query = WC()->query->get_tax_query();

        //recent products
        if (isset($product_type) && ( $product_type == "recent-products" )):
            $args['orderby'] = $orderby;
            $args['order'] = $order;
            $args['tax_query'] = $tax_query;
        endif;

        //featured products
        if (isset($product_type) && ( $product_type == "featured-products" )):
            $f_tax_query = $tax_query;
            $f_tax_query[] = array(
                'key' => '_featured',
                'value' => 'yes'
            );

            $args['orderby'] = $orderby;
            $args['order'] = $order;
            $args['tax_query'] = $f_tax_query;
        endif;
        //Related
        if (isset($product_type) && ( $product_type == "related-products" ) && is_woocommerce() && is_product()):
            $p_id = $product->get_id();           
            if(!empty($p_id)) {
                $related = wc_get_related_products_by_attribute($p_id, $number, $product->get_upsell_ids());
            }            
            $args['orderby'] = $orderby;
            $args['order'] = $order;
            $args['post__in'] = $related;
            $args['post__not_in'] = array($product->get_id());
        endif;
        //best selling
        if (isset($product_type) && ( $product_type == "best-seller-products" )):
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['tax_query'] = $tax_query;
        endif;

        //top reviews
        if (isset($product_type) && ( $product_type == "top-reviews-products" )):
            $args['tax_query'] = $tax_query;
            add_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));
        endif;

        //sale products
        if (isset($product_type) && ( $product_type == "sale-products" )):

            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['orderby'] = $orderby;
            $args['order'] = $order;
            $args['tax_query'] = $tax_query;
            $args['post__in'] = array_merge(array(0), $product_ids_on_sale);

        endif;
        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args, ''));

        if (isset($product_type) && ( $product_type == "top-reviews-products" )):
            remove_filter('posts_clauses', array('WC_Shortcodes', 'order_by_rating_post_clauses'));
        endif;

        $id = uniqid("productsCarousel-");
        if (is_woocommerce() && is_product()) {
            if ($products->have_posts()) :
                ?>

                <?php
                echo $before_widget;
                if ($title)
                    echo $before_title . $title . $after_title;
                ?>

                <ul class="product_list_widget_ woocommerce">
                    <?php
                    $row = 1;
                    global $product;
                    while ($products->have_posts()) : $products->the_post();
                        wc_get_template('gv-product-template.php');
                    endwhile;
                    ?>
                </ul>
                <?php echo $after_widget; ?>
                <?php
                wp_reset_query();
                wp_reset_postdata();  // Restore global post data stomped by the_post().
            endif;
        }
    }

    public function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : esc_html__('Recent Products', 'pl-emallshop-extensions');
        $product_type = isset($instance['product_type']) ? esc_attr($instance['product_type']) : 'recent-products';
        $orderby = isset($instance['orderby']) ? esc_attr($instance['orderby']) : 'date';
        $order = isset($instance['order']) ? esc_attr($instance['order']) : 'desc';
        $number = isset($instance['number']) ? (int) $instance['number'] : 5;

        emallshop_widget_input_text(esc_html__('Title:', 'pl-emallshop-extensions'), $this->get_field_id('title'), $this->get_field_name('title'), $title);
        $product_type_options = array('recent-products' => esc_html__('Recent Products', 'pl-emallshop-extensions'), 'featured-products' => esc_html__('Featured Products', 'pl-emallshop-extensions'), 'related-products' => esc_html__('Related Products', 'pl-emallshop-extensions'), 'top-reviews-products' => esc_html__('Top Reviews Products', 'pl-emallshop-extensions'), 'sale-products' => esc_html__('Sale Products', 'pl-emallshop-extensions'), 'best-seller-products' => esc_html__('Best Seller Products', 'pl-emallshop-extensions'));
        emallshop_widget_select(esc_html__('Product Type:', 'pl-emallshop-extensions'), $this->get_field_id('product_type'), $this->get_field_name('product_type'), $product_type, $product_type_options);
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

function emallshop_widget_label($label, $id) {
    echo "<label for='{$id}'>{$label}</label>";
}

function emallshop_widget_input_checkbox($label, $id, $name, $checked, $value = 1) {
    echo "\n\t\t\t<p>";
    echo "<label for='{$id}'>";
    echo "<input type='checkbox' id='{$id}' value='{$value}' name='{$name}' {$checked} /> ";
    echo "{$label}</label>";
    echo '</p>';
}

function emallshop_widget_textarea($label, $id, $name, $value) {
    echo "\n\t\t\t<p>";
    emallshop_widget_label($label, $id);
    echo "<textarea id='{$id}' name='{$name}' rows='3' cols='10' class='widefat'>" . strip_tags($value) . "</textarea>";
    echo '</p>';
}

function emallshop_widget_input_text($label, $id, $name, $value) {
    echo "\n\t\t\t<p>";
    emallshop_widget_label($label, $id);
    echo "<input type='text' id='{$id}' name='{$name}' value='" . strip_tags($value) . "' class='widefat' />";
    echo '</p>';
}

function emallshop_widget_select($label, $id, $name, $value, $options) {
    echo "\n\t\t\t<p>";
    emallshop_widget_label($label, $id);
    echo "<select name='{$name}' id='{$id}' class='widefat'>";
    foreach ($options as $key => $option) {
        echo "<option value=$key" . selected($value, $key) . ">$option</option>";
    }
    echo '</select>';
    echo '</p>';
}

function register_recent_view_product_widget() {
    register_widget('RecentViewProduct');
}

/**
 * Get related products based on product category and tags.
 *
 * @since  3.0.0
 * @param  int   $product_id  Product ID.
 * @param  int   $limit       Limit of results.
 * @param  array $exclude_ids Exclude IDs from the results.
 * @return array
 */
function wc_get_related_products_by_attribute($product_id, $limit = 5, $exclude_ids = array()) {

    $product_id = absint($product_id);
    $limit = $limit >= -1 ? $limit : 5;
    $exclude_ids = array_merge(array(0, $product_id), $exclude_ids);
    $transient_name = 'wc_related_' . $product_id;
    $query_args = http_build_query(
            array(
                'limit' => $limit,
                'exclude_ids' => $exclude_ids,
            )
    );

    $transient = get_transient($transient_name);
    $related_posts = $transient && isset($transient[$query_args]) ? $transient[$query_args] : false;

    // We want to query related posts if they are not cached, or we don't have enough.
    if (false === $related_posts || count($related_posts) < $limit) {

        $attr_array = apply_filters('woocommerce_product_related_posts_relate_by_attribute', true, $product_id) ? apply_filters('woocommerce_get_related_product_attribute_terms', wc_get_product_term_ids($product_id, 'pa_active-ingredient'), $product_id) : array();
        // Don't bother if none are set, unless woocommerce_product_related_posts_force_display is set to true in which case all products are related.
        if (empty($attr_array) && empty($attr_array) && !apply_filters('woocommerce_product_related_posts_force_display', false, $product_id)) {
            $related_posts = array();
        } else {
            $data_store = WC_Data_Store::load('product');
            $related_posts = $data_store->get_related_products($attr_array, $attr_array, $exclude_ids, $limit + 10, $product_id);
        }

        if ($transient) {
            $transient[$query_args] = $related_posts;
        } else {
            $transient = array($query_args => $related_posts);
        }

        set_transient($transient_name, $transient, DAY_IN_SECONDS);
    }

    $related_posts = apply_filters(
            'woocommerce_related_products', $related_posts, $product_id, array(
        'limit' => $limit,
        'excluded_ids' => $exclude_ids,
            )
    );

    shuffle($related_posts);

    return array_slice($related_posts, 0, $limit);
}

add_action('widgets_init', 'register_recent_view_product_widget');
