<?php
/**
 * WCFM plugin controllers
 *
 * Plugin Products Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers
 * @version   1.0.0
 */

class WCFM_Products_Controller {
	
	public function __construct() {
		global $WCFM;
		
		$this->processing();
	}
	
	public function processing() {
		global $WCFM, $wpdb, $_POST;
		
		$length = get_option('posts_per_page');
		$offset = $_POST['start'];
		
		$args = array(
			'posts_per_page'   => $length,
			'offset'           => $offset,
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
			'post_status'      => array('draft', 'pending', 'publish'),
			'suppress_filters' => true 
		);
		$for_count_args = $args;
		
		// if( isset( $_POST['search'] ) && !empty( $_POST['search']['value'] )) $args['s'] = $_POST['search']['value'];
		if( isset($_POST['wpestate_prop_title']) && !empty($_POST['wpestate_prop_title']) ){
			$args['s'] = $_POST['wpestate_prop_title'];
		} 
		
		$args = apply_filters( 'wcfm_products_args', $args );
		
		$wcfm_products_array = get_posts( $args );
		
		// Get Product Count
		$pro_count = 0;
		$filtered_pro_count = 0;
		$for_count_args['posts_per_page'] = -1;
		$for_count_args['offset'] = 0;
		$for_count_args = apply_filters( 'wcfm_products_args', $for_count_args );
		$wcfm_products_count = get_posts( $for_count_args );
		$pro_count = count($wcfm_products_count);
		// Get Filtered Post Count
		$args['posts_per_page'] = -1;
		$args['offset'] = 0;
		$wcfm_filterd_products_array = get_posts( $args );
		$filtered_pro_count = count($wcfm_filterd_products_array);
		
		
		// Generate Products JSON
		$wcfm_products_json = '';
		$wcfm_products_json = '{
			"draw": ' . $_POST['draw'] . ',
			"recordsTotal": ' . $pro_count . ',
			"recordsFiltered": ' . $filtered_pro_count . ',
			"data": ';
		if(!empty($wcfm_products_array)) {
			$index = 0;
			$wcfm_products_json_arr = array();
			foreach($wcfm_products_array as $wcfm_products_single) {
				$the_product = wc_get_product( $wcfm_products_single );
				// Thumb
				$wcfm_products_json_arr[$index][] =  '<a href="' . get_wcfm_edit_product_url($wcfm_products_single->ID, $the_product) . '">' . $the_product->get_image( 'thumbnail' ) . '</a>';
				
				// Title
				if( current_user_can( 'edit_published_products' ) ) {
					$wcfm_products_json_arr[$index][] =  '<a href="'.site_url().'/edit-equipment?listing_edit='.$wcfm_products_single->ID.'">' . $wcfm_products_single->post_title . '</a>';
				} else {
					$wcfm_products_json_arr[$index][] =  $wcfm_products_single->post_title;
				}
				
				// SKU
				$wcfm_products_json_arr[$index][] =  ( get_post_meta($wcfm_products_single->ID, '_sku', true) ) ? get_post_meta($wcfm_products_single->ID, '_sku', true) : '-';
				
				// Status
				$wcfm_products_json_arr[$index][] =  '<span class="product-status product-status-' . $wcfm_products_single->post_status . '">' . ucfirst( $wcfm_products_single->post_status ) . '</span>';
				
				// Stock
				if ( $the_product->is_in_stock() ) {
					$stock_html = '<span class="instock">' . __( 'In stock', 'woocommerce' ) . '</span>';
				} else {
					$stock_html = '<span class="outofstock">' . __( 'Out of stock', 'woocommerce' ) . '</span>';
				}
		
				// If the product has children, a single stock level would be misleading as some could be -ve and some +ve, some managed/some unmanaged etc so hide stock level in this case.
				if ( $the_product->managing_stock() && ! sizeof( $the_product->get_children() ) ) {
					$stock_html .= ' (' . $the_product->get_total_stock() . ')';
				}
				$wcfm_products_json_arr[$index][] =  apply_filters( 'woocommerce_admin_stock_html', $stock_html, $the_product );
				
				// Price
				$wcfm_products_json_arr[$index][] =  $the_product->get_price_html() ? $the_product->get_price_html() : '<span class="na">&ndash;</span>';
				
				// Type
				$pro_type = '';
				if ( 'grouped' == $the_product->product_type ) {
					$pro_type = '<span class="product-type tips grouped wcicon-grouped text_tip" data-tip="' . esc_attr__( 'Grouped', $WCFM->text_domain ) . '"></span>';
				} elseif ( 'external' == $the_product->product_type ) {
					$pro_type = '<span class="product-type tips external wcicon-external text_tip" data-tip="' . esc_attr__( 'External/Affiliate', $WCFM->text_domain ) . '"></span>';
				} elseif ( 'simple' == $the_product->product_type ) {
		
					if ( $the_product->is_virtual() ) {
						$pro_type = '<span class="product-type tips virtual wcicon-virtual text_tip" data-tip="' . esc_attr__( 'Virtual', $WCFM->text_domain ) . '"></span>';
					} elseif ( $the_product->is_downloadable() ) {
						$pro_type = '<span class="product-type tips downloadable wcicon-downloadable text_tip" data-tip="' . esc_attr__( 'Downloadable', $WCFM->text_domain ) . '"></span>';
					} else {
						$pro_type = '<span class="product-type tips simple wcicon-simple text_tip" data-tip="' . esc_attr__( 'Simple', $WCFM->text_domain ) . '"></span>';
					}
		
				} elseif ( 'variable' == $the_product->product_type ) {
					$pro_type = '<span class="product-type tips variable wcicon-variable text_tip" data-tip="' . esc_attr__( 'Variable', $WCFM->text_domain ) . '"></span>';
				} else {
					// Assuming that we have other types in future
					$pro_type = '<span class="product-type tips wcicon-' . $the_product->product_type . ' text_tip ' . $the_product->product_type . '" data-tip="' . ucfirst( $the_product->product_type ) . '"></span>';
				}
				$wcfm_products_json_arr[$index][] =  $pro_type;
				
				// Date
				$wcfm_products_json_arr[$index][] =  date( 'F j, Y', strtotime($wcfm_products_single->post_date));
				
				// Action
				$actions = '<a class="wcfm-action-icon" target="_blank" href="' . get_permalink( $wcfm_products_single->ID ) . '"><span class="fa fa-eye text_tip" data-tip="' . esc_attr__( 'View', $WCFM->text_domain ) . '"></span></a>';
				if( $wcfm_products_single->post_status == 'publish' ) {
					$actions .= '<a class="wcfm-action-icon" href="' . get_wcfm_edit_product_url($wcfm_products_single->ID, $the_product) . '"><span class="fa fa-edit text_tip" data-tip="' . esc_attr__( 'Edit', $WCFM->text_domain ) . '"></span></a>';
					$actions .= ( current_user_can( 'delete_published_products' ) ) ? '<a class="wcfm-action-icon wcfm_product_delete" href="#" data-proid="' . $wcfm_products_single->ID . '"><span class="fa fa-trash-o text_tip" data-tip="' . esc_attr__( 'Delete', $WCFM->text_domain ) . '"></span></a>' : '';
				} else {
					$actions .= ( current_user_can( 'edit_products' ) ) ? '<a class="wcfm-action-icon" href="' . get_wcfm_edit_product_url($wcfm_products_single->ID, $the_product) . '"><span class="fa fa-edit text_tip" data-tip="' . esc_attr__( 'Edit', $WCFM->text_domain ) . '"></span></a>' : '';
					$actions .= ( current_user_can( 'delete_products' ) ) ? '<a class="wcfm_product_delete wcfm-action-icon" href="#" data-proid="' . $wcfm_products_single->ID . '"><span class="fa fa-trash-o text_tip" data-tip="' . esc_attr__( 'Delete', $WCFM->text_domain ) . '"></span></a>' : '';
				}
				$wcfm_products_json_arr[$index][] =  apply_filters ( 'wcfm_products_actions',  $actions, $the_product );
				$index++;
				?>
				<div class="col-md-4 flexdashbaord" id="proid-<?php echo $wcfm_products_single->ID; ?>" >
				    <div class="dasboard-prop-listing">
				    
				        <div class="blog_listing_image dashboard_imagine">

				                <?php 
				            if( current_user_can( 'edit_published_products' ) ) {
				                	 $wcfm_product_image =  '<a href="'.site_url().'/edit-equipment?listing_edit='.$wcfm_products_single->ID.'">' . $the_product->get_image( 'full' ) . '</a>';  
				                	} else { 
				                		$wcfm_product_image = $the_product->get_image( 'full' );
				                	}
				                	echo $wcfm_product_image;                                                    
				                  ?>
				        </div>
				        
				        <div class="user_dashboard_status">
				       		 <?php

				       		 if( trim($wcfm_products_single->post_status) == 'publish' ){

				       		  	$custom_post_status = "published";
				       		 }
				       		 else{
				       		 	$custom_post_status = $wcfm_products_single->post_status ;	
				       		 }
				       		 
				         	 if( current_user_can( 'edit_published_products' ) ) {
				          	 	$wcfm_product_status =  '<span class="product-status product-status-' . $wcfm_products_single->post_status . '">' . ucfirst( $custom_post_status ) . '</span>';
				      		 } else {
				       		 	$wcfm_product_status = $custom_post_status;
				      		 }
				      		 echo $wcfm_product_status;
				          	 ?>
				        </div>

				    <div class="prop-info">
				    	<div class="title_and_price">
				            <h4 class="listing_title">
				                <?php 
								if( current_user_can( 'edit_published_products' ) ) {
									$wcfm_product_title =  '<a href="'.site_url().'/edit-equipment?listing_edit='.$wcfm_products_single->ID.'" class="wcfm_product_title">' . $wcfm_products_single->post_title . '</a>';
								} else {
									$wcfm_product_title =  $wcfm_products_single->post_title;
								}
								echo $wcfm_product_title;
								?>	 
				            </h4>
				        </div>

						<?php
				        /*<div class="user_dashboard_listed">
							<?php
							if( current_user_can( 'edit_published_products' ) ) {  
							$wcfm_product_sku =  ( get_post_meta($wcfm_products_single->ID, '_sku', true) ) ? get_post_meta($wcfm_products_single->ID, '_sku', true) : '-';
							} else {

							$wcfm_product_sku = $wcfm_products_single->ID;
							} echo $wcfm_product_sku;
							?>
				       </div> */ ?>

				        <div class="user_dashboard_listed title_and_price">
				            <?php
			            	$pro_type = '';
							if ( 'grouped' == $the_product->product_type ) {
							$pro_type = '<span class="product-type tips grouped wcicon-grouped text_tip" data-tip="' . esc_attr__( 'Grouped', $WCFM->text_domain ) . '"></span>';
							} elseif ( 'external' == $the_product->product_type ) {
							$pro_type = '<span class="product-type tips external wcicon-external text_tip" data-tip="' . esc_attr__( 'External/Affiliate', $WCFM->text_domain ) . '"></span>';
							} elseif ( 'simple' == $the_product->product_type ) {
		
								if ( $the_product->is_virtual() ) {
									$pro_type = '<span class="product-type tips virtual wcicon-virtual text_tip" data-tip="' . esc_attr__( 'Virtual', $WCFM->text_domain ) . '"></span>';
								} elseif ( $the_product->is_downloadable() ) {
									$pro_type = '<span class="product-type tips downloadable wcicon-downloadable text_tip" data-tip="' . esc_attr__( 'Downloadable', $WCFM->text_domain ) . '"></span>';
								} else {
									$pro_type = '<span class="product-type tips simple wcicon-simple text_tip" data-tip="' . esc_attr__( 'Simple', $WCFM->text_domain ) . '"></span>';
								}

								$proType = 'For Sale';
			
							} elseif ( 'variable' == $the_product->product_type ) {
								$pro_type = '<span class="product-type tips variable wcicon-variable text_tip" data-tip="' . esc_attr__( 'Variable', $WCFM->text_domain ) . '"></span>';

								$proType = 'For Rent and/or sale';
							} else {
								// Assuming that we have other types in future
								$pro_type = '<span class="product-type tips wcicon-' . $the_product->product_type . ' text_tip ' . $the_product->product_type . '" data-tip="' . ucfirst( $the_product->product_type ) . '"></span>';
								
								$proType = 'For Rent';
							}
							$wcfm_product_type =  $pro_type;
							// echo $wcfm_product_type;
							?>
							<h4 class="listing_title custom_listing_title"><?php echo $proType; ?></h4>
							<div class="user_dashboard_listed">
					            <?php
					              if( current_user_can( 'edit_published_products' ) ) {  
					              $wcfm_product_price =  $the_product->get_price_html() ? $the_product->get_price_html() : '<span class="na">&ndash;</span>';  
					                 } else {
	 									 $wcfm_product_price = $the_product->get_price_html();
	 									}echo $wcfm_product_price;
					               ?>                  
					        </div>
			            </div>


				            <div class="user_dashboard_listed">
				            <?php
				            //if( current_user_can( 'edit_published_products' ) ) {  
					            $wcfm_product_date =  date( 'F j, Y', strtotime($wcfm_products_single->post_date));
					        //}
				        	echo  $wcfm_product_date;
				            ?>
				            </div>



				            <div class="user_dashboard_listed">
				            <?php

				             if ( $the_product->is_in_stock() ) {

					$stock_html = '<span class="instock">' . __( 'In stock', 'woocommerce' ) . '</span>';
				} else {
					$stock_html = '<span class="outofstock">' . __( 'Out of stock', 'woocommerce' ) . '</span>';
				}
		
			
				if ( $the_product->managing_stock() && ! sizeof( $the_product->get_children() ) ) {
					$stock_html .= ' (' . $the_product->get_total_stock() . ')';
				}else {
				 $wcfm_product_stock =  apply_filters( 'woocommerce_admin_stock_html', $stock_html, $the_product ); 
				 	} echo $wcfm_product_stock;
				        ?>
				            </div>

				                     
				             
				                <div class="info-container">
				                <?php
             	//if( current_user_can( 'edit_published_products' ) ) {  
                   $actions = '<a class="dashboad-tooltip" target="_blank" href="' . get_permalink( $wcfm_products_single->ID ) . '"><i class="fa fa-star favprop"></i><span  data-tip="' . esc_attr__( 'View', $WCFM->text_domain ) . '"></span></a>';
				//}

				if( $wcfm_products_single->post_status == 'publish' ) {
					$actions .= '<a class="dashboad-tooltip" href="'.site_url().'/edit-equipment?listing_edit='.$wcfm_products_single->ID.'"><i class="fa fa-pencil editprop"></i><span  data-tip="' . esc_attr__( 'Edit', $WCFM->text_domain ) . '"></span></a>';
					$actions .= '<a class="dashboad-tooltip equ_delete" href="javascript:void(0);" data-proid="' . $wcfm_products_single->ID . '"><i class="fa fa-times deleteprop"></i><span  data-tip="' . esc_attr__( 'Delete', $WCFM->text_domain ) . '"></span></a>';
				} else {
					$actions .= '<a class="dashboad-tooltip" href="'.site_url().'/edit-equipment?listing_edit='.$wcfm_products_single->ID.'"><i class="fa fa-pencil editprop"></i><span  data-tip="' . esc_attr__( 'Edit', $WCFM->text_domain ) . '"></span></a>';
					$actions .=  '<a class="dashboad-tooltip equ_delete" href="javascript:void(0);" data-proid="' . $wcfm_products_single->ID . '"><i class="fa fa-times deleteprop"></i><span data-tip="' . esc_attr__( 'Delete', $WCFM->text_domain ) . '"></span></a>';
				}
				 $wcfm_product_actions =  apply_filters ( 'wcfm_products_actions',  $actions, $the_product );
				$index++;

				echo  $wcfm_product_actions;
				             ?> </div>

           
				                    </div> 
				    
				    </div>
				 </div>	
				<?php 
			}												
		}
		if( !empty($wcfm_products_json_arr) ) $wcfm_products_json .= json_encode($wcfm_products_json_arr);
		else $wcfm_products_json .= '[]';
		$wcfm_products_json .= '
													}';
													

	}
}