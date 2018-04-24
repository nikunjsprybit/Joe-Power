<?php

/**
 * WCFM plugin core
 *
 * Plugin intiate
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   1.0.0
 */
 
class WCFM {

	public $plugin_url;
	public $plugin_path;
	public $version;
	public $token;
	public $text_domain;
	public $wcfm_query;
	public $library;
	public $shortcode;
	public $admin;
	public $frontend;
	public $ajax;
	public $non_ajax;
	private $file;
	public $wcfm_fields;
	public $is_marketplece;
	public $wcfm_marketplace;
	public $wcfm_vendor_support;
	public $wcfm_wcbooking;
	public $wcfm_wccsubscriptions;
	public $wcfm_thirdparty_support;

	public function __construct($file) {

			$this->file = $file;
			$this->plugin_base_name = plugin_basename( $file );
			$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
			$this->plugin_path = trailingslashit(dirname($file));
			$this->token = WCFM_TOKEN;
			$this->text_domain = WCFM_TEXT_DOMAIN;
			$this->version = WCFM_VERSION;
			
			// Updation Hook
			add_action( 'init', array( &$this, 'update_wcfm' ) );

			add_action( 'init', array(&$this, 'init' ) );
			
			// WC Vendors shop_order_vendor - register post type fix - since 2.0.4
			add_filter( 'woocommerce_register_post_type_shop_order_vendor', array( &$this, 'wcvendors_register_post_type_shop_order_vendor' ) );
	}
	
	/**
	 * initilize plugin on WP init
	 */
	function init() {
			global $WCFM;
			
			// Init Text Domain
			$this->load_plugin_textdomain();
			
			if( ( version_compare( WC_VERSION, '3.0', '<' ) ) ) {
				add_action( 'admin_notices', 'wcfm_woocommerce_version_notice' );
				return;
			}

			// Installation check
			if( !get_option( 'wcfm_updated_2_2_2' ) ) {
				require_once ( $WCFM->plugin_path . 'helpers/class-wcfm-install.php' );
				$WCFM_Install = new WCFM_Install();
	
				delete_option( 'wcfm_updated_2_0_1' );
				update_option( 'wcfm_updated_2_2_2', 1 );
			}
			
			// Check Marketplace
			$this->is_marketplece = wcfm_is_marketplace();
			if( $this->is_marketplece ) {
				$this->load_class( 'vendor-support' );
			  $this->wcfm_vendor_support = new WCFM_Vendor_Support();
			}
			
			if (!is_admin() || defined('DOING_AJAX')) {
				if( $this->is_marketplece ) {
					if( wcfm_is_vendor()) {
						$this->load_class( $this->is_marketplece );
						if( $this->is_marketplece == 'wcvendors' ) $this->wcfm_marketplace = new WCFM_WCVendors();
						elseif( $this->is_marketplece == 'wcmarketplace' ) $this->wcfm_marketplace = new WCFM_WCMarketplace();
						elseif( $this->is_marketplece == 'wcpvendors' ) $this->wcfm_marketplace = new WCFM_WCPVendors();
					}
				}
			}  
			
			// Check WC Booking
			if( wcfm_is_booking() ) {
				$this->load_class('wcbookings');
				$this->wcfm_wcbooking = new WCFM_WCBookings();
			}
			
			// Check WC Subscription
			if( wcfm_is_subscription() ) {
				$this->load_class('wcsubscriptions');
				$this->wcfm_wcsubscriptions = new WCFM_WCSubscriptions();
			}
			
			// Init library
			$this->load_class( 'library' );
			$this->library = new WCFM_Library();

			// Init ajax
			if ( defined('DOING_AJAX') ) {
				$this->load_class( 'ajax' );
				$this->ajax = new WCFM_Ajax();
			}

			if ( is_admin() ) {
				$this->load_class( 'admin' );
				$this->admin = new WCFM_Admin();
			}

			if ( !is_admin() || defined('DOING_AJAX') ) {
				$this->load_class( 'frontend' );
				$this->frontend = new WCFM_Frontend();
			}
			
			if ( !is_admin() || defined('DOING_AJAX') ) {
				$this->load_class( 'thirdparty-support' );
				$this->wcfm_thirdparty_support = new WCFM_ThirdParty_Support();
			}
			
			if( !defined('DOING_AJAX') ) {
				$this->load_class( 'non-ajax' );
				$this->non_ajax = new WCFM_Non_Ajax();
			}

			// init shortcode
			$this->load_class( 'shortcode' );
			$this->shortcode = new WCFM_Shortcode();
			
			// WCFM Fields Lib
      $this->wcfm_fields = $this->library->load_wcfm_fields();
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present
	 *
	 * @access public
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters('plugin_locale', get_locale(), $this->token);

		load_textdomain($this->text_domain, WP_LANG_DIR . "/wc-frontend-manager/wc-frontend-manager-$locale.mo");
		load_textdomain($this->text_domain, $this->plugin_path . "/lang/wc-frontend-manager-$locale.mo");
	}

	public function load_class($class_name = '') {
		if ('' != $class_name && '' != $this->token) {
			require_once ('class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}

	// End load_class()
	
	// WCV Shop Vendor 
	function wcvendors_register_post_type_shop_order_vendor( $shop_order_vendor ) {
		$shop_order_vendor['exclude_from_order_reports'] = true;
		return $shop_order_vendor;
	}

	/**
	 * Install upon activation.
	 *
	 * @access public
	 * @return void
	 */
	static function activate_wcfm() {
		global $WCFM;

		require_once ( $WCFM->plugin_path . 'helpers/class-wcfm-install.php' );
		$WCFM_Install = new WCFM_Install();

		update_option('wcfm_installed', 1);
	}
	
	/**
	 * Check upon update.
	 *
	 * @access public
	 * @return void
	 */
	static function update_wcfm() {
		global $WCFM, $WCFM_Query;

		if( !get_option( 'wcfm_updated_2_2_2' ) ) {
			require_once ( $WCFM->plugin_path . 'helpers/class-wcfm-install.php' );
			$WCFM_Install = new WCFM_Install();
			
			// Init WCFM Custom CSS file
			$WCFM->wcfm_create_custom_css();

			delete_option( 'wcfm_updated_2_1_2' );
			update_option( 'wcfm_updated_2_2_2', 1 );
		}
	}

	/**

	 * UnInstall upon deactivation.
	 *
	 * @access public
	 * @return void
	 */
	static function deactivate_wcfm() {
		global $WCFM;
		delete_option('wcfm_installed');
	}
	
	function get_wcfm_menus() {
		global $WCFM;
		$wcfm_menus = apply_filters( 'wcfm_menus',
				array( 'products' => array( 'label' 			=>  __( 'My Equipments', $WCFM->text_domain),
																		 'url'        =>  wpestate_get_dashboard_link(),
																		 'icon'       =>  'cubes',
																		 'has_new'    =>  true,
																		 'new_class'  =>  'wcfm_sub_menu_items_product_manage',
																		 'new_url'    =>  wpestate_get_dasboard_add_listing(),
																		 'capability' =>  'edit_products'
																	 ),
								'coupons' => array(  'label'      => __( 'Coupons', $WCFM->text_domain),
																		 'url'        => wpestate_get_my_reservation_link(),
																		 'icon'       => 'gift',
																		 'has_new'    => true,
																		 'new_class'  => 'wcfm_sub_menu_items_coupon_manage',
																		 'new_url'    => get_inbox_wpestate_booking(),
																		 'capability' => 'edit_shop_coupons'
																		),
								'orders' => array(  'label'       => __( 'Orders', $WCFM->text_domain),
																		 'url'        => wpestate_get_my_bookings_link(),
																		 'icon'       => 'shopping-cart'
																		),
								'store' => array( 'label'      		=> __( 'store', $WCFM->text_domain),
																		 'url'        => 'javascript:void(0)',
																		 'icon'       => 'cogs'
																		),
								'shop-front' => array( 'label' => __('Shop Front', $WCMp->text_domain)
                        												, 'url' => wpestate_shop_link()
                        												, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_shop_front_capability', true)
                       													, 'position' => 10
                     													, 'link_target' => '_self'
                     													
                   													 ),
								'vendor-billing' => array('label' => __('Billing', $WCMp->text_domain)
                       													, 'url' => wpestate_billing_link()
                       													, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_billing_capability', true)
                       													, 'position' => 30
                        												, 'link_target' => '_self'
                        											
                   													 ),
								'Payments' => array( 'label'      		=> __( 'Payments', $WCFM->text_domain),
																		 'url'        => 'javascript:void(0)',
																		 'icon'       => 'cogs'
																		),

								'vendor-withdrawal' => array('label' => __('Withdrawal', $WCMp->text_domain)
                       													, 'url' => wpestate_withdrawal_link()
                        												, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_vendor_withdrawal_capability', false)
                        												, 'position' => 10
                       													, 'link_target' => '_self'
                       													
                   													 ),
                   				'transaction-details' => array('label' => __('History', $WCMp->text_domain)
                        												, 'url' => wpestate_history_link()
                        												, 'capability' => apply_filters('wcmp_vendor_dashboard_menu_transaction_details_capability', true)
                        												, 'position' => 20
                       													, 'link_target' => '_self'
                       													
                   													 ),
								'reports' => array(  'label'      => __( 'Reports', $WCFM->text_domain),
																		 'url'        => wpestate_get_dashboard_favorites(),
																		 'icon'       => 'pie-chart'
																		),
								'settings' => array( 'label'      => __( 'Settings', $WCFM->text_domain),
																		 'url'        => get_invoices_wpestate(),
																		 'icon'       => 'cogs'
																		)


				)
);


		return $wcfm_menus;
	}
	
	function wcfm_color_setting_options() {
		global $WCFM;
		
		$color_options = apply_filters( 'wcfm_color_setting_options', array( 'wcfm_field_menu_bg_color' => array( 'label' => __( 'Menu Background Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_menu_bg_color_settings', 'default' => '#cccccc', 'element' => '#wcfm_menu', 'style' => 'background' ),
																																				 'wcfm_field_menu_icon_bg_color' => array( 'label' => __( 'Menu Item Background', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_menu_icon_bg_color_settings', 'default' => '#f7f7f7', 'element' => '#wcfm_menu .wcfm_menu_items a.wcfm_menu_item, #wcfm_menu span.wcfm_sub_menu_items', 'style' => 'background' ),
																																				 'wcfm_field_menu_icon_color' => array( 'label' => __( 'Menu Item Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_menu_icon_color_settings', 'default' => '#555', 'element' => '#wcfm_menu .wcfm_menu_item span, #wcfm_menu span.wcfm_sub_menu_items a', 'style' => 'color' ),
																																				 'wcfm_field_menu_icon_active_bg_color' => array( 'label' => __( 'Menu Active Item Background', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_menu_icon_active_bg_color_settings', 'default' => '#00897b', 'element' => '#wcfm_menu .wcfm_menu_items a.active', 'style' => 'background' ),
																																				 'wcfm_field_menu_icon_active_color' => array( 'label' => __( 'Menu Active Item Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_menu_icon_active_color_settings', 'default' => '#fff', 'element' => '#wcfm_menu .wcfm_menu_items a.active span', 'style' => 'color' ),
																																				 'wcfm_field_primary_bg_color' => array( 'label' => __( 'Primary Background Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_primary_bg_color_settings', 'default' => '#cccccc', 'element' => '.page_collapsible, .collapse-close', 'style' => 'background' ),
																																				 'wcfm_field_primary_font_color' => array( 'label' => __( 'Primary Font Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_primary_font_color_settings', 'default' => '#000000', 'element' => '.page_collapsible, .collapse-close', 'style' => 'color' ),
																																				 'wcfm_field_secondary_bg_color' => array( 'label' => __( 'Secondary Background Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_secondary_bg_color_settings', 'default' => '#000000', 'element' => '.collapse-open', 'style' => 'background' ),
																																				 'wcfm_field_secondary_font_color' => array( 'label' => __( 'Secondary Font Color', $WCFM->text_domain ), 'name' => 'wc_frontend_manager_secondary_font_color_settings', 'default' => '#ffffff', 'element' => '.collapse-open', 'style' => 'color' ),
																																			) );
		
		return $color_options;
	}
	
	/**
	 * Create WCFM custom CSS
	 */
	function wcfm_create_custom_css() {
		global $WCFM;
		
		$wcfm_options = get_option('wcfm_options');
		$color_options = $WCFM->wcfm_color_setting_options();
		$custom_color_data = '';
		foreach( $color_options as $color_option_key => $color_option ) {
		  $custom_color_data .= $color_option['element'] . '{ ' . "\n";
			$custom_color_data .= "\t" . $color_option['style'] . ': ';
			if( isset( $wcfm_options[ $color_option['name'] ] ) ) { $custom_color_data .= $wcfm_options[ $color_option['name'] ]; } else { $custom_color_data .= $color_option['default']; }
			$custom_color_data .= ';' . "\n";
			$custom_color_data .= '}' . "\n\n";
		}
		
		$upload_dir      = wp_upload_dir();

		$files = array(
			array(
				'base' 		=> $upload_dir['basedir'] . '/wcfm',
				'file' 		=> 'wcfm-style-custom-' . time() . '.css',
				'content' 	=> $custom_color_data,
			)
		);

		$wcfm_style_custom = get_option( 'wcfm_style_custom' );
		if( file_exists( trailingslashit( $upload_dir['basedir'] ) . '/wcfm/' . $wcfm_style_custom ) ) {
			unlink( trailingslashit( $upload_dir['basedir'] ) . '/wcfm/' . $wcfm_style_custom );
		}
		
		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file['base'] ) ) {
				if ( $file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ) ) {
					$wcfm_style_custom = $file['file'];
					update_option( 'wcfm_style_custom', $file['file'] );
					fwrite( $file_handle, $file['content'] );
					fclose( $file_handle );
				}
			}
		}
		return $wcfm_style_custom;
	}
	
	/** Cache Helpers ******************************************************** */

	/**
	 * Sets a constant preventing some caching plugins from caching a page. Used on dynamic pages
	 *
	 * @access public
	 * @return void
	 */
	function nocache() {
			if (!defined('DONOTCACHEPAGE'))
					define("DONOTCACHEPAGE", "true");
			// WP Super Cache constant
	}

}