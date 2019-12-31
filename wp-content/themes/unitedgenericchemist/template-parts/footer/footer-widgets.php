<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>

<?php
if (is_active_sidebar('sidebar-2') ||
        is_active_sidebar('sidebar-3') ||
        is_active_sidebar('sidebar-4') ||
        is_active_sidebar('sidebar-5') ||
        is_active_sidebar('sidebar-6')) :
    ?>



    <div class="footer-widgets-section col-sm-12 ">
        <div class="row"><?php
            if (is_active_sidebar('sidebar-2')) {
                ?>
                <div class="widget-column footer-widget-1 col col-sm-6 col-md-4 col-lg-4 col-xl">
                    <?php dynamic_sidebar('sidebar-2'); ?>
                </div>
                <?php
            }
            if (is_active_sidebar('sidebar-3')) {
                ?>
                <div class="widget-column footer-widget-2 col col-sm-6 col-md-4 col-lg-4 col-xl">
                    <?php dynamic_sidebar('sidebar-3'); ?>
                </div>
                <?php
            }
            if (is_active_sidebar('sidebar-4')) {
                ?>
                <div class="widget-column footer-widget-3 col col-sm-6 col-md-4 col-lg-4 col-xl">
                    <?php dynamic_sidebar('sidebar-4'); ?>
                </div>
                <?php
            }
            if (is_active_sidebar('sidebar-5')) {
                ?>
                <div class="widget-column footer-widget-4 col col-sm-6 col-md-4 col-lg-4 col-xl">
                    <?php dynamic_sidebar('sidebar-5'); ?>
                </div>
                <?php
            }
            if (is_active_sidebar('sidebar-6')) {
                ?>
                <div class="widget-column footer-widget-5 col col-sm-6 col-md-4 col-lg-4 col-xl">
                    <?php dynamic_sidebar('sidebar-6'); ?>
                </div>
                <?php
            }
            ?>
            <?php if (has_nav_menu('footer_menu')) :
                ?>
                <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Social Links Menu', 'twentyseventeen'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_menu',
                        'menu_class' => 'footer-menu-section list-inline',
                    ));
                    ?>
                </nav> 
                <?php
            endif;
            ?>
        </div>
    </div>
    </aside><!-- .widget-area -->

<?php endif; ?>
