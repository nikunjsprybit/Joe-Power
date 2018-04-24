<?php
/**
 * WCFM plugin core
 *
 * Plugin Vendor Support Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   2.0.0
 */
 
class WCFM_Vendor_Support {

	public function __construct() {
		global $WCFM;
		
		// Login Redirect
		add_filter( 'woocommerce_login_redirect', array($this, 'wcfm_wc_vendor_login_redirect'), 50, 2 );
		add_filter( 'login_redirect', array($this, 'wcfm_vendor_login_redirect'), 50, 3 );
		
		// Vendor wp-admin restrict
		if( wcfm_is_vendor() ) {
			$this->restrict_wcfm_vendor_backend();
		}
		
		if( !wcfm_is_vendor()) {
			if( $WCFM->is_marketplece == 'wcvendors' ) {
		  	add_action( 'end_wcfm_products_manage', array( &$this, 'wcvendors_product_commission' ), 500 );
		  	add_action( 'after_wcfm_products_manage_meta_save', array( &$this, 'wcvendors_product_commission_save' ), 500, 2 );
			}
		}
		
		// WC Vendor Capability update
		add_action( 'wcvendors_option_updates', array( &$this, 'vendors_capability_option_updates' ), 10, 2 );
	}
	
		/**
	 * WCFM WC Vendor Login redirect
	 */
	function wcfm_wc_vendor_login_redirect( $redirect_to, $user ) {
		if ( isset($user->roles) && is_array($user->roles) ) {
			if ( in_array( 'vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'dc_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'wc_product_vendors_admin_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'wc_product_vendors_manager_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			}
		}
		
		return $redirect_to;
	}
	
	/**
	 * WCFM Vendor Login redirect
	 */
	function wcfm_vendor_login_redirect( $redirect_to, $request, $user ) {
		if ( isset($user->roles) && is_array($user->roles) ) {
			if ( in_array( 'vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'dc_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'wc_product_vendors_admin_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			} elseif ( in_array( 'wc_product_vendors_manager_vendor', $user->roles ) ) {
				$redirect_to = get_wcfm_url();
			}
		}
		
		return $redirect_to;
	}
	
	/**
	 * Restrict vendors to access wp-admin
	 */
	function restrict_wcfm_vendor_backend(){
	  global $WCFM;
		if(is_user_logged_in()){
			$wcfm_options = get_option( 'wcfm_options' );
			$wc_frontend_manager_restrict_wpadmin = ( isset( $wcfm_options['wc_frontend_manager_restrict_wpadmin'] ) ) ? $wcfm_options['wc_frontend_manager_restrict_wpadmin'] : 'no';
			if( wcfm_is_vendor() && is_admin() && $wc_frontend_manager_restrict_wpadmin && !defined('DOING_AJAX')){
				wp_redirect( get_wcfm_url() );
				exit;
			}
		}
	}
	
	// WCV Vendor Commission
	function wcvendors_product_commission( $product_id ) {
		global $WCFM;
		
		$pv_commission_rate = '';
		if( $product_id  ) {
			$pv_commission_rate = get_post_meta( $product_id , 'pv_commission_rate', true );
		}
		?>
		<!-- collapsible 12 - WCV Commission Support -->
		<div class="page_collapsible products_manage_commission simple variable grouped external booking" id="wcfm_products_manage_form_commission_head"><?php _e('Vendor Commission', $WCFM->text_domain); ?><span></span></div>
		<div class="wcfm-container simple variable external grouped booking">
			<div id="wcfm_products_manage_form_commission_expander" class="wcfm-content">
				<?php
				$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_commission', array(  
																																														"pv_commission_rate" => array('label' => __('Commission(%)', $WCFM->text_domain) , 'type' => 'number', 'attributes' => array( 'min' => '', 'steps' => 1 ), 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $pv_commission_rate ),
																																									)) );
				?>
			</div>
		</div>
		<!-- end collapsible -->
		<div class="wcfm_clearfix"></div>
		<?php
	}
	
	// WCV Vendor Commision Save
	function wcvendors_product_commission_save( $new_product_id, $wcfm_products_manage_form_data ) {
		
		if( isset( $wcfm_products_manage_form_data['pv_commission_rate'] ) && !empty( $wcfm_products_manage_form_data['pv_commission_rate'] ) ) {
			update_post_meta( $new_product_id, 'pv_commission_rate', $wcfm_products_manage_form_data['pv_commission_rate'] );
		}
	}
	
	// Vendors Capability Options update
  function vendors_capability_option_updates( $options = array(), $tabname = 'capabilities' ) {
  	
  	if( $tabname == 'capabilities' ) {
  		$options = get_option( 'wcfm_options' );
  		$is_marketplece = wcfm_is_marketplace();
  		
  		if( $is_marketplece == 'wcvendors' ) {
	  		$vendor_role = get_role( 'vendor' );
	  	} elseif( $is_marketplece == 'wcmarketplace' ) {
	  		$vendor_role = get_role( 'dc_vendor' );
	  	}  elseif( $is_marketplece == 'wcpvendors' ) {
	  		$vendor_role = get_role( 'wc_product_vendors_admin_vendor' );
	  	}
  		
  		// Booking Capability
  		if( $is_marketplece && wcfm_is_booking() ) {
				if( isset( $options['wc_frontend_manager_manage_booking'] ) && $options[ 'wc_frontend_manager_manage_booking' ] == 'yes' ) {
					$vendor_role->add_cap( 'manage_bookings' );
					if( $is_marketplece == 'wcmarketplace' ) add_wcmp_users_caps('manage_bookings');
				} else {
					$vendor_role->remove_cap( 'manage_bookings' );
					if( $is_marketplece == 'wcmarketplace' ) remove_wcmp_users_caps('manage_bookings');
				}
			}
  		
  		// Submit Cupon
  		if( in_array( $is_marketplece, array( 'wcvendors', 'wcpvendors' ) )  ) {
				if( isset( $options[ 'wc_frontend_manager_submit_coupons' ] ) && $options[ 'wc_frontend_manager_submit_coupons' ] == 'yes' ) {
					$vendor_role->add_cap( 'edit_shop_coupons' );
					$vendor_role->add_cap( 'manage_shop_coupons' );
					$vendor_role->add_cap( 'read_shop_coupons' );
				} else {
					$vendor_role->remove_cap( 'edit_shop_coupons' );
					$vendor_role->remove_cap( 'manage_shop_coupons' );
					$vendor_role->remove_cap( 'read_shop_coupons' );
				}
				
				// Publish Coupon
				if( isset( $options[ 'wc_frontend_manager_publish_coupons' ] ) && $options[ 'wc_frontend_manager_publish_coupons' ] == 'yes' ) {
					$vendor_role->add_cap( 'publish_shop_coupons' );
				} else {
					$vendor_role->remove_cap( 'publish_shop_coupons' );
				}
				
				// Live Coupon Edit
				if( isset( $options[ 'wc_frontend_manager_edit_live_coupons' ] ) && $options[ 'wc_frontend_manager_edit_live_coupons' ] == 'yes' ) {
					$vendor_role->add_cap( 'edit_published_shop_coupons' );
					$vendor_role->add_cap( 'delete_published_shop_coupons' );
					$vendor_role->add_cap( 'delete_shop_coupons' );
				} else {
					$vendor_role->remove_cap( 'edit_published_shop_coupons' );
					$vendor_role->remove_cap( 'delete_published_shop_coupons' );
					$vendor_role->remove_cap( 'delete_shop_coupons' );
				}
			}
  	}
  }
}