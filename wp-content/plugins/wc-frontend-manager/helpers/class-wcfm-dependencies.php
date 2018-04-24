<?php
/**
 * WC Dependency Checker
 *
 */
class WCFM_Dependencies {
	
	private static $active_plugins;
	
	static function init() {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() )
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}
	
	static function woocommerce_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce/woocommerce.php', self::$active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', self::$active_plugins );
		return false;
	}
	
	// WC Frontend Manager Ultimate
	static function wcfmu_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php', self::$active_plugins ) || array_key_exists( 'wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php', self::$active_plugins );
		return false;
	}
	
	// WC Bookings
	static function wcfm_bookings_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce-bookings/woocommerce-bookings.php', self::$active_plugins ) || array_key_exists( 'woocommerce-bookings/woocommerce-bookings.php', self::$active_plugins );
		return false;
	}
	
	// WC Subscriptions
	static function wcfm_subscriptions_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', self::$active_plugins ) || array_key_exists( 'woocommerce-subscriptions/woocommerce-subscriptions.php', self::$active_plugins );
		return false;
	}
	
	// Yoast SEO
	static function wcfm_yoast_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'wordpress-seo/wp-seo.php', self::$active_plugins ) || array_key_exists( 'wordpress-seo/wp-seo.php', self::$active_plugins );
		return false;
	}
	
	// WooCommerce Custom Product Tabs Lite
	static function wcfm_wc_tabs_lite_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce-custom-product-tabs-lite/woocommerce-custom-product-tabs-lite.php', self::$active_plugins ) || array_key_exists( 'woocommerce-custom-product-tabs-lite/woocommerce-custom-product-tabs-lite.php', self::$active_plugins );
		return false;
	}
	
	// WooCommerce Barcode & ISBN
	static function wcfm_wc_barcode_isbn_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce-barcode-isbn/AG-barcode-ISBN.php', self::$active_plugins ) || array_key_exists( 'woocommerce-barcode-isbn/AG-barcode-ISBN.php', self::$active_plugins );
		return false;
	}
	
	// WooCommerce MSRP Pricing
	static function wcfm_wc_msrp_pricing_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'woocommerce-msrp-pricing/woocommerce-msrp.php', self::$active_plugins ) || array_key_exists( 'woocommerce-msrp-pricing/woocommerce-msrp.php', self::$active_plugins );
		return false;
	}
	
	// Quantities and Units for WooCommerce
	static function wcfm_wc_quantities_units_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'quantities-and-units-for-woocommerce/quantites-and-units.php', self::$active_plugins ) || array_key_exists( 'quantities-and-units-for-woocommerce/quantites-and-units.php', self::$active_plugins );
		return false;
	}
	
	// WP Job Manager
	static function wcfm_wp_job_manager_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'wp-job-manager/wp-job-manager.php', self::$active_plugins ) || array_key_exists( 'wp-job-manager/wp-job-manager.php', self::$active_plugins );
		return false;
	}
}