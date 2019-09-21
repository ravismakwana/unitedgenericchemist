<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
    <?php if (is_home() && !is_front_page()) : ?>
        <header class="page-header">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header>
    <?php else : ?>
        <header class="page-header">
            <h2 class="page-title"><?php _e('Posts', 'twentyseventeen'); ?></h2>
        </header>
    <?php endif; ?>
    <div class="td_block_wrap td_block_big_grid_7 td_uid_6_5ccbe6acf0f3c_rand td-grid-style-1 td-hover-1 td-big-grids td-pb-border-top td_block_template_1 col-xs-12">
        <div class="td_block_inner">
            <div class="td-big-grid-wrapper">
                <?php
                // the query               
                global $wpdb;
                $recent_posts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_status = 'publish' AND post_type='post' order by post_date DESC LIMIT 7", ARRAY_A);
                $cnt = 0;

                if ($recent_posts) :

                    foreach ($recent_posts as $post_data) {
                        if ($cnt < 3) {
                            $class_module = 'td_module_mx12';
                            $thumbnail_size = 'blog_thumbnail';
                            $grid_class = 'large_grid';
                        } else {
                            $class_module = 'td_module_mx6';
                            $thumbnail_size = 'blog_thumbnail_small';
                            $grid_class = 'small_grid';
                        }
                        // Get a list of categories and extract their names
                        $post_categories = get_the_terms($post_data['ID'], 'category');
                        if (!empty($post_categories) && !is_wp_error($post_categories)) {
                            $categories = wp_list_pluck($post_categories, 'name');
                        }
                        // Get the ID of a given category
                        $category_id = get_cat_ID($categories[0]);
                        ?>
                        <div class="<?php echo $class_module; ?> td-animation-stack td-big-grid-post-<?php echo $cnt++; ?> td-big-grid-post td-small-thumb">
                            <div class="td-module-thumb">
                                <a href="<?php echo get_permalink($post_data['ID']) ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $post_data['post_title']; ?>"><?php echo get_the_post_thumbnail($post_data['ID'], $thumbnail_size, array('class' => 'entry-thumb td-animation-stack-type0-2')); ?></a>
                            </div>
                            <div class="td-meta-info-container">
                                <div class="td-meta-align">
                                    <div class="td-big-grid-meta">
                                        <a href="<?php echo get_category_link($category_id); ?>" class="td-post-category"><?php echo $categories[0]; ?></a>
                                        <h3 class="entry-title td-module-title <?php echo $grid_class; ?>">
                                            <a href="<?php echo get_permalink($post_data['ID']); ?>" rel="bookmark" title="<?php echo $post_data['post_title']; ?>"><?php echo $post_data['post_title']; ?></a>
                                        </h3>
                                    </div>
                                    <div class="td-module-meta-info">
                                        <span class="td-post-date"><time class="entry-date td-module-date" datetime="<?php echo get_the_time(DATE_W3C); ?>"><?php $new_date = date("F j, Y", strtotime($post_data['post_date'])); echo ($new_date); ?></time></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>

                <?php else : ?>
                    <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-9 main-blog-content other-blogs">
            <div class="td-big-grid-wrapper row">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => get_option('posts_per_page'),
                    'offset' => 7,
                    'order' => 'DESC',
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'paged' => $paged,
                );
                $cnt = 0;
                $the_query = new WP_Query($args);
                $thumbnail_size = 'blog_thumbnail_large';
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();
                        // Get a list of categories and extract their names
                        $post_categories = get_the_terms(get_the_ID(), 'category');
                        if (!empty($post_categories) && !is_wp_error($post_categories)) {
                            $categories = wp_list_pluck($post_categories, 'name');
                        }
                        // Get the ID of a given category
                        $category_id = get_cat_ID($categories[0]);
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
                    ?>
                    <!-- pagination here -->

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-3 sidebar-blog">
            <?php get_sidebar(); ?>
        </div>
    </div>


</div><!-- .wrap -->

<?php
get_footer();
