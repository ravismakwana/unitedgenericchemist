<?php
/**
 * Email Header Feedback
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header-feedback.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
        <title><?php echo get_bloginfo('name', 'display'); ?></title>
    </head>
    <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr' ?>">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td align="center" valign="top">                        
                        <table border="0" cellpadding="0" cellspacing="0" width="800" id="template_container">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Header -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="800" id="template_header">
                                        <tr>
                                            <td>
                                                <div id="template_header_image">
                                                    <?php
                                                    if ($img = get_option('woocommerce_email_header_image')) {
                                                        echo '<p style="margin-top:0;margin-bottom:0;"><a href="'. get_home_url().'" target="_blank"><img src="' . esc_url($img) . '" alt="' . get_bloginfo('name', 'display') . '" /></a></p>';
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td id="header_wrapper">
                                                <h1><?php echo $email_heading; ?></h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="800" id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" id="padding_0">                                                     
                                                            <table width="100%" id="bg-cyan-top">
                                                                <tbody>
                                                                    <tr>         
                                                                        <td><a href="https://www.genericvilla.com/" target="_blank">HOME</a></td>
                                                                        <td><a href="https://www.genericvilla.com/category/mens-health/erectile-dysfunction/" target="_blank">ED PILLS</a></td>
                                                                        <td><a href="https://www.genericvilla.com/category/offer-villa/" target="_blank">OFFER ZONE</a></td>
                                                                        <td><a href="https://www.genericvilla.com/blog/" target="_blank">BLOG</a></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div id="body_content_inner">





