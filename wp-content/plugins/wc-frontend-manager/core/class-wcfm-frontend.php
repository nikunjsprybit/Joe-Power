<?php

/**
 * WCFM Frontend Class
 *
 * @version		1.0.0
 * @package		wcfm/core
 * @author 		WC Lovers
 */
class WCFM_Frontend {
	
 	public function __construct() {
 		add_filter( 'the_title', array( &$this, 'wcfm_page_endpoint_title' ) );
 		
 		// Check User Authentication to Access WCFM Pages
 		add_action( 'template_redirect', array(&$this, 'wcfm_template_redirect' ));
 		
 		// WCFM Icon at Shop
 		add_action( 'woocommerce_before_shop_loop', array( &$this, 'wcfm_home' ), 5 );
 		add_action( 'woocommerce_after_shop_loop', array( &$this, 'wcfm_home' ), 5 );
 		
 		// Product Manage from Archive Pages
 		add_action( 'woocommerce_before_shop_loop_item', array(&$this, 'wcfm_product_manage'), 5 );
		add_action( 'woocommerce_before_single_product_summary', array(&$this, 'wcfm_product_manage'), 5 );
		
		// Grid Plus Fix
    add_filter( 'mce_external_plugins', array($this, 'wcfm_grid_custom_editor_register_tinymce_javascript'), 100 );
		
		//enqueue scripts
		add_action('wp_enqueue_scripts', array(&$this, 'wcfm_scripts'));
		//enqueue styles
		add_action('wp_enqueue_scripts', array(&$this, 'wcfm_styles'));
		
 	}
 	
 	/**
	 * Replace a page title with the endpoint title.
	 * @param  string $title
	 * @return string
	 */
	function wcfm_page_endpoint_title( $title ) {
		global $WCFM, $WCFM_Query, $wp_query;
	
		if ( ! is_null( $wp_query ) && ! is_admin() && is_main_query() && in_the_loop() && is_page() && is_wcfm_endpoint_url() ) {
			$endpoint = $WCFM_Query->get_current_endpoint();
	
			if ( $endpoint_title = $WCFM_Query->get_endpoint_title( $endpoint ) ) {
				$title = $endpoint_title;
			}
	
			remove_filter( 'the_title', array( &$this, 'wcfm_page_endpoint_title' ) );
		}
	
		return $title;
	}
	
	/**
	 * Template redirect function
	 * @return void
	*/
	function wcfm_template_redirect() {
		global $WCFM;
		
		// If user not loggedin then reirect to Home page
		if( !is_user_logged_in() && is_wcfm_page() ) {
      wp_safe_redirect( get_site_url() );
      exit();
    }
    
    // If user loggedin but not admin or shop manager then reirect to MyAccount page
		if( is_user_logged_in() && is_wcfm_page() ) {
			$user = wp_get_current_user();
			$allowed_roles = apply_filters( 'wcfm_allwoed_user_rols',  array( 'administrator', 'shop_manager' ) );
			if ( !array_intersect( $allowed_roles, (array) $user->roles ) )  {
				wp_safe_redirect(  get_permalink( wc_get_page_id( 'myaccount' ) ) );
				exit();
			}
		}
	}
	
	/**
	 * WCFM Home at Archive Pages
	 */
	function wcfm_home() {
 		global $WCFM;
 		
 		if( !is_user_logged_in() ) return;
		$user = wp_get_current_user();
		$allowed_roles = apply_filters( 'wcfm_allwoed_user_rols',  array( 'administrator', 'shop_manager' ) );
		if ( !array_intersect( $allowed_roles, (array) $user->roles ) )  return;
		
 		echo '<a href="' . get_wcfm_page() . '"><img class="text_tip" data-tip="' . __( 'WCFM Home', $WCFM->text_domain ) . '" id="wcfm_home" src="' . $WCFM->plugin_url . '/assets/images/wcfm-30x30.png" alt="' . __( 'WCFM Home', $WCFM->text_domain ) . '" /></a>';
 	}
	
	/**
	 * WCFM Product Manage from Archive Pages
	 */
	function wcfm_product_manage() {
		global $WCFM, $post, $woocommerce_loop;

		if( !is_user_logged_in() ) return;
		$user = wp_get_current_user();
		$allowed_roles = apply_filters( 'wcfm_allwoed_user_rols',  array( 'administrator', 'shop_manager' ) );
		if ( !array_intersect( $allowed_roles, (array) $user->roles ) )  return;
				
		if( wcfm_is_vendor() && ( get_current_user_id() != $post->post_author ) ) return;
		
		$pro_id = $post->ID;
		$_product = wc_get_product($pro_id);
		
		?>
		<!-- <div class="wcfm_buttons"> -->
		  <?php //do_action( 'wcfm_product_manage', $pro_id, $_product ); ?>
		  <?php /*if( current_user_can( 'edit_published_products' ) ) { ?>
				<a class="wcfm_button" href="<?php echo get_wcfm_edit_product_url( $pro_id, $_product ); ?>"> <span class="wcicon-edit text_tip" data-tip="<?php echo esc_attr__( 'Edit', $WCFM->text_domain ); ?>"></span> </a>
		  <?php } ?>
		  <?php if( current_user_can( 'delete_published_products' ) ) { ?>
		  	<span class="wcfm_button_separator">|</span>
		  	<a class="wcfm_button wcfm_delete_product" href="#" data-proid="<?php echo $pro_id; ?>"><span class="wcicon-status-cancelled text_tip" data-tip="<?php echo esc_attr__( 'Delete', $WCFM->text_domain ); ?>"></span> </a>
		  <?php }*/ ?>
		<!-- </div> -->
		<?php
		
	}
	
	/**
	 * Grid Plus Tinymc Editor issue fixed
	 */
	function wcfm_grid_custom_editor_register_tinymce_javascript( $plugin_array ) {
		unset( $plugin_array['grid_custom_editor'] );
		return $plugin_array;
	}
	
	/**
	 * WCFM Core JS
	 */
	function wcfm_scripts() {
 		global $WCFM;
 		
 		// Libs
	  $WCFM->library->load_qtip_lib();
 		
 		// Core JS
	  wp_enqueue_script( 'wcfm_core_js', $WCFM->library->js_lib_url . 'wcfm-script-core.js', array('jquery'), $WCFM->version, true );
	  
	  // Localize Script
	  wp_localize_script( 'wcfm_core_js', 'wcfm_messages', array( 'shop_url' => get_permalink( wc_get_page_id( 'shop' ) ) ) );
 	}
 	
 	/**
 	 * WCFM Core CSS
 	 */
 	function wcfm_styles() {
 		global $WCFM;
 		
 		// WC Icon set
	  wp_enqueue_style( 'wcfm_wc_icon_css',  $WCFM->library->css_lib_url . 'wcfm-style-icon.css', array(), $WCFM->version );
	  
	  // Font Awasome Icon set
	  wp_enqueue_style( 'wcfm_fa_icon_css',  $WCFM->plugin_url . 'assets/fonts/font-awesome/css/font-awesome.min.css', array(), $WCFM->version );
	  
	  // Admin Bar CSS
	  wp_enqueue_style( 'wcfm_admin_bar_css',  $WCFM->library->css_lib_url . 'wcfm-style-adminbar.css', array(), $WCFM->version );
	  
	  // WCFM Core CSS
	  wp_enqueue_style( 'wcfm_core_css',  $WCFM->library->css_lib_url . 'wcfm-style-core.css', array(), $WCFM->version );
 	}
 	
}