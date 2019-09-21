<?php
/**
 * Customer feedback order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-feedback-order.php.
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
<p><?php printf(esc_html__('Dear %s,', 'woocommerce'), esc_html($order->get_billing_first_name())); ?></p>
<?php /* translators: %s: Order number */ ?>
<?php $blog_title = get_bloginfo('name'); ?>
<p>Thank you for choosing <a href="<?php echo home_url(); ?>"><?php echo $blog_title; ?></a></p>
<p><?php esc_html_e('To improve the satisfaction of our customers, we have partnered with the online review community, Trustpilot, to collect reviews.', 'woocommerce'); ?></p>
<p>
    <?php esc_html_e('All reviews, good, bad or otherwise will be visible immediately.', 'woocommerce'); ?>
</p>
<?php $feedbackLink = of_get_option('feedback_url'); ?>
<p>
    <a href="<?php echo $feedbackLink; ?>" style="color:#0c59f2;font-weight:normal;line-height:1em;text-decoration:underline;font-size:18px;">Click here to review us on Trustpilot</a>
    <?php
    $trustImage = of_get_option('feedback_image');
    ?><br/>
    <a href="<?php echo $feedbackLink; ?>" target="_blank"><img src="<?php echo $trustImage; ?>" width="250" height="243" /></a>
</p>
<p>
    <b>Thanks for your time,</b><br/>
    Team GenericVilla
</p>
<p><b>Please note:</b> This email is sent automatically, so you may have received this review invitation before the arrival of your package or service. In this case, you are welcome to wait with writing your review until your package or service arrives.</p>
<p></p>
<?php
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action('woocommerce_email_footer', $email);
