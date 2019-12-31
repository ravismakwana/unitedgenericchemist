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

<?php wp_footer(); ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5cc3ff04ee912b07bec5172b/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
