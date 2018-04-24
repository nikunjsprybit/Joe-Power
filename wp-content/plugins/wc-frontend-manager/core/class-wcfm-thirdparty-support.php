<?php
/**
 * WCFM plugin core
 *
 * Third Party Plugin Support Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   2.2.2
 */
 
class WCFM_ThirdParty_Support {

	public function __construct() {
		global $WCFM;
		
		// Product Manage Third Party Plugins View
    add_action( 'end_wcfm_products_manage', array( &$this, 'wcfm_thirdparty_products_manage_views' ), 100 );
    
    // WCFM Menu Filter
    add_filter( 'wcfm_menus', array( &$this, 'wcfm_thirdparty_menus' ), 100 );
	}
	
	/**
   * Product Manage Third Party Plugins views
   */
  function wcfm_thirdparty_products_manage_views( ) {
		global $WCFM;
	  
	 require_once( $WCFM->library->views_path . 'wcfm-view-thirdparty-products-manage.php' );
	}
	
	/**
	 * WCFM Third Party Plugins Menus
	 */
	function wcfm_thirdparty_menus( $menus ) {
  	global $WCFM;
  	
  	// WP Job Manager Menu Item
  	if ( WCFM_Dependencies::wcfm_wp_job_manager_plugin_active_check() ) {
  		$wcfm_options = get_option( 'wcfm_options' );
  		$wc_frontend_manager_associate_listings = ( isset( $wcfm_options['wc_frontend_manager_associate_listings'] ) ) ? $wcfm_options['wc_frontend_manager_associate_listings'] : 'no';
  		if( !wcfm_is_vendor() || ( wcfm_is_vendor() && 'yes' == $wc_frontend_manager_associate_listings ) ) {
				$jobs_dashboard = get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) );
				$post_a_job = get_permalink ( get_option( 'job_manager_submit_job_form_page_id' ) );
				$menus = array_slice($menus, 0, 3, true) +
														array( 'listings' => array(  'label'  => __( 'Listings', $WCFM->text_domain ),
																										 'url'     => $jobs_dashboard,
																										 'icon'    => 'university',
																										 'has_new'    => true,
																										 'new_class'  => 'wcfm_sub_menu_items_listings_manage',
																										 'new_url'    => $post_a_job,
																										) )	 +
															array_slice($menus, 3, count($menus) - 3, true) ;
			}
		}
		
  	return $menus;
  }
	
}