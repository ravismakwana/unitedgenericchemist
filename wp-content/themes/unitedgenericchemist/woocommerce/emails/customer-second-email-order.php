<?php
/**
 * Customer second email on order
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-second-email-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.4
 */
if (!defined('ABSPATH')) {
    exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
$template = 'emails/email-header-feedback.php';
wc_get_template($template, array('email_heading' => $email_heading));
//do_action('woocommerce_email_header', $email_heading, $email);
?>

<?php /* translators: %s: Customer first name */ ?>
    <p><?php printf(esc_html__('Hello %s,', 'woocommerce'), esc_html($order->get_billing_first_name())); ?></p>
<?php /* translators: %s: Order number */ ?>
<?php $blog_title = get_bloginfo('name'); ?>
<?php
$content_html = of_get_option('second_email_on_order');
if (empty($content_html)) {
    $content_html = 'Content not found.';
}
echo wpautop($content_html);
?>
    <p>
        <b>Thanks for your time,</b><br/>
        Team GenericVilla
    </p>
    <p><b>Please note:</b> This email is sent automatically, so you may have received this review invitation before the
        arrival of your package or service. In this case, you are welcome to wait with writing your review until your
        package or service arrives.</p>
    <p></p>
<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action('woocommerce_email_footer', $email);
