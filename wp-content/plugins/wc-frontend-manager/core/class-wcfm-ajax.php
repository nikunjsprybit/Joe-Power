<?php
/**
 * WCFM plugin core
 *
 * Plugin Ajax Controler
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   1.0.0
 */
class WCFM_Ajax {
	
	public $controllers_path;

	public function __construct() {
		global $WCFM;
		
		$this->controllers_path = $WCFM->plugin_path . 'controllers/';
		
		add_action( 'wp_ajax_wcfm_ajax_controller', array( &$this, 'wcfm_ajax_controller' ) );
		add_action( 'wp_ajax_nopriv_wcfm_ajax_controller', array( &$this, 'wcfm_ajax_controller' ) );
		
		// Generate Variation Attributes
		add_action('wp_ajax_wcfm_generate_variation_attributes', array( &$this, 'wcfm_generate_variation_attributes' ) );
		add_action('wp_ajax_nopriv_wcfm_generate_variation_attributes', array( &$this, 'wcfm_generate_variation_attributes' ) );
		
		// Product Delete
		add_action( 'wp_ajax_delete_wcfm_product', array( &$this, 'delete_wcfm_product' ) );
		add_action( 'wp_ajax_nopriv_delete_wcfm_product', array( &$this, 'delete_wcfm_product' ) );
		add_action( 'wp_ajax_nopriv_wcfupload', [$this, 'wcfupload'] );
		add_action( 'wp_ajax_wcfupload', [$this, 'wcfupload'] );
	}
	
	function wcfupload(){
		
		// check to make sure its a successful upload
		if ($_FILES['files']['error'] !== UPLOAD_ERR_OK) __return_false();

		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');

		$files 			= 	$_FILES["files"];
		$pro_id 		= 	0;
		if(isset($_POST["pro_id"])){
			$pro_id = $_POST["pro_id"];
		}
		if(isset($_POST["featuredimages"])){
			$featuredimages 	= 	$_POST["featuredimages"];
		}
		$attachement_ids	=	[];
		foreach ($files['name'] as $key => $value) {
			if ($files['name'][$key]) {
				$file = array(
					'name' => $files['name'][$key],
					'type' => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error' => $files['error'][$key],
					'size' => $files['size'][$key]
				);
				$_FILES = array("upload_file" => $file);
				$attachment_id = media_handle_upload("upload_file", 0);
				if (is_wp_error($attachment_id)) {
					
					$error 		=	true;
					$success 	=	false;
				} else {
					$error 		=	false;
					$success 	=	true;
					$attachement_ids[]	=	array('id'=>$attachment_id,'image'=>wp_get_attachment_url($attachment_id));
					$featuredimages[]	=	$attachment_id;
				}
			}
		}
		if($pro_id!=0){
			$product 		= 	wc_get_product( $pro_id );
			$featured_img 	= 	($product->get_image_id()) ? $product->get_image_id() : '';
			
			if (($key = array_search($featured_img, $featuredimages)) !== false) {
				unset($featuredimages[$key]);
			}
			update_post_meta($pro_id, '_product_image_gallery', implode(",", $featuredimages));
		}
		echo json_encode(array('success'=>$success,'error'=>$error, 'attachement_ids'=>$attachement_ids));
		wp_die();
	}
  
	public function wcfm_ajax_controller() {
  	global $WCFM;
  	
  	do_action( 'after_wcfm_ajax_controller' );
  	
  	$controller = '';
  	if( isset( $_POST['controller'] ) ) {
  		$controller = $_POST['controller'];
  		
  		switch( $controller ) {
	  	
				case 'wc-products':
				case 'wcfm-products':
					require_once( $this->controllers_path . 'wcfm-controller-products.php' );
					new WCFM_Products_Controller();
			  break;
			  
			  case 'wcfm-products-manage':
			  	if( wcfm_is_booking() ) {
						require_once( $this->controllers_path . 'wcfm-controller-wcbookings-products-manage.php' );
						new WCFM_WCBookings_Products_Manage_Controller();
					}
					// Third Party Plugin Support
					require_once( $this->controllers_path . 'wcfm-controller-thirdparty-products-manage.php' );
					new WCFM_ThirdParty_Products_Manage_Controller();
					
					require_once( $this->controllers_path . 'wcfm-controller-products-manage.php' );
					new WCFM_Products_Manage_Controller();
					
			  break;
					
			  case 'wcfm-coupons':
					require_once( $this->controllers_path . 'wcfm-controller-coupons.php' );
					new WCFM_Coupons_Controller();
				break;
				
				case 'wcfm-coupons-manage':
					require_once( $this->controllers_path . 'wcfm-controller-coupons-manage.php' );
					new WCFM_Coupons_Manage_Controller();
				break;
				
				case 'wcfm-orders':
					if( $WCFM->is_marketplece && wcfm_is_vendor() ) {
						require_once( $this->controllers_path . 'wcfm-controller-' . $WCFM->is_marketplece . '-orders.php' );
						if( $WCFM->is_marketplece == 'wcvendors' ) new WCFM_Orders_WCVendors_Controller();
						elseif( $WCFM->is_marketplece == 'wcpvendors' ) new WCFM_Orders_WCPVendors_Controller();
					} else {
						require_once( $this->controllers_path . 'wcfm-controller-orders.php' );
						new WCFM_Orders_Controller();
					}
				break;
				
				case 'wcfm-reports-out-of-stock':
					require_once( $this->controllers_path . 'wcfm-controller-reports-out-of-stock.php' );
					new WCFM_Reports_Out_Of_Stock_Controller();
				break;
					
				case 'wcfm-settings':
					if( $WCFM->is_marketplece && wcfm_is_vendor() ) {
						require_once( $this->controllers_path . 'wcfm-controller-' . $WCFM->is_marketplece . '-settings.php' );
						if( $WCFM->is_marketplece == 'wcvendors' ) new WCFM_Settings_WCVendors_Controller();
						elseif( $WCFM->is_marketplece == 'wcpvendors' ) new WCFM_Settings_WCPVendors_Controller();
					} else {
						require_once( $this->controllers_path . 'wcfm-controller-settings.php' );
						new WCFM_Settings_Controller();
					}
				break;
			}
  	}
  	
  	do_action( 'before_wcfm_ajax_controller' );
  	die();
  }
  
  public function wcfm_generate_variation_attributes() {
		global $wpdb, $WCFM;
	  
	  $wcfm_products_manage_form_data = array();
	  parse_str($_POST['wcfm_products_manage_form'], $wcfm_products_manage_form_data);

	  // print_r($wcfm_products_manage_form_data);

	  // die();
	  
	  if(isset($wcfm_products_manage_form_data['attributes']) && !empty($wcfm_products_manage_form_data['attributes'])) {
			$pro_attributes = '{';
			$attr_first = true;
			foreach($wcfm_products_manage_form_data['attributes'] as $attributes) {
				// if(isset($attributes['is_variation'])) {
					if(!empty($attributes['name']) && !empty($attributes['value'])) {
						if(!$attr_first) $pro_attributes .= ',';
						if($attr_first) $attr_first = false;
						
						if($attributes['is_taxonomy']) {
							$pro_attributes .= '"' . $attributes['tax_name'] . '": {';
							if( !is_array($attributes['value']) ) {
								$att_values = explode("|", $attributes['value']);
								$is_first = true;
								foreach($att_values as $att_value) {
									if(!$is_first) $pro_attributes .= ',';
									if($is_first) $is_first = false;
									$pro_attributes .= '"' . sanitize_title($att_value) . '": "' . trim($att_value) . '"';
								}
							} else {
								$att_values = $attributes['value'];
								$is_first = true;
								foreach($att_values as $att_value) {
									if(!$is_first) $pro_attributes .= ',';
									if($is_first) $is_first = false;
									$att_term = get_term( absint($att_value) );
									if( $att_term ) {
										$pro_attributes .= '"' . $att_term->slug . '": "' . $att_term->name . '"';
									} else {
										$pro_attributes .= '"' . sanitize_title($att_value) . '": "' . trim($att_value) . '"';
									}
								}
							}
							$pro_attributes .= '}';
						} else {
							$pro_attributes .= '"' . $attributes['name'] . '": {';
							$att_values = explode("|", $attributes['value']);
							$is_first = true;
							foreach($att_values as $att_value) {
								if(!$is_first) $pro_attributes .= ',';
								if($is_first) $is_first = false;
								$pro_attributes .= '"' . trim($att_value) . '": "' . trim($att_value) . '"';
							}
							$pro_attributes .= '}';
						}
					}
				// }
			}
			$pro_attributes .= '}';
			echo $pro_attributes;
		}
		
		die();
	}
  
  /**
   * Handle Product Delete
   */
  public function delete_wcfm_product() {
  	global $WCFM, $WCFMu;
  	
  	$proid = $_POST['proid'];
		
		if($proid) {
			if(wp_delete_post($proid)) {
				echo 'success';
				die;
			}
			die;
		}
  }
  
}
