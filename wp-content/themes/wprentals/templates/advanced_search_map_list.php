<?php
$adv_submit             =   wpestate_get_adv_search_link();
$guest_list             =   wpestate_get_guest_dropdown();

//  show cities or areas that are empty ?
$args = wpestate_get_select_arguments();
$allowed_html = array();
$allowed_html_list =    array('li' => array(
                                        'data-value'        =>array(),
                                        'role'              => array(),
                                        'data-parentcity'   =>array(),
                                        'data-value2'       =>array()
                        ) );
$action_select_list =   wpestate_get_action_select_list($args);
$categ_select_list  =   wpestate_get_category_select_list($args);
$min_price_slider   =   floatval(get_option('wp_estate_show_slider_min_price',''));
$max_price_slider   =   floatval(get_option('wp_estate_show_slider_max_price',''));
$where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );

if ($where_currency == 'before') {
    $price_slider_label = $currency . number_format($min_price_slider).' '.esc_html__( 'to','wpestate').' '.$currency . number_format($max_price_slider);
}else {
    $price_slider_label =  number_format($min_price_slider).$currency.' '.esc_html__( 'to','wpestate').' '.number_format($max_price_slider).$currency;
} 


if ( is_page('advanced-search') ) { 
    $col_class = 'col-md-12'; 
    $advanced_search_price = 'advanced_search_price'; 
    $advanced_search_filter = 'advanced_search_filter'; 
}  
else { 
    $col_class = 'col-md-12'; 
    $advanced_search_price = ''; 
    $advanced_search_filter = 'advanced_search_filter'; 
}
?>

<h3>Show results for</h3>
<div id="advanced_search_map_list">
    <div class="advanced_search_map_list_container <?php echo $advanced_search_filter; ?>">
        <?php if( is_page('advanced-search') || is_tax()) { ?>
			<div class="<?php echo $col_class; ?> equipment_type_search">
                <label for="equipment_type" class="equipment_type_label"><?php esc_html_e('Zip Code','wpestate');?></label>
                <div class="equipment_type_option">
                    <div class="custom_ajax_call_type">
                        <input type="text" class="form-control" name="zip_code" id="zip_code" value="<?php echo (isset($_REQUEST['zip_code']) && $_REQUEST['zip_code']!="")?$_REQUEST['zip_code']:'';?>"> 
                    </div>
                </div>
            </div>
            <div class="<?php echo $col_class; ?> equipment_type_search hide">
                <label for="equipment_type" class="equipment_type_label"><?php esc_html_e('Equipment Type :','wpestate');?></label>
                <div class="equipment_type_option">
                    <div class="custom_ajax_call_type">
                        <input type="radio" name="product_type" checked="checked" id="booking" value="booking"> 
                        <label for='booking'>For Rent</label>
                    </div>
                    <div class="custom_ajax_call_type">
                        <input type="radio" name="product_type" id="simple" value="simple"> 
                        <label for='simple'>For Sale</label>
                    </div>
                </div>
            </div>
            <div class="advanced_search_cat_list" id="advanced_search_cat_list">
                <?php 
				$current_category 	=	0;
				if( is_category() || is_tax() ){
					$category = get_queried_object();
					$current_category 	=	$category->term_id;
				}
                $product_categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0&parent=0' );
                foreach ($product_categories as $value) { ?>
                    <div class="<?php echo $col_class; ?>">
                        <input type="radio" name="filter_search_by_cat" class="parent_cat" id="<?php echo $value->slug; ?>" value="<?php echo $value->slug; ?>" > 
                        <label class="parent" for='<?php echo $value->slug; ?>'><?php echo $value->name; ?></label>
                        <?php 
                        $product_child_categories = get_terms( 'product_cat', 'orderby=name&hide_empty=0&parent=' . absint( $value->term_id ) );
                        if ( $product_child_categories ) { ?>
                            <ul>
                                <?php foreach ($product_child_categories as $child_value) { ?>
                                    <li class="custom_ajax_call">
                                        <input type="radio" name="filter_search_by_cat" id="<?php echo $child_value->slug; ?>" value="<?php echo $child_value->slug; ?>" <?php echo ($current_category==$child_value->term_id)?'checked':''?> /> 
                                        <label for='<?php echo $child_value->slug; ?>'><?php echo $child_value->name; ?></label>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>              
                <?php } ?>
            </div>
        <?php } else {  ?>  
            <div class="<?php echo $col_class; ?> map_icon">
                <?php
                $show_adv_search_general            =   get_option('wp_estate_wpestate_autocomplete','');
                $wpestate_internal_search           =   '';
                if($show_adv_search_general=='no'){
                    $wpestate_internal_search='_autointernal';
                    
                    if( isset($_GET['stype']) && $_GET['stype']=='meta'){
                        print '<input type="hidden" class="stype" id="stype" name="stype" value="meta">';
                    }else{
                       print '<input type="hidden" class="stype" id="stype" name="stype" value="tax">'; 
                    }
                }
                ?>
                <input type="text"   id="search_location_filter<?php echo $wpestate_internal_search;?>" class="form-control search_location_city" name="search_location" placeholder="<?php esc_html_e('Search Equipment','wpestate');?>" value="<?php if(isset( $_GET['search_location'] )){echo wp_kses( esc_attr($_GET['search_location']),$allowed_html );}?>" >              
                <input type="hidden" id="search_location_city" value="<?php if(isset( $_GET['advanced_city'] )){echo wp_kses( esc_attr($_GET['advanced_city']),$allowed_html);}?>" >
                <input type="hidden" id="search_location_area" value="<?php if(isset( $_GET['advanced_area'] )){echo wp_kses ( esc_attr($_GET['advanced_area']),$allowed_html);}?>" >
                <input type="hidden" id="search_location_country"    value="<?php if(isset( $_GET['advanced_country'] )){echo wp_kses ( esc_attr($_GET['advanced_country']),$allowed_html);}?>" >              
                <input type="hidden" id="property_admin_area" name="property_admin_area"  value="<?php if(isset( $_GET['property_admin_area'] )){echo wp_kses ( esc_attr($_GET['property_admin_area']),$allowed_html);}?>" >
            </div>
            <div class="<?php echo $col_class; ?>">
                <div class="dropdown form-control" id="categ_list" > <!-- types_icon -->
                    <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="all"> <?php esc_html_e('All','wpestate');?> <span class="caret caret_filter"></span> </div>           
                    <input type="hidden" name="filter_search_type[]" value="">
                    <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                        <?php  print wp_kses($categ_select_list,$allowed_html_list); ?>
                    </ul>        
                </div>
            </div>
        <?php } ?>
        <div class="<?php echo $col_class.' '.$advanced_search_price; ?>">
            <div class="adv_search_slider">
                <p>
                    <label class="price_label"><?php esc_html_e('Price range:','wpestate');?></label>
                    <span id="amount"  style="border:0; color:#f6931f; font-weight:bold;"><?php print wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);?></span>
                </p>
            </div>
        </div>
        <div class="<?php echo $col_class.' '.$advanced_search_price; ?>">
            <div class="">
                <div id="slider_price"></div>
                <input type="hidden" id="price_low"  name="price_low"  value="<?php echo wpestate_price_default_convert ($min_price_slider);?>" />
                <input type="hidden" id="price_max"  name="price_max"  value="<?php echo wpestate_price_default_convert ($max_price_slider);?>" />
            </div>
        </div>
        <?php if ( is_page('advanced-search') || is_tax()) { ?>
            <div class="<?php echo $col_class; ?> ajaxAdvanceSearchScetion">
                <a id="ajaxAdvanceSearch" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" href="javascript:void(0);">Search</a>
            </div>
        <?php } ?>
        <?php wpestate_show_extended_search(''); ?>
        <?php get_template_part('libs/internal_autocomplete_wpestate'); ?>
    </div>
</div>