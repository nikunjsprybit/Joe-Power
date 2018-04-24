<?php
/*
Plugin Name: Testimonial
Description: Testimonial is a clean, easy-to-use and Powerful Testimonials Management System for WordPress that allows you to manage and display Testimonials.
Plugin URI: http://shapedplugin.com/plugin/testimonial-pro
Author: ShapedPlugin
Author URI: http://shapedplugin.com
Version: 1.4.2
*/


/* Define */
define( 'SP_TF_URL', plugins_url('/') . plugin_basename( dirname( __FILE__ ) ) . '/' );
define( 'SP_TF_PATH', plugin_dir_path( __FILE__ ) );


/* Including files */
if(file_exists( SP_TF_PATH . 'inc/scripts.php')){
	require_once(SP_TF_PATH . "inc/scripts.php");
}
if(file_exists( SP_TF_PATH . 'inc/functions.php')){
	require_once(SP_TF_PATH . "inc/functions.php");
}

/* Plugin Action Links */
function sp_testimonial_free_action_links( $links ) {
	$links[] = '<a target="_blank" href="https://shapedplugin.com/plugin/testimonial-pro/" style="color: red; font-weight: 600;">Go
Pro!</a>';

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'sp_testimonial_free_action_links' );


// Redirect after active
function sp_testimonial_free_active_redirect( $plugin ) {
	if ( $plugin == plugin_basename( __FILE__ ) ) {
		exit( wp_redirect( admin_url( 'options-general.php' ) ) );
	}
}
add_action( 'activated_plugin', 'sp_testimonial_free_active_redirect' );


// admin menu
function sp_testimonial_free_options_framwrork() {
	add_options_page( 'Testimonial Pro Info', 'Testimonial Pro Info', 'manage_options', 'sp-tf-settings', 'sp_tf_options_framwrork' );
}
add_action( 'admin_menu', 'sp_testimonial_free_options_framwrork' );


if ( is_admin() ) : // Load only if we are viewing an admin page

	function sp_testimonial_free_register_settings() {
		// Register settings and call sanitation functions
		register_setting( 'sp_tf_p_options', 'sp_tf_options', 'sp_tf_validate_options' );
	}
	add_action( 'admin_init', 'sp_testimonial_free_register_settings' );


// Function to generate options page
	function sp_tf_options_framwrork() {

		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		} // This checks whether the form has just been submitted. ?>


		<div class="wrap about-wrap">

			<h1>Welcome to Testimonial Free</h1>

			<div class="about-text">Thank you for using our Testimonial Free plugin.</div>


			<hr>

			<h3>Want some cool features of this plugin?</h3>

			<p>We've added many extra features in our <a href="https://shapedplugin.com/plugin/testimonial-pro/">Premium
					Version</a> of this
				plugin. Let see some amazing features. <a href="https://shapedplugin.com/plugin/testimonial-pro/">Buy Premium Version Now.</a></p>



			<div class="feature-section two-col">
				<h2>Pro Version Features</h2>
				<div class="col">
					<ul>
						<li><span class="dashicons dashicons-yes"></span> 20+ Predefined Testimonial Theme Styles</li>
						<li><span class="dashicons dashicons-yes"></span> Front-end Submission form</li>
						<li><span class="dashicons dashicons-yes"></span> Notification e-mail for Testimonial submission to Admin</li>
						<li><span class="dashicons dashicons-yes"></span> Testimonial pending for approval by Admin to show in frontend</li>
						<li><span class="dashicons dashicons-yes"></span> Front-end submission form fields show/hide options</li>
						<li><span class="dashicons dashicons-yes"></span> 100% Responsive & Mobile Friendly</li>
						<li><span class="dashicons dashicons-yes"></span> Very Light weight, clean & beautiful design</li>
						<li><span class="dashicons dashicons-yes"></span> Testimonials from specific Categories</li>
						<li><span class="dashicons dashicons-yes"></span> Grid Testimonial Showcase</li>
						<li><span class="dashicons dashicons-yes"></span> List Testimonial showcase</li>
						<li><span class="dashicons dashicons-yes"></span> Filterable Testimonial Showcase</li>
						<li><span class="dashicons dashicons-yes"></span> Testimonials Order by (Date, Title, modified, Author, Random)</li>
						<li><span class="dashicons dashicons-yes"></span> Order (Decending, Ascending)</li>
						<li><span class="dashicons dashicons-yes"></span> Set Testimonial Auto-play time</li>
						<li><span class="dashicons dashicons-yes"></span> Testimonial stop on hover</li>
						<li><span class="dashicons dashicons-yes"></span> Set different style client images (Circle, Round, Square, Border)</li>
						<li><span class="dashicons dashicons-yes"></span> Show maximum number of testimonials displayed in devices</li>
					</ul>
				</div>
				<div class="col">
					<ul>
						<li><span class="dashicons dashicons-yes"></span> Testimonial Auto height option</li>
						<li><span class="dashicons dashicons-yes"></span> Simple Pagination Style</li>
						<li><span class="dashicons dashicons-yes"></span> Unlimited Testimonials anywhere</li>
						<li><span class="dashicons dashicons-yes"></span> Show/hide Testimonial next/prev buttons</li>
						<li><span class="dashicons dashicons-yes"></span> Star Rating System</li>
						<li><span class="dashicons dashicons-yes"></span> Unlimited colors</li>
						<li><span class="dashicons dashicons-yes"></span> Widget Ready</li>
						<li><span class="dashicons dashicons-yes"></span> Visual Composer Supported (Add-on)</li>
						<li><span class="dashicons dashicons-yes"></span> All Major Browsers compatible</li>
						<li><span class="dashicons dashicons-yes"></span> Fully Localized or Translation Ready</li>
						<li><span class="dashicons dashicons-yes"></span> Mobile, Tablet touch-swiped</li>
						<li><span class="dashicons dashicons-yes"></span> Work with all standard WordPress themes</li>
						<li><span class="dashicons dashicons-yes"></span> Developer friendly & easy to customize</li>
						<li><span class="dashicons dashicons-yes"></span> Extensive online documentation</li>
						<li><span class="dashicons dashicons-yes"></span> Lifetime free update</li>
						<li><span class="dashicons dashicons-yes"></span> 24/7 Free & Quick Developer support</li>
						<li><span class="dashicons dashicons-yes"></span> And many more…</li>
					</ul>
				</div>
			</div>

			<h2><a href="https://shapedplugin.com/plugin/testimonial-pro/" class="button button-primary button-hero">Buy
					PRO Version Now</a>
			</h2>
			<br>
			<br>

		</div>

		<?php
	}

endif;  // EndIf is_admin()

register_activation_hook( __FILE__, 'shapedplugin_tf_activate' );
add_action( 'admin_init', 'shapedplugin_tf_redirect' );

function shapedplugin_tf_activate() {
	add_option( 'shapedplugin_tf_activation_redirect', true );
}

function shapedplugin_tf_redirect() {
	if ( get_option( 'shapedplugin_tf_activation_redirect', false ) ) {
		delete_option( 'shapedplugin_tf_activation_redirect' );
		if ( ! isset( $_GET['activate-multi'] ) ) {
			wp_redirect( "options-general.php?page=sp-tf-settings" );
		}
	}
}