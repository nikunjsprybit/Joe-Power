<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*** Plugin Scripts and CSS ***/
if (!function_exists('sp_tf_scripts_and_style')) {
	function sp_tf_scripts_and_style(){
		// CSS Files
		wp_enqueue_style('owl-carousel-css', SP_TF_URL . 'assets/css/owl.carousel.css', array(), NULL);
		wp_enqueue_style( 'font-awesome-css', SP_TF_URL . 'assets/css/font-awesome.min.css', array(), NULL );
		wp_enqueue_style('tf-style', SP_TF_URL . 'assets/css/style.css');

		//JS Files
		wp_enqueue_script( 'owl-carousel-min-js', SP_TF_URL . 'assets/js/owl.carousel.min.js', array('jquery'), NULL, TRUE );
		wp_enqueue_script( 'jquery-masonry', array('jquery'), NULL, TRUE );
	}
	add_action('wp_enqueue_scripts', 'sp_tf_scripts_and_style');
}

/*** Plugin admin Scripts and CSS ***/
if(is_admin()) {
	function sp_tf_admin_scripts_and_style() {
		// CSS Files
		wp_enqueue_style('tf-admin-style', SP_TF_URL . 'assets/css/admin-style.css', array(), NULL);

	}
	add_action('admin_footer', 'sp_tf_admin_scripts_and_style');
}