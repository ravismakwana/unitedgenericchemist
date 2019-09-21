<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form');
?>

<?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
    <div class="my-account-section">
        <!--        <div class="col-xs-12 col-sm-12">
                    <div class="row">-->

        <?php if (isset($_GET['action']) && $_GET['action'] == "register") : ?>

            <div class="col-xs-12">
                <p>If you already have an account with us, please login at the <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">login page</a>.</p>
                <form method="post" class="woocommerce-form woocommerce-form-register register">

                    <h2 class="headline"><?php _e('Your Personal Details', 'woocommerce'); ?></h2>

                    <?php do_action('woocommerce_register_form_start'); ?>

                    <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                        <div class="form-group">
                            <label for="reg_username"><?php _e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                            <input type="text" class="form-control" name="username" id="reg_username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                        </div>

                    <?php endif; ?>

                    <div class="form-group">
                        <label for="reg_email"><?php _e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email" id="reg_email" value="<?php if (!empty($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
                    </div>

                    <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                        <div class="form-group">
                            <label for="reg_password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                            <input type="password" class="form-control" name="password" id="reg_password" />
                        </div>

                    <?php endif; ?>

                    <!-- Spam Trap -->
                    <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e('Anti-spam', 'woocommerce'); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                    <?php do_action('woocommerce_register_form'); ?>
                    <?php do_action('register_form'); ?>

                    <p class="form-row">
                        <?php wp_nonce_field('woocommerce-register'); ?>
                        <input type="submit" class="button" name="register" value="<?php _e('Register', 'woocommerce'); ?>" />
                    </p>

                    <?php do_action('woocommerce_register_form_end'); ?>

                </form>

            </div> <!-- end Register Section .col-sm-6 -->

        <?php else : ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="sqaure-box">
                        <h2>New Customer</h2>
                        <strong>Register</strong>

                        <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.
                        </p>
                        <a class="btn btn-primary" href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=register'; ?>"><?php _e('Continue'); ?></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">

                    <form method="post" class="woocommerce-form woocommerce-form-login login">

                        <h2 class="headline"><?php _e('Returning Customer', 'woocommerce'); ?></h2>
                        <strong>I am a returning customer</strong>
                        <?php do_action('woocommerce_login_form_start'); ?>

                        <div class="form-group">
                            <label for="username"><?php _e('Username or email address', 'woocommerce'); ?> <span class="required">*</span></label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                            <input class="form-control" type="password" name="password" id="password" />
                        </div>

                        <?php do_action('woocommerce_login_form'); ?>

                        <p class="form-row">
                            <?php wp_nonce_field('woocommerce-login'); ?>
                            <input type="submit" class="btn btn-primary" name="login" value="<?php _e('Login', 'woocommerce'); ?>" />
                            <label for="rememberme" class="inline">
                                <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e('Remember me', 'woocommerce'); ?>
                            </label>
                        </p>
                        <p class="lost_password">
                            <a href="<?php echo esc_url(wc_lostpassword_url()); ?>"><?php _e('Lost your password?', 'woocommerce'); ?></a>
                        </p>

                        <?php do_action('woocommerce_login_form_end'); ?>

                    </form>
                </div> <!-- end Login Section .col-sm-6 -->
            </div>



        <?php endif; ?>

        <!--            </div>
                </div> end .col-xs-12 .col-sm-10 .col-sm-offset-1 -->
    </div>



<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
