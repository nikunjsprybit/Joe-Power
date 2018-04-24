<?php

// Post thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'tf-client-image-size', 100, 100, true );


/* Load plugin textDomain. */
function sp_testimonial_free_load_text_domain() {
	load_plugin_textdomain( 'testimonial-free', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'sp_testimonial_free_load_text_domain' );


function testimonial_free_register_post_type() {

	$labels = array(
		'name'               => esc_html__( 'Testimonials', 'testimonial-free' ),
		'singular_name'      => esc_html__( 'Testimonial', 'testimonial-free' ),
		'add_new'            => esc_html__( 'Add New Testimonial', 'testimonial-free' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'testimonial-free' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'testimonial-free' ),
		'new_item'           => esc_html__( 'New Testimonial', 'testimonial-free' ),
		'view_item'          => esc_html__( 'View Testimonial', 'testimonial-free' ),
		'search_items'       => esc_html__( 'Search Testimonials', 'testimonial-free' ),
		'not_found'          => esc_html__( 'No Testimonials found', 'testimonial-free' ),
		'not_found_in_trash' => esc_html__( 'No Testimonials found in Trash', 'testimonial-free' ),
		'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'testimonial-free' ),
		'menu_name'          => esc_html__( 'Testimonials', 'testimonial-free' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-format-quote',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => false,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'thumbnail',
			'page-attributes'
		)
	);

	register_post_type( 'testimonial-free', $args );
}

add_action( 'init', 'testimonial_free_register_post_type' );


// Change title placeholder
function sp_testimonial_free_change_default_title($title) {
	$screen = get_current_screen();
	if('testimonial-free' == $screen->post_type) {
		$title = esc_html__('Type client name here', 'testimonial-free');
	}
	return $title;
}
add_filter('enter_title_here','sp_testimonial_free_change_default_title');


// show shortcode
add_filter( 'views_edit-testimonial-free', function ( $view_shortcode ) {
	echo '<p>Shortcode <input style="background: #ffffff;width: 245px;padding: 6px;" type="text" onClick="this.select();"
value="[testimonial-free color=&#34;#52b3d9&#34; nav=&#34;true&#34; pagination=&#34;true&#34;]" /></p>';

	return $view_shortcode;
} );


/* Including files */
if(file_exists( SP_TF_PATH . 'inc/options/meta-box.php')){
	require_once(SP_TF_PATH . "inc/options/meta-box.php");
}
if(file_exists( SP_TF_PATH . 'inc/shortcodes.php')){
	require_once(SP_TF_PATH . "inc/shortcodes.php");
}