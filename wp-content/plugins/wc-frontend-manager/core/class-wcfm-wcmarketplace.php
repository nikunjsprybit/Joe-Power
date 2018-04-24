<?php

/**
 * WCFM plugin core
 *
 * Marketplace WC Marketplace Support
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   1.1.0
 */
 
class WCFM_WCMarketplace {
	
	public function __construct() {
    global $WCFM;
    
    if( wcfm_is_vendor() ) {
    	// Store Identity
    	add_filter( 'wcfm_store_logo', array( &$this, 'wcmarketplace_store_logo' ) );
    	add_filter( 'wcfm_store_name', array( &$this, 'wcmarketplace_store_name' ) );
    	
    	// WCFM Menu Filter
    	add_filter( 'wcfm_menus', array( &$this, 'wcmarketplace_wcfm_menus' ), 30 );
    	add_filter( 'wcfm_add_new_product_sub_menu', array( &$this, 'wcmarketplace_add_new_product_sub_menu' ) );
    	add_filter( 'wcfm_add_new_coupon_sub_menu', array( &$this, 'wcmarketplace_add_new_coupon_sub_menu' ) );
    	add_filter( 'wcmp_vendor_dashboard_nav', array( &$this, 'wcmarketplace_wcfm_vendor_dashboard_nav' ) );
    	
    	// WP Admin View
    	add_filter( 'wcfm_allow_wp_admin_view', array( &$this, 'wcmarketplace_allow_wp_admin_view' ) );
    	
			// Allow Vendor user to manage product from catalog
			add_filter( 'wcfm_allwoed_user_rols', array( &$this, 'allow_wcmarketplace_vendor_role' ) );
			
			// Filter Vendor Products
			add_filter( 'wcfm_products_args', array( &$this, 'wcmarketplace_products_args' ) );
			
			// Manage Vendor Product Permissions
			add_filter( 'wcfm_product_types', array( &$this, 'wcmarketplace_is_allow_product_types'), 100 );
			add_filter( 'wcfm_product_manage_fields_general', array( &$this, 'wcmarketplace_is_allow_fields_general' ), 100 );
			add_filter( 'wcfm_is_allow_inventory', array( &$this, 'wcmarketplace_is_allow_inventory' ) );
			add_filter( 'wcfm_is_allow_shipping', array( &$this, 'wcmarketplace_is_allow_shipping' ) );
			add_filter( 'wcfm_is_allow_tax', array( &$this, 'wcmarketplace_is_allow_tax' ) );
			add_filter( 'wcfm_is_allow_attribute', array( &$this, 'wcmarketplace_is_allow_attribute' ) );
			add_filter( 'wcfm_is_allow_variable', array( &$this, 'wcmarketplace_is_allow_variable' ) );
			add_filter( 'wcfm_is_allow_linked', array( &$this, 'wcmarketplace_is_allow_linked' ) );
			add_action( 'after_wcfm_products_manage_meta_save', array( &$this, 'wcmarketplace_product_manage_vendor_association' ), 10, 2 ); 
			
			// Filter Vendor Coupons
			add_filter( 'wcfm_coupons_args', array( &$this, 'wcmarketplace_coupons_args' ) );
			
			// Manage Vendor Coupon Permission
			add_filter( 'wcfm_coupon_types', array( &$this, 'wcmarketplace_coupon_types' ) );
			
			// Report Filter
			add_filter( 'wcfm_report_out_of_stock_query_from', array( &$this, 'wcmarketplace_report_out_of_stock_query_from' ), 100, 2 );
			add_filter( 'woocommerce_reports_order_statuses', array( &$this, 'wcmarketplace_reports_order_statuses' ) );
			add_filter( 'woocommerce_dashboard_status_widget_top_seller_query', array( &$this, 'wcmarketplace_dashboard_status_widget_top_seller_query'), 100 );
			//add_filter( 'woocommerce_reports_get_order_report_data', array( &$this, 'wcmarketplace_reports_get_order_report_data'), 100 );
		}
  }
  
  // WCFM WCMp Store Logo
  function wcmarketplace_store_logo( $store_logo ) {
  	$vendor = get_wcmp_vendor(get_current_user_id());
  	if ( $vendor->image ) {
			$store_logo = $vendor->image;
		}
  	return $store_logo;
  }
  
  // WCFM WCMp Store Name
  function wcmarketplace_store_name( $store_name ) {
  	$shop_name = get_user_meta(get_current_user_id(), '_vendor_page_title', true);
  	if( $shop_name ) $store_name = $shop_name;
  	return $store_name;
  }
  
  // WCFM wcmarketplace Menu
  function wcmarketplace_wcfm_menus( $menus ) {
  	global $WCFM;
  	
  	if( !current_user_can( 'edit_products' ) ) unset( $menus['products'] );
  	if( !current_user_can( 'edit_shop_coupons' ) ) unset( $menus['coupons'] );
  	
  	$menus['orders']['url'] = wcmp_get_vendor_dashboard_endpoint_url( get_wcmp_vendor_settings( 'wcmp_vendor_orders_endpoint', 'vendor', 'general', 'vendor-orders' ) );
  	$menus['settings'] = array(  'label'   => __( 'Settings', $WCFM->text_domain),
																 'url'     => wcmp_get_vendor_dashboard_endpoint_url( get_wcmp_vendor_settings( 'wcmp_store_settings_endpoint', 'vendor', 'general', 'shop-front' ) ),
																 'icon'    => 'gear'
																);
  	
  	return $menus;
  }
  
  // WCMp Add New Product Sub menu
  function wcmarketplace_add_new_product_sub_menu( $has_new ) {
  	if( !current_user_can( 'edit_products' ) ) $has_new = false;
  	return $has_new;
  }
  
  // WCMp Add New Coupon Sub menu
  function wcmarketplace_add_new_coupon_sub_menu( $has_new ) {
  	if( !current_user_can( 'edit_shop_coupons' ) ) $has_new = false;
  	return $has_new;
  }
  
  // WCMp menu
  function wcmarketplace_wcfm_vendor_dashboard_nav( $vendor_nav ) {
  	global $WCFM;
  	
  	// WCMp Dashboard Menu
  	$vendor_nav['dashboard']['url'] = '#';
		$vendor_nav['dashboard']['submenu'] = array(
																								'wcmp-dashboard' => array(
																										'label' => __('WCMp', $WCFM->text_domain)
																										, 'url' => wcmp_get_vendor_dashboard_endpoint_url('dashboard')
																										, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_dashboard_capability', true)
																										, 'position' => 10
																										, 'link_target' => '_self'
																								),
																								'wcfm-dashboard' => array(
																										'label' => __('WCFM', $WCFM->text_domain)
																										, 'url' => get_wcfm_page()
																										, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_dashboard_capability', true)
																										, 'position' => 20
																										, 'link_target' => '_self'
																								)
																						);
  	
  	// WCMp Products Menu
  	if( current_user_can( 'edit_products' ) ) {
  		$vendor_nav['vendor-products']['url'] = '#';
  		$vendor_nav['vendor-products']['submenu'] = array(
																												'add-new-product' => array(
																														'label' => __('Add Product', $WCFM->text_domain)
																														, 'url' => get_wcfm_edit_product_url()
																														, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_add_new_product_capability', 'edit_products')
																														, 'position' => 10
																														, 'link_target' => '_self'
																												),
																												'products' => array(
																														'label' => __('Products', $WCFM->text_domain)
																														, 'url' => get_wcfm_products_url()
																														, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_products_capability', 'edit_products')
																														, 'position' => 20
																														, 'link_target' => '_self'
																												)
																										);
  	} else {
  		unset( $vendor_nav['vendor-products'] );
  	}
  	
  	// WCMp Coupons Menu
  	if( current_user_can( 'edit_shop_coupons' ) ) {
  		$vendor_nav['vendor-promte']['url'] = '#';
  		$vendor_nav['vendor-promte']['submenu']['coupons']['url'] = get_wcfm_coupons_url();
  		$vendor_nav['vendor-promte']['submenu']['add-new-coupon']['url'] = get_wcfm_coupons_manage_url();
  	} else {
  		unset( $vendor_nav['vendor-promte'] );
  	}
  	
  	// WCMp Reports Menu
  	$vendor_nav['vendor-report']['submenu']['wcfm-reports-sales-by-date'] = array(
																																									'label' => __( 'by Date', $WCFM->text_domain )
																																									, 'url' => get_wcfm_reports_url( '', 'wcfm-reports-sales-by-date' )
																																									, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_report_capability', true)
																																									, 'position' => 20
																																									, 'link_target' => '_self'
																																							);
  	$vendor_nav['vendor-report']['submenu']['wcfm-reports-out-of-stock'] = array(
																																									'label' => __( 'Out of stock', $WCFM->text_domain )
																																									, 'url' => get_wcfm_reports_url( '', 'wcfm-reports-out-of-stock' )
																																									, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_report_capability', true)
																																									, 'position' => 50
																																									, 'link_target' => '_self'
																																							);
  	
  	return $vendor_nav;
  }
  
  // WCMp WP-admin view
  function wcmarketplace_allow_wp_admin_view( $allow ) {
  	$allow = false;
  	return $allow;
  }
  
  // WCMp user roles
  function allow_wcmarketplace_vendor_role( $allowed_roles ) {
  	if( wcfm_is_vendor() ) $allowed_roles[] = 'dc_vendor';
  	return $allowed_roles;
  }
  
  // Product args
  function wcmarketplace_products_args( $args ) {
  	if( wcfm_is_vendor() ) $args['author'] = get_current_user_id();
  	return $args;
  }
  
  // Product Types
  function wcmarketplace_is_allow_product_types( $product_types ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('simple') ) unset( $product_types[ 'simple' ] );
  	if( !$WCMp->vendor_caps->vendor_can('variable') ) unset( $product_types[ 'variable' ] );
  	if( !$WCMp->vendor_caps->vendor_can('grouped') ) unset( $product_types[ 'grouped' ] );
  	if( !$WCMp->vendor_caps->vendor_can('external') ) unset( $product_types[ 'external' ] );
  	
  	if( !$WCMp->vendor_caps->vendor_can('attribute') ) unset( $product_types['variable'] );
		return $product_types;
  }
  
  // General Fields
  function wcmarketplace_is_allow_fields_general( $general_fields ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('sku') ) unset( $general_fields['sku'] );
  		
  	return $general_fields;
  }
  
  // Inventory
  function wcmarketplace_is_allow_inventory( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('inventory') ) return false;
  	return $allow;
  }
  
  // Shipping
  function wcmarketplace_is_allow_shipping( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('shipping') ) return false;
  	return $allow;
  }
  
  // Tax
  function wcmarketplace_is_allow_tax( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('taxes') ) return false;
  	return $allow;
  }
  
  // Attributes
  function wcmarketplace_is_allow_attribute( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('attribute') ) return false;
  	return $allow;
  }
  
  // Variable
  function wcmarketplace_is_allow_variable( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('attribute') ) return false;
  	if( !$WCMp->vendor_caps->vendor_can('variable') ) return false;
  	return $allow;
  }
  
  // Linked
  function wcmarketplace_is_allow_linked( $allow ) {
  	global $WCMp;
  	if( !$WCMp->vendor_caps->vendor_can('linked_products') ) return false;
  	return $allow;
  }
  
  // Product Vendor association on Product save
  function wcmarketplace_product_manage_vendor_association( $new_product_id, $wcfm_products_manage_form_data ) {
  	global $WCFM, $WCMp;
  	
  	$vendor_term = get_user_meta( get_current_user_id(), '_vendor_term_id', true );
		$term = get_term( $vendor_term , 'dc_vendor_shop' );
		wp_delete_object_term_relationships( $new_product_id, 'dc_vendor_shop' );
		wp_set_post_terms( $new_product_id, $term->name , 'dc_vendor_shop', true );
  }
  
  // Coupons Args
  function wcmarketplace_coupons_args( $args ) {
  	if( wcfm_is_vendor() ) $args['author'] = get_current_user_id();
  	return $args;
  }
  
  // Coupon Types
  function wcmarketplace_coupon_types( $types ) {
  	$wcmp_coupon_types = array( 'fixed_product' );
  	foreach( $types as $type => $label ) 
  		if( !in_array( $type, $wcmp_coupon_types ) ) unset( $types[$type] );
  	return $types;
  } 
  
  // Report Vendor Filter
  function wcmarketplace_report_out_of_stock_query_from( $query_from, $stock ) {
  	global $WCFM, $wpdb, $_POST;
  	
  	$user_id = get_current_user_id();
  	
  	$query_from = "FROM {$wpdb->posts} as posts
			INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND posts.post_author = {$user_id}
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
			AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'
		";
		
		return $query_from;
  }
  
  // Report Order Data Status
  function wcmarketplace_reports_order_statuses( $order_status ) {
  	$order_status = array( 'completed', 'processing' );
  	return $order_status;
  }
  
  // WCVendor dashboard top seller query
  function wcmarketplace_dashboard_status_widget_top_seller_query( $query ) {
  	global $WCFM, $wpdb, $_POST;
  	
  	$user_id = get_current_user_id();
  	
    $vendor = get_wcmp_vendor($user_id);
    $vendor_products = $vendor->get_products();
  	$products = array(0);
		foreach ($vendor_products as $vendor_product) {
			$products[] = $vendor_product->ID;
			if( $vendor_product->post_type == 'product_variation' ) $products[] = $vendor_product->post_parent;
		}
		if( !empty($products) )
			$query['where'] .= "AND order_item_meta_2.meta_value in (" . implode( ',', $products ) . ")";
  	
  	return $query;
  }
  
  // Report Data Filter as per Vendor
  function wcmarketplace_reports_get_order_report_data( $result ) {
  	global $WCFM, $wpdb, $_POST;
  	
  	$user_id = get_current_user_id();
  	
  	$vendor = get_wcmp_vendor($user_id);
    $vendor_products = $vendor->get_products();
  	$products = array();
		foreach ($vendor_products as $vendor_product) {
			$products[] = $vendor_product->ID;
			if( $vendor_product->post_type == 'product_variation' ) $products[] = $vendor_product->post_parent;
		}
  	
  	if( !empty( $result ) && is_array( $result ) ) {
  		foreach( $result as $result_key => $result_val ) {
  			if( !in_array( $result_val->product_id, $products ) ) unset( $result[$result_key] );
  		}
  	}
  	
  	return $result;
  }
}