<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9 main-column order-lg-1">
            <div id="primary" class="content-area">
                <?php
                /**
                 * woocommerce_before_main_content hook.
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 */
                do_action('woocommerce_before_main_content');
                ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php wc_get_template_part('content', 'single-product'); ?>

                <?php endwhile; // end of the loop. ?>

                <?php
                /**
                 * woocommerce_after_main_content hook.
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action('woocommerce_after_main_content');
                ?>

                <?php
                /**
                 * woocommerce_sidebar hook.
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
//                    do_action('woocommerce_sidebar');
                ?>
            </div><!-- #primary -->
        </div>
<!--        <div class="col-lg-3 column-sidebar-1 order-lg-0">
            <?php
//            if (!is_active_sidebar('category-left-sidebar')) {
//                return;
//            }
            ?>
            <div id="secondary-left" class="widget-area" role="complementary" aria-label="<?php // esc_attr_e('Left Sidebar', 'twentyseventeen'); ?>">
                <?php // dynamic_sidebar('category-left-sidebar'); ?>
            </div> #secondary 
        </div>-->
        <div class="col-lg-3 column-sidebar-2 order-lg-2">
            <?php
            /**
             * Hook: woocommerce_sidebar.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            //do_action('woocommerce_sidebar');

            if (!is_active_sidebar('category-right-sidebar')) {
                return;
            }
            ?>
            <div id="secondary-left" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Left Sidebar', 'twentyseventeen'); ?>">
                <?php dynamic_sidebar('single-product-sidebar'); ?>
            </div><!-- #secondary -->
        </div>
    </div>

</div><!-- .wrap -->
<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
