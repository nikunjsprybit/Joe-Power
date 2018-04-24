<?php
global $wp, $WCFM, $wc_product_attributes;

$user = wp_get_current_user();

if( !current_user_can( 'edit_products' ) && !in_array( 'dc_vendor', (array) $user->roles )) {
	_e( "<span class='permission_restrict'>You don't have permission to access this page. Please contact site administrator for assistance.</span>", $WCFM->text_domain );
	return;
}



$product_id = 0;
$product = array();
$product_type = '';
$is_virtual = '';
$title = '';
$sku = '';
$excerpt = '';
$description = '';
$regular_price = '';
$sale_price = '';
$sale_date_from = '';
$sale_date_upto = '';
$product_url = '';
$button_text = '';
$is_downloadable = '';
$children = array();

$featured_img = '';
$gallery_img_ids = array();
$gallery_img_urls = array();
$categories = array();
$product_tags = '';
$manage_stock = '';
$stock_qty = 0;
$backorders = '';
$stock_status = ''; 
$sold_individually = '';
$weight = '';
$length = '';
$width = '';
$height = '';
$shipping_class = '';
$tax_status = '';
$tax_class = '';
$attributes = array();
$attributes_select_type = array();
$variations = array();

$upsell_ids = array();
$crosssell_ids = array();

$current_user_id = get_current_user_id();
if( isset( $_GET['listing_edit']) && !empty( $_GET['listing_edit'] ) ) {
	
	$product = wc_get_product( $_GET['listing_edit'] );
	// Fetching Product Data
	if($product && !empty($product)) {
		$product_id = $_GET['listing_edit'];
		$product_type = $product->get_type();
		$title = $product->get_title();
		$sku = $product->get_sku();
		$excerpt = $product->get_short_description();
		$description = $product->get_description();
		$regular_price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();
		
		// External product option
		$product_url = get_post_meta( $product_id, '_product_url', true);
		$button_text = get_post_meta( $product_id, '_button_text', true);
		$product_image_gallery = get_post_meta( $product_id, '_product_image_gallery', true);


		$sale_price = get_post_meta( $product_id, 'sale_price', true);
		
		$rental_price_per_day = get_post_meta( $product_id, 'rental_price_per_day', true);
		$rental_price_per_week = get_post_meta( $product_id, 'rental_price_per_week', true);
		$rental_price_per_month = get_post_meta( $product_id, 'rental_price_per_month', true);
		
		// Virtual
		$is_virtual = ( get_post_meta( $product_id, '_virtual', true) == 'yes' ) ? 'enable' : '';
		
		// Download ptions
		$is_downloadable = ( get_post_meta( $product_id, '_downloadable', true) == 'yes' ) ? 'enable' : '';
		if( $product_type != 'simple' ) $is_downloadable = '';
		
		// Product Images
		$featured_img = ($product->get_image_id()) ? $product->get_image_id() : '';
		if($featured_img) $featured_img = wp_get_attachment_url($featured_img);
		if(!$featured_img) $featured_img = '';
		$gallery_img_ids = $product->get_gallery_image_ids();
		if(!empty($gallery_img_ids)) {
			foreach($gallery_img_ids as $gallery_img_id) {
				$gallery_img_urls[] = array('image'=>wp_get_attachment_url($gallery_img_id),'id'=>$gallery_img_id);
			}
		}
		$gallery_img_id = get_post_thumbnail_id($product_id);
		
		// Product Categories
		$pcategories = get_the_terms( $product_id, 'product_cat' );
		if( !empty($pcategories) ) {
			foreach($pcategories as $pkey => $pcategory) {
				$categories[] = $pcategory->term_id;
			}
		} else {
			$categories = array();
		}
		
		// Product Tags
		$product_tag_list = wp_get_post_terms($product_id, 'product_tag', array("fields" => "names"));
		$product_tags = implode(',', $product_tag_list);
		
		// Product Stock options
		$manage_stock = $product->managing_stock() ? 'enable' : '';
		$stock_qty = $product->get_stock_quantity();
		$backorders = $product->get_backorders();
		$stock_status = $product->get_stock_status(); 
		$sold_individually = $product->is_sold_individually() ? 'enable' : '';
		
		// Product Shipping Data
		$weight = $product->get_weight();
		$length = $product->get_length();
		$width = $product->get_width();
		$height = $product->get_height();
		$shipping_class = $product->get_shipping_class_id();
		
		// Product Tax Data
		$tax_status = $product->get_tax_status();
		$tax_class = $product->get_tax_class();
		
		// Product Attributes
		$wcfm_attributes = get_post_meta( $product_id, '_product_attributes', true );
		if(!empty($wcfm_attributes)) {
			$acnt = 0;
			foreach($wcfm_attributes as $wcfm_attribute) {
				
				if ( $wcfm_attribute['is_taxonomy'] ) {
					$att_taxonomy = $wcfm_attribute['name'];

					if ( ! taxonomy_exists( $att_taxonomy ) ) {
						continue;
					}
					
					$attribute_taxonomy = $wc_product_attributes[ $att_taxonomy ];
					
					$attributes[$acnt]['term_name'] = $att_taxonomy;
					$attributes[$acnt]['name'] = wc_attribute_label( $att_taxonomy );
					$attributes[$acnt]['attribute_taxonomy'] = $attribute_taxonomy;
					$attributes[$acnt]['tax_name'] = $att_taxonomy;
					$attributes[$acnt]['is_taxonomy'] = 1;
					
					if ( 'select' === $attribute_taxonomy->attribute_type ) {
						$args = array(
										'orderby'    => 'name',
										'hide_empty' => 0
									);
						$all_terms = get_terms( $att_taxonomy, apply_filters( 'wcfm_product_attribute_terms', $args ) );
						$attributes_option = array();
						if ( $all_terms ) {
							foreach ( $all_terms as $term ) {
								$attributes_option[$term->term_id] = esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) );
							}
						}
						$attributes[$acnt]['attribute_type'] = 'select';
						$attributes[$acnt]['option_values'] = $attributes_option;
						$attributes[$acnt]['value'] = wp_get_post_terms( $product_id, $att_taxonomy, array( 'fields' => 'ids' ) );
					} else {
						$attributes[$acnt]['attribute_type'] = 'text';
						$attributes[$acnt]['value'] = esc_attr( implode( ' ' . WC_DELIMITER . ' ', wp_get_post_terms( $product_id, $att_taxonomy, array( 'fields' => 'names' ) ) ) );
					}
				} else {
					$attributes[$acnt]['term_name'] = apply_filters( 'woocommerce_attribute_label', $wcfm_attribute['name'], $wcfm_attribute['name'], true );
					$attributes[$acnt]['name'] = apply_filters( 'woocommerce_attribute_label', $wcfm_attribute['name'], $wcfm_attribute['name'], true );
					$attributes[$acnt]['value'] = $wcfm_attribute['value'];
					$attributes[$acnt]['tax_name'] = '';
					$attributes[$acnt]['is_taxonomy'] = 0;
					$attributes[$acnt]['attribute_type'] = 'text';
				}
				
				$attributes[$acnt]['is_visible'] = $wcfm_attribute['is_visible'] ? 'enable' : '';
				$attributes[$acnt]['is_variation'] = $wcfm_attribute['is_variation'] ? 'enable' : '';
				
				if( 'select' === $attributes[$acnt]['attribute_type'] ) {
					$attributes_select_type[$acnt] = $attributes[$acnt];
					unset($attributes[$acnt]);
				}
				$acnt++;
			}
		}
		
		// Variable Product Variations
		$variation_ids = $product->get_children();
		if(!empty($variation_ids)) {
			foreach($variation_ids as $variation_id_key => $variation_id) {
				$variation_data = new WC_Product_Variation($variation_id);
				
				$variations[$variation_id_key]['id'] = $variation_id;
				$variations[$variation_id_key]['enable'] = $variation_data->is_purchasable() ? 'enable' : '';
				$variations[$variation_id_key]['sku'] = $variation_data->get_sku();
				
				// Variation Image
				$variation_img = $variation_data->get_image_id();
				if($variation_img) $variation_img = wp_get_attachment_url($variation_img);
				else $variation_img = '';
				$variations[$variation_id_key]['image'] = $variation_img;
				
				// Variation Price
				$variations[$variation_id_key]['regular_price'] = $variation_data->get_regular_price();
				$variations[$variation_id_key]['sale_price'] = $variation_data->get_sale_price();
				
				// Variation Stock Data
				$variations[$variation_id_key]['manage_stock'] = $variation_data->managing_stock() ? 'enable' : '';
				$variations[$variation_id_key]['stock_status'] = $variation_data->get_stock_status();
				$variations[$variation_id_key]['stock_qty'] = $variation_data->get_stock_quantity();
				$variations[$variation_id_key]['backorders'] = $variation_data->get_backorders();
				
				// Variation Virtual Data
				$variations[$variation_id_key]['is_virtual'] = ( 'yes' == get_post_meta($variation_id, '_virtual', true) ) ? 'enable' : '';
				
				// Variation Downloadable Data
				$variations[$variation_id_key]['is_downloadable'] = ( 'yes' == get_post_meta($variation_id, '_downloadable', true) ) ? 'enable' : '';
				$variations[$variation_id_key]['downloadable_files'] = get_post_meta($variation_id, '_downloadable_files', true);
				$variations[$variation_id_key]['download_limit'] = ( -1 == get_post_meta($variation_id, '_download_limit', true) ) ? '' : get_post_meta($variation_id, '_download_limit', true);
				$variations[$variation_id_key]['download_expiry'] = ( -1 == get_post_meta($variation_id, '_download_expiry', true) ) ? '' : get_post_meta($variation_id, '_download_expiry', true);
				if(!empty($variations[$variation_id_key]['downloadable_files'])) {
					foreach($variations[$variation_id_key]['downloadable_files'] as $variations_downloadable_files) {
						$variations[$variation_id_key]['downloadable_file'] = $variations_downloadable_files['file'];
						$variations[$variation_id_key]['downloadable_file_name'] = $variations_downloadable_files['name'];
					}
				}
				
				// Variation Shipping Data
				$variations[$variation_id_key]['weight'] = $variation_data->get_weight();
				$variations[$variation_id_key]['length'] = $variation_data->get_length();
				$variations[$variation_id_key]['width'] = $variation_data->get_width();
				$variations[$variation_id_key]['height'] = $variation_data->get_height();
				$variations[$variation_id_key]['shipping_class'] = $variation_data->get_shipping_class_id();
				
				// Variation Tax
				$variations[$variation_id_key]['tax_class'] = $variation_data->get_tax_class();
				
				// Variation Attributes
				$variations[$variation_id_key]['attributes'] = json_encode( $variation_data->get_variation_attributes() );
				
				// Description
				$variations[$variation_id_key]['description'] = get_post_meta($variation_id, '_variation_description', true);
				
				$variations = apply_filters( 'wcfm_variation_edit_data', $variations, $variation_id, $variation_id_key );
			}
		}
		
		$upsell_ids = get_post_meta( $product_id, '_upsell_ids', true ) ? get_post_meta( $product_id, '_upsell_ids', true ) : array();
		$crosssell_ids = get_post_meta( $product_id, '_crosssell_ids', true ) ? get_post_meta( $product_id, '_crosssell_ids', true ) : array();
		$children = get_post_meta( $product_id, '_children', true ) ? get_post_meta( $product_id, '_children', true ) : array();
	}
	
	$post_author = get_post_field( 'post_author', $_GET['listing_edit'] );

	$is_admin = current_user_can('manage_options');

	if ( ($current_user_id !=  $post_author) && !$is_admin) {
		echo "<p class='product_type wcfm_title' style='width: 100%; margin-left: 16%;'><strong>You don't have permission to edit this equipment.</strong></p>";
		return;
	}
}





// Shipping Class List
$product_shipping_class = get_terms( 'product_shipping_class', array('hide_empty' => 0));
$variation_shipping_option_array = array('-1' => __('Same as parent', $WCFM->text_domain));
$shipping_option_array = array('_no_shipping_class' => __('No shipping class', $WCFM->text_domain));
foreach($product_shipping_class as $product_shipping) {
	$variation_shipping_option_array[$product_shipping->term_id] = $product_shipping->name;
	$shipping_option_array[$product_shipping->term_id] = $product_shipping->name;
}

// Tax Class List
$tax_classes         = WC_Tax::get_tax_classes();
$classes_options     = array();
$variation_tax_classes_options['parent'] = __( 'Same as parent', $WCFM->text_domain );
$variation_tax_classes_options[''] = __( 'Standard', $WCFM->text_domain );
$tax_classes_options[''] = __( 'Standard', $WCFM->text_domain );

if ( ! empty( $tax_classes ) ) {

	foreach ( $tax_classes as $class ) {
		$tax_classes_options[ sanitize_title( $class ) ] = esc_html( $class );
		$variation_tax_classes_options[ sanitize_title( $class ) ] = esc_html( $class );
	}
}

$args = array(
	'posts_per_page'   => -1,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'product',
	'post_mime_type'   => '',
	'post_parent'      => '',
	//'author'	   => get_current_user_id(),
	'post_status'      => array('publish'),
	'suppress_filters' => true 
);
$args = apply_filters( 'wcfm_products_args', $args );

$products_objs = get_posts( $args );
$products_array = array();
if( !empty($products_objs) ) {
	foreach( $products_objs as $products_obj ) {
		$products_array[esc_attr( $products_obj->ID )] = esc_html( $products_obj->post_title );
	}
}
$product_types = apply_filters( 'wcfm_product_types', array('simple' => __('For Sale', $WCFM->text_domain)) );
$product_categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0&parent=0' );

    if ($_GET['listing_edit'] && !empty($_GET['listing_edit']) ) {
		 $selected_sub_cats = 	array();
		 $post_id			=	$_GET['listing_edit'];
		 $sub_cats			=	get_post_meta($post_id,'product_subcats',true);
         if($sub_cats != ""){
			$selected_sub_cats = explode(',',$sub_cats);
		 }
    }
?>

<div class="collapse wcfm-collapse col-md-12" id="">
  <?php do_action( 'before_wcfm_product_simple' ); ?>
	<form id="wcfm_products_manage_form" class="wcfm" method="post">
		<div class="tab-content">
			<div id="general1" class="tab-pane fade in active">	
				<?php do_action( 'begin_wcfm_products_manage_form' ); ?>	  
				<!-- collapsible -->
				<h4 class="user_dashboard_panel_title user_dashboard_title"><?php _e('General', $WCFM->text_domain); ?></h4>
				<div class="wcfm-container simple variable external grouped booking">
					<div  class="wcfm-content">
						<div class="wcfm_clearfix"></div>
						<p class="wcfm_title"></p><div class="wcfm-message-general" style="display: inline-block;"></div>
						<div id="wcfm_products_manage_form_taxonomy_expander">
							  <p class="wcfm_title"><strong><?php _e( 'Categories', $WCFM->text_domain ); ?>  <span class="required_field">*</span></strong></p><label class="screen-reader-text" for="product_cats"><?php _e( 'Categories', $WCFM->text_domain ); ?></label>
							  <select id="product_parent_cats" name="product_cats" class="wcfm-select wcfm_ele simple variable external grouped booking" style="width: 60%; margin-bottom: 10px;" required="required">
									<option value="">Choose ...</option>
									<?php
									
										$parentCate = '';
										if ( $product_categories ) {
											foreach ( $product_categories as $cat ) {
												
												echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( in_array( $cat->term_id, $categories ), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
												if(in_array($cat->term_id,$categories)){
													$parentCate = $cat->term_id;
												}
											}
										}
									?>
								</select>
								<p class="wcfm_title product_subcats" style="display: none;">
									<strong><?php _e( 'Subcategories', $WCFM->text_domain ); ?>  <span class="required_field">*</span></strong>
								</p>
								<label class="screen-reader-text product_subcats product_subcats_label" for="product_subcats" style="display: none;"><?php _e( 'Subcategories', $WCFM->text_domain ); ?></label>
								<?php if( isset($_GET['listing_edit']) && $_GET['listing_edit'] != "") {
									$product_child_categories   = 	get_terms( 'product_cat', 'orderby=name&hide_empty=0&parent=' . absint( $parentCate ) );
									if (!empty($product_child_categories)) { ?>
										<script type="text/javascript">
											jQuery('.product_subcats').show();
										</script>
										<select id="product_subcats" name="product_subcats[]" class="product_subcats wcfm-select wcfm_ele simple variable external grouped booking" multiple="multiple" style="width: 60%; margin-bottom: 10px;">
											<?php foreach ( $product_child_categories as $child_cat ) {
												echo '<option value="' . esc_attr( $child_cat->term_id ) . '"' . selected( in_array( $child_cat->term_id, $selected_sub_cats ), true, false ) . '>'.esc_html( $child_cat->name ).'</option>';
											} ?>
										</select><?php
									}
								} ?>
							  <?php
							  $product_taxonomies = get_object_taxonomies( 'product', 'objects' );
							  if( !empty( $product_taxonomies ) ) {
								foreach( $product_taxonomies as $product_taxonomy ) {
									if( !in_array( $product_taxonomy->name, array( 'product_cat', 'product_tag' ) ) ) {
										if( $product_taxonomy->public && $product_taxonomy->show_ui ) {
											// Fetching Saved Values
											$taxonomy_values_arr = array();
											if($product && !empty($product)) {
													$taxonomy_values = get_the_terms( $product_id, $product_taxonomy->name );
													if( !empty($taxonomy_values) ) {
														foreach($taxonomy_values as $pkey => $ptaxonomy) {
															$taxonomy_values_arr[] = $ptaxonomy->term_id;
														}
													}
												}
											?>
											<p class="wcfm_title"><strong><?php _e( $product_taxonomy->label, $WCFM->text_domain ); ?></strong></p><label class="screen-reader-text" for="<?php echo $product_taxonomy->name; ?>"><?php _e( $product_taxonomy->label, $WCFM->text_domain ); ?></label>
												<select id="<?php echo $product_taxonomy->name; ?>" name="product_custom_taxonomies[<?php echo $product_taxonomy->name; ?>][]" class="wcfm-select product_taxonomies wcfm_ele simple variable external grouped booking" multiple="multiple" style="width: 60%; margin-bottom: 10px;">
													<?php
													  $product_taxonomy_terms   = get_terms( $product_taxonomy->name, 'orderby=name&hide_empty=0&parent=0' );
														if ( $product_taxonomy_terms ) {
															foreach ( $product_taxonomy_terms as $product_taxonomy_term ) {
																echo '<option value="' . esc_attr( $product_taxonomy_term->term_id ) . '"' . selected( in_array( $product_taxonomy_term->term_id, $taxonomy_values_arr ), true, false ) . '>' . esc_html( $product_taxonomy_term->name ) . '</option>';
																$product_taxonomy_child_terms   = get_terms( $product_taxonomy->name, 'orderby=name&hide_empty=0&parent=' . absint( $product_taxonomy_term->term_id ) );
																if ( $product_taxonomy_child_terms ) {
																	foreach ( $product_taxonomy_child_terms as $product_taxonomy_child_term ) {
																		echo '<option value="' . esc_attr( $product_taxonomy_child_term->term_id ) . '"' . selected( in_array( $product_taxonomy_child_term->term_id, $taxonomy_values_arr ), true, false ) . '>' . '&nbsp;&nbsp;' . esc_html( $product_taxonomy_child_term->name ) . '</option>';
																	}
																}
															}
														}
													?>
												</select>
											<?php
										}
									}
								}
							  }
							  ?>
						</div>
						<?php
						ksort($product_types);
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_general', array(
						"product_type" => array('label' => __('Product Type', $WCFM->text_domain) , 'type' => 'hidden', 'options' => $product_types, 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => 'booking' ),
						"title" => array('label' => __('Title <span class="required_field">*</span>', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking', 'value' => $title),
						"sku" => array('label' => __('SKU', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable grouped external', 'label_class' => 'wcfm_title wcfm_ele simple variable grouped external', 'value' => $sku, 'hints' => __( 'SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.', $WCFM->text_domain )),
						"product_url" => array('label' => __('Product URL', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele external', 'label_class' => 'wcfm_ele wcfm_title external', 'value' => $product_url, 'hints' => __( 'Enter the external URL to the product.', $WCFM->text_domain )),
						"button_text" => array('label' => __('Button Text', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele external', 'label_class' => 'wcfm_ele wcfm_title external', 'value' => $button_text, 'hints' => __( 'This text will be shown on the button linking to the external product.', $WCFM->text_domain )),
						"regular_price" => array('label' => __('Price', $WCFM->text_domain) . '(' . get_woocommerce_currency_symbol() . ')', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple external non-subscription non-variable-subscription', 'label_class' => 'wcfm_ele wcfm_title simple external non-subscription non-variable-subscription', 'value' => $regular_price),
						"excerpt" => array('label' => __('Short Description', $WCFM->text_domain) , 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele simple variable external grouped booking' , 'label_class' => 'wcfm_title', 'value' => $excerpt),
						"description" => array('label' => __('Long Description <span class="required_field">*</span>', $WCFM->text_domain) , 'type' => 'wpeditor', 'class' => 'wcfm-editor wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'value' => $description),
						"pro_id" => array('type' => 'hidden', 'value' => $product_id)
					), $product_id, $product_type ) );
					?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<?php //do_action( 'after_wcfm_products_manage_general', $product_id, $product_type ); ?>		
				<!-- collapsible 2 - Grouped Product -->
				<div class="page_collapsible products_manage_grouped grouped" id="wcfm_products_manage_form_grouped_head" style="display:none;"><?php _e('Grouped Products', $WCFM->text_domain); ?><span></span></div>
					<div class="wcfm-container grouped">
						<div id="wcfm_products_manage_form_grouped_expander" class="wcfm-content">
							<?php
							$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_grouped', array(  
								"grouped_products" => array('label' => __('Grouped products', $WCFM->text_domain) , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele grouped', 'label_class' => 'wcfm_title wcfm_ele grouped', 'options' => $products_array, 'value' => $children, 'hints' => __( 'This lets you choose which products are part of this group.', $WCFM->text_domain ))
							)) );
							?>
						</div>
					</div>
						<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>


				<!-- collapsible 8 -->
				<div class="page_collapsible products_manage_variations variable variations variable-subscription" id="wcfm_products_manage_form_variations_head" style="display:none;"><?php _e('Price', $WCFM->text_domain); ?><span></span></div>
				<div class="wcfm-container variable variable-subscription" style="padding: 0px;display: block;width: 88%;">
					<div id="wcfm_products_manage_form_variations_expander" class="wcfm-content">
						<div id="wcfm_products_manage_form_variations_expander" class="wcfm-content">	 
							<div class="custom_attributes" style="display: none;"> <!-- style="display: none;" -->
								<?php
								$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_simple_fields_attributes', array(  
									"attributes" => array( 'type' => 'multiinput', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'has_dummy' => true, 'label_class' => 'wcfm_title', 'value' => $attributes, 'options' => array(
									"term_name" => array('type' => 'hidden'),
									"name" => array('label' => __('Name', 'wc-frontend-manager'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title'),
									"value" => array('label' => __('Value(s):', 'wc-frontend-manager'), 'type' => 'textarea', 'class' => 'wcfm-textarea wcfm_ele simple variable external grouped booking', 'placeholder' => __('Enter some text, some attributes by "|" separating values.', 'wc-frontend-manager'), 'label_class' => 'wcfm_title'),
									"is_visible" => array('label' => __('Visible on the product page', 'wc-frontend-manager'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title checkbox_title'),
									"is_variation" => array('label' => __('Use as Variation', 'wc-frontend-manager'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title checkbox_title wcfm_ele variable variable-subscription'),
									"tax_name" => array('type' => 'hidden'),
									"is_taxonomy" => array('type' => 'hidden')
									))
								)) );

								if( !empty($attributes_select_type) ) {
									$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_simple_fields_attributes', array(  
									"select_attributes" => array( 'type' => 'multiinput', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'value' => $attributes_select_type, 'options' => array(
									"term_name" => array('type' => 'hidden'),
									"name" => array('label' => __('Name', 'wc-frontend-manager'), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title'),
									"value" => array('label' => __('Value(s):', 'wc-frontend-manager'), 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title'),
									"is_visible" => array('label' => __('Visible on the product page', 'wc-frontend-manager'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title checkbox_title'),
									"is_variation" => array('label' => __('Use as Variation', 'wc-frontend-manager'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title checkbox_title wcfm_ele variable variable-subscription'),
									"tax_name" => array('type' => 'hidden'),
									"is_taxonomy" => array('type' => 'hidden')
									))
									)) );
								}
								?>
							</div>
							<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( array(  
							"variations" => array('type' => 'multiinput', 'class' => 'wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title', 'value' => $variations, 'options' => 
							apply_filters( 'wcfm_product_manage_fields_variations', array(
							"id" => array('type' => 'hidden', 'class' => 'variation_id'),
							"enable" => array('label' => __('Enable', 'wc-frontend-manager'), 'type' => 'checkbox', 'value' => 'enable', 'class' => 'wcfm-checkbox wcfm_ele variable variable-subscription', 'label_class' => 'wcfm_title checkbox_title'),
							"regular_price" => array('label' => __('Regular Price', 'wc-frontend-manager') . '(' . get_woocommerce_currency_symbol() . ')', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_half_ele variable', 'label_class' => 'wcfm_title wcfm_ele wcfm_half_ele_title variable'),
							"stock_status" => array('label' => __('Stock status', 'wc-frontend-manager') , 'type' => 'select', 'options' => array('instock' => __('In stock', 'wc-frontend-manager'), 'outofstock' => __('Out of stock', 'wc-frontend-manager')), 'class' => 'wcfm-select wcfm_ele wcfm_half_ele variable variable-subscription', 'label_class' => 'wcfm_title wcfm_half_ele_title'), 
							"attributes" => array('type' => 'hidden')
							), $variations, $variation_shipping_option_array, $variation_tax_classes_options ) )
						) );
						?>
						  <!-- collapsible 6 -->
						</div>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<div ><a class="btn btnNext next_step1" id="toactivetab2" href="javascript:void(0)" data-nextstep="address"  active-tab="2" data-toggle="tab">Next</a></div>
			</div>

			<div id="address" class="tab-pane fade">
				<div id="wcfm_products_manage_form_gallery_head" >
					<h4 class="user_dashboard_panel_title"><?php _e('Equipment Location', $WCFM->text_domain); ?></h4>
				</div>
				<div class="wcfm_clearfix"></div>
				<p class="wcfm_title"></p><div class="wcfm-message-address" style="display: inline-block;"></div>
				<div class="wcfm-container simple variable external grouped booking">
					<div id="wcfm_products_manage_form_address_expander" class="wcfm-content">
						<p class="weight wcfm_title"><strong>Address</strong></p>
						<input type="text" id="property_address" name="property_address" class="wcfm-text wcfm_ele simple variable booking" value="<?php echo get_post_meta($product_id, 'property_address', true); ?>">
						
						<p class="weight wcfm_title"><strong>City  <span class="required_field">*</span></strong></p>
						<input type="text" id="property_county" name="property_county" class="wcfm-text wcfm_ele simple variable booking" value="<?php echo get_post_meta($product_id, 'property_county', true); ?>">

						<p class="weight wcfm_title"><strong>State</strong></p>
						<input type="text" id="property_state" name="property_state" class="wcfm-text wcfm_ele simple variable booking" value="<?php echo get_post_meta($product_id, 'property_state', true); ?>">

						<p class="weight wcfm_title"><strong>Zip  <span class="required_field">*</span></strong></p>
						<input type="text" id="property_zip" name="property_zip" class="wcfm-text wcfm_ele simple variable booking" value="<?php echo get_post_meta($product_id, 'property_zip', true); ?>">

						<p class="weight wcfm_title"><strong>Country</strong></p>
						<?php print wpestate_country_list(esc_html(get_post_meta($product_id, 'property_country', true)), 'wcfm-select wcfm_ele simple variable external grouped booking'); ?>
					</div>
				</div>
				<div class="wcfm_clearfix"></div>
				<div> 
					<a class="btn btnPrevious" href="#general1"  active-tab="1" data-toggle="tab" data-prevstep="general1">Previous</a>
					<a class="btn btnNext next_step2" href="javascript:void(0)" data-nextstep="image" active-tab="3" data-toggle="tab">Next</a>
				</div>
			</div>	

			<div id="image" class="tab-pane fade">			
				<!-- collapsible 2 -->
				<div id="wcfm_products_manage_form_gallery_head" >
					<h4 class="user_dashboard_panel_title"><?php _e('Featured Image and Gallery', $WCFM->text_domain); ?></h4>
				</div>
				<div class="wcfm_clearfix"></div>
				<p class="wcfm_title"></p><div class="wcfm-message-image" style="display: inline-block;"></div>
				<div class="wcfm-container simple variable external grouped booking">
					<div id="wcfm_products_manage_form_gallery_expander" class="wcfm-content">
						<?php $WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_gallery', array(  "featured_img" => array('gallery_img_id' => $gallery_img_id, 'product_image_gallery' => $product_image_gallery, 'label' => __('', $WCFM->text_domain) , 'type' => 'hidden', 'class' => 'wcfm-text wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'prwidth' => 100, 'value' => $featured_img) ), $gallery_img_urls ) );
						?>
						<div class="uploadcontainer col-sm-4" role="main">
							<div class="box has-advanced-upload" >
								<div class="box__input">
									<svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"/></svg>
									<input type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple />
									<img src="<?php echo get_template_directory_uri()."/img/ajax-loader-gmap.gif";?>" id="image_upload" />
									<label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
									<button type="submit" class="box__button">Upload</button>
								</div>
								<div class="box__uploading">Uploading&hellip;</div>
								<div class="box__success">Done!</div>
								<div class="box__error">Error! <span></span></div>
							</div>
						</div>
						<div class="galeries col-sm-6">
							<?php 
							if($gallery_img_id!=""){
								?>
								<div class="image_container col-sm-6">
									<label for="featured_<?php echo $gallery_img_id;?>">
										<img class="product_add_edit" src="<?php echo $featured_img;?>" />
									</label>
									<input class="featured" type="radio" checked name="featured" value="<?php echo $gallery_img_id;?>" id="featured_<?php echo $gallery_img_id;?>"/>
									<input type="hidden" name="featuredimages[]" value="<?php echo $gallery_img_id;?>" />
								</div>
								<?php	
							}
							if(!empty($gallery_img_urls)){
								foreach($gallery_img_urls as $gallery_img_url){
								?>
								<div class="image_container col-sm-6">
									<label for="featured_<?php echo $gallery_img_url['id'];?>">
										<img class="product_add_edit" src="<?php echo $gallery_img_url['image'];?>" />
									</label>
									<input class="featured" type="radio" name="featured" value="<?php echo $gallery_img_url['id'];?>" id="featured_<?php echo $gallery_img_url['id'];?>"/>
									<input type="hidden" name="featuredimages[]" value="<?php echo $gallery_img_url['id'];?>" />
								</div>
								<?php 	
								}
							}
							?>
						</div>
					</div>
				</div>    
				<script>
					'use strict';

				;( function ( document, window, index )
				{
					// feature detection for drag&drop upload
					var isAdvancedUpload = function()
						{
							var div = document.createElement( 'div' );
							return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
						}();


					// applying the effect for every form
					var forms = document.querySelectorAll( '#wcfm_products_manage_form' );
					Array.prototype.forEach.call( forms, function( form )
					{
						var input		 = form.querySelector( 'input[type="file"]' ),
							label		 = form.querySelector( 'label' ),
							errorMsg	 = form.querySelector( '.box__error span' ),
							restart		 = form.querySelectorAll( '.box__restart' ),
							droppedFiles = false,
							showFiles	 = function( files )
							{
								label.textContent = files.length > 1 ? ( input.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name;
							},
							triggerFormSubmit = function()
							{
								var event = document.createEvent( 'HTMLEvents' );
								event.initEvent( 'submit', true, false );
								form.dispatchEvent( event );
							};

						// letting the server side to know we are going to make an Ajax request
						var ajaxFlag = document.createElement( 'input' );
						ajaxFlag.setAttribute( 'type', 'hidden' );
						ajaxFlag.setAttribute( 'name', 'ajax' );
						ajaxFlag.setAttribute( 'value', 1 );
						form.appendChild( ajaxFlag );

						// automatically submit the form on file select
						input.addEventListener( 'change', function( e )
						{
							   var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
							   if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
								   $('#wcfm_products_manage_form .wcfm-message-image').html('<span class="wcicon-status-cancelled"></span> Please Upload only images.').addClass('wcfm-error').slideDown();
								   $('html, body').animate({
										'scrollTop' : $(".wcfm-message-image").position().top - 200
									});
							    }else{
									$('.wcfm-message-image').html('').removeClass('wcfm-error');
									triggerFormSubmit();
								} 
						});

						// drag&drop files if the feature is available
						if( isAdvancedUpload )
						{
							form.classList.add( 'has-advanced-upload' ); // letting the CSS part to know drag&drop is supported by the browser

							[ 'drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop' ].forEach( function( event )
							{
								form.addEventListener( event, function( e )
								{
									// preventing the unwanted behaviours
									e.preventDefault();
									e.stopPropagation();
								});
							});
							[ 'dragover', 'dragenter' ].forEach( function( event )
							{
								form.addEventListener( event, function()
								{
									form.classList.add( 'is-dragover' );
								});
							});
							[ 'dragleave', 'dragend', 'drop' ].forEach( function( event )
							{
								form.addEventListener( event, function()
								{
									form.classList.remove( 'is-dragover' );
								});
							});
							form.addEventListener( 'drop', function( e )
							{
								droppedFiles = e.dataTransfer.files; // the files that were dropped
								showFiles( droppedFiles );
								triggerFormSubmit();
							});
						}
						// if the form was submitted
						form.addEventListener( 'submit', function( e )
						{
							// preventing the duplicate submissions if the current one is in progress
							if( form.classList.contains( 'is-uploading' ) ) return false;

							form.classList.add( 'is-uploading' );
							form.classList.remove( 'is-error' );

							if( isAdvancedUpload ) // ajax file upload for modern browsers
							{
								e.preventDefault();

								// gathering the form data
								var ajaxData = new FormData( form );
								if( droppedFiles )
								{
									Array.prototype.forEach.call( droppedFiles, function( file )
									{
										ajaxData.append( input.getAttribute( 'name' ), file );
									});
								}
								$("#image_upload").show();
								// ajax request
								var ajax = new XMLHttpRequest();
								ajax.open( 'POST', wc_add_to_cart_params.ajax_url+"?action=wcfupload", true );
								ajax.onload = function()
								{
									form.classList.remove( 'is-uploading' );
									if( ajax.status >= 200 && ajax.status < 400 )
									{
										$("#image_upload").hide();
										var data = JSON.parse( ajax.responseText );
										
										form.classList.add( data.success == true ? 'is-success' : 'is-error' );
										if( !data.success ) 
											errorMsg.textContent = data.error;
										else{
											//
											var galaryhtmlimage 	=	"";
											if(data.attachement_ids.length>0){
												jQuery.each(data.attachement_ids, function(index, value){
													galaryhtmlimage	+=	'<div class="image_container col-sm-6"> <label for="featured_'+value.id+'"> <img class="product_add_edit" src="'+value.image+'" /> </label> <input class="featured" type="radio" name="featured" value="'+value.id+'" id="featured_'+value.id+'"/> <input type="hidden" name="featuredimages[]" value="'+value.id+'" /> </div>';
												});
											}
											jQuery(".galeries").append(galaryhtmlimage);
											// $('#wcfm_products_manage_form').find('#featured_img').val(data.attachement_ids[0]);
										}
									}
									else alert( 'Error. Please, contact the webmaster!' );
								};

								ajax.onerror = function()
								{
									form.classList.remove( 'is-uploading' );
									alert( 'Error. Please, try again!' );
								};

								ajax.send( ajaxData );
							}
							else // fallback Ajax solution upload for older browsers
							{
								var iframeName	= 'uploadiframe' + new Date().getTime(),
									iframe		= document.createElement( 'iframe' );

									$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

								iframe.setAttribute( 'name', iframeName );
								iframe.style.display = 'none';

								document.body.appendChild( iframe );
								form.setAttribute( 'target', iframeName );

								iframe.addEventListener( 'load', function()
								{
									var data = JSON.parse( iframe.contentDocument.body.innerHTML );
									form.classList.remove( 'is-uploading' )
									form.classList.add( data.success == true ? 'is-success' : 'is-error' )
									form.removeAttribute( 'target' );
									if( !data.success ) errorMsg.textContent = data.error;
									iframe.parentNode.removeChild( iframe );
								});
							}
						});


						// restart the form if has a state of error/success
						Array.prototype.forEach.call( restart, function( entry )
						{
							entry.addEventListener( 'click', function( e )
							{
								e.preventDefault();
								form.classList.remove( 'is-error', 'is-success' );
								input.click();
							});
						});

						// Firefox focus bug fix for file input
						input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
						input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });

					});
				}( document, window, 0 ));
				</script>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<div > 
				<a class="btn btnPrevious" href="#image"  active-tab="1" data-toggle="tab" data-prevstep="address">Previous</a>
				<a class="btn btnNext next_step3" href="javascript:void(0)" data-nextstep="shipping" active-tab="4" data-toggle="tab">Next</a>
				 </div>
			</div>
			<div id="shipping" class="tab-pane fade">		
			<?php if( $allow_shipping = apply_filters( 'wcfm_is_allow_shipping', true ) ) { ?>
				<!-- collapsible 5 -->		
				<div  id="wcfm_products_manage_form_shipping_head"><h4 class="user_dashboard_panel_title"><?php _e('Hauling Parameters (optional)', $WCFM->text_domain); ?></h4></div>
				<div class="wcfm_clearfix"></div>
				<p class="wcfm_title"></p><div class="wcfm-message-shipping" style="display: inline-block;"></div>
				<div class="wcfm-container simple variable nonvirtual booking">
					<div id="wcfm_products_manage_form_shipping_expander" class="wcfm-content">
						<?php
						$new_shipping_array = [];
						foreach ($shipping_option_array  as $key => $value) {
							if ($key == '_no_shipping_class') {
								$new_shipping_array[$key] = 'No transportation class';
							}
							else{
								$new_shipping_array[$key] = $value;
							}
						}

						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_shipping', 
						array(  
							"weight" => array('label' => __('Weight', $WCFM->text_domain)  , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $weight),
							"length" => array('label' => __('Length', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $length),
							"width" => array('label' => __('Width', $WCFM->text_domain) , 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $width),
							"height" => array('label' => __('Height', $WCFM->text_domain), 'type' => 'text', 'class' => 'wcfm-text wcfm_ele simple variable booking', 'label_class' => 'wcfm_title', 'value' => $height)
						), $product_id ) );
					  ?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<?php }  
				if( $allow_tax = apply_filters( 'wcfm_is_allow_tax', true ) ) {
					if ( wc_tax_enabled() ) { 
					?>
				<!-- collapsible 6 -->
					<div class="page_collapsible products_manage_tax simple variable" id="wcfm_products_manage_form_tax_head"><h4 class="user_dashboard_panel_title"><?php _e('Tax', $WCFM->text_domain); ?></h4></div>
					<div class="wcfm-container simple variable">
						<div id="wcfm_products_manage_form_tax_expander" class="wcfm-content">
							<?php
							$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_simple_fields_tax', array(  
								"tax_status" => array('label' => __('Tax Status', $WCFM->text_domain) , 'type' => 'select', 'options' => array( 'taxable' => __( 'Taxable', $WCFM->text_domain ), 'shipping' => __( 'Shipping only', $WCFM->text_domain ), 'none' => _x( 'None', 'Tax status', $WCFM->text_domain ) ), 'class' => 'wcfm-select wcfm_ele simple variable', 'label_class' => 'wcfm_title', 'value' => $tax_status, 'hints' => __( 'Define whether or not the entire product is taxable, or just the cost of shipping it.', $WCFM->text_domain )),
								"tax_class" => array('label' => __('Tax Class', $WCFM->text_domain) , 'type' => 'select', 'options' => $tax_classes_options, 'class' => 'wcfm-select wcfm_ele simple variable', 'label_class' => 'wcfm_title', 'value' => $tax_class, 'hints' => __( 'Choose a tax class for this product. Tax classes are used to apply different tax rates specific to certain types of product.', $WCFM->text_domain ))
							)) );
							  ?>
						</div>
					</div>
					<!-- end collapsible -->
					<div class="wcfm_clearfix"></div>
					<?php 
					} 
				} ?>
				<div>
					<a class="btn btnPrevious" href="#shipping"  active-tab="4" data-toggle="tab" data-prevstep="image">Previous</a>
					<a class="btn btnNext next_step4" href="javascript:void(0)" data-nextstep="linkedpro" active-tab="5" data-toggle="tab">Next</a>
				</div>
			</div>
			<div id="linkedpro" class="tab-pane fade">		
			<?php if( $allow_advanced = apply_filters( 'wcfm_is_allow_linked', true ) ) { ?>
			<!-- collapsible 9 - Linked Product -->
			<div  id="wcfm_products_manage_form_linked_head"><h4 class="user_dashboard_panel_title"><?php /* _e('Linked Products', $WCFM->text_domain); */ ?></h4></div>
				<div class="wcfm_clearfix"></div>
				<p class="wcfm_title"></p><div class="wcfm-message-linkedpro" style="display: inline-block;"></div>
				<div class="wcfm-container simple variable external grouped">
					<div id="wcfm_products_manage_form_linked_expander" class="wcfm-content">
						<?php
							$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'product_manage_fields_linked', array(  
								"upsell_ids" => array('label' => __('Up-sells', $WCFM->text_domain) , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'options' => $products_array, 'value' => $upsell_ids, 'hints' => __( 'Up-sells are products which you recommend instead of the currently viewed product, for example, products that are more profitable or better quality or more expensive.', $WCFM->text_domain )),
								"crosssell_ids" => array('label' => __('Cross-sells', $WCFM->text_domain) , 'type' => 'select', 'attributes' => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ), 'class' => 'wcfm-select wcfm_ele simple variable external grouped booking', 'label_class' => 'wcfm_title', 'options' => $products_array, 'value' => $crosssell_ids, 'hints' => __( 'Cross-sells are products which you promote in the cart, based on the current product.', $WCFM->text_domain ))
							)) );
						?>
					</div>
				</div>
				<!-- end collapsible -->
				<div class="wcfm_clearfix"></div>
				<?php } ?>
				<?php do_action( 'end_wcfm_products_manage', $product_id ); ?>
				<div id="wcfm_products_simple_submit" >
					<a class="btn btnPrevious" href="#shipping"  active-tab="6" data-toggle="tab" data-prevstep="shipping">Previous</a>
					<button class="btn btnNext" type="submit" name="submit-data" id="wcfm_products_simple_submit_button">
						<i class="fa fa-spinner fa-pulse loading_icon" style="display: none;"></i> 
						<span> <?php 
							if( isset( $_GET['listing_edit'] ) ){ 
								_e( 'Update', $WCFM->text_domain ); 
							} else if( current_user_can( 'publish_products' ) ) { 
								_e( 'Submit', $WCFM->text_domain ); 
							} else { 
								_e( 'Submit for Review', $WCFM->text_domain ); 
							} ?>
						</span>
					</button>
					<?php if( ( isset( $_GET['listing_edit'] ) && empty( $_GET['listing_edit'] ) ) || ( isset( $_GET['listing_edit'] ) && !empty( $_GET['listing_edit'] ) && ( get_post_status( $wp->query_vars['wcfm-products-manage'] ) == 'draft' ) ) ) { ?>
						<button type="submit" name="submit-data" id="wcfm_products_simple_draft_button">
							<i class="fa fa-spinner fa-pulse loading_icon" style="display: none;"></i> 
							<span>
								<?php _e( 'Draft', $WCFM->text_domain ); ?>
							</span>
						</button>
					<?php } ?>
				</div>
				<div class="wcfm-message" tabindex="-1"></div>
			</div>
		</div>
	</form>
	<?php
	do_action( 'after_wcfm_products_manage' );
	?>
</div>
<script>
jQuery(document).ready(function(){
	
	if ( jQuery("#attributes_is_visible_0").prop('checked') == false ) {
		jQuery('#attributes_name_0').val('rentalrateandorsale');
		jQuery('#attributes_value_0').val('equipmentprice | rentalrateperday | rentalrateperweek | rentalratepermonth');
		jQuery('#attributes_is_visible_0').prop('checked', true);
		
		if ( jQuery('#attributes_name_0').val() != '' && jQuery('#attributes_value_0').val() != '' ) {
			jQuery('#attributes_is_variation_0').click();
		}

		jQuery('[id^="variations_enable_"]').prop('checked', true);
	}
	jQuery('[class^="variations_enable_"]').hide();
	jQuery('[id^="variations_enable_"]').hide();


	
    jQuery('a[data-toggle="tooltip"]').tooltip();   
    jQuery('button[data-toggle="tooltip"]').tooltip();   


	jQuery('#pa_color').remove();

	jQuery('.uploaded_images').each( function() {
		if ( jQuery(this).attr('data-imageid') == '' ) {
			jQuery(this).remove();
		}
	});

	jQuery(document).on('click', '.fa-trash-o', function(){
		if ( jQuery(this).hasClass('featured_img') ) {
			jQuery('#featured_img').val('');
		}
	});

	setTimeout( function(){
		jQuery('#featured_img_button').show();
		jQuery('#featured_img_remove_button').hide();
		jQuery('.blockOverlay').remove();
	},1000);

	jQuery('.wcfm_title').each( function() {
		if ( jQuery(this).html() == '<strong>Product Color</strong>' ) {
			jQuery(this).remove();
		}
	});

	var product_type = '<?php echo $product_type; ?>';
	if ( product_type == 'variable' ) {
		if ( !jQuery('.products_manage_variations').hasClass('collapse-open') ) {
			jQuery('.products_manage_variations').click();
		}


		jQuery('#wcfm_products_manage_form .selectbox_title').text('Select Rent and/or sale type');
		jQuery('select option[value=""]').text('Select Rent and/or sale type');
		jQuery('select option[value="equipmentprice"]').text('Equipment Price');
		jQuery('select option[value="rentalrateperday"]').text('Rental Rate/Day');
		jQuery('select option[value="rentalrateperweek"]').text('Rental Rate/Week');
		jQuery('select option[value="rentalratepermonth"]').text('Rental Rate/Month');

		jQuery('#product_parent_cats option[value=""]').text('Choose ...');
		jQuery('#_wc_booking_calendar_display_mode option[value=""]').text('Choose ...');
	}

	if ( product_type != '' && product_type != 'booking' ) {
		jQuery('.menuLinkedpro').html('Linked Equipments');
	}

	jQuery('#product_type').on('change', function() {
		if ( jQuery(this).val() == 'variable' && !jQuery('.products_manage_variations').hasClass('collapse-open') ) {
			jQuery('.products_manage_variations').click();
		}

		setTimeout( function() { 
			jQuery('#wcfm_products_manage_form .selectbox_title').text('Select Rent and/or sale type');
			jQuery('select option[value=""]').text('Select Rent and/or sale type');
			jQuery('select option[value="equipmentprice"]').text('Equipment Price');
			jQuery('select option[value="rentalrateperday"]').text('Rental Rate/Day');
			jQuery('select option[value="rentalrateperweek"]').text('Rental Rate/Week');
			jQuery('select option[value="rentalratepermonth"]').text('Rental Rate/Month');

			jQuery('#product_parent_cats option[value=""]').text('Choose ...');
			jQuery('#_wc_booking_calendar_display_mode option[value=""]').text('Choose ...');
			jQuery('#attributes_is_variation_0').prop('checked', true);
		},1000);

		if ( jQuery(this).val() != 'booking' ) {
			jQuery('.menuLinkedpro').html('Linked Equipments');
		}
		else{
			jQuery('.menuLinkedpro').html('Availability/Pricing');
		}
	});
	$('.tab-content').on('keyup', '.valreq', function() { 
		if ( $(this).val().length != 0 ) {
			$('#title').css('border-color', '');
			$('.wcfm-error').hide();
		}
		else{
			$('#title').css('border-color', '#D8000C');
			$('.wcfm-error').show();
		}
	});
});

</script>
<script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('#product_parent_cats').on('change', function() {
        	var _this = jQuery(this);
        	_this.attr('disabled', 'disabled');
            var thisVal = _this.val();
        	jQuery('#product_subcats, #wcfm_products_manage_form_taxonomy_expander .select2-container').remove();
        	jQuery('.product_subcats').hide();
        	jQuery('.cat_loding').show();
        	if ( thisVal != '' ) {
	            jQuery.ajax({
	                type: 'POST',
	                url: '<?php echo admin_url("/admin-ajax.php"); ?>',
	                data: {
	                    action: 'load_prodoucts_subcategory',
	                    'id': thisVal,
	                },
	                success: function(data) {
	    				_this.removeAttr('disabled');
	    				jQuery('.cat_loding').hide();
	                    if ( data != 'not_found' && data != 0 && data != '' ) {
	                    	jQuery('.product_subcats').show();
	                    	jQuery(data).insertAfter('.product_subcats_label');
	                    }
	                }
	            });
	        }
	        else{
	        	_this.removeAttr('disabled');
				jQuery('.cat_loding').hide();
	        }
        });

        jQuery("#product_subcats").select2({
            placeholder: "Choose ..."
        });
    });
</script>
<?php if( !isset( $_GET['listing_edit']) && isset( $_GET['e']) ) { ?>
<script type="text/javascript">
	jQuery(document).ready( function() {
		var cattype = '<?php echo $_GET["e"]; ?>';
		if ( cattype == 0 ) {
			jQuery('#product_parent_cats option:contains("Construction")').attr('selected', 'selected');
		}
		if ( cattype == 1 ) {
			jQuery('#product_parent_cats option:contains("Agriculture")').attr('selected', 'selected');
		}
		jQuery('#product_parent_cats').trigger('change');
	});
</script>
<?php } ?>
