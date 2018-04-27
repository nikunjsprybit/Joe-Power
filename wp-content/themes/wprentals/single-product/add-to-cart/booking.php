<?php
/**
 * Booking product add to cart
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $product;
if (!$product->is_purchasable()) {
    return;
}
do_action('woocommerce_before_add_to_cart_form');
?>
<noscript><?php _e('Your browser must support JavaScript in order to make a booking.', 'woocommerce-bookings'); ?></noscript>
<form class="cart custom_cart" method="post" enctype='multipart/form-data'>
    <div id="wc-bookings-booking-form" class="wc-bookings-booking-form">
        <?php do_action('woocommerce_before_booking_form'); ?>
        <div class="bookingformoutdata">
            <?php $booking_form->output(); ?>
        </div>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
        <div class="wc-bookings-booking-cost" ></div>
        <div class="has_calendar calendar_icon">
            <input type="text" id="start_date1" placeholder="Check in" class="form-control calendar_icon" size="40" name="start_date" value="">
        </div>
        <div class=" has_calendar calendar_icon">
            <input type="text" id="end_date1" disabled="" placeholder="Check Out" class="form-control calendar_icon" size="40" name="end_date" value="">
        </div>
    </div>
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr(is_callable(array($product, 'get_id')) ? $product->get_id() : $product->id ); ?>" class="wc-booking-product-id" />
    <button type="submit" class="wc-bookings-booking-form-button single_add_to_cart_button button wpestate_vc_button wpb_btn-info wpb_btn-small alt">Book Now<?php //echo $product->single_add_to_cart_text();  ?></button>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
</form>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>