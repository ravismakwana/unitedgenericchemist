<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined('ABSPATH') || exit;

get_header('shop');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9 main-column order-lg-1">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <?php
                    /**
                     * Hook: woocommerce_before_main_content.
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     * @hooked WC_Structured_Data::generate_website_data() - 30
                     */
                    do_action('woocommerce_before_main_content');
                    ?>
                    <header class="woocommerce-products-header ravi">
                        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                        <?php endif; ?>

                        <?php
                        /**
                         * Hook: woocommerce_archive_description.
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action('woocommerce_archive_description');
                        ?>
                    </header>
                    <?php
                    if (woocommerce_product_loop()) {

                        /**
                         * Hook: woocommerce_before_shop_loop.
                         *
                         * @hooked woocommerce_output_all_notices - 10
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */
                        do_action('woocommerce_before_shop_loop');

                        woocommerce_product_loop_start();
//
//                        if (wc_get_loop_prop('total')) {
//                            while (have_posts()) {
//                                the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         *
                         * @hooked WC_Structured_Data::generate_product_data() - 10
                         */
                        $selected_cat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
                        $search_text = isset($_GET['s']) ? $_GET['s'] : '';
                        $port_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
                        do_action('woocommerce_shop_loop');
                        if (!empty($selected_cat) || !empty($search_text) || !empty($port_type)) {
                            
                            echo do_shortcode('[ajax_load_more search="'.$search_text.'" orderby="relevance" post_type="'.$port_type.'" taxonomy="product_cat" taxonomy_operator="IN" css_classes="products columns-4" posts_per_page="12" transition="fade" scroll="false" button_label="View More Products" button_loading_label="Loading Products..." container_type="ul"]');
                        } else {
                            if (is_archive()) {
                                $obj = get_queried_object();
                                $taxonomy = $obj->taxonomy;
                                $taxonomy_term = $obj->slug;

                                // Product Taxonomy Archive 

                                echo do_shortcode('[ajax_load_more post_type="product" taxonomy="' . $taxonomy . '" taxonomy_terms="' . $taxonomy_term . '" taxonomy_operator="IN" css_classes="products columns-4" posts_per_page="12" transition="fade" scroll="false" button_label="View More Products" button_loading_label="Loading Products..." container_type="ul"]');
                            } else {

//                                     Shop Landing Page
                                echo "<p>" . woocommerce_page_title() . " category have not products.</p>";
                            }
                        }
//                                wc_get_template_part('content', 'product');
//                            }
//                        }
//
                        woocommerce_product_loop_end();

                        /**
                         * Hook: woocommerce_after_shop_loop.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action('woocommerce_after_shop_loop');
                    } else {
                        /**
                         * Hook: woocommerce_no_products_found.
                         *
                         * @hooked wc_no_products_found - 10
                         */
                        do_action('woocommerce_no_products_found');
                    }

                    /**
                     * Hook: woocommerce_after_main_content.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');
                    ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <!--<div class="col-lg-3 column-sidebar-1 order-lg-0">-->
            <?php
//            if (!is_active_sidebar('category-left-sidebar')) {
//                return;
//            }
            ?>
            <!--<div id="secondary-left" class="widget-area" role="complementary" aria-label="<?php // esc_attr_e('Left Sidebar', 'twentyseventeen'); ?>">-->
                <?php // dynamic_sidebar('category-left-sidebar'); ?>
            <!--</div> #secondary -->
        <!--</div>-->
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
                <?php dynamic_sidebar('category-right-sidebar'); ?>
            </div><!-- #secondary -->
        </div>
    </div>

</div><!-- .wrap -->

<?php
get_footer('shop');
