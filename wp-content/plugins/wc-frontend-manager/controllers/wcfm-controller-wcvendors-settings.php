<?php
/**
 * WCFM plugin controllers
 *
 * Plugin WC Vendors Setings Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers
 * @version   2.1.1
 */

class WCFM_Settings_WCVendors_Controller {
	
	public function __construct() {
		global $WCFM;
		
		$this->processing();
	}
	
	public function processing() {
		global $WCFM, $wpdb, $_POST;
		
		$user_id = get_current_user_id();
		
		$wcfm_settings_form_data = array();
	  parse_str($_POST['wcfm_settings_form'], $wcfm_settings_form);
	  
	  // sanitize
		$wcfm_settings_form = array_map( 'sanitize_text_field', $wcfm_settings_form );
		$wcfm_settings_form = array_map( 'stripslashes', $wcfm_settings_form );
		
		// sanitize html editor content
		$wcfm_settings_form['shop_description'] = ! empty( $_POST['profile'] ) ? wp_kses_post( stripslashes( $_POST['profile'] ) ) : '';
		
		update_user_meta( $user_id, 'pv_shop_name', $wcfm_settings_form['shop_name'] );
		update_user_meta( $user_id, 'pv_paypal', $wcfm_settings_form['paypal'] );
		update_user_meta( $user_id, 'pv_seller_info', $wcfm_settings_form['seller_info'] );
		update_user_meta( $user_id, 'pv_shop_description', $wcfm_settings_form['shop_description'] );
		
		// Set Product Featured Image
		$wp_upload_dir = wp_upload_dir();
		if(isset($wcfm_settings_form['logo']) && !empty($wcfm_settings_form['logo'])) {
			$featured_img = str_replace($wp_upload_dir['baseurl'], $wp_upload_dir['basedir'], $wcfm_settings_form['logo']);
			$wcfm_settings_form['logo'] = $this->wcfm_get_image_id($wcfm_settings_form['logo']);
		} else {
			$wcfm_settings_form['logo'] = '';
		}
		update_user_meta( $user_id, 'pv_logo_image', $wcfm_settings_form['logo'] );
		
		echo '{"status": true, "message": "' . __( 'Settings saved successfully', $WCFM->text_domain ) . '"}';
		 
		die;
	}
	
	function wcfm_get_image_id($image_url) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
		return $attachment[0]; 
	}
}