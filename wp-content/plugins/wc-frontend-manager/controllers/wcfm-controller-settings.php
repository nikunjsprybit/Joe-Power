<?php
/**
 * WCFM plugin controllers
 *
 * Plugin Setings Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers
 * @version   1.1.6
 */

class WCFM_Settings_Controller {
	
	public function __construct() {
		global $WCFM;
		
		$this->processing();
	}
	
	public function processing() {
		global $WCFM, $wpdb, $_POST;
		
		$wcfm_settings_form_data = array();
	  parse_str($_POST['wcfm_settings_form'], $wcfm_settings_form);
	  
	  $options = get_option( 'wcfm_options' );
	  $is_marketplece = wcfm_is_marketplace();
	  
	  if( $is_marketplece ) {
	  	
	  	// Restrict wp-admin
  		if( isset( $wcfm_settings_form['wc_frontend_manager_restrict_wpadmin'] ) ) {
  			$options[ 'wc_frontend_manager_restrict_wpadmin' ] = 'yes';
  		} else {
  			$options[ 'wc_frontend_manager_restrict_wpadmin' ] = 'no';
  		}
	  }
	  
	  if( $is_marketplece && wcfm_is_booking() ) {
	  	
	  	// Manage Bookings
  		if( isset( $wcfm_settings_form['wc_frontend_manager_manage_booking'] ) ) {
  			$options[ 'wc_frontend_manager_manage_booking' ] = 'yes';
  		} else {
  			$options[ 'wc_frontend_manager_manage_booking' ] = 'no';
  		}
	  }
	  
	  if( $is_marketplece && wcfm_is_subscription() ) {
	  	
	  	// Manage Subscriptions
  		if( isset( $wcfm_settings_form['wc_frontend_manager_manage_subscription'] ) ) {
  			$options[ 'wc_frontend_manager_manage_subscription' ] = 'yes';
  		} else {
  			$options[ 'wc_frontend_manager_manage_subscription' ] = 'no';
  		}
	  }
	  
	  if( $is_marketplece && WCFM_Dependencies::wcfm_wp_job_manager_plugin_active_check() ) {
	  	
	  	// Associate Listings
  		if( isset( $wcfm_settings_form['wc_frontend_manager_associate_listings'] ) ) {
  			$options[ 'wc_frontend_manager_associate_listings' ] = 'yes';
  		} else {
  			$options[ 'wc_frontend_manager_associate_listings' ] = 'no';
  		}
	  }
	  
	  if( in_array( $is_marketplece, array( 'wcvendors', 'wcpvendors' ) )  ) {
	  	
  		// Submit Cupon
			if( isset( $wcfm_settings_form['wc_frontend_manager_submit_coupons'] ) ) {
				$options[ 'wc_frontend_manager_submit_coupons' ] = 'yes';
			} else {
				$options[ 'wc_frontend_manager_submit_coupons' ] = 'no';
			}
				
			// Publish Coupon
			if( isset( $wcfm_settings_form['wc_frontend_manager_publish_coupons'] ) ) {
				$options[ 'wc_frontend_manager_publish_coupons' ] = 'yes';
			} else {
				$options[ 'wc_frontend_manager_publish_coupons' ] = 'no';
			}
				
			// Live Coupon Edit
			if( isset( $wcfm_settings_form['wc_frontend_manager_edit_live_coupons'] ) ) {
				$options[ 'wc_frontend_manager_edit_live_coupons' ] = 'yes';
			} else {
				$options[ 'wc_frontend_manager_edit_live_coupons' ] = 'no';
			}
	  }
	  
	  if( isset( $wcfm_settings_form['wc_frontend_manager_menu_type'] ) ) {
	  	$options[ 'wc_frontend_manager_menu_type' ] = $wcfm_settings_form['wc_frontend_manager_menu_type'];
	  }
	  
	  // Set Product Featured Image
		$wp_upload_dir = wp_upload_dir();
		if(isset($wcfm_settings_form['logo']) && !empty($wcfm_settings_form['logo'])) {
			$featured_img = str_replace($wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $wcfm_settings_form['logo']);
			$options['site_logo'] = $this->wcfm_get_image_id($wcfm_settings_form['logo']);
			update_option( 'wcfm_site_logo', $options['site_logo'] );
		} else {
			update_option( 'wcfm_site_logo', '' );
		}
	  
	  $color_options = $WCFM->wcfm_color_setting_options();
		foreach( $color_options as $color_option_key => $color_option ) {
			if( isset( $wcfm_settings_form[ $color_option['name'] ] ) ) { $options[$color_option['name']] = $wcfm_settings_form[ $color_option['name'] ]; } else { $options[$color_option['name']] = $color_option['default']; }
		}
	  
	  update_option( 'wcfm_options', $options );
	  
		$WCFM->wcfm_vendor_support->vendors_capability_option_updates();
		
		// Init WCFM Custom CSS file
		$wcfm_style_custom = $WCFM->wcfm_create_custom_css();
		 
		$upload_dir      = wp_upload_dir();
		echo '{"status": true, "message": "' . __( 'Settings saved successfully', $WCFM->text_domain ) . '", "file": "' . trailingslashit( $upload_dir['baseurl'] ) . '/wcfm/' . $wcfm_style_custom . '"}';
		 
		die;
	}
	
	function wcfm_get_image_id($image_url) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
		return $attachment[0]; 
	}
}