<?php 
global $post;
$adv_search_what            =   get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';

if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}

if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

$extended_search    =   get_option('wp_estate_show_adv_search_extended','');
$extended_class     =   '';

if ( $extended_search =='yes' ){
    $extended_class='adv_extended_class';
    if($show_adv_search_visible=='no'){
        $close_class='adv-search-1-close-extended';
    }      
}
    
$header_type                =   get_post_meta ( $post->ID, 'header_type', true);
$global_header_type         =   get_option('wp_estate_header_type','');

$google_map_lower_class='';
 if (!$header_type==0){  // is not global settings
    if ($header_type==5){ 
        $google_map_lower_class='adv_lower_class';
    }
}else{    // we don't have particular settings - applt global header          
    if($global_header_type==4){
        $google_map_lower_class='adv_lower_class';
    }
} // end if header
    

?>
 <div class="adv-1-wrapper"> </div>  

<div class="adv-search-1 <?php echo $google_map_lower_class.' '.$close_class.' '.$extended_class;?>" id="adv-search-1" data-postid="<?php echo $post_id; ?>"> 

  
    <form  method="get"  id="main_search" action="<?php print $adv_submit; ?>" >
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>
        
        <div class="search-category col-md-3">
            <div class="dropdown form-control">
                <div data-toggle="dropdown" id="category" class="filter_menu_trigger" 
                    data-value="<?php  
                    if(isset($_GET['category'])){
                        echo esc_attr($_GET['category']);
                    }else{
                        echo 'All';
                    }
                ?>"> 
                <?php  
                if(isset($_GET['category'])){
                   echo $_GET['category'];
                }else{
                    esc_html_e('All','wpestate');
                }?>     
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="category" id="category_main" 
                    value="<?php  
                    if(isset($_GET['category'])){
                        echo intval(esc_attr($_GET['category']));
                    }?>">
                <ul class="dropdown-menu filter_menu custom_filter_menu"   id="category_main_list" role="menu" aria-labelledby="category">
                    <?php 
                    $product_categories   = get_terms( 'product_cat','orderby=name&hide_empty=0&parent=0' );
                    /*$categories 	=	wp_list_categories( array(
						'echo' => 0,
						'title_li' => '',
						'feed_type' => '',
						'taxonomy' => 'product_cat',
						'orderby' => 'name',
                        'show_option_all'     => 'All',
					) );
					echo preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $categories);*/

                    if ( $product_categories ) {
                        foreach ( $product_categories as $cat ) {
                            echo '<li value="' . esc_attr( $cat->term_id ) . '">' . esc_html( $cat->name ) . '</li>';
                            $product_child_categories   = get_terms( 'product_cat','orderby=name&hide_empty=0&parent=' . absint( $cat->term_id ) );
                            if ( $product_child_categories ) {
                                foreach ( $product_child_categories as $child_cat ) {
                                    echo '<li value="' . esc_attr( $child_cat->term_id ) . '">' . '&nbsp;&nbsp;' . esc_html( $child_cat->name ) . '</li>';
                                }
                            }
                        }
                    }
					?>
                </ul>        
            </div>       
        </div>
        <div style="display:none;" id="searchmap"></div>

        
		
        
        <div class="nav-fill col-md-4">
            <div class="search-input map_icon">    
                <?php 
                $show_adv_search_general            =   get_option('wp_estate_wpestate_autocomplete','');
                $wpestate_internal_search           =   '';
                if($show_adv_search_general=='no'){
                    $wpestate_internal_search='_autointernal';
                    print '<input type="hidden" class="stype" id="stype" name="stype" value="tax">';
                }
                ?>
                <input type="text" id="search_location<?php echo $wpestate_internal_search;?>" class="form-control" name="search_location" placeholder="<?php esc_html_e('Search Equipment','wpestate');?>" >
            </div>
        </div>
		<div class="col-md-2 has_calendar calendar_icon">
            <input type="text" id="check_in" class="form-control " name="check_in"  placeholder="<?php esc_html_e('Check in','wpestate');?>" 
                value="<?php  
                if(isset($_GET['check_in'])){
                    echo esc_attr($_GET['check_in']);
                }?>" >       
        </div>
        
        <div class="col-md-2  has_calendar calendar_icon">
            <input type="text" id="check_out"   disabled class="form-control" name="check_out" placeholder="<?php esc_html_e('Check Out','wpestate');?>" 
                value="<?php  
                if(isset($_GET['check_out'])){
                    echo esc_attr($_GET['check_out']);
                }?>">
        </div>
		<div class="nav-right col-md-1">
            <div class="search-icon">
                <button name="submit" type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button vc_button" id="advanced_submit_2"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
        <?php 
        /*
        <div class="col-md-2">
            <div class="dropdown form-control">
                <div data-toggle="dropdown" id="guest_no" class="filter_menu_trigger" 
                    data-value="<?php  
                    if(isset($_GET['guest_no'])){
                        echo intval(esc_attr($_GET['guest_no']));
                    }else{
                        echo 'all';
                    }
                ?>"> 
                <?php  
                if(isset($_GET['guest_no'])){
                   echo intval($_GET['guest_no']).' '.esc_html__('guests','wpestate');
                }else{
                    esc_html_e('Guests','wpestate');
                }?>     
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="guest_no" id="guest_no_main" 
                    value="<?php  
                    if(isset($_GET['guest_no'])){
                        echo intval(esc_attr($_GET['guest_no']));
                    }?>">
                <ul  class="dropdown-menu filter_menu"  id="guest_no_main_list" role="menu" aria-labelledby="guest_no">
                    <?php print $guest_list;?>
                </ul>        
            </div>
        </div>
        <?php esc_html_e('Search','wpestate');?>
         */
        ?>
        <div id="results">
            <?php esc_html_e('We found ','wpestate')?> <span id="results_no">0</span> <?php esc_html_e('results.','wpestate'); ?>  
            <span id="showinpage"> <?php esc_html_e('Do you want to load the results now ?','wpestate');?> </span>
        </div>

    </form>   

</div>  
<div class="clearfix"></div>
<?php get_template_part('libs/internal_autocomplete_wpestate'); ?>