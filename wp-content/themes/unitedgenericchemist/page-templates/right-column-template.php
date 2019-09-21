<?php
/*
 * Template Name: Right Column Page Template
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?> 
<div class="container">
    <div class="row">
        <div class="col-lg-9 main-column order-lg-1">
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
        </div>        
        <div class="col-lg-3 column-sidebar-2 order-lg-2"><?php
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
<?php get_footer(); ?>