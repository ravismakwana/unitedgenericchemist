<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; 

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>

<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	
	<div class="product-image">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo wp_kses_post( $product->get_image('thumbnail') ); ?>
		</a>
	</div>
	<div class="product-details">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<span class="product-title"><?php echo $product->get_name(); ?></span>
		</a>
		
		<?php if ( ! empty( $show_rating ) ) : ?>
			<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
		<?php endif; ?>
	
		<span class="product-price">
			<?php echo wp_kses_post( $product->get_price_html() ); ?>
		</span>
	</div>
	
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
	
</li>