<?php
/**
 * The template for displaying archive pages
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
        <div class="col-sm-9 main-blog-content other-blogs">

            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="taxonomy-description">', '</div>');
                    ?>
                </header><!-- .page-header -->
            <?php endif; ?>

            <div id="primary" class="content-area">
                <main id="main" class="site-main row" role="main">

                    <?php if (have_posts()) : ?>
                        <?php
                        $thumbnail_size = 'blog_thumbnail_large';
                        $post_categories = get_the_terms(get_the_ID(), 'category');
                        if (!empty($post_categories) && !is_wp_error($post_categories)) {
                            $categories = wp_list_pluck($post_categories, 'name');
                        }
                        // Get the ID of a given category
                        $category_id = get_cat_ID($categories[0]);
                        /* Start the Loop */
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
//                            get_template_part('template-parts/post/content', get_post_format());
                            ?>
                            <div class="td_module_2 td_module_wrap td-animation-stack col-sm-6 col-xs-12">
                                <div class="td-module-image">
                                    <div class="td-module-thumb">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark" class="td-image-wrap" title="<?php the_title(); ?>">                                                
                                            <?php the_post_thumbnail($thumbnail_size, array('class' => 'entry-thumb td-animation-stack-type0-2')); ?>
                                        </a>
                                    </div>                
                                    <a href="<?php echo get_category_link($category_id); ?>" class="td-post-category"><?php echo $categories[0]; ?></a>            
                                </div>
                                <h3 class="entry-title td-module-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="td-module-meta-info">                                        
                                    <span class="td-post-date"><time class="entry-date td-module-date" datetime="<?php echo get_the_time(DATE_W3C); ?>"><?php echo get_the_time('F j, Y', '', get_the_ID()); ?></time></span>
                                    <div class="td-module-comments d-none"><a href="<?php echo get_comments_link(get_the_ID()); ?>"><?php echo get_comments_number(get_the_ID()); ?></a></div>            
                                </div>
                                <div class="td-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>    
                            <?php
                        endwhile;

                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'type' => 'list',
                            'prev_text' => twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'twentyseventeen') . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __('Next page', 'twentyseventeen') . '</span>' . twentyseventeen_get_svg(array('icon' => 'arrow-right')),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyseventeen') . ' </span>',
                        ));

                    else :

                        get_template_part('template-parts/post/content', 'none');

                    endif;
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <div class="col-sm-3 blog-sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div><!-- #primary -->

</div><!-- .wrap -->
<?php
get_footer();
