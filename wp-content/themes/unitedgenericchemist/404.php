<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
        <div class="col-sm-12 main-404-content text-center">

            <section class="error-404 not-found">
                <header class="page-header">
                    <span class="not-found-error">404</span>
                    <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'twentyseventeen'); ?></h1>
                </header><!-- .page-header -->
                <div class="page-content">
                    <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'twentyseventeen'); ?></p>

                    <?php get_search_form(); ?>

                </div><!-- .page-content -->
            </section><!-- .error-404 -->
        </div><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
