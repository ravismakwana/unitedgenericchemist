<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<div class="site-info">
    <div class="container">
        <div class="row">
            <div class="payment-section col-sm-12 col-xs-12 col-md-12 col-lg-3">
                <img src="<?php echo of_get_option('payment-accept'); ?>" height="40" width="240" alt="Payment Accepts" />
            </div>
            <div class="text-center copy-section col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <p>
                    <?php echo of_get_option('copyright_text'); ?>
                </p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-3"></div>

        </div>
    </div>

</div><!-- .site-info -->
