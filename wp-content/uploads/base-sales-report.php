<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
include_once('report-function.php'); 
if( !class_exists( 'BaseSalesReport' ) ) {
class BaseSalesReport extends ReportFunction{
 	 public function __construct(){
	 
	 //$this->print_data( $_REQUEST["page"] );
	 	add_action( 'admin_menu',  array(&$this,'admin_menu' ));
		
		if (isset($_REQUEST["page"])){
			 $page =  	$this->get_request("page");
			if ($page =="order-product" || $page =="ni-sales-report")
		
			add_action( 'admin_enqueue_scripts',  array(&$this,'my_enqueue' ));
		}
		add_action( 'wp_ajax_sales_order',  array(&$this,'ajax_sales_order' )); /*used in form field name="action" value="my_action"*/
		add_action('admin_init', array( &$this, 'admin_init' ) );
		add_filter( 'plugin_row_meta',  array(&$this,'plugin_row_meta' ), 10, 2 );
		add_filter( 'admin_footer_text',  array(&$this,'admin_footer_text' ),101);
	}
	function admin_footer_text($text){
		
		 if (isset($_REQUEST["page"])){
			 $page = $_REQUEST["page"]; 
			 	if ($page == "sales-report" || $page  =="order-product" || $page =="ni-sales-report-addons"){
			 	$text = sprintf( __( 'Thank you for using our plugins <a href="%s" target="_blank">naziinfotech</a>' ), 
				__( 'http://naziinfotech.com/' ) );
				$text = "<span id=\"footer-thankyou\">". $text ."</span>"	 ;
		 	}
		 }
		return $text ; 
	}
	function plugin_row_meta($links, $file){
		if ( $file == "ni-woocommerce-sales-report/ni-woocommerce-sales-report.php" ) {
			$row_meta = array(
			
			'ni_pro_version'=> '<a target="_blank" href="http://naziinfotech.com/product/ni-woocommerce-sales-report-pro">Buy Pro Version</a>',
			
			'ni_pro_review'=> '<a target="_blank" href="https://wordpress.org/support/plugin/ni-woocommerce-sales-report/reviews/">Write a Review</a>'	);
				

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
	function my_enqueue($hook) {
   		
		 if (isset($_REQUEST["page"])){
			 $page = $_REQUEST["page"];
			if ($page == "ni-sales-report" || $page  =="order-product" || $page =="ni-sales-report-addons"){
		 	
				wp_enqueue_script( 'ajax-script', plugins_url( '../assets/js/script.js', __FILE__ ), array('jquery') );
		 		wp_enqueue_script( 'jquery-ui', plugins_url( '../assets/js/jquery-ui.js', __FILE__ ), array('jquery') );
		 		
			
				if ($page == "ni-sales-report"){
					wp_register_style( 'ni-sales-report-summary-css', plugins_url( '../assets/css/ni-sales-report-summary.css', __FILE__ ));
		 			wp_enqueue_style( 'ni-sales-report-summary-css' );
					wp_register_style( 'ni-font-awesome-css', plugins_url( '../assets/css/font-awesome.css', __FILE__ ));
		 			wp_enqueue_style( 'ni-font-awesome-css' );
					
					wp_register_script( 'ni-amcharts-script', plugins_url( '../assets/js/amcharts/amcharts.js', __FILE__ ) );
					wp_enqueue_script('ni-amcharts-script');
				
		
					wp_register_script( 'ni-light-script', plugins_url( '../assets/js/amcharts/light.js', __FILE__ ) );
					wp_enqueue_script('ni-light-script');
				
					wp_register_script( 'ni-pie-script', plugins_url( '../assets/js/amcharts/pie.js', __FILE__ ) );
					wp_enqueue_script('ni-pie-script');
					
				}else{
					wp_register_style( 'sales-report-style', plugins_url( '../assets/css/sales-report-style.css', __FILE__ ));
		 			wp_enqueue_style( 'sales-report-style' );
				}
		 		wp_localize_script( 'ajax-script','ajax_object',
					array('ni_sales_report_ajaxurl'=>admin_url( 'admin-ajax.php' ),'we_value' => 1234 ) );
			}
		 }
		
    }
	/*Ajax Call*/
	function ajax_sales_order()
	{
		$page= $this->get_request("page");
		if($page=="order-item")
		{	include_once('order-item.php');
			$obj = new OrderItem();  
			$obj->ajax_call();
		}
		die;
	}
	function admin_menu(){
   		add_menu_page(__(  'Sales Report', 'NiWooCommerceSalesReport')
		,__(  'Sales Report', 'NiWooCommerceSalesReport')
		,'manage_options'
		,'ni-sales-report'
		,array(&$this,'AddMenuPage')
		,'dashicons-media-document'
		,8);
    	add_submenu_page('ni-sales-report'
		,__( 'Dashboard', 'NiWooCommerceSalesReport' )
		,__( 'Dashboard', 'NiWooCommerceSalesReport' )
		,'manage_options'
		,'ni-sales-report' 
		,array(&$this,'AddMenuPage'));
    	add_submenu_page('ni-sales-report'
		,__( 'Order Product', 'NiWooCommerceSalesReport' )
		,__( 'Order Product', 'NiWooCommerceSalesReport' )
		, 'manage_options', 'order-product' 
		, array(&$this,'AddMenuPage'));
		
		
		do_action('ni_sales_report_menu','ni-sales-report');
		
		add_submenu_page('ni-sales-report'
		,__( 'Other Plugins', 'NiWooCommerceSalesReport' )
		,__( 'Other Plugins', 'NiWooCommerceSalesReport' )
		, 'manage_options'
		, 'ni-sales-report-addons' , array(&$this,'AddMenuPage'));
		
		
		
		
	}
	function AddMenuPage()
	{
		$page= $this->get_request("page");
		/*Order Item*/
		if($page=="order-product")
		{	include_once('order-item.php');
			$initialize = new OrderItem();  
			$initialize->create_form();
		}
		/*Order Item*/
		if($page=="ni-sales-report")
		{	include_once('order-summary.php');
			$initialize = new Summary();  
		}
		
		/*Order Item*/
		if($page=="ni-sales-report-addons")
		{	include_once('ni-sales-report-addons.php');
			$initialize = new ni_sales_report_addons(); 
			$initialize->page_init(); 
		}
	}
	function admin_init()
	{
		if(isset($_REQUEST['btn_print'])){
			include_once('order-item.php');
			$obj = new OrderItem();
			$obj->get_print_content();
			die;
		}	
	}
	public function activation() {
      // To override
    }	
	 // Called when the plugin is deactivated
    public function deactivation() {
      // To override
    }
	 // Called when the plugin is loaded
    public function loaded() {
      // To override
    }
}
}
?>