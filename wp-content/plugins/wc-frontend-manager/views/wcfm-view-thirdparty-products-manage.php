<?php
/**
 * WCFM plugin views
 *
 * Plugin WC Booking Products Manage Views
 *
 * @author 		WC Lovers
 * @package 	wcfm/views
 * @version   2.1.0
 */
global $wp, $WCFM;

// Yoast SEO Support
$yoast_wpseo_focuskw_text_input = '';
$yoast_wpseo_metadesc = '';

// WooCommerce Custom Product Tabs Lite Support
$product_tabs = array();

// WooCommerce barcode & ISBN support
$barcode = '';
$ISBN = '';

// WooCommerce MSRP Pricing Support
$msrp_price = '';

// Quantities and Units for WooCommerce
$_wpbo_deactive = 'no';
$_wpbo_override = 'no';
$_wpbo_step = '';
$_wpbo_minimum = '';
$_wpbo_maximum = '';
$_wpbo_minimum_oos = '';
$_wpbo_maximum_oos = '';
$unit = '';

if( isset( $wp->query_vars['wcfm-products-manage'] ) && !empty( $wp->query_vars['wcfm-products-manage'] ) ) {
	$product_id = $wp->query_vars['wcfm-products-manage'];
	if( $product_id ) {
		// Yoast SEO Support
		if(WCFM_Dependencies::wcfm_yoast_plugin_active_check()) {
			$yoast_wpseo_focuskw_text_input = get_post_meta( $product_id, '_yoast_wpseo_focuskw_text_input', true );
			$yoast_wpseo_metadesc = get_post_meta( $product_id, '_yoast_wpseo_metadesc', true );
		}
		
		// WooCommerce Custom Product Tabs Lite Support
		if(WCFM_Dependencies::wcfm_wc_tabs_lite_plugin_active_check()) {
			$product_tabs = (array) get_post_meta( $product_id, 'frs_woo_product_tabs', true );
		}
		
		// WooCommerce barcode & ISBN Support
		if(WCFM_Dependencies::wcfm_wc_barcode_isbn_plugin_active_check()) {
			$barcode = get_post_meta( $product_id, 'barcode', true );
			$ISBN = get_post_meta( $product_id, 'ISBN', true );
		}
		
		// WooCommerce MSRP Pricing Support
		if(WCFM_Dependencies::wcfm_wc_msrp_pricing_plugin_active_check()) {
			$msrp_price = get_post_meta( $product_id, '_msrp_price', true );
		}
		
		// Quantities and Units for WooCommerce
		if(WCFM_Dependencies::wcfm_wc_quantities_units_plugin_active_check()) {
			$_wpbo_deactive = ( get_post_meta( $product_id, '_wpbo_deactive', true ) ) ? 'on' : '';
			$_wpbo_override = ( get_post_meta( $product_id, '_wpbo_override', true ) ) ? 'on' : '';
			$_wpbo_step = get_post_meta( $product_id, '_wpbo_step', true );
			$_wpbo_minimum = get_post_meta( $product_id, '_wpbo_minimum', true );
			$_wpbo_maximum = get_post_meta( $product_id, '_wpbo_maximum', true );
			$_wpbo_minimum_oos = get_post_meta( $product_id, '_wpbo_minimum_oos', true );
			$_wpbo_maximum_oos = get_post_meta( $product_id, '_wpbo_maximum_oos', true );
			$unit = get_post_meta( $product_id, 'unit', true );
		}
	}
}
?>

    <?php if( $allow_seo = apply_filters( 'wcfm_is_allow_seo', true ) ) { ?>
			<?php if(WCFM_Dependencies::wcfm_yoast_plugin_active_check()) { ?>
				<!-- collapsible 10 - Yoast SEO Support -->
				<div class="page_collapsible products_manage_yoast simple variable grouped external booking" id="wcfm_products_manage_form_yoast_head"><?php _e('Yoast SEO', $WCFM->text_domain); ?><span></span></div>
				<div class="wcfm-container simple variable external grouped booking">
					<div id="wcfm_products_manage_form_yoast_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_yoast', array(  
																																																"yoast_wpseo_focuskw_text_input" => array('label' => __('Enter a focus keyword', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $yoast_wpseo_focuskw_text_input, 'hints' => __( 'It should appear in title and first paragraph of the copy.', $WCFM->text_domain )),
																																																"yoast_wpseo_metadesc" => array('label' => __('Meta description', $WCFM->text_domain) , 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_ele wcfm_title simple variable external grouped booking', 'value' => $yoast_wpseo_metadesc, 'hints' => __( 'It should not be more than 156 characters.', $WCFM->text_domain ))
																																											)) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
			<?php } ?>
		<?php } ?>
		
		<?php if(WCFM_Dependencies::wcfm_wc_tabs_lite_plugin_active_check()) { ?>
			<!-- collapsible 11 - WooCommerce Custom Product Tabs Lite Support -->
			<div class="page_collapsible products_manage_wc_tabs_lite simple variable grouped external booking" id="wcfm_products_manage_form_wc_tabs_lite_head"><?php _e('Custom Tabs', $WCFM->text_domain); ?><span></span></div>
			<div class="wcfm-container simple variable external grouped booking">
				<div id="wcfm_products_manage_form_wc_tabs_lite_expander" class="wcfm-content">
					<?php
					$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_wc_tabs_lite', array( 
																																													"product_tabs" => array('label' => __('Tabs', $WCFM->text_domain) , 'type' => 'multiinput', 'class' => 'wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'value' => $product_tabs, 'options' => array(  
																																															"title" => array('label' => __('Title', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'hints' => __( 'Required for tab to be visible', $WCFM->text_domain )),
																																															"content" => array('label' => __('Content', $WCFM->text_domain) , 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_ele wcfm_title simple variable external grouped booking', 'placeholder' => __( 'HTML or Text to display ...', $WCFM->text_domain ))
																																													) ) 
																																												) ) );
					?>
				</div>
			</div>
			<!-- end collapsible -->
			<div class="wcfm_clearfix"></div>
		<?php } ?>
		
		<?php if( $allow_barcode_isbn = apply_filters( 'wcfm_is_allow_barcode_isbn', true ) ) { ?>
			<?php if(WCFM_Dependencies::wcfm_wc_barcode_isbn_plugin_active_check()) { ?>
				<!-- collapsible 12 - WooCommerce Barcode & ISBN Support -->
				<div class="page_collapsible products_manage_barcode_isbn simple external non-variable-subscription" id="wcfm_products_manage_form_barcode_isbn_head"><?php _e('Barcode & ISBN', $WCFM->text_domain); ?><span></span></div>
				<div class="wcfm-container simple external non-variable-subscription">
					<div id="wcfm_products_manage_form_barcode_isbn_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_barcode_isbn', array(  
																																																"barcode" => array('label' => __('Barcode', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple external non-variable-subscription', 'label_class' => 'wcfm_title wcfm_ele simple external non-variable-subscription', 'value' => $barcode ),
																																																"ISBN" => array('label' => __('ISBN', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple external non-variable-subscription', 'label_class' => 'wcfm_ele wcfm_title simple external non-variable-subscription', 'value' => $ISBN )
																																											) ) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
			<?php } ?>
		<?php } ?>
		
		<?php if( $allow_msrp_pricing = apply_filters( 'wcfm_is_allow_msrp_pricing', true ) ) { ?>
			<?php if(WCFM_Dependencies::wcfm_wc_msrp_pricing_plugin_active_check()) { ?>
				<!-- collapsible 13 - WooCommerce MSRP Pricing Support -->
				<div class="page_collapsible products_manage_msrp_pricing simple external non-variable-subscription" id="wcfm_products_manage_form_msrp_pricing_head"><?php _e('MSRP Pricing', $WCFM->text_domain); ?><span></span></div>
				<div class="wcfm-container simple external non-variable-subscription">
					<div id="wcfm_products_manage_form_msrp_pricing_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_msrp_pricing', array(  
																																																"_msrp_price" => array('label' => __('MSRP Price', $WCFM->text_domain) . '(' . get_woocommerce_currency_symbol() . ')' , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple external non-variable-subscription', 'label_class' => 'wcfm_title wcfm_ele simple external non-variable-subscription', 'value' => $barcode )
																																											) ) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
			<?php } ?>
		<?php } ?>
		
		<?php if( $allow_quantities_units = apply_filters( 'wcfm_is_allow_quantities_units', true ) ) { ?>
			<?php if(WCFM_Dependencies::wcfm_wc_quantities_units_plugin_active_check()) { ?>
				<!-- collapsible 14 - Quantities and Units for WooCommerce Support -->
				<div class="page_collapsible products_manage_quantities_units simple variable external grouped booking" id="wcfm_products_manage_form_quantities_units_head"><?php _e('Quantities and Units', $WCFM->text_domain); ?><span></span></div>
				<div class="wcfm-container simple variable external grouped booking">
					<div id="wcfm_products_manage_form_quantities_units_expander" class="wcfm-content">
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_quantities_units', array(  
																																																"_wpbo_deactive" => array('label' => __('Deactivate Quantity Rules', $WCFM->text_domain), 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => 'on', 'dfvalue' => $_wpbo_deactive ),
																																																"_wpbo_override" => array('label' => __('Override Quantity Rules', $WCFM->text_domain), 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => 'on', 'dfvalue' => $_wpbo_override ),
																																																"_wpbo_step" => array('label' => __('Step Value', $WCFM->text_domain), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $_wpbo_step ),
																																																"_wpbo_minimum" => array('label' => __('Minimum Quantity', $WCFM->text_domain), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $_wpbo_minimum ),
																																																"_wpbo_maximum" => array('label' => __('Maximum Quantity', $WCFM->text_domain), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $_wpbo_maximum ),
																																																"_wpbo_minimum_oos" => array('label' => __('Out of Stock Minimum', $WCFM->text_domain), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $_wpbo_minimum_oos ),
																																																"_wpbo_maximum_oos" => array('label' => __('Out of Stock Maximum', $WCFM->text_domain), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $_wpbo_maximum_oos ),
																																																"unit" => array('label' => __('Unit', $WCFM->text_domain), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $unit )
																																																) ) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
			<?php } ?>
		<?php } ?>