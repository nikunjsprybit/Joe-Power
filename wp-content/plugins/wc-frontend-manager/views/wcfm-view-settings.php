<?php
/**
 * WCFM plugin view
 *
 * WCFM Settings View
 *
 * @author 		WC Lovers
 * @package 	wcfm/view
 * @version   1.1.6
 */

global $WCFM;

$user = wp_get_current_user();
if( !current_user_can( 'manage_options' )  && !in_array( 'dc_vendor', (array) $user->roles )) {
	_e( "<span class='permission_restrict'>You don't have permission to access this page. Please contact site administrator for assistance.</span>", $WCFM->text_domain );
	return;
}

$wcfm_options = get_option( 'wcfm_options' );

$wc_frontend_manager_restrict_wpadmin = ( isset( $wcfm_options['wc_frontend_manager_restrict_wpadmin'] ) ) ? $wcfm_options['wc_frontend_manager_restrict_wpadmin'] : 'no';
$wc_frontend_manager_manage_booking = ( isset( $wcfm_options['wc_frontend_manager_manage_booking'] ) ) ? $wcfm_options['wc_frontend_manager_manage_booking'] : 'no';
$wc_frontend_manager_manage_subscription = ( isset( $wcfm_options['wc_frontend_manager_manage_subscription'] ) ) ? $wcfm_options['wc_frontend_manager_manage_subscription'] : 'no';
$wc_frontend_manager_associate_listings = ( isset( $wcfm_options['wc_frontend_manager_associate_listings'] ) ) ? $wcfm_options['wc_frontend_manager_associate_listings'] : 'no';
$wc_frontend_manager_submit_coupons = ( isset( $wcfm_options['wc_frontend_manager_submit_coupons'] ) ) ? $wcfm_options['wc_frontend_manager_submit_coupons'] : 'no';
$wc_frontend_manager_publish_coupons = ( isset( $wcfm_options['wc_frontend_manager_publish_coupons'] ) ) ? $wcfm_options['wc_frontend_manager_publish_coupons'] : 'no';
$wc_frontend_manager_edit_live_coupons = ( isset( $wcfm_options['wc_frontend_manager_edit_live_coupons'] ) ) ? $wcfm_options['wc_frontend_manager_edit_live_coupons'] : 'no';

$logo = ! empty( get_option( 'wcfm_site_logo' ) ) ? get_option( 'wcfm_site_logo' ) : '';
$logo_image_url = wp_get_attachment_image_src( $logo, 'full' );

if ( !empty( $logo_image_url ) ) {
	$logo_image_url = $logo_image_url[0];
}

$is_marketplece = wcfm_is_marketplace();
?>

<div class="col-sm-12" id="">
  <?php do_action( 'before_wcfm_settings' ); ?>
  <form id="wcfm_settings_form" class="wcfm">

	  <?php do_action( 'begin_wcfm_settings_form' ); ?>
	  
	  <?php if( $is_marketplece ) { ?>
			<!-- collapsible -->
			<div class="page_collapsible" id="wcfm_settings_form_vendor_head">
				<?php _e('Vendor Settings', $WCFM->text_domain); ?><span></span>
			</div>
			<div class="wcfm-container">
				<div id="wcfm_settings_form_vendor_expander" class="wcfm-content">
				  <?php
				  $WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_general', array(  "wc_frontend_manager_restrict_wpadmin" => array('label' => __('Restrict wp-admin', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_restrict_wpadmin),
																												) ) );
					
				  if( wcfm_is_booking() ) {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_booking', array(  "wc_frontend_manager_manage_booking" => array('label' => __('Manage Bookings', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_manage_booking),
																												) ) );
				  } else {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_booking', array(  "wc_frontend_manager_manage_booking" => array('label' => __('Manage Bookings', $WCFM->text_domain) , 'type' => 'checkbox', 'custom_tags' => array( 'disabled' => 'disabled' ), 'desc' => __( 'Install WC Bookings to enable this feature.', $WCFM->text_domain ), 'class' => 'wcfm-checkbox wcfm-checkbox-disabled wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_manage_booking),
																												) ) );
				  }
				  
				  if( wcfm_is_subscription() ) {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_subscription', array(  "wc_frontend_manager_manage_subscription" => array('label' => __('Manage Subscriptions', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_manage_subscription),
																												) ) );
				  } else {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_subscription', array(  "wc_frontend_manager_manage_subscription" => array('label' => __('Manage Subscriptions', $WCFM->text_domain) , 'type' => 'checkbox', 'custom_tags' => array( 'disabled' => 'disabled' ), 'desc' => __( 'Install WC Subscriptions to enable this feature.', $WCFM->text_domain ), 'class' => 'wcfm-checkbox wcfm-checkbox-disabled wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_manage_subscription),
																												) ) );
					}
					
					if( WCFM_Dependencies::wcfm_wp_job_manager_plugin_active_check() ) {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_listings', array(  "wc_frontend_manager_associate_listings" => array('label' => __('Associate Listings', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'desc' => __( 'by WP Job Manager.', $WCFM->text_domain ), 'dfvalue' => $wc_frontend_manager_associate_listings),
																												) ) );
				  } else {
				  	$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_listings', array(  "wc_frontend_manager_associate_listings" => array('label' => __('Associate Listings', $WCFM->text_domain) , 'type' => 'checkbox', 'custom_tags' => array( 'disabled' => 'disabled' ), 'desc' => __( 'Install WP Job Manager to enable this feature.', $WCFM->text_domain ), 'class' => 'wcfm-checkbox wcfm-checkbox-disabled wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_associate_listings),
																												) ) );
					}
				  
					if( in_array( $is_marketplece, array( 'wcvendors', 'wcpvendors' ) )  ) {
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_vendor_coupon', array(  "wc_frontend_manager_submit_coupons" => array('label' => __('Submit Coupons', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_submit_coupons),
																																																											 "wc_frontend_manager_publish_coupons" => array('label' => __('Publish Coupons', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_publish_coupons),
																																																											 "wc_frontend_manager_edit_live_coupons" => array('label' => __('Edit Live Coupons', $WCFM->text_domain) , 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'value' => 'yes', 'label_class' => 'wcfm_title checkbox_title', 'dfvalue' => $wc_frontend_manager_edit_live_coupons)
																												) ) );
					}
					?>
				</div>
			</div>
			<div class="wcfm_clearfix"></div><br />
			<!-- end collapsible -->
		<?php } ?>
		
		<!-- collapsible -->
			<div class="page_collapsible" id="wcfm_settings_form_style_head">
				<?php _e('Style Settings', $WCFM->text_domain); ?><span></span>
			</div>
			<div class="wcfm-container">
				<div id="wcfm_settings_form_style_expander" class="wcfm-content">
					<?php
					  $WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_settings_fields_style', array(
																																															"logo" => array('label' => __('Logo', $WCFM->text_domain) , 'type' => 'upload', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title', 'prwidth' => 150, 'value' => $logo_image_url )
																																															) ) );
						$color_options = $WCFM->wcfm_color_setting_options();
						$color_options_array = array();
		
						foreach( $color_options as $color_option_key => $color_option ) {
							$color_options_array[$color_option['name']] = array( 'label' => $color_option['label'] , 'type' => 'colorpicker', 'class' => 'wcfm-text wcfm_ele colorpicker', 'label_class' => 'wcfm_title wcfm_ele', 'value' => ( isset($wcfm_options[$color_option['name']]) ) ? $wcfm_options[$color_option['name']] : $color_option['default'] );
						}
						$WCFM->wcfm_fields->wcfm_generate_form_field( $color_options_array );
					?>
				</div>
			</div>
			<div class="wcfm_clearfix"></div>
			<!-- end collapsible -->
			
			<?php do_action( 'end_wcfm_settings', $wcfm_options ); ?>
		
		<div class="wcfm-message" tabindex="-1"></div>
		
		<div id="wcfm_settings_submit">
			<input type="submit" name="save-data" value="<?php _e( 'Save', $WCFM->text_domain ); ?>" id="wcfmsettings_save_button" />
		</div>
	</form>	
	<?php
	do_action( 'after_wcfm_settings' );
	?>
</div>