<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( __( 'Hi %s,', 'woocommerce' ), $order->get_billing_first_name() ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
<p><?php _e( 'Thank you for shopping with us!', 'woocommerce' ); ?></p><?php // phpcs:ignore WordPress.XSS.EscapeOutput ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>
<p style="text-align: left;">
<?php _e( 'Average normal shipping through EMS time is 15- 22 days, please (Delivery may be take up to 30 days from date of dispatch, due to if any disruption in postal services due to weather issue or natural disaster).', 'woocommerce' ); // phpcs:ignore WordPress.XSS.EscapeOutput ?>
</p>
<p style="text-align: left;">
<?php _e( 'You can send your prescription to <a href="mailto:admin@genericvilla.com">admin@genericvilla.com</a> also. (JPEG, PDF file supported)', 'woocommerce' ); // phpcs:ignore WordPress.XSS.EscapeOutput ?>
</p>
<p style="text-align: left;">
<?php _e( 'This email has been sent to you, as a one-time mailing, as a result of an order being placed on the website <a href="'.get_home_url().'" target="_blank">www.genericvilla.com</a> and the person placing the order entering the email address. If you have any questions or concerns about this, please contact our Customer Care immediately.', 'woocommerce' ); // phpcs:ignore WordPress.XSS.EscapeOutput ?>
</p>
<p style="text-align: left;">
<?php _e( 'In case of any trouble please email us at <a href="mailto:support@genericvilla.com">support@genericvilla.com</a> or open support Ticket', 'woocommerce' ); // phpcs:ignore WordPress.XSS.EscapeOutput ?>
</p>
<p style="text-align: left;">
Warm Regards,<br/>
Team GenericVilla
</p>
<?php

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
