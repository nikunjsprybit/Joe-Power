<div class="header_media">
    <?php 
    global $page_tax;
    global $global_header_type;
    global $header_type;

    $show_adv_search_status = get_option('wp_estate_show_adv_search','');
    if(isset($post->ID)){
        $header_type =  get_post_meta ( $post->ID, 'header_type', true);
    }

    $global_header_type = get_option('wp_estate_header_type','');
    if(is_singular('estate_agent')){
        $global_header_type = get_option('wp_estate_user_header_type','');
    }

    if(!is_404()){
        if( is_tax() ){
            $taxonmy = get_query_var('taxonomy');
            if ( $taxonmy !=='property_action_category' && $taxonmy!='property_category' && esc_html(get_option('wp_estate_use_upload_tax_page',''))==='yes' ){
				if($taxonmy=="dc_vendor_shop"){
					
					$term                           = 	get_query_var( 'term' );
					$term_data                      = 	get_queried_object();
					$place_id                       = 	$term_data->term_id;
					$category_attach_id             = 	'';
					$category_tax                   = 	'';
					$category_featured_image        = 	'';
					$category_name                  = 	'';
					$category_featured_image_url    = 	'';
					$term_meta                      = 	get_option( "taxonomy_$place_id");
					$category_tagline               = 	'';
					$page_tax                       = 	'';
					$vendor 						= 	get_wcmp_vendor_by_term(get_queried_object()->term_id);	
					$category_featured_image_url 	= 	get_the_author_meta( 'custom_picture' , $vendor->ID);
					if($category_featured_image_url==''){
						$category_featured_image_url		=	get_template_directory_uri().'/img/default_user.png';
					}
					if(isset($term_meta['category_tax'])){
						$category_tax=$term_meta['category_tax'];
						$term= get_term( $place_id, $category_tax);
						$category_name=$term->name;
					}

					if(isset($term_meta['category_tagline'])){
						$category_tagline=stripslashes ( $term_meta['category_tagline'] );           
					}

					if(isset($term_meta['page_tax'])){
						$page_tax=$term_meta['page_tax'];           
					}
				}else{
					$term                           = 	get_query_var( 'term' );
					$term_data                      = 	get_queried_object();
					$place_id                       = 	$term_data->term_id;
					$category_attach_id             = 	'';
					$category_tax                   = 	'';
					$category_featured_image        = 	'';
					$category_name                  = 	'';
					$category_featured_image_url    = 	'';
					$term_meta                      = 	get_option( "taxonomy_$place_id");
					$category_tagline               = 	'';
					$page_tax                       = 	'';
						
					$thumbnail_id 					= 	get_woocommerce_term_meta($term_data->term_id, 'thumbnail_id', true);
					if($thumbnail_id!=0){					
						// get the image URL for parent category
						$category_featured_image_url 	= wp_get_attachment_url($thumbnail_id);
					}
					else{
						$category_featured_image_url 	= 	get_site_url().'wp-content/uploads/2017/08/image-5-1.jpg';
					}
					if(isset($term_meta['category_tax'])){
						$category_tax=$term_meta['category_tax'];
						$term= get_term( $place_id, $category_tax);
						$category_name=$term->name;
					}

					if(isset($term_meta['category_tagline'])){
						$category_tagline=stripslashes ( $term_meta['category_tagline'] );           
					}

					if(isset($term_meta['page_tax'])){
						$page_tax=$term_meta['page_tax'];           
					}
				}
                
				
                print '<div class="listing_main_image" id="listing_main_image_photo"  style="background-image: url('.$category_featured_image_url.')">';
                print '<h1 class="entry-title entry-tax">'.ucfirst($term_data->name).'</h1>';
                print '<div class="tax_tagline">'.$category_tagline.'</div>';
                print '<div class="img-overlay"></div>';
                print '</div>';
            }else{
                wpestate_show_media_header('global', $global_header_type,'','','');
            }
        } else{ 
			
            if(isset($post->ID)){
                $custom_image  = esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
                $rev_slider    = esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 
            }

            if(  is_category() || is_tag()|| is_search() ){ // dashbaord page
                wpestate_show_media_header('global', $global_header_type,'','','');
            }
            else if (!$header_type==0){
                if( ! wpestate_check_if_admin_page($post->ID) ){
                    wpestate_show_media_header('NOT global', $global_header_type,$header_type,$rev_slider,$custom_image);
                } else{
                    wpestate_show_media_header('global', 0,'','','');
                }
            }
            else {    // we don't have particular settings - applt global header
                if( ! wpestate_check_if_admin_page($post->ID) ) {
                    wpestate_show_media_header('global', $global_header_type,'','','');
                } else {
                    wpestate_show_media_header('global', 0,'','','');
                }

            } // end if header
        }
    }// end if 404    

    if(!is_front_page()) {
		
        $show_adv_search_general = get_option('wp_estate_show_adv_search_general','');
        if( isset($post->ID)){
            $header_type = get_post_meta ( $post->ID, 'header_type', true);
        }

        $global_header_type = get_option('wp_estate_header_type','');
        if(is_singular('estate_agent')){
            $global_header_type = get_option('wp_estate_user_header_type','');
        }

        $show_mobile = 0;  
        $show_adv_search_slider  = get_option('wp_estate_show_adv_search_slider','');

        if($show_adv_search_general ==  'yes' && !is_404() ){
            if( !is_tax() && !is_category() && !is_archive() && !is_tag() && !is_search() ){
                if(  wpestate_check_if_admin_page($post->ID) ){

                }else if($header_type == 1 ){
                    //nothing  
                }else if($header_type == 0){ 
                    if($global_header_type==4){
                        $show_mobile=1;
                        get_template_part('templates/advanced_search');  
                    }else if( $global_header_type==0){
                        //nonthing 
                    }else{
                        if($show_adv_search_slider=='yes'){             
                            $show_mobile=1;
                            get_template_part('templates/advanced_search');  
                        }
                    }
                }else if($header_type == 5){
                    $show_mobile=1;
                    get_template_part('templates/advanced_search');  
                }else{
                    if($show_adv_search_slider=='yes'){
                        $show_mobile=1;
                        get_template_part('templates/advanced_search');  
                    }
                }      
            }else{
                $show_mobile=1;  
                if($global_header_type!==0){
                    get_template_part('templates/advanced_search');  
                }

            } 
        }
    } ?>   

<?php if(is_front_page()) { ?>
        <?php get_template_part('templates/google_maps_base'); 

        $show_adv_search_general = get_option('wp_estate_show_adv_search_general','');
        if( isset($post->ID)){
            $header_type        = get_post_meta ( $post->ID, 'header_type', true);
        }

        $global_header_type = get_option('wp_estate_header_type','');
        if(is_singular('estate_agent')){
            $global_header_type = get_option('wp_estate_user_header_type','');
        }

        $show_mobile = 0;  
        $show_adv_search_slider  = get_option('wp_estate_show_adv_search_slider','');

        if($show_adv_search_general ==  'yes' && !is_404() ){
            if( !is_tax() && !is_category() && !is_archive() && !is_tag() && !is_search() ){
                if(  wpestate_check_if_admin_page($post->ID) ){
                    //nothing  
                } else if($header_type == 1 ){
                    //nothing  
                } else if($header_type == 0){ 
                    if($global_header_type==4){
                        $show_mobile=1;
                        get_template_part('templates/advanced_search');  
                    } else if( $global_header_type==0){
                        //nonthing 
                    } else{
                        if($show_adv_search_slider=='yes'){             
                            $show_mobile=1;
                            get_template_part('templates/advanced_search');  
                        }
                    }
                } else if($header_type == 5){
                    $show_mobile=1;
                    get_template_part('templates/advanced_search');  
                } else{
                    if($show_adv_search_slider=='yes'){
                        $show_mobile=1;
                        get_template_part('templates/advanced_search');  
                    }
                }      
            } else{
                $show_mobile=1;  
                if($global_header_type!==0){
                    get_template_part('templates/advanced_search');  
                }
            } 
        } ?>
<?php } ?>

<?php  if( $show_mobile == 1 ){
    get_template_part('templates/adv_search_mobile');
} ?>
</div>