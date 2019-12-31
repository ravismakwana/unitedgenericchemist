<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">        
        <?php wp_head(); ?>
        <?php
        $google_code = of_get_option('google_code');
        if (!empty($google_code)) {
            echo $google_code;
        }
		$schemaKey = 'schema_code_add-schema-code';
        $schemaCode = get_post_meta(get_the_ID(), $schemaKey, true);
        if(!empty($schemaCode) && is_product()) {
            echo $schemaCode;
        }
        ?>
		<meta name="p:domain_verify" content="94beefae341dada72ded9dc16bddc8c4"/>
    </head>

    <body <?php body_class(); ?>>
        <div class="panel-overlay"></div>
        <div id="page" class="site">
            <!--<a class="skip-link screen-reader-text" href="#content"><?php // _e('Skip to content', 'twentyseventeen');                                      ?></a>-->

            <header id="masthead" class="site-header" role="banner">
                <?php //get_template_part( 'template-parts/header/header', 'image' );  ?>
                <div id="top-bar-section" class="top-bar-section">
                    <div class="container">
                        <div class="row">
                            <div class="header-top-left col-lg-6 col-md-12">
                                <span class="left-top-text">
                                    <?php
                                    $topbar_left_text = of_get_option('topbar_left_text');
                                    if (!empty($topbar_left_text)) {
                                        echo trim($topbar_left_text);
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="header-top-right col-lg-6 col-md-12">
                                <div class="contact-link">
                                    <ul class="list-inline">
                                        <li class="header-phone list-inline-item">
                                            <?php
                                            $topbar_right_phone = of_get_option('topbar_right_phone');
                                            if (!empty($topbar_right_phone)) {
                                                ?>
                                                <a href="<?php echo 'tel:' . trim($topbar_right_phone); ?>"><i class="fa fa-phone"></i>
                                                    <?php echo trim($topbar_right_phone); ?>
                                                </a>
                                                <?php
                                            }
                                            ?>

                                        </li>
                                        <li class="header-mail list-inline-item">
                                            <?php
                                            $topbar_right_email = of_get_option('topbar_right_email');
                                            $topbar_right_email_imagge = of_get_option('topbar_right_email_image');
                                            if (!empty($topbar_right_email_imagge)) {
                                                ?>
                                                <a href="javascript:void(0)">
                                                    <img src="<?php echo $topbar_right_email_imagge; ?>" width="207" height="19" alt="<?php echo $topbar_right_email; ?>" />
                                                </a>
                                                <?php
                                            } else if (!empty($topbar_right_email)) {
                                                ?>
                                                <a href="<?php echo 'mailto:' . trim($topbar_right_email); ?>"><i class="fa fa-envelope"></i>
                                                    <?php echo trim($topbar_right_email); ?>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="full-header bg-dark-blue">
                    <div class="container">
                        <div class="header-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                        <div class="phone-section">
                            <div class="phone-inner">
                                <?php
//                                $topbar_right_phone = of_get_option('topbar_right_phone');
//                                if (!empty($topbar_right_phone)) {
                                ?>
<!--                                    <a href="<?php // echo 'tel:' . trim($topbar_right_phone);                     ?>"><i class="fa fa-phone"></i>
                                <?php // echo trim($topbar_right_phone); ?>
                                    </a>-->
                                <?php
//                                }
                                ?>
                                <div class="mini-bar">
                                    <?php
                                    if (function_exists('emallshop_header_mobile_toggle')) {
                                        emallshop_header_mobile_toggle();
                                    }
                                    ?>
                                </div>
                                <ul class="login-links list-inline">
                                    <?php if (is_user_logged_in()) { ?>
                                        <li class="list-inline-item"><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('My Account', 'woothemes'); ?>"><i class="fa fa-user fa-fw"></i> <?php _e('My Account', 'woothemes'); ?></a></li>
                                        <li class="list-inline-item"><a href="<?php echo wp_logout_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                    <?php } else {
                                        ?>
                                        <li class="list-inline-item"><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('Login', 'woothemes'); ?>"><i class="fa fa-sign-in fa-fw"></i> <?php _e('Login', 'woothemes'); ?></a></li>
                                        <li class="list-inline-item"><a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=register'; ?>"><i class="fa fa-user fa-fw"></i> Register</a></li>

                                    <?php } ?>
                                <!--<li><a href="#" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart fa-fw"></i> <span class="hidden-sm hidden-md">Wish List (0)</span></a></li>-->
                                </ul>
                            </div>

                        </div>
                        <div class="search-section">
                            <?php
                            get_product_search_form();
                            //emallshop_products_live_search_form();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="header-main-menu-section">
                    <div class="container">
                        <div class="main-product-category-list show_mega_menu col-sm-3">
                            <?php // if (has_nav_menu('product_category')) : ?>
                                <div class="cover-white-space">
                                    <div class="cat-menu">
                                        <!--<div class="cate-title"><i class="fa fa-bars fa-fw"></i>All Categories</div>-->
                                        <div class="cate-title"><a href="javascript:void(0);"><i class="fa fa-bars fa-fw"></i>All Categories</a></div>                                       
                                    </div><!-- .navigation-top -->
                                </div>
                            <?php // endif; ?>
                        </div>
                        <div class="show_mega_menu_block" id="mega_menu_block">
                            <?php
                            echo do_shortcode('[display_mega_menu]');
                            ?>
                        </div>
                        <div id="mobile-menu-wrapper" class="mobile-menu-wrapper">
                            <a href="#" id="mobile-nav-close" class=""><i class="fa fa-close"></i></a>
                            <div class="navbar-collapse">
                                <?php emallshop_header_mobile_menu(); ?>
                            </div><!-- /.navbar-collapse -->
                        </div>
                        <div class="main-header-menu">
                            <?php if (has_nav_menu('top')) : ?>
                                <div class="navigation-top">
                                    <div class="wrap">
                                        <?php get_template_part('template-parts/navigation/navigation', 'top'); ?>
                                    </div><!-- .wrap -->
                                </div><!-- .navigation-top -->
                            <?php endif; ?>
                        </div>
                        <div class="login-minicart-section">
                            <div class="signin-block d-none">
                                <div class="dropdown"><a href="#" title="Sign in" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user-o fa-fw"></i>
                                        <span class="sign-in-title">sign in</span><i class="fa fa-caret-down d-none"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right account-link-toggle">
                                        <?php if (is_user_logged_in()) { ?>
                                            <li><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('My Account', 'woothemes'); ?>"><i class="fa fa-user fa-fw"></i> <?php _e('My Account', 'woothemes'); ?></a>
                                            <?php } else {
                                                ?>
                                            <li><a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=register'; ?>"><i class="fa fa-user fa-fw"></i> Register</a></li>
                                            <li><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" title="<?php _e('Login', 'woothemes'); ?>"><i class="fa fa-sign-in fa-fw"></i> <?php _e('Login', 'woothemes'); ?></a>
                                            <?php } ?>
                                        <li><a href="#" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart fa-fw"></i> <span class="hidden-sm hidden-md">Wish List (0)</span></a></li>
                                        <?php if (is_user_logged_in()) { ?>
                                            <li><a href="<?php echo wp_logout_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="minicart-block woocommerce">
                                <div class="cart btn-group" id="cart">
                                    <?php echo do_shortcode('[custom-techno-mini-cart]'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </header><!-- #masthead -->

            <?php
            /*
             * If a regular post or page, and not the front page, show the featured image.
             * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
             */
//            if (( is_single() || ( is_page() && !twentyseventeen_is_frontpage() ) ) && has_post_thumbnail(get_queried_object_id())) :
//                echo '<div class="single-featured-image-header">';
//                echo get_the_post_thumbnail(get_queried_object_id(), 'twentyseventeen-featured-image');
//                echo '</div><!-- .single-featured-image-header -->';
//            endif;
            ?>

            <div class="site-content-contain">
                <div id="content" class="site-content">
