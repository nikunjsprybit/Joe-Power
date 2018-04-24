<?php
/**
 * WCFM plugin shortcode
 *
 * Plugin Shortcode output
 *
 * @author 		WC Lovers
 * @package 	wcfm/includes/shortcode
 * @version   1.0.0
 */
 
class WCFM_Frontend_Manager_Shortcode {

	public function __construct() {

	}

	/**
	 * Output the WC Frontend Manager shortcode.
	 *
	 * @access public
	 * @param array $atts
	 * @return void
	 */
	static public function output( $attr ) {
		global $WCFM, $wp;
		$WCFM->nocache();
		
		echo '<div id="wcfm-main-contentainer"> <div id="wcfm-content">';
		
		if ( isset( $wp->query_vars['wc-products'] ) || isset( $wp->query_vars['wcfm-products'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-products' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-products' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-products' );
			
		} elseif ( isset( $wp->query_vars['wcfm-products-manage'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-products-manage' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-products-manage' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-products-manage' );
			
		} elseif ( isset( $wp->query_vars['wcfm-coupons'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-coupons' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-coupons' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-coupons' );
			
		} elseif ( isset( $wp->query_vars['wcfm-coupons-manage'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-coupons-manage' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-coupons-manage' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-coupons-manage' );
			
		} elseif ( isset( $wp->query_vars['wcfm-orders'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-orders' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-orders' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-orders' );
			
		} elseif ( isset( $wp->query_vars['wcfm-orders-details'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-orders-details' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-orders-details' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-orders-details' );
			
		} elseif ( isset( $wp->query_vars['wcfm-bookings'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-bookings' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-bookings' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-bookings' );
			
		} elseif ( isset( $wp->query_vars['wcfm-bookings-details'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-bookings-details' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-bookings-details' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-bookings-details' );
			
		} elseif ( isset( $wp->query_vars['wcfm-reports-sales-by-date'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-reports-sales-by-date' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-reports-sales-by-date' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-reports-sales-by-date' );
			
		} elseif ( isset( $wp->query_vars['wcfm-reports-out-of-stock'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-reports-out-of-stock' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-reports-out-of-stock' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-reports-out-of-stock' );
			
		} elseif( isset( $wp->query_vars['wcfm-reports-sales-by-product'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-reports-sales-by-product' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-reports-sales-by-product' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-reports-sales-by-product' );
			
		} elseif( isset( $wp->query_vars['wcfm-reports-coupons-by-date'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-reports-coupons-by-date' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-reports-coupons-by-date' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-reports-coupons-by-date' );
			
		} elseif( isset( $wp->query_vars['wcfm-reports-low-in-stock'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-reports-low-in-stock' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-reports-low-in-stock' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-reports-low-in-stock' );
			
		} elseif ( isset( $wp->query_vars['wcfm-settings'] ) ) {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-settings' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-settings' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-settings' );
			
		} else {
			
			// Load Scripts
			$WCFM->library->load_scripts( 'wcfm-dashboard' );
			
			// Load Styles
			$WCFM->library->load_styles( 'wcfm-dashboard' );
			
			// Load View
			$WCFM->library->load_views( 'wcfm-dashboard' );
		}
		
		echo '</div></div>';
	}
}
