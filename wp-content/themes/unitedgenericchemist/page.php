<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 main-column order-lg-1">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">

                    <?php
                    while (have_posts()) : the_post();

                        get_template_part('template-parts/page/content', 'page');

                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .wrap -->

        <div class="col-lg-3 column-sidebar-1 order-lg-0">
            <?php
            if (!is_active_sidebar('category-left-sidebar')) {
                return;
            }
            ?>
            <div id="secondary-left" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Left Sidebar', 'twentyseventeen'); ?>">
                <?php dynamic_sidebar('category-left-sidebar'); ?>
            </div><!-- #secondary -->
        </div>
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
</div>

</div><!-- .wrap -->

<?php
get_footer();
