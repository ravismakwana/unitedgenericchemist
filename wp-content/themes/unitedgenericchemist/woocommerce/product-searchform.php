<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<!--<form role="search" method="get" class="woocommerce-product-search" action="<?php // echo esc_url(home_url('/'));        ?>">
    <label class="screen-reader-text" for="woocommerce-product-search-field-<?php // echo isset($index) ? absint($index) : 0;        ?>"><?php // esc_html_e('Search for:', 'woocommerce');        ?></label>
    <input type="search" id="woocommerce-product-search-field-<?php // echo isset($index) ? absint($index) : 0;        ?>" class="search-field" placeholder="<?php // echo esc_attr__('Search products&hellip;', 'woocommerce');        ?>" value="<?php // echo get_search_query();        ?>" name="s" />
    <button type="submit" value="<?php // echo esc_attr_x('Search', 'submit button', 'woocommerce');        ?>"><?php // echo esc_html_x('Search', 'submit button', 'woocommerce');        ?></button>
    <input type="hidden" name="post_type" value="product" />
</form>-->
<form role="search" method="get" class="search-form input-lg woocommerce-product-search" action="<?php echo home_url('/'); ?>" autocomplete="off" >                                
    <div class="input-group">
        <input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="form-control search-text" placeholder="<?php echo esc_attr__('Search Medicine&hellip;', 'woocommerce'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label'); ?>" />
        <div class="product-cat-list">
            <?php
            if (isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
                $optsetlect = $_REQUEST['product_cat'];
            } else {
                $optsetlect = 0;
            }
// output all of our Categories
// for more information see http://codex.wordpress.org/Function_Reference/wp_dropdown_categories
            $swp_cat_dropdown_args = array(
                'show_option_all' => __('Categories'),
                'name' => 'product_cat',
                'class' => 'custom-select product-category-list',
                'taxonomy' => 'product_cat',
                'echo' => 1,
                'value_field' => 'slug',
                'hierarchical' => 1,
                'selected' => $optsetlect,
                'hide_empty' => 1,
                'orderby' => 'name',
                'order' => 'asc',
            );
            //wp_dropdown_categories($swp_cat_dropdown_args);
            ?>            
        </div>
        <div class="input-group-append bg-search">
            <button type="submit" class="btn btn-search" value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>"><i class="fa fa-search fa-fw"></i> <span class="search-btn-text"><?php echo esc_html_x('Search', 'submit button', 'woocommerce'); ?></span></button>
            <input type="hidden" name="post_type" value="product" />
        </div>
    </div>
    <div class="live-search-results"></div>
</form>
