<?php
/**
 * WCFM plugin controllers
 *
 * Third Party Plugin Products Manage Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers
 * @version   2.2.2
 */

class WCFM_ThirdParty_Products_Manage_Controller {
	
	public function __construct() {
		global $WCFM;
		
		// Third Party Product Meta Data Save
    add_action( 'after_wcfm_products_manage_meta_save', array( &$this, 'wcfm_thirdparty_products_manage_meta_save' ), 100, 2 );
	}
	
	/**
	 * Third Party Product Meta data save
	 */
	function wcfm_thirdparty_products_manage_meta_save( $new_product_id, $wcfm_products_manage_form_data ) {
		global $wpdb, $WCFM, $_POST;
		
		// Yoast SEO Support
		if(WCFM_Dependencies::wcfm_yoast_plugin_active_check()) {
			if(isset($wcfm_products_manage_form_data['yoast_wpseo_focuskw_text_input'])) {
				update_post_meta( $new_product_id, '_yoast_wpseo_focuskw_text_input', $wcfm_products_manage_form_data['yoast_wpseo_focuskw_text_input'] );
				update_post_meta( $new_product_id, '_yoast_wpseo_focuskw', $wcfm_products_manage_form_data['yoast_wpseo_focuskw_text_input'] );
			}
			if(isset($wcfm_products_manage_form_data['yoast_wpseo_metadesc'])) {
				update_post_meta( $new_product_id, '_yoast_wpseo_metadesc', strip_tags( $wcfm_products_manage_form_data['yoast_wpseo_metadesc'] ) );
			}
		}
		
		// WooCommerce Custom Product Tabs Lite Support
		if(WCFM_Dependencies::wcfm_wc_tabs_lite_plugin_active_check()) {
			if(isset($wcfm_products_manage_form_data['product_tabs'])) {
				$frs_woo_product_tabs = array();
				if( !empty( $wcfm_products_manage_form_data['product_tabs'] ) ) {
					foreach( $wcfm_products_manage_form_data['product_tabs'] as $frs_woo_product_tab ) {
						if( $frs_woo_product_tab['title'] ) {
							// convert the tab title into an id string
							$tab_id = strtolower( wc_clean( $frs_woo_product_tab['title'] ) );
		
							// remove non-alphas, numbers, underscores or whitespace
							$tab_id = preg_replace( "/[^\w\s]/", '', $tab_id );
		
							// replace all underscores with single spaces
							$tab_id = preg_replace( "/_+/", ' ', $tab_id );
		
							// replace all multiple spaces with single dashes
							$tab_id = preg_replace( "/\s+/", '-', $tab_id );
		
							// prepend with 'tab-' string
							$tab_id = 'tab-' . $tab_id;
							
							$frs_woo_product_tabs[] = array(
																							'title'   => wc_clean( $frs_woo_product_tab['title'] ),
																							'id'      => $tab_id,
																							'content' => $frs_woo_product_tab['content']
																						);
						}
					}
					update_post_meta( $new_product_id, 'frs_woo_product_tabs', $frs_woo_product_tabs );
				} else {
					delete_post_meta( $new_product_id, 'frs_woo_product_tabs' );
				}
			}
		}
		
		// WooCommerce barcode & ISBN Support
		if(WCFM_Dependencies::wcfm_wc_barcode_isbn_plugin_active_check()) {
			if(isset($wcfm_products_manage_form_data['barcode'])) {
				update_post_meta( $new_product_id, 'barcode', $wcfm_products_manage_form_data['barcode'] );
				update_post_meta( $new_product_id, 'ISBN', $wcfm_products_manage_form_data['ISBN'] );
			}
		}
		
		// WooCommerce MSRP Pricing Support
		if(WCFM_Dependencies::wcfm_wc_msrp_pricing_plugin_active_check()) {
			if(isset($wcfm_products_manage_form_data['_msrp_price'])) {
				update_post_meta( $new_product_id, '_msrp_price', strip_tags( $wcfm_products_manage_form_data['_msrp_price'] ) );
			}
		}
		
		// Quantities and Units for WooCommerce Support 
		if( $allow_quantities_units = apply_filters( 'wcfm_is_allow_quantities_units', true ) ) {
			if(WCFM_Dependencies::wcfm_wc_quantities_units_plugin_active_check()) {
				if(isset($wcfm_products_manage_form_data['_wpbo_override'])) {
					update_post_meta( $new_product_id, '_wpbo_override', 'on' );
					update_post_meta( $new_product_id, '_wpbo_deactive', isset( $wcfm_products_manage_form_data['_wpbo_deactive'] ) ? 'on' : '' );
					update_post_meta( $new_product_id, '_wpbo_step', strip_tags( $wcfm_products_manage_form_data['_wpbo_step'] ) );
					update_post_meta( $new_product_id, '_wpbo_minimum', strip_tags( $wcfm_products_manage_form_data['_wpbo_minimum'] ) );
					update_post_meta( $new_product_id, '_wpbo_maximum', strip_tags( $wcfm_products_manage_form_data['_wpbo_maximum'] ) );
					update_post_meta( $new_product_id, '_wpbo_minimum_oos', strip_tags( $wcfm_products_manage_form_data['_wpbo_minimum_oos'] ) );
					update_post_meta( $new_product_id, '_wpbo_maximum_oos', strip_tags( $wcfm_products_manage_form_data['_wpbo_maximum_oos'] ) );
					update_post_meta( $new_product_id, 'unit', strip_tags( $wcfm_products_manage_form_data['unit'] ) );
				} else {
					update_post_meta( $new_product_id, '_wpbo_override', '' );
				}
			}
		}
	}
}