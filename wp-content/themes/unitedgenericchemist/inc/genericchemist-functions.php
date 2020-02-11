<?php
/**
 * Add class name to logo <a> tag
 */
add_filter('get_custom_logo', 'change_logo_class');
if (!function_exists('change_logo_class')) {

    function change_logo_class($html)
    {

        $html = str_replace('custom-logo', 'navbar-brand', $html);
        $html = str_replace('custom-logo-link', 'navbar-brand', $html);

        return $html;
    }

}
/* Display mini cart */
if (!function_exists('custom_mini_cart')) {

    function custom_mini_cart()
    {
        echo '<a href="#" class="dropdown-back" data-toggle="dropdown"> ';
        echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
        echo '<div class="basket-item-count">';
        echo '<span class="cart-items-count">';
        echo count(WC()->cart->get_cart());
        echo '</span>';
        echo '<span class="cart-heading">Checkout</span></div>';
        echo '</a>';
        echo '<ul class="dropdown-menu dropdown-menu-mini-cart">';
        echo '<li> <div class="widget_shopping_cart_content">';
        woocommerce_mini_cart();
        echo '</div></li></ul>';
    }

}
add_shortcode('custom-techno-mini-cart', 'custom_mini_cart');
add_filter('woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1);

function iconic_cart_count_fragments($fragments)
{

    $fragments['span.cart-items-count'] = '<span class="cart-items-count">' . count(WC()->cart->get_cart()) . '</span>';

    return $fragments;
}

add_action('woocommerce_archive_description', 'add_view_more_button');

if (!function_exists('add_view_more_button')) {

    /**
     * Added the View More button to display more content to the archive product page
     * @global type $wp_query
     */
    function add_view_more_button()
    {
        if (is_product_category()) {
            global $wp_query;
            $cat_id = $wp_query->get_queried_object_id();
            $cat_desc = term_description($cat_id, 'product_cat');
            if (!empty($cat_desc)) {
                ?>
                <div class="view-more-button-section">
                    <a href="javascript:void(0)" class="view-more-button">View More</a>
                </div>
                <?php
            }
        }
    }

}


add_action('product_cat_add_form_fields', 'rv_taxonomy_add_new_cate_field', 10, 1);
add_action('product_cat_edit_form_fields', 'rv_taxonomy_edit_cate_field', 10, 1);

//Product Cat Create page
function rv_taxonomy_add_new_cate_field()
{
    ?>
    <div class="form-field">
        <label for="rv_cat_sub_title"><?php _e('Sub Second Category Title', 'wh'); ?></label>
        <input type="text" name="rv_cat_sub_title" id="rv_cat_sub_title">
        <p class="description"><?php _e('Enter sub-category title for category page', 'wh'); ?></p>
    </div>
    <div class="form-field">
        <label for="rv_cat_title"><?php _e('Second Category Title', 'wh'); ?></label>
        <input type="text" name="rv_cat_title" id="rv_cat_title">
        <p class="description"><?php _e('Enter second title for category page display at bottom', 'wh'); ?></p>
    </div>
    <div class="form-field">
        <label for="rv_cate_desc"><?php _e('Second Category Description', 'wh'); ?></label>
        <textarea name="rv_cate_desc" id="rv_cate_desc"></textarea>
        <p class="description"><?php _e('Enter a second category description', 'wh'); ?></p>
    </div>
    <?php
}

//Product Cat Edit page
function rv_taxonomy_edit_cate_field($term)
{
    //getting term ID
    $term_id = $term->term_id;
    // retrieve the existing value(s) for this meta field.
    $rv_cat_title = get_term_meta($term_id, 'rv_cat_title', true);
    $rv_cate_desc = get_term_meta($term_id, 'rv_cate_desc', true);
    $rv_cat_sub_title = get_term_meta($term_id, 'rv_cat_sub_title', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="rv_cat_sub_title"><?php _e('Second Category Title', 'wh'); ?></label>
        </th>
        <td>
            <input type="text" name="rv_cat_sub_title" id="rv_cat_sub_title"
                   value="<?php echo esc_attr($rv_cat_sub_title) ? esc_attr($rv_cat_sub_title) : ''; ?>">
            <p class="description"><?php _e('Enter sub-category title for category page', 'wh'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="rv_cat_title"><?php _e('Second Category Title', 'wh'); ?></label></th>
        <td>
            <input type="text" name="rv_cat_title" id="rv_cat_title"
                   value="<?php echo esc_attr($rv_cat_title) ? esc_attr($rv_cat_title) : ''; ?>">
            <p class="description"><?php _e('Enter second title for category page display at bottom', 'wh'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="rv_cate_desc"><?php _e('Second Category Description', 'wh'); ?></label>
        </th>
        <td>
            <!--<textarea name="rv_cate_desc" id="rv_cate_desc"><?php $content = ($rv_cate_desc) ? ($rv_cate_desc) : ''; ?></textarea>-->
            <?php wp_editor($content, 'rv_cate_desc'); ?>
            <p class="description"><?php _e('Enter a second category description', 'wh'); ?></p>
        </td>
    </tr>
    <?php
}

add_action('edited_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);

// Save extra taxonomy fields callback function.
function wh_save_taxonomy_custom_meta($term_id)
{
    $rv_cat_title = filter_input(INPUT_POST, 'rv_cat_title');
    $rv_cate_desc = filter_input(INPUT_POST, 'rv_cate_desc');
    $rv_cat_sub_title = filter_input(INPUT_POST, 'rv_cat_sub_title');
    update_term_meta($term_id, 'rv_cat_title', $rv_cat_title);
    update_term_meta($term_id, 'rv_cate_desc', $rv_cate_desc);
    update_term_meta($term_id, 'rv_cat_sub_title', $rv_cat_sub_title);
}

add_action('woocommerce_archive_description', 'add_sub_category_title', 5);
if (!function_exists('add_sub_category_title')) {

    function add_sub_category_title()
    {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $cat_sub_title = get_term_meta($term_id, 'rv_cat_sub_title', true);
        if (!empty($cat_sub_title)) {
            ?><h2 class="sub-cat-title"><?php echo $cat_sub_title; ?></h2><?php
        }
    }

}

add_action('woocommerce_after_main_content', 'add_second_category_title', 5);
if (!function_exists('add_second_category_title')) {

    function add_second_category_title()
    {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $rv_cat_title = get_term_meta($term_id, 'rv_cat_title', true);
        $rv_cate_desc = get_term_meta($term_id, 'rv_cate_desc', true);
        if (!is_search()) { // Remove title and description on search result
            if (!empty($rv_cat_title)) {
                ?><h2 class="sub-cat-title"><?php echo $rv_cat_title; ?></h2><?php
            }
            if (!empty($rv_cate_desc)) {
                ?>
                <div class="term-description"><?php echo wpautop($rv_cate_desc); ?></div>
                <div class="view-more-button-section">
                    <a href="javascript:void(0)" class="view-more-button">View More</a>
                </div>
                <?php
            }
        }
    }

}


add_action('woocommerce_archive_description', 'add_shortcode_for_recommened_product_slider', 11);

if (!function_exists('add_shortcode_for_recommened_product_slider')) {

    /**
     * Added the View More button to display more content to the archive product page
     * @global type $wp_query
     */
    function add_shortcode_for_recommened_product_slider()
    {
        $selected_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
        $search_text = isset($_GET['s']) ? $_GET['s'] : '';
        $port_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
        if (!isset($_GET['product_cat']) || !isset($_GET['product_cat']) || !isset($_GET['product_cat'])) {
            ?>
            <div class="recommended-products">
                <?php echo do_shortcode("[RECOMMENDED_PRODUCTS]"); ?>
            </div>
            <?php
        }
    }

}


/* Remove "all result caption at below" */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 9);
/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 20);

function new_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 12;
    return $cols;
}

add_action('woocommerce_after_shop_loop', 'add_start_div_for_design', 8);
if (!function_exists('add_start_div_for_design')) {

    function add_start_div_for_design()
    {
        echo "<div class='pagination-result-section d-none'>";
    }

}
add_action('woocommerce_after_shop_loop', 'add_end_div_for_design', 12);
if (!function_exists('add_end_div_for_design')) {

    function add_end_div_for_design()
    {
        echo "</div>";
    }

}

add_filter('woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');

/**
 * custom_woocommerce_template_loop_add_to_cart Rename the button names
 */
function custom_woocommerce_product_add_to_cart_text()
{
    global $product;

    $product_type = $product->product_type;

    switch ($product_type) {
        case 'external':
            return __('Buy product', 'woocommerce');
            break;
        case 'grouped':
            return __('View products', 'woocommerce');
            break;
        case 'simple':
            return __('Add to cart', 'woocommerce');
            break;
        case 'variable':
            return __('View detail', 'woocommerce');
            break;
        default:
            return __('Read more', 'woocommerce');
    }
}

add_action('woocommerce_after_single_product_summary', 'display_variation_in_table_format', 5);
if (!function_exists('display_variation_in_table_format')) {

    function display_variation_in_table_format()
    {
        ?>
        <div class="product-variation-display-section table-responsive">
            <?php
            global $product;
            $id = $product->get_id();
            $product = new WC_Product_Variable($id);
            // get the product variations
            $product_variations = $product->get_available_variations();
            $attributes = $product->get_attributes();
            //            echo "<pre>";
            //            print_r($attributes);
            foreach ($attributes as $key => $attribute) {
                if ($attribute->get_variation()) {
                    $attribute_name = $attribute->get_name();
                }
            }
            if (!empty($product_variations)) {
                ?>

                <table class="product_type">
                    <tbody>
                    <tr>
                        <td class="p_image">
                            <div class="product_img">
                                <a class="thumbnail" href="#">
                                    <img src="<?php echo $product_variations[0]['image']['src']; ?>"
                                         title="<?php echo $product_variations[0]['image']['title']; ?>"
                                         alt="<?php echo $product_variations[0]['image']['alt']; ?>"
                                         class="img-responsive"
                                         width="<?php echo $product_variations[0]['image']['gallery_thumbnail_src_w']; ?>">
                                </a>
                            </div>
                        </td>
                        <td class="block">
                            <table class="table footable footable-1 breakpoint-lg table-bordered"
                                   data-toggle-column="last">
                                <thead>
                                <tr class="row-title">
                                    <th colspan="5"><h2
                                                class="variation-product-title"><?php echo $product->get_title() . ' - ' . $attribute_name; ?></h2>
                                    </th>
                                </tr>
                                <tr class="footable-header">
                                    <th class="footable-first-visible"><?php echo $attribute_name; ?></th>
                                    <th>Price:</th>
                                    <th class="hide-mobile">Price/unit</th>
                                    <th>Quantity</th>
                                    <th class="footable-last-visible">Add To Cart</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($product_variations as $key => $product_variation) {
                                    $attribute = array_values($product_variation['attributes']);
                                    ?>
                                    <tr>
                                        <td class="footable-first-visible"><?php echo($attribute[0]); ?></td>
                                        <td> <?php echo $product_variation['price_html']; ?></td>
                                        <td class="hide-mobile">
                                            <?php
                                            $tablets = explode(' ', $attribute[0]);
                                            $unit_price = $product_variation['display_price'] / $tablets[0];
                                            $final_unit = round(number_format($unit_price, 2), 2);
                                            echo '$' . $final_unit . ' /Piece';
                                            ?>
                                        </td>
                                        <td>
                                            <select class="form-control select-qty">
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td class="footable-last-visible">
                                            <?php
                                            $attr = '';
                                            $attrs = $product_variation['attributes'];
                                            foreach ($attrs as $key => $attr) {
                                                if (!empty($attr)) {
                                                    $attr = $key . '=' . $attr;
                                                } else {
                                                    $attr .= '&' . $key . '=' . $attr;
                                                }
                                            }
                                            $key = '_stock_status';
                                            $checkStock = get_post_meta($product_variation["variation_id"], $key, true);
                                            if (!empty($checkStock) && $checkStock == 'outofstock') {
                                                ?><span class="text-danger">Out of stock</span><?php
                                            } else {
                                                ?>
                                            <button type="button"
                                                    class="btn-add-to-cart-ajax btn btn-link btn-color-orange"
                                                    data-product_id="<?php echo abs($id); ?>"
                                                    data-variation_id="<?php echo abs($product_variation["variation_id"]); ?>"
                                                    data-quantity="1" data-variation="<?php echo $attr; ?>"><i
                                                            class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                </button><?php
                                            }
                                            ?>
                                            <!--<a href="<?php echo get_the_permalink() . '?add-to-cart=' . $id . '&quantity=1&variation_id=' . $product_variation["variation_id"] . '&' . $attr . ''; ?>" class="btn btn-primary btn-add-to-cart-ajax">add to cart</a>-->
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <?php
    }

}


add_action('wp_ajax_nopriv_woocommerce_add_variation_to_cart', 'so_27270880_add_variation_to_cart');
add_action('wp_ajax_woocommerce_add_variation_to_cart', 'so_27270880_add_variation_to_cart');

function so_27270880_add_variation_to_cart()
{

    ob_start();

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

    $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : '';
    $variations = !empty($_POST['variation']) ? (array)$_POST['variation'] : '';
    $variations = array($variations[0] => $variations[1]);
//    print_r($new_variation);
//    exit;
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations, $cart_item_data);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations)) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
            wc_add_to_cart_message($product_id);
        }

        // Return fragments
        WC_AJAX::get_refreshed_fragments();
    } else {

        // If there was an error adding to the cart, redirect to the product page to show any errors
        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
        );

        wp_send_json($data);
    }

    die();
}

/* remove price in single product page */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
add_action('woocommerce_single_product_summary', 'hide_add_to_cart_button_variable_product', 1, 0);

function hide_add_to_cart_button_variable_product()
{

    // Removing add to cart button and quantities only
    remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
}

add_action('woocommerce_single_product_summary', 'woocommerce_attribute_display', 10);
if (!function_exists('woocommerce_attribute_display')) {

    /**
     * Display product attribute with SKU
     * @global type $product
     */
    function woocommerce_attribute_display()
    {
        global $product;
        $attributes = $product->get_attributes();
        ?>
        <table class="shop_attributes">
        <?php if ($product->get_sku()) { ?>
        <tr>
            <th>Product Code:</th>
            <td><?php echo $product->get_sku(); ?></td>
        </tr>
        <?php
    }
        foreach ($attributes as $attribute) :
            $visible = $attribute->get_visible();
            if ($visible) {
                ?>
                <tr>
                    <th><?php echo wc_attribute_label($attribute->get_name()); ?>:</th>
                    <td><?php
                        $values = array();

                        if ($attribute->is_taxonomy()) {
                            $attribute_taxonomy = $attribute->get_taxonomy_object();
                            $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

                            foreach ($attribute_values as $attribute_value) {
                                $value_name = esc_html($attribute_value->name);

                                if ($attribute_taxonomy->attribute_public) {
                                    $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                                } else {
                                    $values[] = $value_name;
                                }
                            }
                        } else {
                            $values = $attribute->get_options();

                            foreach ($values as &$value) {
                                $value = make_clickable(esc_html($value));
                            }
                        }

                        echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);
                        ?></td>
                </tr>
                <?php
            }
        endforeach;
        ?></table><?php
    }

}

/**
 * @snippet       Hide SKU @ Single Product Page - WooCommerce
 */
add_filter('wc_product_sku_enabled', 'bbloomer_remove_product_page_sku');

function bbloomer_remove_product_page_sku($enabled)
{
    if (!is_admin() && is_product()) {
        return false;
    }

    return $enabled;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);


if (!function_exists('display_variation_in_table_format_upsell')) {

    function display_variation_in_table_format_upsell($product_id)
    {
        ?>
        <div class="product-variation-display-section table-responsive">
            <?php
            //            global $product;
            //            $id = $product->get_id();
            $product = new WC_Product_Variable($product_id);
            // get the product variations
            $product_variations = $product->get_available_variations();
            $attributes = $product->get_attributes();
            //            echo "<pre>";
            //            print_r($attributes);
            foreach ($attributes as $key => $attribute) {
                if ($attribute->get_variation()) {
                    $attribute_name = $attribute->get_name();
                }
            }
            if (!empty($product_variations)) {
                ?>

                <table class="product_type">
                    <tbody>
                    <tr>
                        <td class="p_image">
                            <div class="product_img">
                                <a class="thumbnail" href="#">
                                    <img src="<?php echo $product_variations[0]['image']['src']; ?>"
                                         title="<?php echo $product_variations[0]['image']['title']; ?>"
                                         alt="<?php echo $product_variations[0]['image']['alt']; ?>"
                                         class="img-responsive"
                                         width="<?php echo $product_variations[0]['image']['gallery_thumbnail_src_w']; ?>">
                                </a>
                            </div>
                        </td>
                        <td class="block">
                            <table class="table footable footable-1 breakpoint-lg table-bordered"
                                   data-toggle-column="last">
                                <thead>
                                <tr class="row-title">
                                    <th colspan="5"><h2
                                                class="variation-product-title"><?php echo $product->get_title(); ?></h2>
                                    </th>
                                </tr>
                                <tr class="footable-header">
                                    <th class="footable-first-visible"><?php echo $attribute_name; ?></th>
                                    <th>Price:</th>
                                    <th class="hide-mobile">Price/unit</th>
                                    <th>Quantity</th>
                                    <th class="footable-last-visible">Add To Cart</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($product_variations as $key => $product_variation) {
                                    $attribute = array_values($product_variation['attributes']);
                                    ?>
                                    <tr>
                                        <td class="footable-first-visible"><?php echo($attribute[0]); ?></td>
                                        <td> <?php echo $product_variation['price_html']; ?></td>
                                        <td class="hide-mobile">
                                            <?php
                                            $tablets = explode(' ', $attribute[0]);
                                            $unit_price = $product_variation['display_price'] / $tablets[0];
                                            $final_unit = round(number_format($unit_price, 2), 2);
                                            echo '$' . $final_unit . ' /Piece';
                                            ?>
                                        </td>
                                        <td>
                                            <select class="form-control select-qty">
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td class="footable-last-visible">
                                            <?php
                                            $attr = '';
                                            $attrs = $product_variation['attributes'];
                                            foreach ($attrs as $key => $attr) {
                                                if (!empty($attr)) {
                                                    $attr = $key . '=' . $attr;
                                                } else {
                                                    $attr .= '&' . $key . '=' . $attr;
                                                }
                                            }
                                            $key = '_stock_status';
                                            $checkStock = get_post_meta($product_variation["variation_id"], $key, true);
                                            if (!empty($checkStock) && $checkStock == 'outofstock') {
                                                ?><span class="text-danger">Out of stock</span><?php
                                            } else {
                                                ?>
                                            <button type="button"
                                                    class="btn-add-to-cart-ajax btn btn-link btn-color-orange"
                                                    data-product_id="<?php echo abs($id); ?>"
                                                    data-variation_id="<?php echo abs($product_variation["variation_id"]); ?>"
                                                    data-quantity="1" data-variation="<?php echo $attr; ?>"><i
                                                            class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                </button><?php
                                            }
                                            ?>
                                            <!--<a href="<?php echo get_the_permalink() . '?add-to-cart=' . $id . '&quantity=1&variation_id=' . $product_variation["variation_id"] . '&' . $attr . ''; ?>" class="btn btn-primary btn-add-to-cart-ajax">add to cart</a>-->
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <?php
            }
            ?>
        </div>
        <?php
    }

}
/* Remove only heading of "Description" */
add_filter('woocommerce_product_description_heading', '__return_empty_string');

add_action('woocommerce_after_single_product_summary', 'woocommerce_template_product_description', 18);
if (!function_exists('woocommerce_template_product_description')) {

    /**
     * Display the Product description without Tabbing
     */
    function woocommerce_template_product_description()
    {
        if (WC()->cart->get_cart_contents_count() != 0) {
            ?>
            <div class="check-out-buttons"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></div><?php
        }
        ?>
        <div class="product-description-section">
            <h3 class="product-heading">Description</h3>
            <div class="description">
                <?php
                wc_get_template('single-product/tabs/description.php');
                ?>
            </div>
        </div>
        <?php
    }

}

add_action('woocommerce_after_single_product_summary', 'woocommerce_template_product_review', 19);
if (!function_exists('woocommerce_template_product_review')) {

    function woocommerce_template_product_review()
    {

        comments_template();
    }

}


/**
 * @snippet       Add First & Last Name to My Account Register Form - WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21974
 * @author        Rodolfo Melogli
 * @credits       Claudio SM Web
 * @compatible    WC 3.5.2
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
///////////////////////////////
// 1. ADD FIELDS

add_action('woocommerce_register_form_start', 'bbloomer_add_name_woo_account_registration');

function bbloomer_add_name_woo_account_registration()
{
    ?>
    <div class="row">
        <div class="form-group col-sm-6">
            <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?> <span
                        class="required">*</span></label>
            <input type="text" class="form-control" name="billing_first_name" id="reg_billing_first_name"
                   value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>"
                   maxlength="32"/>
        </div>

        <div class="form-group col-sm-6">
            <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?> <span class="required">*</span></label>
            <input type="text" class="form-control" name="billing_last_name" id="reg_billing_last_name"
                   value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>"
                   maxlength="32"/>
        </div>
        <div class="form-group col-sm-12">
            <label for="reg_billing_phone"><?php _e('Phone number', 'woocommerce'); ?> <span
                        class="required">*</span></label>
            <input type="text" class="form-control" name="billing_phone" id="reg_billing_phone"
                   value="<?php esc_attr_e($_POST['billing_phone']); ?>" maxlength="10"/>
        </div>
    </div>
    <div class="clear"></div>

    <?php
}

///////////////////////////////
// 2. VALIDATE FIELDS

add_filter('woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3);

function bbloomer_validate_name_fields($errors, $username, $email)
{
    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
        $errors->add('billing_first_name_error', __('First name is required!', 'woocommerce'));
    }
    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
        $errors->add('billing_last_name_error', __('Last name is required!.', 'woocommerce'));
    }
    if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
        $errors->add('billing_phone_error', __('Phone number is required!.', 'woocommerce'));
    }
    if (isset($_POST['billing_phone']) && (!preg_match('/^[0-9]{10}+$/', $_POST['billing_phone']))) {
        $errors->add('billing_phone_error', __('Phone number is invalid!.', 'woocommerce'));
    }

    return $errors;
}

///////////////////////////////
// 3. SAVE FIELDS

add_action('woocommerce_created_customer', 'bbloomer_save_name_fields');

function bbloomer_save_name_fields($customer_id)
{
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['billing_phone'])) {
        // Mobile No. input filed (Billing Phone of WooCommerce)
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}

// ----- validate password match on the registration page
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email)
{
    global $woocommerce;
    extract($_POST);
    if (strcmp($password, $password2) !== 0) {
        return new WP_Error('registration-error', __('Passwords do not match.', 'woocommerce'));
    }
    return $reg_errors;
}

add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10, 3);

// ----- add a confirm password fields match on the registration page
function wc_register_form_password_repeat()
{
    ?>
    <p class="form-row form-row-wide">
        <label for="reg_password2"><?php _e('Password Confirm', 'woocommerce'); ?> <span
                    class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2"
               value="<?php if (!empty($_POST['password2'])) echo esc_attr($_POST['password2']); ?>"/>
    </p>
    <?php
}

add_action('woocommerce_register_form', 'wc_register_form_password_repeat');

// ----- Validate confirm password field match to the checkout page
function lit_woocommerce_confirm_password_validation($posted)
{
    $checkout = WC()->checkout;
    if (!is_user_logged_in() && ($checkout->must_create_account || !empty($posted['createaccount']))) {
        if (strcmp($posted['account_password'], $posted['account_confirm_password']) !== 0) {
            wc_add_notice(__('Passwords do not match.', 'woocommerce'), 'error');
        }
    }
}

add_action('woocommerce_after_checkout_validation', 'lit_woocommerce_confirm_password_validation', 10, 2);

// ----- Add a confirm password field to the checkout page
function lit_woocommerce_confirm_password_checkout($checkout)
{
    if (get_option('woocommerce_registration_generate_password') == 'no') {

        $fields = $checkout->get_checkout_fields();

        $fields['account']['account_confirm_password'] = array(
            'type' => 'password',
            'label' => __('Confirm password', 'woocommerce'),
            'required' => true,
            'placeholder' => _x('Confirm Password', 'placeholder', 'woocommerce')
        );

        $checkout->__set('checkout_fields', $fields);
    }
}

add_action('woocommerce_checkout_init', 'lit_woocommerce_confirm_password_checkout', 10, 1);

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}

add_filter('woocommerce_account_menu_items', 'rv_remove_my_account_links');
if (!function_exists('rv_remove_my_account_links')) {

    /**
     * Remove Logout link and Download tab on my account page.
     * @param type $menu_links
     * @return type
     */
    function rv_remove_my_account_links($menu_links)
    {

        unset($menu_links['downloads']); // Disable Downloads
        unset($menu_links['customer-logout']); // Remove Logout link
        return $menu_links;
    }

}


add_action('woocommerce_after_order_notes', 'wk_add_custom_checkout_field');

function wk_add_custom_checkout_field($checkout)
{
    echo '<div class="health-form"><h2>' . __('Medical Condition') . '</h2>';

    woocommerce_form_field('physician_name', array(
        'type' => 'text',
        'class' => array('physician-name'),
        'label' => __("Your Physician's Name: "),
        'placeholder' => __(''),
        'maxlength' => 32,
        'required' => false,
    ), $checkout->get_value('physician_name'));

    woocommerce_form_field('physician_phone', array(
        'type' => 'tel',
        'class' => array('physician-phone'),
        'label' => __("Physician's Telephone No:"),
        'placeholder' => __(''),
        'maxlength' => 10,
        'required' => false,
    ), $checkout->get_value('physician_phone'));

    woocommerce_form_field('drug_allergies', array(
        'type' => 'text',
        'class' => array('drug-allergies'),
        'label' => __("Drug Allergies:"),
        'placeholder' => __(''),
        'maxlength' => 32,
        'required' => false,
    ), $checkout->get_value('drug_allergies'));
    woocommerce_form_field('current_medications', array(
        'type' => 'text',
        'class' => array('current-medications'),
        'label' => __("Current Medications:"),
        'placeholder' => __(''),
        'maxlength' => 32,
        'required' => false,
    ), $checkout->get_value('current_medications'));
    woocommerce_form_field('current_treatments', array(
        'type' => 'text',
        'class' => array('current-treatments'),
        'label' => __("Current Treatments:"),
        'placeholder' => __(''),
        'maxlength' => 32,
        'required' => false,
    ), $checkout->get_value('current_treatments'));
    woocommerce_form_field('smoke', array(
        'type' => 'radio',
        'class' => array('smoke'),
        'label' => __("Do you Smoke?"),
        'required' => false,
        'default' => 0,
        'options' => array('No', 'Yes'),
    ), $checkout->get_value('smoke'));
    woocommerce_form_field('drink_alcohol', array(
        'type' => 'radio',
        'class' => array('drink-alcohol'),
        'label' => __("Do you drink Alcohol?"),
        'required' => false,
        'default' => 0,
        'options' => array('No', 'Yes'),
    ), $checkout->get_value('drink_alcohol'));
    echo ''
        . "<p class='certify-text'><strong>I certify that I am 'over 18 years' and that I am under the supervision of a doctor. The ordered medication is for my own personal use and is strictly not meant for a re-sale. I also accept that I am taking the medicine /s at my own risk and that I am duly aware of all the effects / side effects of the medicine / s. If my order contain Tadalafil, I confirm that the same is not meant for consumption in the USA. I acknowledge that the drugs are as per the norms of the country of destination.</strong></p>"
        . '<p class="form-row file-upload" id="fileupload_field" data-priority=""><label for="fileupload_field" class="">Upload Prescription&nbsp;</label><span class="woocommerce-input-wrapper"><div class="uploader" id="uploader"></div></span><input type="hidden" name="prescription_name" id="prescription_name" /></p>'
        . '</div>';
}

/**
 * Update the order meta with field value
 */
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['physician_name'])) {
        update_post_meta($order_id, '_medical_physician_name', sanitize_text_field($_POST['physician_name']));
    }
    if (!empty($_POST['physician_phone'])) {
        update_post_meta($order_id, '_medical_physician_phone', sanitize_text_field($_POST['physician_phone']));
    }
    if (!empty($_POST['drug_allergies'])) {
        update_post_meta($order_id, '_medical_drug_allergies', sanitize_text_field($_POST['drug_allergies']));
    }
    if (!empty($_POST['current_medications'])) {
        update_post_meta($order_id, '_medical_current_medications', sanitize_text_field($_POST['current_medications']));
    }
    if (!empty($_POST['current_treatments'])) {
        update_post_meta($order_id, '_medical_current_treatments', sanitize_text_field($_POST['current_treatments']));
    }
    if (!empty($_POST['smoke'])) {
        update_post_meta($order_id, '_medical_smoke', sanitize_text_field($_POST['smoke']));
    }
    if (!empty($_POST['drink_alcohol'])) {
        update_post_meta($order_id, '_medical_drink_alcohol', sanitize_text_field($_POST['drink_alcohol']));
    }
    if (!empty($_POST['prescription_name'])) {
        update_post_meta($order_id, '_prescription', ($_POST['prescription_name']));
    }
}

/**
 * Display field value on the order edit page
 */
add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);

function my_custom_checkout_field_display_admin_order_meta($order)
{
    $smoke = get_post_meta($order->id, '_medical_smoke', true);
    $smoke = (($smoke == 1) ? "Yes" : "No");
    $drink_alcohol = get_post_meta($order->id, '_medical_drink_alcohol', true);
    $drink_alcohol = (($drink_alcohol == 1) ? "Yes" : "No");
    $baseUploadUrl = wp_get_upload_dir();
    $output_dir = $baseUploadUrl['baseurl'] . '/';
    $fileName = get_post_meta($order->id, '_prescription', true);
    $prescript_attach = "Not found";
    if (!empty($fileName)) {
        $prescript_attach = '<a href="' . $output_dir . $fileName . '" target="_blank">Download</a>';
    }
    echo '<p><strong>' . __("Physician's Name") . ':</strong> <br/>' . get_post_meta($order->id, '_medical_physician_name', true) . '</p>';
    echo '<p><strong>' . __("Physician's Telephone No") . ':</strong> <br/>' . get_post_meta($order->id, '_medical_physician_phone', true) . '</p>';
    echo '<p><strong>' . __('Drug Allergies') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_drug_allergies', true) . '</p>';
    echo '<p><strong>' . __('Current Medications') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_current_medications', true) . '</p>';
    echo '<p><strong>' . __('Current Treatments') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_current_treatments', true) . '</p>';
    echo '<p><strong>' . __('Smoke?') . ':</strong> ' . $smoke . '</p>';
    echo '<p><strong>' . __('Drink Alcohol') . ':</strong> ' . $drink_alcohol . '</p>';
    echo '<p><strong>' . __('Prescription') . ':</strong> <br/>' . $prescript_attach . '</p>';
}

add_filter('woocommerce_ship_to_different_address_checked', '__return_true');


add_filter('woocommerce_continue_shopping_redirect', 'wc_custom_redirect_continue_shopping');
if (!function_exists('wc_custom_redirect_continue_shopping')) {
    /*
     * Redirecting the "Continue Shopping" button to a Cart page
     */

    function wc_custom_redirect_continue_shopping()
    {
        //return your desired link here.
        $return_url = wc_get_cart_url();

        return $return_url;
    }

}
add_filter('wc_add_to_cart_message_html', 'change_continue_shopping_message', 10, 2);
if (!function_exists('change_continue_shopping_message')) {
    /*
     * Rename "Continue shopping" to "View Cart"
     */

    function change_continue_shopping_message($message, $products)
    {
        if (strpos($message, 'Continue shopping') !== false) {
            $message = str_replace("Continue shopping", "View Cart", $message);
        }

        return $message;
    }

}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {

    function loop_columns()
    {
        $column = 4;
        return $column; // 3 products per row
    }

}
add_filter('woocommerce_output_related_products_args', 'jk_related_products_args');

function jk_related_products_args($args)
{
    $args['posts_per_page'] = 3; // 4 related products
    $args['columns'] = 3; // arranged in 2 columns
    return $args;
}

add_action('woocommerce_before_cart', 'tl_continue_shopping_button');

if (!function_exists('tl_continue_shopping_button')) {

    /**
     * Display Continue Shopping button below the checkout button
     */
    function tl_continue_shopping_button()
    {
        $shop_page_url = get_permalink(woocommerce_get_page_id('shop'));

        echo '<div class="wc-proceed-to-checkout continue-shopping-btn">';
        echo ' <a href="' . $shop_page_url . '" class="button alt wc-forward">Continue Shopping</a>';
        echo '</div>';
    }

}
/* Uncheck Ship item to another address by default */
add_filter('woocommerce_ship_to_different_address_checked', '__return_false');

/**
 * Adds SKUs and product images to WooCommerce order emails
 */
function sww_add_sku_to_wc_emails($args)
{

    $args['show_sku'] = true;
    return $args;
}

add_filter('woocommerce_email_order_items_args', 'sww_add_sku_to_wc_emails');


add_filter('woocommerce_cod_process_payment_order_status', 'change_cod_payment_order_status', 10, 2);

function change_cod_payment_order_status($order_status, $order)
{
    return 'on-hold';
}

// Trigger "On hold" notification for COD orders
//add_action('woocommerce_order_status_on-hold', 'email_on_hold_notification_for_cod', 2, 20);

function email_on_hold_notification_for_cod($order_id, $order)
{
    if ($order->get_payment_method() == 'cod')
        WC()->mailer()->get_emails()['WC_Email_Customer_On_Hold_Order']->trigger($order_id);
}

//add_action('woocommerce_email', 'unhook_new_order_processing_emails');

function unhook_new_order_processing_emails($email_class)
{
    // Turn off pending to processing for now
    remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
    // Turn it back on but send the on-hold email
    add_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_On_Hold_Order'], 'trigger'));
}

/**
 * @snippet       Add Content to the Customer Processing Order Email - WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=385
 * @author        Rodolfo Melogli
 * @testedwith    Woo 3.5.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
add_action('woocommerce_email_before_order_table', 'bbloomer_add_content_specific_email', 20, 4);

function bbloomer_add_content_specific_email($order, $sent_to_admin, $plain_text, $email) {
    $paypal_url = 'https://www.paypal.me/';
    $paypal_id = of_get_option('paypal_url');
    $cart_total = $order->get_total();
    $paypal_url = $paypal_url . $paypal_id . '/' . $cart_total . 'usd';
    $payment_title = $order->get_payment_method_title();

    if ($payment_title == 'Pay By Credit/Debit Card') {
        if ($email->id == 'customer_on_hold_order') {
            echo '<p>Your order has been successfully placed.</p>';
            echo '<p><b>We will send you the PAYMENT LINK within 12 hours to your email. After your payment confirmation, Your order will be shipped within 24 hours and provide you the tracking number.
</b></p>';
            echo '<p>Stay Tuned with your Email...!</p>';
        }
    } else if ($payment_title == 'Pay By Credit Card') {
        if ($email->id == 'customer_on_hold_order') {
            echo '<p>Your card will be charged within 24-36 hours and we will update you the status of your order.</p>';
        }
    }
    if ( $email->id == 'customer_shipped_order' ) {
        echo '<p>However, you can also track your order from below links, (use your tracking number)</p>';
        echo '<table style="border-color:#dddddd;margin:0 0 16px;" width="100%" cellspacing="0" cellpadding="3" border="1">';
        echo '<tr>';
        echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For USA Customers (USPS) : </th>';
        echo '<td><a href="https://www.usps.com" target="_blank">https://www.usps.com</a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For UK Customers (ParcelForce) : </th>';
        echo '<td><a href="https://www.parcelforce.com/track-trace" target="_blank">https://www.parcelforce.com/track-trace</a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For AUS Customers (AUSPOST) : </th>';
        echo '<td><a href="https://auspost.com.au" target="_blank">https://auspost.com.au</a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For All countries :  </th>';
        echo '<td><a href="https://www.indiapost.gov.in" target="_blank">https://www.indiapost.gov.in</a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For DHL: </th>';
        echo '<td><a href="https://ecommerceportal.dhl.com/track" target="_blank">https://ecommerceportal.dhl.com/track</a>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<p><b>MUST NOTE :</b><br>You can track shipment after 3-4 days of shipment.</p>';
        echo '<p>Average normal shipping time is 15-22 days, please (Delivery may be take up to 30 days from date of dispatch, due to if any disruption in postal services due to weather issue or natural disaster).</p>';
    }
    echo '<p><b>Our Operation time:</b><br/>9am to 9pm (Indian Time Only)</p>';


    if ($email->id == 'customer_shipped_order') {
        $trackingCode = get_post_meta($order->id, 'ywot_tracking_code', true);
        $trackingName = get_post_meta($order->id, 'ywot_carrier_name', true);
        $trackingDate = get_post_meta($order->id, 'ywot_pick_up_date', true);
        if ((!empty($trackingDate)) && (!empty($trackingName)) && (!empty($trackingCode))) {
            echo '<p>Your order has been shipped up by ' . $trackingName . ' on <b>' . $trackingDate . '</b>. Your track code is <b>' . $trackingCode . '.</b></p>';
        }
    }
}

/**
 * Only display minimum price for WooCommerce variable products
 * */
add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

function custom_variation_price($price, $product)
{

    $price = $unit_price = $final_unit = '';
    $min_price = [];
    $product_variations = $product->get_available_variations();

    foreach ($product_variations as $key => $product_variation) {
        $attribute = array_values($product_variation['attributes']);
        $tablets = explode(' ', $attribute[0]);
        $min_price[] = $tablets[0];
    }
    // Main Variation Price
    $prices = array($product->get_variation_price('max', true), $product->get_variation_price('min', true));
    $price = max($prices);
    $unit_price = $price / max($min_price);
    $final_unit = round(number_format($unit_price, 2), 2);
    return 'Just $' . $final_unit . ' /Piece';
}

add_filter('woocommerce_loop_add_to_cart_args', 'remove_rel', 10, 2);

/**
 * Remove rel=“nofollow” from woocommerce 'add to cart' buttons
 * @param type $args
 * @param type $product
 * @return type
 */
function remove_rel($args, $product)
{
    unset($args['attributes']['rel']);

    return $args;
}

/*
 * The wp_mail_from_name filter modifies the "from name" used in an email sent using the wp_mail function.
 * When used together with the 'wp_mail_from' filter, it creates a from address like "Name <email@address.com>".
 * The filter should return a string.
 */
add_filter('wp_mail_from_name', function ($name) {
    return 'Generic Villa';
});

/**
 * The wp_mail_from filter modifies the "from email address" used in an email sent using the wp_mail function.
 * When used together with the 'wp_mail_from_name' filter, it creates a from address like "Name <email@address.com>".
 * The filter should return an email address.
 */
add_filter('wp_mail_from', function ($email) {
    return 'admin@genericvilla.com';
});

/* remove pagination on archive product page */
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);


add_shortcode('RECOMMENDED_PRODUCTS', 'display_featured_product_of_each_category');
if (!function_exists('display_featured_product_of_each_category')) {

    /**
     * Display archive page category wise selected featured products
     * Use Shortcode: [RECOMMENDED_PRODUCTS]
     */
    function display_featured_product_of_each_category()
    {
        if (is_archive()) {
            $obj = get_queried_object();
            $taxonomy = $obj->taxonomy;
            $taxonomy_term = $obj->slug;
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_visibility',
                        'field' => 'name',
                        'terms' => 'featured',
                    ),
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $taxonomy_term,
                    ),
                ),
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                ?>
                <ul class="products columns-4">
                <h3 class="main-custom-title">Recommended Products</h3>
                <?php
                while ($loop->have_posts()) : $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
                ?></ul><?php
            }
            wp_reset_postdata();
        }
    }

}

// remove the upsells action using the same priority as original add_action()
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 10);
// add my custom upsells function in the same place
add_action('woocommerce_after_single_product_summary', 'custom_upsell_display', 10);

/**
 * @param int $limit (default: -1).
 * @param int $columns (default: 4).
 * @param string $orderby Supported values - rand, title, ID, date, modified, menu_order, price.
 * @param string $order Sort direction.
 */
function custom_upsell_display()
{

    woocommerce_upsell_display($limit = '-1', $columns = 4, $orderby = 'menu_order', $order = 'asc');
}

/**
 * AJAX Hooks
 */
add_action('wp_ajax_nopriv_products_live_search', 'emallshop_products_live_search');
add_action('wp_ajax_products_live_search', 'emallshop_products_live_search');

if (!function_exists('emallshop_products_live_search')) {

    function emallshop_products_live_search()
    {

        $products = array();
        $sku_products = array();

        $products = emallshop_ajax_search_products();
//        $sku_products = emallshop_get_option('enable-search-by-sku', 0) ? emallshop_ajax_search_products_by_sku() : array();

        $results = array_merge($products, $sku_products);

        $suggestions = array();

        foreach ($results as $key => $post) {
            $product = wc_get_product($post);
            $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()));

            $suggestions[] = array(
                'id' => $product->get_id(),
                'value' => $product->get_title(),
                'url' => $product->get_permalink(),
                'img' => $product_image[0],
                'price' => $product->get_price_html(),
            );
        }

        if (empty($results)) {
            $no_results = esc_html__('No products found.', 'emallshop');
            $suggestions[] = array(
                'id' => -1,
                'value' => $no_results,
                'url' => '',
            );
        }

        echo json_encode(array('suggestions' => $suggestions));
        die();
    }

}

/* 	Search for products.
 *
 * @ since EmallShop 2.0
  /* --------------------------------------------------------------------- */
if (!function_exists('emallshop_ajax_search_products')) {

    function emallshop_ajax_search_products()
    {
        global $woocommerce, $wpdb;
        $ordering_args = $woocommerce->query->get_catalog_ordering_args('title', 'asc');

        // Add products to the results.
        $like = $_REQUEST['query'];
        $args = array(
            's' => $like,
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => 1,
            'orderby' => $ordering_args['orderby'],
            'order' => $ordering_args['order'],
            'tax_query' => WC()->query->get_tax_query(),
            'meta_query' => WC()->query->get_meta_query(),
        );

        if (isset($_REQUEST['product_cat'])) {
            $args['tax_query'][] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => esc_attr($_REQUEST['product_cat'])
                )
            );
        }

        $search_query = http_build_query($args);
        $query_results = new WP_Query($search_query);

        return $query_results->get_posts();
    }

}
if (!function_exists('social_sharing_icons')) {

    function social_sharing_icons()
    {
        ?>
        <ul class="social-sharing">

            <li class="facebook">
                <a href="https://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i
                            class="fa fa-facebook"></i><?php esc_html_e('Facebook', 'alura-studio'); ?></a>
            </li>

            <li class="twitter">
                <a href="https://twitter.com/home?status=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i
                            class="fa fa-twitter"></i><?php esc_html_e('Twitter', 'alura-studio'); ?></a>
            </li>

            <li class="pinterest">
                <?php $image_link = wp_get_attachment_url(get_post_thumbnail_id()); ?>
                <a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php echo esc_url($image_link); ?>"
                   target="_blank"><i class="fa fa-pinterest"></i><?php esc_html_e('Pinterest', 'alura-studio'); ?></a>
            </li>

            <li class="google-plus">
                <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" target="_blank"><i
                            class="fa fa-google-plus"></i><?php esc_html_e('Google Plus', 'alura-studio'); ?></a>
            </li>

            <li class="linkedin">
                <a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php echo esc_attr(sanitize_title(get_the_title())); ?>"
                   target="_blank"><i class="fa fa-linkedin"></i><?php esc_html_e('Linkedin', 'alura-studio'); ?></a>
            </li>

            <li class="reddit">
                <a href="http://www.reddit.com/submit?url=<?php echo esc_url(get_permalink()); ?>&amp;title=<?php echo esc_attr(sanitize_title(get_the_title())); ?>"
                   target="_blank"><i class="fa fa-reddit"></i><?php esc_html_e('Reddit', 'alura-studio'); ?></a>
            </li>

        </ul>
        <?php
    }

}


if (!function_exists('chang_bic_to_swift_code_text')) {

    /**
     * filter translations, to replace some WooCommerce text with our own
     * @param string $translation the translated text
     * @param string $text the text before translation
     * @param string $domain the gettext domain for translation
     * @return string
     */
    function chang_bic_to_swift_code_text($translation, $text, $domain)
    {
        if ($domain == 'woocommerce') {
            switch ($text) {
                case 'BIC':
                    $translation = 'SWIFT CODE';
                    break;
            }
        }

        return $translation;
    }

}

add_filter('gettext', 'chang_bic_to_swift_code_text', 10, 3);

/* 	Header Mobile menu
 *
 * @since EmallShop 2.0
  /* --------------------------------------------------------------------- */
if (!function_exists('emallshop_header_mobile_menu')) {

    function emallshop_header_mobile_menu()
    {

        if (function_exists('get_product_search_form')) {
            ?>
            <div class="search-section"><?php
            get_product_search_form($arg = "product_cat2");
            ?></div><?php
        }
        ?>

        <div class="mobile-nav-tabs">
            <ul>
                <?php if (has_nav_menu('top')) { ?>
                    <li class="primary-menu active" data-menu="primary">
                        <span><?php esc_html_e('Menu', 'emallshop'); ?></span></li>
                <?php } ?>
                <?php if (has_nav_menu('product_category')) { ?>
                    <li class=" categories-menu" data-menu="vertical">
                        <span><?php esc_html_e('Categories', 'emallshop'); ?></span></li>
                <?php } ?>
            </ul>
        </div>

        <?php
        if (has_nav_menu('top')) {
            wp_nav_menu(array('theme_location' => 'top',
                'menu_class' => 'mobile-main-menu',
                'container_class' => 'mobile-primary-menu mobile-nav-content active',
            ));
        }

        if (has_nav_menu('product_category')) {
            ?>
            <div class="mobile-vertical-menu mobile-nav-content"><?php
            wp_nav_menu(array('theme_location' => 'product_category',
                'menu_class' => 'mobile-main-menu',
                'container_class' => 'mobile-vertical-menu mobile-nav-content',
            ));
            ?></div><?php
        }
        ?>

        <div class="mobile-topbar-wrapper">
            <?php
            if (function_exists('genericvilla_myaccount')) {
                genericvilla_myaccount();
            }
            ?>
        </div>
        <div class="mobile-topbar-social">
            <?php ?>
        </div>

        <?php
    }

}


if (!function_exists('emallshop_header_mobile_toggle')) {
    /* 	Header Mobile Toggle Bar Icon
     *
     * @since EmallShop 2.0
     */

    function emallshop_header_mobile_toggle()
    {
        ?>
        <div class="navbar-toggle">
            <span class="sr-only"><?php esc_html_e('Menu', 'emallshop'); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>
        <?php
    }

}

if (!function_exists('genericvilla_myaccount')) {

    function genericvilla_myaccount()
    {
        ?>
        <ul class="login-links list-inline">
            <?php
            $topbar_right_phone = of_get_option('topbar_right_phone');
            $store_email_image = of_get_option('store_email_image');
            $topbar_right_email = of_get_option('topbar_right_email');
            if (!empty($topbar_right_phone)) {
                ?>
                <li class="list-inline-item">
                    <a href="<?php echo 'tel:' . trim($topbar_right_phone); ?>"><i class="fa fa-phone"></i>
                        <?php echo trim($topbar_right_phone); ?>
                    </a>
                </li>
                <?php
            }
            if (!empty($store_email_image)) {
            ?>
            <li class="list-inline-item"><?php
                echo '<a href="javascript:void(0)"><img src=' . $store_email_image . ' width="198" height="20" alt="' . $topbar_right_email . '" /></a>';
                } else if (!empty($topbar_right_email)) {
                    echo '<a href="mailto:' . $topbar_right_email . '"><i class="fa fa-envelope fa-fw email-icon" aria-hidden="true"></i> ' . $topbar_right_email . '</a>';
                }
                ?></li>
            <?php if (is_user_logged_in()) { ?>
                <li class="list-inline-item"><a
                            href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                            title="<?php _e('My Account', 'woothemes'); ?>"><i
                                class="fa fa-user fa-fw"></i> <?php _e('My Account', 'woothemes'); ?></a></li>
                <li class="list-inline-item"><a
                            href="<?php echo wp_logout_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><i
                                class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            <?php } else {
                ?>
                <li class="list-inline-item"><a
                            href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                            title="<?php _e('Login', 'woothemes'); ?>"><i
                                class="fa fa-sign-in fa-fw"></i> <?php _e('Login', 'woothemes'); ?></a></li>
                <li class="list-inline-item"><a
                            href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=register'; ?>"><i
                                class="fa fa-user fa-fw"></i> Register</a></li>

            <?php } ?>
            <!--<li><a href="#" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart fa-fw"></i> <span class="hidden-sm hidden-md">Wish List (0)</span></a></li>-->
        </ul>
        <?php
    }

}
/*
 *
 * Remove the default WooCommerce 3 JSON/LD structured data format
 */

function remove_output_structured_data()
{
    remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10); // Frontend pages
    remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30); // Emails
}

add_action('init', 'remove_output_structured_data');
if (!function_exists('remove_wc_account_page_noindex')) {

    /**
     * Remove noindex nofollow from my account page
     */
    function remove_wc_account_page_noindex()
    {
        remove_action('wp_head', 'wc_page_noindex');
    }

}

add_action('init', 'remove_wc_account_page_noindex');


add_filter('woocommerce_credit_card_form_fields', 'change_cvc_cvv_text', 10, 2);
if (!function_exists('change_cvc_cvv_text')) {

    /**
     * Change the name of CVC Code to CVV Code
     * @param type $default_fields
     * @param type $id
     * @return type
     */
    function change_cvc_cvv_text($default_fields, $id)
    {
        $search = 'Card code';
        $replace = 'CVV Code';
        $default_fields = str_replace($search, $replace, $default_fields);
        $search1 = 'CVC';
        $replace1 = 'CVV';
        $default_fields = str_replace($search1, $replace1, $default_fields);
        return $default_fields;
    }

}
add_filter('woocommerce_order_number', 'change_woocommerce_order_number');

function change_woocommerce_order_number($order_id)
{
    $prefix = '250';
    $new_order_id = $prefix . $order_id;
    return $new_order_id;
}

remove_action('wp_footer', 'output_structured_data', 90);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


add_shortcode('TRENDING_PRODUCTS', 'display_selected_products_in_slider');
if (!function_exists('display_selected_products_in_slider')) {

    /**
     * Shortcode: [TRENDING_PRODUCTS]
     */
    function display_selected_products_in_slider()
    {
        $get_data = of_get_option('trending_products');

        if (!empty($get_data)) {
            $products = explode(',', $get_data);
            $_image_size = 'woocommerce_thumbnail';
            do_action('woocommerce_before_shop_loop');
            ?>
            <div class="woocommerce trending-products-rv">
                <?php
                if ($products) {

                    woocommerce_product_loop_start();
                    foreach ($products as $productId):
                        $product = wc_get_product($productId);
                        ?>
                        <li class="product">
                            <a href="<?php echo get_permalink($product->get_id()); ?>"
                               title="<?php echo $product->get_title(); ?>">
                                <?php
                                if (has_post_thumbnail($product->get_id())) {
                                    $image_src = get_the_post_thumbnail_url($product->get_id(), $_image_size);
                                    echo get_the_post_thumbnail($product->get_id(), $_image_size, array("data-lazy" => $image_src));
                                }
                                ?>
                                <h3 class="woocommerce-loop-product__title"><?php echo $product->get_title(); ?></h3>
                                <?php
                                echo wc_get_rating_html($product->get_average_rating());
                                ?>
                                <span class="price"><?php echo $product->get_price_html(); ?></span>
                            </a>
                            <a href="<?php echo get_permalink($product->get_id()); ?>"
                               class="button product_type_variable add_to_cart_button"
                               data-product_id="<?php echo $product->get_id(); ?>"
                               aria-label="Select options for “Aromasin (Exemestane)”">View detail</a>
                        </li>
                    <?php
                    endforeach;
                    wp_reset_postdata();
                    woocommerce_product_loop_end();
                    do_action('woocommerce_after_shop_loop');
                } else {
                    do_action('woocommerce_no_products_found');
                }
                ?>
            </div>
            <?php
        } else {
            echo "<p>No products found</p>";
        }
    }

}

add_shortcode('HOME_SLIDER', 'display_slider_for_homepage');
if (!function_exists('display_slider_for_homepage')) {

    /**
     * Display Slider at Homepage
     * Shortcode Name: [HOME_SLIDER]
     */
    function display_slider_for_homepage()
    {
        $slider1 = of_get_option('slider1');
        $slider2 = of_get_option('slider2');
        $slider3 = of_get_option('slider3');
        $slider4 = of_get_option('slider4');
        ?>
        <ul class="homepage-slider">
            <?php if (!empty($slider1)) { ?>
                <li><a href="#"><img src="<?php echo $slider1; ?>"/></a></li>
            <?php }
            if (!empty($slider2)) { ?>
                <li><a href="#"><img src="<?php echo $slider2; ?>"/></a></li>
            <?php }
            if (!empty($slider3)) { ?>
                <li><a href="#"><img src="<?php echo $slider3; ?>"/></a></li>
            <?php }
            if (!empty($slider4)) { ?>
                <li><a href="#"><img src="<?php echo $slider4; ?>"/></a></li>
            <?php } ?>
        </ul>
        <?php
    }

}
add_filter('posts_search', 'my_search_is_perfect', 20, 2);
function my_search_is_perfect($search, $wp_query)
{
    global $wpdb;

    if (empty($search))
        return $search;

    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';

    $search = $searchand = '';

    foreach ((array)$q['search_terms'] as $term) {
        $term = esc_sql(like_escape($term));

        $search .= "{$searchand}($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]') OR ($wpdb->posts.post_title REGEXP '[[:<:]]{$term}[[:>:]]')";

        $searchand = ' AND ';
    }

    if (!empty($search)) {
        $search = " AND ({$search}) ";
        if (!is_user_logged_in())
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }

    return $search;
}

/* Search result with Order Id at backend */
add_filter('woocommerce_shop_order_search_results', 'custom_shop_order_search_results_filter', 10, 3);
function custom_shop_order_search_results_filter($order_ids, $term, $search_fields)
{
    global $wpdb;
    if(strpos($term, '#') !== false){
        $term = preg_replace('/#[[:<:]]250/', '', $term); //  <===  <===  <===  Your change
    } else{
        $term = preg_replace('/[[:<:]]250/', '', $term); //  <===  <===  <===  Your change
    }

    $order_ids = array();

    if (is_numeric($term)) {
        $order_ids[] = absint($term);
    }

    if (!empty($search_fields)) {
        $order_ids = array_unique(
            array_merge(
                $order_ids,
                $wpdb->get_col(
                    $wpdb->prepare(
                        "SELECT DISTINCT p1.post_id FROM {$wpdb->postmeta} p1 WHERE p1.meta_value LIKE %s AND p1.meta_key IN ('" . implode("','", array_map('esc_sql', $search_fields)) . "')", // @codingStandardsIgnoreLine
                        '%' . $wpdb->esc_like(wc_clean($term)) . '%'
                    )
                ),
                $wpdb->get_col(
                    $wpdb->prepare(
                        "SELECT order_id
							FROM {$wpdb->prefix}woocommerce_order_items as order_items
							WHERE order_item_name LIKE %s",
                        '%' . $wpdb->esc_like(wc_clean($term)) . '%'
                    )
                )
            )
        );
    }
//    echo "<pre>";
//    print_r($order_ids);
//    die;

    return $order_ids;
}

if (!function_exists('upload_prescription')) {

    /**
     * Prescription Upload actions
     */
    function upload_prescription()
    {
        $fileName = '';
        $baseUploadUrl = wp_get_upload_dir();
        $output_dir = $baseUploadUrl['basedir'] . '/';
        $yearMonth = $baseUploadUrl['subdir'] . '/';
        if (isset($_FILES["prescription"])) {
            $error = $_FILES["prescription"]["error"];
            if (!is_array($_FILES["prescription"]["name"])) { //single file
                $fileName = $_FILES["prescription"]["name"];
                $fileName = $yearMonth . $fileName;
                move_uploaded_file($_FILES["prescription"]["tmp_name"], $output_dir . $fileName);
                $ret[] = $fileName;
            } else {  //Multiple files, file[]
                $fileCount = count($_FILES["prescription"]["name"]);
                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $_FILES["prescription"]["name"][$i];
                    $fileName = $yearMonth . $fileName;
                    move_uploaded_file($_FILES["prescription"]["tmp_name"][$i], $output_dir . $fileName);
                    $ret[] = $fileName;
                }
            }
            wp_send_json($ret);
            wp_die();
        }
    }

}

add_action('wp_ajax_upload_prescription', 'upload_prescription');
add_action('wp_ajax_nopriv_upload_prescription', 'upload_prescription');

/**
 * Prescription Delete Action
 */
function delete_prescription_action()
{
    $baseUploadUrl = wp_get_upload_dir();
    $output_dir = $baseUploadUrl['basedir'] . "/";
    if (isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])) {
        $fileCount = count($_POST['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_POST['name'][$i];
            //$fileName =$_POST['name'];
            $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files
            $filePath = $output_dir . $fileName;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }
    wp_die();
}

add_action('wp_ajax_delete_prescription', 'delete_prescription_action');
add_action('wp_ajax_nopriv_delete_prescription', 'delete_prescription_action');

function wc_cancelled_order_add_customer_email($recipient, $order)
{
    return $recipient . ',' . $order->billing_email;
}

add_filter('woocommerce_email_recipient_cancelled_order', 'wc_cancelled_order_add_customer_email', 10, 2);
add_filter('woocommerce_email_recipient_failed_order', 'wc_cancelled_order_add_customer_email', 10, 2);

/* Add New order status "Shipped" */

if (!function_exists('register_shipped_order_status')) {
    /*
     * Step 1: Register new order status "Shipped" to order detail page
     */

    function register_shipped_order_status()
    {
        register_post_status('wc-shipped', array(
            'label' => 'Shipped',
            'public' => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list' => true,
            'exclude_from_search' => false,
            'label_count' => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>')
        ));
    }

}

add_action('init', 'register_shipped_order_status');


if (!function_exists('add_shipped_to_order_statuses')) {
    /*
     * Step 2: To add New order status after processing in drop down
     */

    function add_shipped_to_order_statuses($order_statuses)
    {
        $new_order_statuses = array();
        foreach ($order_statuses as $key => $status) {
            $new_order_statuses[$key] = $status;
            if ('wc-processing' === $key) {
                $new_order_statuses['wc-shipped'] = 'Shipped';
            }
        }
        return $new_order_statuses;
    }

}

add_filter('wc_order_statuses', 'add_shipped_to_order_statuses');


add_action('woocommerce_order_status_changed', 'shipped_status_custom_notification', 10, 4);

if (!function_exists('shipped_status_custom_notification')) {
    /*
     * Step 3: Send email notification for shipped order
     */

    function shipped_status_custom_notification($order_id, $from_status, $to_status, $order)
    {

        if ($order->has_status('shipped')) {

            // Getting all WC_emails objects
            $email_notifications = WC()->mailer()->get_emails();

            // Customizing Heading and subject In the WC_email processing Order object
//        $email_notifications['WC_Email_Customer_Shipped_Order']->heading = __('Your Order shipped', 'woocommerce');
//        $email_notifications['WC_Email_Customer_Shipped_Order']->subject = 'Your {site_title} order shipped receipt from {order_date}';
            // Sending the customized email
            $email_notifications['WC_Email_Customer_Shipped_Order']->trigger($order_id);
        }
    }

}


//add_action('woocommerce_order_status_wc-shipped', array(WC(), 'send_transactional_email'), 10, 1);


add_filter('woocommerce_email_actions', 'filter_woocommerce_email_actions');

function filter_woocommerce_email_actions($actions)
{
    $actions[] = 'woocommerce_order_status_wc-shipped';
    return $actions;
}

/**
 *  Add a shipped email to the list of emails WooCommerce should load
 *
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 * @since 0.1
 */
function add_shipped_order_woocommerce_email($email_classes)
{

    // include our custom email class
    wc_get_template_part('class', 'wc-email-customer-shipped-order');

    // add the email class to the list of email classes that WooCommerce loads
    $email_classes['WC_Email_Customer_Shipped_Order'] = new WC_Email_Customer_Shipped_Order();

    return $email_classes;
}

add_filter('woocommerce_email_classes', 'add_shipped_order_woocommerce_email');

/* Send all the emails to the admin when order status change */
add_filter('woocommerce_email_recipient_customer_completed_order', 'your_email_recipient_filter_function', 10, 2);
add_filter('woocommerce_email_recipient_customer_shipped_order', 'your_email_recipient_filter_function', 10, 2);
add_filter('woocommerce_email_recipient_customer_on_hold_order', 'your_email_recipient_filter_function', 10, 2);
add_filter('woocommerce_email_recipient_customer_processing_order', 'your_email_recipient_filter_function', 10, 2);
add_filter('woocommerce_email_recipient_customer_note', 'your_email_recipient_filter_function', 10, 2);
add_filter('woocommerce_email_recipient_customer_refunded_order', 'your_email_recipient_filter_function', 10, 2);

function your_email_recipient_filter_function($recipient, $object)
{
    $recipient = $recipient . ', admin@genericvilla.com';
    return $recipient;
}

add_filter('woocommerce_billing_fields', 'woocommerce_billing_phone_number_make_optional');
if (!function_exists('woocommerce_billing_phone_number_make_optional')) {

    /**
     * Billing Phone number make required to optional
     * @param array $fields
     * @return boolean
     */
    function woocommerce_billing_phone_number_make_optional($fields)
    {
        $fields['billing_phone']['required'] = false;
        return $fields;
    }

}

add_shortcode('EXPRESS_COUNTER', 'express_counter_function');
if (!function_exists('express_counter_function')) {

    /**
     * Show express counter functionality at home page
     * Use shortcode: [EXPRESS_COUNTER]
     */
    function express_counter_function()
    {
        $product_ids = of_get_option('express_products');
        if (!empty($product_ids)) {
            $product_ids = explode(',', $product_ids);
            echo '<div class="express_products woocommerce text-center"><h3 class="exp-title text-uppercase">Express Counter <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i></h3>';
            echo '<div class="select-section"><select class="select_product" name="select_product" id="select_product">';
            echo '<option value="">--- Select Product ---</option>';
            foreach ($product_ids as $key => $value) {
                $getTitle = get_the_title($value);
                $shortTitle = explode(' ', trim($getTitle));
                echo '<option value=' . $value . '>' . $shortTitle[0] . '</option>';
            }
            echo '</select>';
            echo '<select class="strength_mg_list" name="strength_mg_list" id="strength_mg_list">';
            echo '<option value="">--- Select Strength ---</option>';
            echo '</select>';
            echo '<select class="variation_list" name="variation_list" id="variation_list">';
            echo '<option value="">--- Select Tablets ---</option>';
            echo '</select>';

            echo '<select class="product_qty" name="product_qty" id="product_qty">';
            echo '<option value="">--- Select Quantity ---</option>';
            for ($i = 1; $i <= 10; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            echo '</select></div>';
            echo '<div class="btn-express-section"><button data-product_id="" data-variation_id="" data-quantity="" id="express_add_to_cart" class="button product_type_variable add_to_cart_button btn-express" disabled="disabled">Add to cart <i class="fa" aria-hidden="true"></i></button></div>';
            echo '</div>';
        }
    }

}

add_action('wp_ajax_get_attributes_selected_products', 'get_mg_attributes_on_selected_product');
add_action('wp_ajax_nopriv_get_attributes_selected_products', 'get_mg_attributes_on_selected_product');

function get_mg_attributes_on_selected_product()
{
    $productAttr = array();
    $selectHTML = '<option value="">--- Select Strength ---</option>';;
    if ($_POST['product_id']) {
        $selectedProductId = $_POST['product_id'];
        $product = new WC_Product($selectedProductId);
//        print_r($product);
        $productAttr[$selectedProductId] = get_products_attribute($selectedProductId);

        $upsells = $product->get_upsells();
        foreach ($upsells as $key => $value) {
            $productAttr[$value] = get_products_attribute($value);
        }
        natsort($productAttr);
        foreach ($productAttr as $key => $value) {
            // Remove words which contain in () brackets
            $title = trim(preg_replace('/\s*\([^)]*\)/', '', get_the_title($key)));
            // Remove MG data repeated
            $mgData = str_replace($value, "", $title);
            $selectHTML .= '<option value="' . $key . '">' . $value . ' - ' . $title . '</option>';
        }
        return wp_send_json($selectHTML);
    }
    wp_die();
}

function get_products_attribute($upsellId)
{
    $productAttributes = '';
    $product = new WC_Product_Variable($upsellId);
    $attributes = $product->get_attributes();
    // Get MG attribute which is used for variation
    foreach ($attributes as $key => $attribute) {
        if ($attribute->get_variation()) {
            $productAttributes = $attribute->get_name();
        }
    }
    return $productAttributes;
}

add_action('wp_ajax_get_variation', 'get_variation_by_upsell_products');
add_action('wp_ajax_nopriv_get_variation', 'get_variation_by_upsell_products');

if (!function_exists('get_variation_by_upsell_products')) {

    /**
     * Display variation by up sell product
     */
    function get_variation_by_upsell_products()
    {
        $productAttr = array();
        $selectHTML = '<option value="">--- Select Tablets ---</option>';
        if ($_POST['upsell_id']) {
            $selectedProductId = $_POST['upsell_id'];
            $product = new WC_Product_Variable($selectedProductId);
            $product_variation = $product->get_available_variations();
            foreach ($product_variation as $key => $value) {
                $attribute = array_values($value['attributes']);
                $selectHTML .= '<option value="' . $value['variation_id'] . '">' . $attribute[0] . '</option>';
            }
            return wp_send_json($selectHTML);
        }
        wp_die();
    }

}
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart()
{

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }
        WC_AJAX:: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();
}

add_action('woocommerce_single_product_summary', 'woocommerce_company_logo_dispaly', 55);
if (!function_exists('woocommerce_company_logo_dispaly')) {

    function woocommerce_company_logo_dispaly()
    {
        $key = 'product_company_logo_company-logo';
        $companyLogo = get_post_meta(get_the_ID(), $key, TRUE);
        if (!empty($companyLogo)) {
            echo '<img src="' . $companyLogo . '" />';
        }
    }

}
add_shortcode('display_mega_menu', 'mega_menu_function');
if (!function_exists('mega_menu_function')) {

    /**
     * Display Mega Menu On home page hover on all categories.
     * Use shortcode: [display_mega_menu]
     */
    function mega_menu_function()
    {
        global $allCount;
        $product_cat = '';

        get_worldcollection_category_tree(0);

        $args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => 0
        );
        $product_cat = get_terms($args);

        $countchildren = count($product_cat);
        $totalCategoryInSingleColumn = $allCount / 5;
        $cnt = 1;
        $total = 0;
        ob_start();
        echo '<div class="col-sm single-menu-column">';

        foreach ($product_cat as $parent_product_cat) {
            $total = $cnt % $totalCategoryInSingleColumn;

            if ($total == 0) {
                echo '</div><div class="col-sm single-menu-column">';
            }
            echo '<ul class="parent-category list-unstyled ' . $cnt++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '">
                        <li><a href="' . get_term_link($parent_product_cat->term_id) . '" class="parent-category-a">' . $parent_product_cat->name . '<span class="arrow-menu"></span></a>
                      <ul class="list-unstyled">';

            $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => $parent_product_cat->term_id
            );
            $child_product_cats = get_terms($child_args);
            foreach ($child_product_cats as $child_product_cat) {
                $total = $cnt % $totalCategoryInSingleColumn;
                echo '<li class="' . $cnt++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '"><a href="' . get_term_link($child_product_cat->term_id) . '">' . $child_product_cat->name . '</a></li>';

                if ($total == 0) {
                    echo '</ul></div><div class="col-sm single-menu-column"><ul class="list-unstyled">';
                }
            }
            echo '</ul>
                </li>
              </ul>';
        }
        echo '</div>';
        $data = ob_get_clean();
        $allCount = 0;
        wp_reset_postdata();
        wp_reset_query();
        return $data;
    }

}

/**
 * This function get the child categories when we pass the parent category ID
 * @param type $cat
 * @global type $allCount
 */
function get_worldcollection_category_tree($cat)
{
    $next = get_categories('taxonomy=product_cat&depth=2&hide_empty=0&orderby=title&order=ASC&parent=' . $cat);
    if ($next) :
        foreach ($next as $cat) {
            global $allCount;
            $allCount++;
            get_worldcollection_category_tree($cat->term_id);
        }
    endif;
}

add_action('woocommerce_widget_shopping_cart_buttons', 'display_security_image');

if (!function_exists('display_security_image')) {

    /**
     * Display image at minicart after buttons
     */
    function display_security_image()
    {
        $image_url = of_get_option('minicart_image');
        $image_link = of_get_option('secure_image_link');
        if (!empty($image_url)) {
            echo '<a class="secure-image" href="' . $image_link . '" target="_blank"><img src="' . $image_url . '" class="img-secure" /></a>';
        }
    }

}

add_action('woocommerce_review_order_before_payment', 'display_security_image');

/**
 *  Add a Feedback email to the list of emails WooCommerce should load
 *
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 * @since 0.1
 */
function add_feedback_order_woocommerce_email($email_classes)
{
    // include our custom email class
    wc_get_template_part('class', 'wc-email-customer-feedback-order');

    // add the email class to the list of email classes that WooCommerce loads
    $email_classes['WC_Email_Customer_Feedback_Order'] = new WC_Email_Customer_Feedback_Order();

    return $email_classes;
}

add_filter('woocommerce_email_classes', 'add_feedback_order_woocommerce_email');
/**
 *  Add a second email to the list of emails WooCommerce should load
 *
 * @param array $email_classes available email classes
 * @return array filtered available email classes
 * @since 0.1
 */
function add_second_email_on_order_woocommerce_email($email_classes)
{
    // include our custom email class
    wc_get_template_part('class', 'wc-email-customer-second-email-on-order');

    // add the email class to the list of email classes that WooCommerce loads
    $email_classes['WC_Email_Customer_Second_Mail_Order'] = new WC_Email_Customer_Second_Mail_Order();

    return $email_classes;
}

add_filter('woocommerce_email_classes', 'add_second_email_on_order_woocommerce_email');
/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available($rates)
{
    $free = array();
    foreach ($rates as $rate_id => $rate) {
        if ('free_shipping' === $rate->method_id) {
            $free[$rate_id] = $rate;
            break;
        }
    }
    return !empty($free) ? $free : $rates;
}

add_filter('woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100);

// E. Query WooCommerce database for completed orders between two timestamps

function bbloomer_get_completed_orders_before_after($date_one, $date_two)
{
    global $wpdb;
    $completed_orders = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT posts.ID
         FROM {$wpdb->prefix}posts AS posts
         WHERE posts.post_type = 'shop_order'
         AND posts.post_status = 'wc-completed'
         AND posts.post_modified >= '%s'
         AND posts.post_modified <= '%s'",
            date('Y/m/d H:i:s', absint($date_one)),
            date('Y/m/d H:i:s', absint($date_two))
        )
    );

    return $completed_orders;
}

//// Add a new interval of 180 seconds
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
add_filter('cron_schedules', 'isa_add_every_seven_days');
function isa_add_every_seven_days($schedules)
{
    $schedules['every_seven_days'] = array(
        'interval' => 604800,
        'display' => __('Every 7 days', 'textdomain')
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if (!wp_next_scheduled('isa_add_every_seven_days')) {
    wp_schedule_event(time(), 'every_seven_days', 'isa_add_every_seven_days');
}

// Hook into that action that'll fire every three minutes
add_action('isa_add_every_seven_days', 'every_seven_days_event_func');
if(!function_exists('every_seven_days_event_func')) {
    function every_seven_days_event_func() {
        global $wpdb;
        $range = 10080; // 7 days in minutes
        $completed_orders = bbloomer_get_completed_orders_before_after(strtotime('-' . absint($range) . ' MINUTES', current_time('timestamp')), current_time('timestamp'));
        if ($completed_orders) {
            foreach ($completed_orders as $order_id) {
                ob_start();
                $email_data = '';
                $template = 'emails/email-header-feedback.php';
                $email_heading = "Give Rating";
                wc_get_template($template, array('email_heading' => $email_heading));
                // 1) Get the Order object
                $order = wc_get_order($order_id);
                // Get the order meta data in an unprotected array
                $email_ad = $order->get_billing_email();
                $order_items = $order->get_items();
                // OUTPUT
                ?>
                <p><?php printf(esc_html__('Dear %s,', 'woocommerce'), esc_html($order->get_billing_first_name())); ?></p>
                <?php /* translators: %s: Order number */ ?>
                <?php $blog_title = get_bloginfo('name'); ?>
                <p>Thank you for choosing <a href="<?php echo home_url(); ?>" target="_blank"><?php echo $blog_title; ?></a>
                </p>
                <p><?php esc_html_e('To improve the satisfaction of our customers, ' . $blog_title . ' to collect reviews for better service with best quality products.', 'woocommerce'); ?></p>
                <p>
                    <?php esc_html_e('All reviews, good, bad or otherwise will be visible immediately.', 'woocommerce'); ?>
                </p>
                <?php
                foreach ($order_items as $item_id => $item) {
                    $product = $item->get_product();
                    $is_visible = $product && $product->is_visible();
                    $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                    ?>
                    <p>
                        <a href="<?php echo $product_permalink . '#comments' ?>" style="color:#0c59f2;font-weight:normal;line-height:1em;text-decoration:underline;font-size:18px;">Click here to review us on </a><?php echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s#comments" style="color:#0c59f2;font-weight:normal;line-height:1em;text-decoration:underline;font-size:18px;" target="_blank">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible); ?>
                        <?php
                        $trustImage = of_get_option('feedback_image');
                        ?><br/>
                        <a href="<?php echo $product_permalink . '#comments' ?>" target="_blank"><img src="<?php echo $trustImage; ?>" width="250" height="243"/></a>
                    </p>
                    <?php
                }?>
                <p>
                    <b>Thanks for your time,</b><br/>
                    Team GenericVilla
                </p>
                <p><b>Please note:</b> This email is sent automatically, so you may have received this review invitation before the arrival of your package or service. In this case, you are welcome to wait with writing your review until your package or service arrives.</p>
                <p></p>
                <?php

                $template_footer = 'emails/email-footer.php';
                wc_get_template($template_footer);
                $email_data = ob_get_clean();
                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";

                $mailer = WC()->mailer();
                $subject = __("⭐ ⭐ ⭐ ⭐ ⭐ How many stars would you give our Medicine(s)?", 'woocommerce');
                $headers = "Content-Type: text/html\r\n";
                //send the email through wordpress
                $mailer->send($email_ad, $subject, $email_data, $headers);
            }

        }
    }
}
if(!function_exists('defer_parsing_of_js')) {
    function defer_parsing_of_js($url) {
        if (is_admin()) return $url; //don't break WP Admin
        if (false === strpos($url, '.js')) return $url;
        if (strpos($url, 'jquery.js')) return $url;
        return str_replace(' src', ' defer src', $url);
    }
}
add_filter('script_loader_tag', 'defer_parsing_of_js', 10);

add_action('woocommerce_before_main_content','add_horizontal_layout_func', 25 );
if(!function_exists('add_horizontal_layout_func')) {
    /**
     * Created a shortcode to display Free shipping block horizontally on single product page
     */
    function add_horizontal_layout_func(){
        ?>
        <div class="horizontal-section">
            <div class="ttcmsservices">
                <div class="ttcmsservice">
                    <div class="ttshipping">
                        <div class="ttshipping_img service-icon"></div>
                        <div class="service-content">
                            <div class="service-title">Free Shipping</div>
                            <div class="service-desc">Deliver to Door</div>
                        </div>
                    </div>
                    <div class="ttsupport">
                        <div class="ttsupport_img service-icon"></div>
                        <div class="service-content">
                            <div class="service-title">24x7 Support</div>
                            <div class="service-desc">in Safe Hands</div>
                        </div>
                    </div>
                    <div class="ttsaving">
                        <div class="ttsaving_img service-icon"></div>
                        <div class="service-content">
                            <div class="service-title">Big Saving</div>
                            <div class="service-desc">at Lowest Price</div>
                        </div>
                    </div>
                    <div class="ttmoney">
                        <div class="ttmoney_img service-icon"></div>
                        <div class="service-content">
                            <div class="service-title">Money Back</div>
                            <div class="service-desc">Easy to Return</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
/**
 * Remove product page sorting options
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );