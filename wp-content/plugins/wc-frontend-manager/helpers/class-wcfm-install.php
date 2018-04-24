<?php

/**
 * WCFM plugin Install
 *
 * Plugin install script which adds default pages, taxonomies, and database tables to WordPress. Runs on activation and upgrade.
 *
 * @author 		WC Lovers
 * @package 	wcfm/helpers
 * @version   1.0.3
 */
class WCFM_Install {

	public $arr = array();

	public function __construct() {
		global $WCFM, $WCFM_Query;
		if ( get_option("wcfm_page_install") == 1 ) {
			$wcfm_options = get_option('wcfm_options');
			if (isset($wcfm_options['wc_frontend_manager_page_id'])) {
				wp_update_post(array('ID' => $wcfm_options['wc_frontend_manager_page_id'], 'post_content' => '[wc_frontend_manager]'));
			}
			update_option('wcfm_options', $wcfm_options);
		}
		if ( !get_option("wcfm_page_install") ) {
			$this->wcfm_create_pages();
			update_option("wcfm_db_version", $WCFM->version);
			update_option("wcfm_page_install", 1);
		}
		
		// Intialize WCFM End points
		$WCFM_Query->init_query_vars();
		$WCFM_Query->add_endpoints();
		
		// Flush rules after install
		flush_rewrite_rules();
	}
	
	/**
	 * Create a page
	 *
	 * @access public
	 * @param mixed $slug Slug for the new page
	 * @param mixed $option Option name to store the page's ID
	 * @param string $page_title (default: '') Title for the new page
	 * @param string $page_content (default: '') Content for the new page
	 * @param int $post_parent (default: 0) Parent for the new page
	 * @return void
	 */
	function wcfm_create_page($slug, $option, $page_title = '', $page_content = '', $post_parent = 0) {
		global $wpdb;
		$option_value = get_option($option);
		if ($option_value > 0 && get_post($option_value))
				return;
		$page_found = $wpdb->get_var("SELECT ID FROM " . $wpdb->posts . " WHERE post_name = '$slug' LIMIT 1;");
		if ($page_found) :
				if (!$option_value)
						update_option($option, $page_found);
				return;
		endif;
		$page_data = array(
				'post_status' => 'publish',
				'post_type' => 'page',
				'post_author' => 1,
				'post_name' => $slug,
				'post_title' => $page_title,
				'post_content' => $page_content,
				'post_parent' => $post_parent,
				'comment_status' => 'closed'
		);
		$page_id = wp_insert_post($page_data);
		update_option($option, $page_id);
	}

	/**
	 * Create pages that the plugin relies on, storing page id's in variables.
	 *
	 * @access public
	 * @return void
	 */
	function wcfm_create_pages() {
			global $WCFM;

			// WCFM page
			$this->wcfm_create_page(esc_sql(_x('wc_frontend_manager', 'page_slug', $WCFM->text_domain)), 'wc_frontend_manager_page_id', __('WC Frontend Manager', $WCFM->text_domain), '[wc_frontend_manager]');
			
			$array_pages = array();
			$array_pages['wc_frontend_manager_page_id'] = get_option('wc_frontend_manager_page_id');

			update_option('wcfm_options', $array_pages);
	}

}

?>