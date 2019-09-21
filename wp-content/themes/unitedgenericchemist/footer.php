<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer footer-widgets-section" role="contentinfo">
    <div class="footer-social">
        <div class="container">
            <div class="row">   
                <div class="col-sm col-md col-lg vertical-middle news-letter-text"><label class="sign-up-lable">Sign Up For Newsletter</label></div>
                <div class="col-sm col-md col-lg-5 vertical-middle">
                    <?php
//                    echo do_shortcode('[mc4wp_form id="2933"]');    //local
                    echo do_shortcode('[mc4wp_form id="3818"]');    //live
                    ?> 
                </div>
                <div class="col-sm-12 col-md-12 col-lg">
                    <div class="sticky-social-menu">
                        <?php if (has_nav_menu('social')) : ?>
                            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Social Links Menu', 'twentyseventeen'); ?>">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'social',
                                    'menu_class' => 'social-links-menu',
                                    'depth' => 1,
                                    'link_before' => '<span class="screen-reader-text">',
                                    'link_after' => '</span>' . twentyseventeen_get_svg(array('icon' => 'chain')),
                                ));
                                ?>
                            </nav><!-- .social-navigation -->
                        <?php endif;
                        ?>
                    </div>
                </div>                
            </div>
        </div>
    </div>

    <div class="container widget-area">
        <div class="row">
            <?php
            get_template_part('template-parts/footer/footer', 'widgets');
            ?>
        </div>

    </div><!-- .container -->
    <?php get_template_part('template-parts/footer/site', 'info'); ?>    
</footer><!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php
global $product;
if (isset($product)) {
    $meta = get_post_meta(get_the_ID());
    $_product = new WC_Product(get_the_ID());
    if ($_product->regular_price != NULL) {
        $price = $_product->regular_price;
    } elseif ($_product->price != NULL) {
        $price = $_product->price;
    }
    if (($_product->price > $_product->sale_price) && ($_product->sale_price != NULL)) {
        $price = $_product->sale_price;
    }
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $rv_cate_desc = get_term_meta($term_id, 'rv_cate_desc', true);
    ?>
    <script type="application/ld+json">
        {
        "@context": "http://schema.org/",
        "@type": "Product",
        "name": "<?php echo get_the_title(get_the_ID()); ?>",
        "offers": {
        "@type": "Offer",
        "priceCurrency": "<?php echo get_woocommerce_currency(); ?>",
        "price": "<?php echo $price; ?>",
        "itemCondition" : "http://schema.org/NewCondition",
        "availability" : "http://schema.org/<?php echo $meta['_stock_status'][0] ? 'InStock' : 'OutOfStock'; ?>",
        "brand" : "Tripada Healthcare",
        "description": "<?php echo get_the_title(get_the_ID()); ?>"
        }
        }
    </script>
<?php } ?>
<?php wp_footer(); ?>

</body>
</html>
