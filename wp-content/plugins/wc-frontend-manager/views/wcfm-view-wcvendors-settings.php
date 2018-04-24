<?php
/**
 * WCFM plugin view
 *
 * WCFM WC Vendors Settings View
 *
 * @author 		WC Lovers
 * @package 	wcfm/view
 * @version   2.1.1
 */

global $WCFM;

$user_id = get_current_user_id();

$shop_name = get_user_meta( $user_id, 'pv_shop_name', true );
$logo = get_user_meta( $user_id, 'pv_logo_image', true );
$paypal = get_user_meta( $user_id, 'pv_paypal', true );
$seller_info = get_user_meta( $user_id, 'pv_seller_info', true );
$shop_description = get_user_meta( $user_id, 'pv_shop_description', true );

$logo_image_url = wp_get_attachment_image_src( $logo, 'full' );

if ( !empty( $logo_image_url ) ) {
	$logo_image_url = $logo_image_url[0];
}

$is_marketplece = wcfm_is_marketplace();
?>

<div class="collapse wcfm-collapse" id="">
  <?php do_action( 'before_wcfm_wcvendors_settings' ); ?>
  <form id="wcfm_settings_form" class="wcfm">

	  <?php do_action( 'begin_wcfm_wcvendors_settings_form' ); ?>
	  
		<!-- collapsible -->
			<div class="page_collapsible" id="wcfm_settings_form_style_head">
				<?php _e('Store Settings', $WCFM->text_domain); ?><span></span>
			</div>
			<div class="wcfm-container">
				<div id="wcfm_settings_form_style_expander" class="wcfm-content">
					<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_wcpvendors_settings_fields_style', array(
																																															"logo" => array('label' => __('Logo', $WCFM->text_domain) , 'type' => 'upload', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title', 'prwidth' => 150, 'value' => $logo_image_url ),
																																															"shop_name" => array('label' => __('Shop Name', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $shop_name, 'hints' => __( 'Your shop name is public and must be unique.', $WCFM->text_domain ) ),
																																															"paypal" => array('label' => __('Paypal Email', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $paypal, 'hints' => __( 'Your PayPal address is used to send you your commission.', $WCFM->text_domain ) ),
																																															"seller_info" => array('label' => __('Seller Info', $WCFM->text_domain) , 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele', 'label_class' => 'wcfm_title', 'value' => $seller_info, 'hints' => __( 'This is displayed on each of your products.', $WCFM->text_domain ) ),
																																															"shop_description" => array('label' => __('Shop Description', $WCFM->text_domain) , 'type' => 'wpeditor', 'class' => 'wcfm-editor wcfm_ele', 'label_class' => 'wcfm_title', 'value' => $shop_description, 'hints' => __( 'This is displayed on your shop page.', $WCFM->text_domain ) )
																																															) ) );
						
					?>
				</div>
			</div>
			<div class="wcfm_clearfix"></div>
			<!-- end collapsible -->
			
			<?php do_action( 'end_wcfm_wcvendors_settings', $user_id ); ?>
		
		<div class="wcfm-message" tabindex="-1"></div>
		
		<div id="wcfm_settings_submit">
			<input type="submit" name="save-data" value="<?php _e( 'Save', $WCFM->text_domain ); ?>" id="wcfmsettings_save_button" />
		</div>
		
	</form>
	<?php
	do_action( 'after_wcfm_wcvendors_settings' );
	?>
</div>