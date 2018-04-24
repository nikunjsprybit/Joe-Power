<?php
/**
 * WCFM plugin view
 *
 * WCFM WC Product Vendors Settings View
 *
 * @author 		WC Lovers
 * @package 	wcfm/view
 * @version   2.1.1
 */

global $WCFM;

$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_from_user();

// logo image
$logo = ! empty( $vendor_data['logo'] ) ? $vendor_data['logo'] : '';

$logo_image_url = wp_get_attachment_image_src( $logo, 'full' );

if ( !empty( $logo_image_url ) ) {
	$logo_image_url = $logo_image_url[0];
}

$shop_name         = ! empty( $vendor_data['shop_name'] ) ? $vendor_data['shop_name'] : '';
$profile           = ! empty( $vendor_data['profile'] ) ? $vendor_data['profile'] : '';
$email             = ! empty( $vendor_data['email'] ) ? $vendor_data['email'] : '';
$paypal            = ! empty( $vendor_data['paypal'] ) ? $vendor_data['paypal'] : '';
$vendor_commission = ! empty( $vendor_data['commission'] ) ? $vendor_data['commission'] : get_option( 'wcpv_vendor_settings_default_commission', '0' );
$tzstring          = ! empty( $vendor_data['timezone'] ) ? $vendor_data['timezone'] : '';

if ( empty( $tzstring ) ) {
	$tzstring = WC_Product_Vendors_Utils::get_default_timezone_string();
}

$is_marketplece = wcfm_is_marketplace();
?>

<div class="collapse wcfm-collapse" id="">
  <?php do_action( 'before_wcfm_wcpvendors_settings' ); ?>
  <form id="wcfm_settings_form" class="wcfm">

	  <?php do_action( 'begin_wcfm_wcpvendors_settings_form' ); ?>
	  
		<!-- collapsible -->
			<div class="page_collapsible" id="wcfm_settings_form_style_head">
				<?php _e('Store Settings', $WCFM->text_domain); ?><span></span>
			</div>
			<div class="wcfm-container">
				<div id="wcfm_settings_form_style_expander" class="wcfm-content">
					<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_wcpvendors_settings_fields_style', array(
																																															"logo" => array('label' => __('Logo', $WCFM->text_domain) , 'type' => 'upload', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title', 'prwidth' => 150, 'value' => $logo_image_url),
																																															"shop_name" => array('label' => __('Shop Name', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $shop_name, 'hints' => __( 'Your shop name is public and must be unique.', $WCFM->text_domain ) ),
																																															"profile" => array('label' => __('Profile', $WCFM->text_domain) , 'type' => 'wpeditor', 'class' => 'wcfm-editor wcfm_ele', 'label_class' => 'wcfm_title', 'value' => $profile, 'hints' => __( 'Enter the profile information you would like for customer to see.', $WCFM->text_domain ) ),
																																															"email" => array('label' => __('Vendor Email', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $email, 'hints' => __( 'Enter the email for this vendor. This is the email where all notifications are sent such as new orders and customer inquiries. You may enter more than one email separating each with a comma.', $WCFM->text_domain ) ),
																																															"paypal" => array('label' => __('Paypal Email', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $paypal, 'hints' => __( 'PayPal email account where you will receive your commission.', $WCFM->text_domain ) ),
																																															"vendor_commission" => array('label' => __('Commission', $WCFM->text_domain) , 'type' => 'text', 'attributes' => array( 'disabled' => 'disabled' ), 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $vendor_commission, 'hints' => __( 'Default commission you will receive per product sale. Please note product level commission can override this. Check your product to confirm.', $WCFM->text_domain ) )
																																															) ) );
						
					?>
					<p class="tzstring wcfm_title wcfm_ele"><strong><?php _e('Timezone', $WCFM->text_domain); ?></strong><span class="img_tip" data-tip="<?php _e('Set the local timezone.', $WCFM->text_domain); ?>" data-hasqtip="4"></span></p>
					<label class="screen-reader-text" for="tzstring"><?php _e('Timezone', $WCFM->text_domain); ?></label>
					<select id="timezone" name="timezone" class="wcfm-select wcfm_ele">
					  <?php echo wp_timezone_choice( $tzstring ); ?>
					</select>
				</div>
			</div>
			<div class="wcfm_clearfix"></div>
			<!-- end collapsible -->
			
			<?php do_action( 'end_wcfm_wcpvendors_settings', $vendor_data ); ?>
		
		<div class="wcfm-message" tabindex="-1"></div>
		
		<div id="wcfm_settings_submit">
			<input type="submit" name="save-data" value="<?php _e( 'Save', $WCFM->text_domain ); ?>" id="wcfmsettings_save_button" />
		</div>
		
	
	</form>
	<?php
	do_action( 'after_wcfm_wcpvendors_settings' );
	?>
</div>