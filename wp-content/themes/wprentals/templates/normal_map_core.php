<?php
global $options;
global $prop_selection;
global $property_list_type_status;
global $full_page;
global $term;
global $taxonmy;
global $book_from;
global $book_to;
global $listing_type;
global $property_unit_slider;

$prop_no =  intval( get_option('wp_estate_prop_no', '') );
$listing_type   =   get_option('wp_estate_listing_unit_type','');
$page_tax       =   '';
if($options['content_class']=="col-md-12"){
    $full_page=1;
}
$property_unit_slider= esc_html ( get_option('wp_estate_prop_list_slider','') );   
ob_start(); 
    if ($prop_selection->have_posts()) {
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
            get_template_part('templates/property_unit');
        endwhile;
    }
    else{
        echo '<div id="listing_ajax_container" class="row"><div class="half_map_results">0  Results found!</div><span id="scrollhere">'."</span><span class='no_results'>We didn't find any results</span></div>";
    }
$templates = ob_get_contents();
ob_end_clean(); 
wp_reset_query(); 
wp_reset_postdata();
?>
<div class="row content-fixed">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <!-- <div class=" <?php //print $options['content_class'];?>  "> -->
    <div class="col-md-4">
        <?php get_template_part('templates/advanced_search_map_list'); ?>
        <?php get_template_part('templates/spiner'); ?> 
    </div>
    <div class="col-md-8">
        <?php if( !is_tax() ){?>
            <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                <?php 
                    if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { 
                        if( is_page_template('advanced_search_results.php') ){?>
                            <h1 class="entry-title title_list_prop"><?php the_title(); //print ': '.$prop_selection->found_posts .' '.esc_html__( 'results','wpestate'); ?></h1>
                        <?php }else{ ?>
                            <h1 class="entry-title title_list_prop"><?php the_title();?></h1>   
                        <?php }               
                    }
                ?>
            <?php } ?>
            <div class="single-content"><?php the_content();?></div>
            <?php endwhile;   ?>  
        <?php }else{ ?>
            
            <?php   
            $term_data  =   get_term_by('slug', $term, $taxonmy);
            $place_id   =   $term_data->term_id;
            $term_meta  =   get_option( "taxonomy_$place_id");
       
          
            if(isset($term_meta['pagetax'])){
               $page_tax=$term_meta['pagetax'];           
            }
            
            if($page_tax!=''){
                $content_post = get_post($page_tax);
                $content = $content_post->post_content;
                $content = apply_filters('the_content', $content);
                echo $content;
            }
            ?>
            <h1 class="entry-title title_prop"> 
                <?php
				if($taxonmy=="dc_vendor_shop"){
					esc_html_e('Equipments listed by ','wpestate');single_cat_title();
				}else{
					esc_html_e('Equipments listed in ','wpestate');single_cat_title();
				}
                ?>
            </h1>
        <?php } 
        if ( $property_list_type_status == 2 ){
            get_template_part('templates/advanced_search_map_list');
        }
        get_template_part('templates/compare_list');
        ?> 
        
        <!-- Listings starts here -->                   
        <?php  get_template_part('templates/spiner'); ?> 
        <div id="listing_ajax_container" class="row"> 
            <?php print $templates; ?>

            <?php if( $prop_selection->max_num_pages > 1 ){ ?>   
                <div class="col-md-12 load_more_row" style="text-align: center;">
                    <button type="button" id="load_more">
                        <i class="fa fa-spinner fa-pulse loading_icon" style="display: none;"></i> 
                        <span>Load More</span>
                    </button>
                </div>    
            <?php } ?>
        </div>
        <!-- Listings Ends  here --> 
        <?php //kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    </div><!-- end 8col container-->
<?php  //include(locate_template('sidebar.php')); ?>
</div>   
<?php  if ( is_page('advanced-search') && isset($_GET['category']) && empty(trim($_GET['category'])) ) {  ?>
    <script type="text/javascript">
        jQuery(document).ready( function() {
            jQuery('#category').prepend('All');
        });
    </script>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready( function() {
	var perpage = '<?php echo $prop_no ?>';
	var totalpage = '<?php echo $prop_selection->max_num_pages; ?>';
	var currentPage = 1;
	
	var category = '<?php echo $_GET["category"] ?>';
	var search_location = '<?php echo $_GET["search_location"] ?>';
	
	jQuery('#load_more').on('click', function() {
		jQuery('#load_more .loading_icon').show();
		jQuery('#load_more').attr('disabled', 'disabled');
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url("/admin-ajax.php"); ?>',
			data: {
				action: 'load_more_advance_search_equplist',
				'perpage': perpage,
				'totalpage': totalpage,
				'currentpage': currentPage,
				'category': category,
				'search_location': search_location
			},
			success: function(data) {
				jQuery(data).insertBefore('.load_more_row');
				jQuery('#load_more .loading_icon').hide();
				currentPage = parseInt(currentPage)+1;
				if ( currentPage >= totalpage ) {
					jQuery('.load_more_row').remove();
				}
				jQuery('#load_more').removeAttr('disabled');
			}
		});
	});
});
</script>