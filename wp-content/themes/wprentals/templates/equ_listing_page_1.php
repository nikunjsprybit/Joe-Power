<?php
global $post;
global $current_user;
global $feature_list_array;
global $propid ;
global $post_attachments;
global $options;
global $where_currency;
global $property_description_text;     
global $property_details_text;
global $property_features_text;
global $property_adr_text;  
global $property_price_text;   
global $property_pictures_text;    
global $propid;
global $gmap_lat;  
global $gmap_long;
global $unit;
global $currency;
global $use_floor_plans;
global $favorite_text;
global $favorite_class;
global $property_action_terms_icon;
global $property_action;
global $property_category_terms_icon;
global $property_category;
global $guests;
global $bedrooms;
global $bathrooms;
global $show_sim_two;

$getAdd = (get_post_meta($post->ID, 'property_address', true)) ? get_post_meta($post->ID, 'property_address', true).' ' : '';
$getCounty = (get_post_meta($post->ID, 'property_county', true)) ? get_post_meta($post->ID, 'property_county', true).' ' : '';
$getState = (get_post_meta($post->ID, 'property_state', true)) ? get_post_meta($post->ID, 'property_state', true).' ' : '';
$getCountry = (get_post_meta($post->ID, 'property_country', true)) ? get_post_meta($post->ID, 'property_country', true).' ' : '';
$getZip = (get_post_meta($post->ID, 'property_zip', true)) ? get_post_meta($post->ID, 'property_zip', true) : '';

$price              =   intval   ( get_post_meta($post->ID, 'property_price', true) );
$price_label        =   esc_html ( get_post_meta($post->ID, 'property_label', true) );  
$property_city      =   $getCounty ;
$property_area      =   $getAdd;

$post_id=$post->ID; 
$guest_no_prop ='';
if(isset($_GET['guest_no_prop'])){
    $guest_no_prop = intval($_GET['guest_no_prop']);
}
$guest_list= wpestate_get_guest_dropdown('noany');

global $product;

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
?>

<div class="row content-fixed-listing listing_type_1">
    <?php //get_template_part('templates/breadcrumbs'); ?>
    
    <div class=" 
        <?php
        if($options['sidebar_class']=='' || $options['sidebar_class']=='none' ){
            print ' col-md-4 '; 
        }else{
            print $options['sidebar_class'];
        }
        ?> 
        widget-area-sidebar listingsidebar2 listing_type_1" id="primary" >
        
            <div class="booking_form_request cut_booking_form_request" id="booking_form_request">
            <div id="booking_form_request_mess"></div>
            <div class="submit_booking_front_wrapper">
				<strong>Price </strong>: <?php
				do_action( 'woocommerce_single_product_summary' );
				?>
            </div>
            <div class="third-form-wrapper">
                <div class="col-md-6 reservation_buttons">
                    <div id="add_favorites" class=" <?php print $favorite_class;?>" data-postid="<?php the_ID();?>">
                        <?php echo $favorite_text;?>
                    </div>                 
                </div>
                <div class="col-md-6 reservation_buttons">
                    <div id="contact_host" class="col-md-6" data-postid="<?php the_ID();?>">
                        <?php esc_html_e('Contact Owner','wpestate');?>
                    </div>  
                </div>
            </div>
                
                <?php 
                if (has_post_thumbnail()){
                    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'wpestate_property_full_map');
                }
                ?>

                <div class="prop_social">
                    <span class="prop_social_share"><?php esc_html_e('Share','wpestate');?></span>
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink()); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '.esc_url( get_permalink()) ); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                    <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a> 
                    <?php if (isset($pinterest[0])){ ?>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php echo $pinterest[0];?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
                    <?php } ?>           
                </div>             

        </div>


        <?php
        $post_author_id = $post->post_author;
        if( !empty($post_author_id) ) {
            $user = get_userdata($post_author_id);
            if( in_array( 'dc_vendor', (array) $user->roles ) ) {
                ?>
                
                <div class="owner_area_wrapper_sidebar" id="listing_owner">
                    <?php get_template_part ('/templates/owner_area2'); ?>
                </div>
            <?php } ?>
        <?php } ?>
        
        <?php  include(locate_template('sidebar-listing.php')); ?>
    </div>

    <div class="clearfix visible-xs"></div>
    <div class=" <?php 
    if ( $options['content_class']=='col-md-12' || $options['content_class']=='none'){
        print 'col-md-8';
    }else{
       print  $options['content_class']; 
    }?> ">
    
        <?php get_template_part('templates/ajax_container'); ?>
        <?php
        while (have_posts()) : the_post();
            $image_id       =   get_post_thumbnail_id();
            $image_url      =   wp_get_attachment_image_src($image_id, 'wpestate_property_full_map');
            $full_img       =   wp_get_attachment_image_src($image_id, 'full');
            $image_url      =   $image_url[0];
            $full_img       =   $full_img [0];     
		?>
    <div class="single-content listing-content">
        <h1 class="entry-title entry-prop"><?php the_title(); ?>        
            <span class="property_ratings">
                <?php 
                $args = array(
                    'number' => '15',
                    'post_id' => $post->ID, // use post_id, not post_ID
                );
                $comments   =   get_comments($args);
                $coments_no =   0;
                $stars_total=   0;

                foreach($comments as $comment) :
                    $coments_no++;
                    $rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
                    $stars_total+=$rating;
                endforeach;

                if($stars_total!= 0 && $coments_no!=0){
                    $list_rating= ceil($stars_total/$coments_no);
                    $counter=0; 
                    while($counter<5){
                        $counter++;
                        if( $counter<=$list_rating ){
                            print '<i class="fa fa-star"></i>';
                        }else{
                            print '<i class="fa fa-star-o"></i>'; 
                        }

                    }
                    print '<span class="rating_no">('.$coments_no.')</span>';
                }  
                ?>         
            </span> 
        </h1>
       
        <div class="listing_main_image_location">
            <?php print  $property_city.', '.$property_area; ?>        
        </div>   


        <div class="panel-wrapper imagebody_wrapper">
            <div class="panel-body imagebody imagebody_new">
                <?php  
                get_template_part('templates/property_pictures3');
                ?>
            </div> 
        </div>

        <?php
        $content = get_the_content();
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        if($content!=''){   
               
            $property_description_text =  get_option('wp_estate_property_description_text');
            if (function_exists('icl_translate') ){
                $property_description_text     =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( get_option('wp_estate_property_description_text') ) );
            } ?>
        
            <div class="panel-wrapper" id="listing_desc">
                <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseDesc"> <span class="panel-title-arrow"></span>
                    <?php if($property_description_text!=''){
                        echo $property_description_text;
                    } else{
                        echo 'Equipment Description';
                    }  ?>
                </a>
                <div id="collapseDesc" class="panel-collapse collapse in">
                    <div id="listing_description">
                        <?php  print '<div class="panel-body">'.$content.'</div>'; ?>
                    </div>
                    <div id="view_more_desc"><?php esc_html_e('View more','wpestate');?></div>
                </div>
            </div>
        <?php } ?>
          
        <!-- property price   -->   
        <div class="panel-wrapper" id="listing_price">
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseOne"> <span class="panel-title-arrow"></span>
                <?php if($property_price_text!=''){
                    echo $property_price_text;
                } else{
                    esc_html_e('Equipment Price','wpestate');
                }  ?>
            </a>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
					<?php 
					if($product->is_type( 'booking' )){	
						?>
						Per Day: <strong><?php echo wc_price(get_post_meta($post->ID, '_wc_booking_day_cost', true)); ?></strong><br />
						Per Week: <strong><?php echo wc_price(get_post_meta($post->ID, '_wc_booking_week_cost', true)); ?></strong><br />
						Per Month: <strong><?php echo wc_price(get_post_meta($post->ID, '_wc_booking_month_cost', true)); ?></strong>
						<?php 
					}else{
						?>
						<strong>Price: <?php echo woocommerce_template_single_price(); ?></strong>
						<?php 	
					}
					wpestate_show_custom_details($post->ID); ?>
					
                </div>
            </div>
        </div>

        <!-- Category -->
        <div class="panel-wrapper" id="eque_cat">
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseCate"> 
                <span class="panel-title-arrow"></span>
                <?php echo 'Equipment Categories'; ?>
            </a>
            <div id="collapseCate" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php 
                        $terms = get_the_terms( $post->ID, 'product_cat' );
                        if ($terms) {
                            echo '<ul>';
                            foreach ( $terms as $term ) {
                             
                                // The $term is an object, so we don't need to specify the $taxonomy.
                                $term_link = get_term_link( $term );
                                // If there was an error, continue to the next term.
                                if ( is_wp_error( $term_link ) ) {
                                    continue;
                                }
                                // We successfully got a link. Print it out.
                                echo '<li><a target="_blank" href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
                            }
                            echo '</ul>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- product_tag -->
        <div class="panel-wrapper" id="eque_tag">
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTag"> 
                <span class="panel-title-arrow"></span>
                <?php echo 'Equipment Tags'; ?>
            </a>
            <div id="collapseTag" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php $product_tag = get_the_terms( $post->ID, 'product_tag' );
                        if ($product_tag) {
                            echo '<ul>';
                            foreach ( $product_tag as $term ) {
                             
                                // The $term is an object, so we don't need to specify the $taxonomy.
                                $term_link = get_term_link( $term );
                                
                                // If there was an error, continue to the next term.
                                if ( is_wp_error( $term_link ) ) {
                                    continue;
                                }
                             
                                // We successfully got a link. Print it out.
                                echo '<li><a target="_blank" href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
                            }
                            echo '</ul>';
                        }
						
		
                    ?>
                </div>
            </div>
        </div>
        <div class="panel-wrapper">
            <!-- property address   -->             
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">  <span class="panel-title-arrow"></span>
                <?php 
				if($property_adr_text!=''){
                    echo $property_adr_text;
                } else{
                    esc_html_e('Equipment Address','wpestate');
                }
				
                ?>
            </a>    
            <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php print estate_listing_address($post->ID);?>
                </div>
            </div>
        </div>
        <!-- property details   -->  
        <div class="panel-wrapper">
            <?php 	
            if($property_details_text=='') {
                print'<a class="panel-title" id="listing_details" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTree"><span class="panel-title-arrow"></span>'.esc_html__( 'Equipment Details', 'wpestate').'  </a>';
            }else{
                print'<a class="panel-title"  id="listing_details" data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTree"><span class="panel-title-arrow"></span>'.$property_details_text.'  </a>';
            }
            ?>
            <div id="collapseTree" class="panel-collapse collapse in">
                <div class="panel-body panel-body-border">
                    <?php print estate_listing_details($post->ID);?>
                </div>
            </div>
        </div>
        <?php
        endwhile; // end of the loop
        $show_compare=1;
        get_template_part ('templates/listing_reviews'); ?>

	</div><!-- end single content -->
        <?php
        
		$getAdd = (get_post_meta($post->ID, 'property_address', true)) ? get_post_meta($post->ID, 'property_address', true).' ' : '';
        $getCounty = (get_post_meta($post->ID, 'property_county', true)) ? get_post_meta($post->ID, 'property_county', true).' ' : '';
        $getState = (get_post_meta($post->ID, 'property_state', true)) ? get_post_meta($post->ID, 'property_state', true).' ' : '';
        $getCountry = (get_post_meta($post->ID, 'property_country', true)) ? get_post_meta($post->ID, 'property_country', true).' ' : '';
        $getZip = (get_post_meta($post->ID, 'property_zip', true)) ? get_post_meta($post->ID, 'property_zip', true) : '';
        
        $getLatLong = get_lat_long( $getAdd. $getCounty . $getState . $getCountry . $getZip);

        if ( isset($getLatLong['lat']) && !empty($getLatLong['lat']) ) {
            $lat = $getLatLong['lat'];
        }
        else{ $lat = ''; }

        if ( isset($getLatLong['lng']) && !empty($getLatLong['lng']) ) {
            $long = $getLatLong['lng'];
        }
        else{ $long = ''; }
		/* ?>
        <div class="property_page_container"> 
            <h3 class="panel-title" id="on_the_map"><?php esc_html_e('On the Map','wpestate');?></h3>
            <div class="google_map_on_list_wrapper ">            
                <div id="gmapzoomplus"></div>
                <div id="gmapzoomminus"></div>
                <div id="gmapstreet"></div>
                <div id="google_map_on_list" 
                    data-cur_lat="<?php echo $lat; ?>" 
                    data-cur_long="<?php echo $long; ?>" 
                    data-post_id="<?php echo $post->ID; ?>">
                </div>
            </div>    
        </div>
        <?php */
        $show_sim_two=1;
        //get_template_part ('/templates/eq_similar_listings');
        ?> 
    </div><!-- end 8col container-->
</div>
<script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('.property_page_container .wc-bookings-date-picker legend').remove();
    });
</script>
<style type="text/css">
    .wc-bookings-booking-form{
        border: none;
    }
    .third-form-wrapper { border-top: none; margin-top: 0px; }
    .wc_bookings_field_duration{ margin-bottom: 10px !important;}
    .wc_bookings_field_duration input{padding-left: 10px;}
</style>