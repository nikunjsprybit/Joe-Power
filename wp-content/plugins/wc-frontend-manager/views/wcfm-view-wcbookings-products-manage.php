<?php
/**
 * WCFM plugin views
 *
 * Plugin WC Booking Products Manage Views
 *
 * @author 		WC Lovers
 * @package 	wcfm/views
 * @version   2.1.0
 */
global $wp, $WCFM;

$product_id = 0;
$booking_qty = 1;

$min_date      = 0;
$min_date_unit = '';
$max_date = 12;
$max_date_unit = '';

$buffer_period= '';
$apply_adjacent_buffer = '';

$default_date_availability = '';

$booking_cost = '';
$booking_base_cost = '';
$display_cost = '';

if( isset( $_GET['listing_edit'] ) && !empty( $_GET['listing_edit'] ) ) {
	$product_id = $_GET['listing_edit'];
	if( $product_id ) {
		//$product = wc_get_product( $product_id );
		$bookable_product = new WC_Product_Booking( $product_id );
		
		$booking_qty = $bookable_product->get_qty( 'edit' );
		
		$min_date      = $bookable_product->get_min_date_value( 'edit' );
		$min_date_unit = $bookable_product->get_min_date_unit( 'edit' );
		$max_date      = $bookable_product->get_max_date_value( 'edit' );
		$max_date_unit = $bookable_product->get_max_date_unit( 'edit' );
		
		$buffer_period = esc_attr( $bookable_product->get_buffer_period( 'edit' ) );
		$apply_adjacent_buffer = $bookable_product->get_apply_adjacent_buffer( 'edit' ) ? 'yes' : 'no';
		
		$default_date_availability = $bookable_product->get_default_date_availability( 'edit' );
		
		$booking_cost = $bookable_product->get_cost( 'edit' );
		$booking_base_cost = $bookable_product->get_base_cost( 'edit' );
		$display_cost = $bookable_product->get_display_cost( 'edit' );

		$wc_booking_day_cost = get_post_meta($product_id, '_wc_booking_day_cost',true );
		$wc_booking_week_cost = get_post_meta($product_id, '_wc_booking_week_cost',true );
		$wc_booking_month_cost = get_post_meta($product_id, '_wc_booking_month_cost',true );
	}
}

?>

<!-- Collapsible Booking 2  -->
<div class="page_collapsible products_manage_availability booking check_collapsible_open" id="wcfm_products_manage_form_availability_head"><?php _e('Availability', 'woocommerce-bookings'); ?><span></span></div>
<div class="wcfm-container booking products_manage_availability_fildes">
	<div id="wcfm_products_manage_form_availability_expander" class="wcfm-content">
		<?php
		$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_wcbokings_availability_fields', array(  
					
					"_wc_booking_min_date" => array('label' => __('Minimum Rental Period', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $min_date ),
					"_wc_booking_min_date_unit" => array('type' => 'select', 'options' => array( 'month' => __( 'Month', 'woocommerce-bookings'), 'day' => __( 'Day', 'woocommerce-bookings' ), 'hour' => __( 'Hour', 'woocommerce-bookings' )), 'class' => 'wcfm-select wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $min_date_unit ),
					"_wc_booking_max_date" => array('label' => __('Maximum Rental Period', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $max_date ),
					"_wc_booking_max_date_unit" => array('type' => 'select', 'options' => array( 'month' => __( 'Month', 'woocommerce-bookings'), 'day' => __( 'Day', 'woocommerce-bookings' ), 'hour' => __( 'Hour', 'woocommerce-bookings' )), 'class' => 'wcfm-select wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $max_date_unit ),
					"_wc_booking_buffer_period" => array('label' => __('Require a buffer period of', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $buffer_period, 'desc' => '<span class="_wc_booking_buffer_period_unit"></span>' . __( 'between bookings', 'woocommerce-bookings' ) ),
					/* "_wc_booking_default_date_availability" => array('label' => __('All dates are...', 'woocommerce-bookings') , 'type' => 'select', 'options' => array( 'available' => __( 'available by default', 'woocommerce-bookings'), 'non-available' => __( 'not-available by default', 'woocommerce-bookings' ) ), 'class' => 'wcfm-select wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $default_date_availability, 'hints' => __( 'This option affects how you use the rules below.', 'woocommerce-bookings' ) ) */
																										
																														), $product_id ) );
		?>
	</div>
</div>
<!-- end collapsible Booking -->
<div class="wcfm_clearfix"></div>

<!-- Collapsible Booking 3  -->
<div class="page_collapsible products_manage_costs booking" style="<?php echo $visible; ?>" id="wcfm_products_manage_form_costs_head"><?php _e('Prices', 'woocommerce-bookings'); ?><span></span></div>
<div class="wcfm-container booking products_manage_costs_fields">
	<div id="wcfm_products_manage_form_costs_expander" class="wcfm-content">
		<?php
		/*$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_wcbokings_cost_fields', array(  
					
					"_wc_booking_cost" => array('label' => __('Base Price', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $booking_cost, 'hints' => __( 'One-off cost for the booking as a whole.', 'woocommerce-bookings' ), 'attributes' => array( 'min' => '', 'step' => '0.01' ) ),
					"_wc_booking_base_cost" => array('label' => __('Block Price', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $booking_base_cost, 'hints' => __( 'This is the cost per block booked. All other costs (for resources and persons) are added to this.', 'woocommerce-bookings' ), 'attributes' => array( 'min' => '', 'step' => '0.01' ) ),
					"_wc_display_cost" => array('label' => __('Display Price', 'woocommerce-bookings') , 'type' => 'number', 'class' => 'wcfm-text wcfm_ele booking', 'label_class' => 'wcfm_title booking', 'value' => $display_cost, 'hints' => __( 'The cost is displayed to the user on the frontend. Leave blank to have it calculated for you. If a booking has varying costs, this will be prefixed with the word `from:`.', 'woocommerce-bookings' ), 'attributes' => array( 'min' => '', 'step' => '0.01' ) ),
																										
																														), $product_id ) );*/
		?>


		<p class="wcfm_title booking">
			<strong>Per Day Price</strong>
		</p>
		<input type="number" id="_wc_booking_day_cost" name="_wc_booking_day_cost" class="wcfm-text wcfm_ele booking" value="<?php echo $wc_booking_day_cost; ?>" placeholder="" min="" step="0.01">

		<p class="wcfm_title booking">
			<strong>Per Week Price</strong>
		</p>
		<input type="number" id="_wc_booking_week_cost" name="_wc_booking_week_cost" class="wcfm-text wcfm_ele booking" value="<?php echo $wc_booking_week_cost; ?>" placeholder="" min="" step="0.01">

		<p class="wcfm_title booking">
			<strong>Per Month Price</strong>
		</p>
		<input type="number" id="_wc_booking_month_cost" name="_wc_booking_month_cost" class="wcfm-text wcfm_ele booking" value="<?php echo $wc_booking_month_cost; ?>" placeholder="" min="" step="0.01">

		

		<!-- <input type="numbe" id="_wc_booking_cost" name="_wc_booking_cost" class="wcfm-text wcfm_ele booking" value="" placeholder="" min="" step="0.01">

		<p class="_wc_booking_base_cost wcfm_title booking"><strong>Block Price</strong></p>
		<input type="number" id="_wc_booking_base_cost" name="_wc_booking_base_cost" class="wcfm-text wcfm_ele booking" value="" placeholder="" min="" step="0.01"> -->
	</div>
</div>
<!-- end collapsible Booking -->
<div class="wcfm_clearfix"></div>