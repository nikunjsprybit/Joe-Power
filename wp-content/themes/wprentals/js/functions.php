<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
        
if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
  function chld_thm_cfg_parent_css() {
    wp_enqueue_style('wpestate_bootstrap',get_template_directory_uri().'/css/bootstrap.css', array(), '1.0', 'all');
    wp_enqueue_style('wpestate_bootstrap-theme',get_template_directory_uri().'/css/bootstrap-theme.css', array(), '1.0', 'all');
    wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css' ); 
    wp_enqueue_style('wpestate_media',get_template_directory_uri().'/css/my_media.css', array(), '1.0', 'all'); 
  }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css' );

// END ENQUEUE PARENT ACTION


if( function_exists('vc_map') ):

  vc_map(
    array(
      "name" => esc_html__( "Featured Place","wpestate"),
      "base" => "featured_place",
      "class" => "",
      "category" => esc_html__( 'Content','wpestate'),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      'weight'=>100,
      'icon'   =>'wpestate_vc_logo',
      'description'=>esc_html__( 'Featured Place Shortcode','wpestate'),
      "params" => array(
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Place Id","wpestate"),
          "param_name" => "id",
          "value" => "0",
          "description" => esc_html__( "Place Id (city or neighborhood) ","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Type","wpestate"),
          "param_name" => "type",
          "value" => "type1",
          "description" => esc_html__( "Design Type (type1 or type2) ","wpestate")
        )
      )
    )
  );
      
      
  vc_map(
    array(
      "name" => esc_html__( "Recent Items Slider","wpestate"),//done
      "base" => "slider_recent_items",
      "class" => "",
      "category" => esc_html__( 'Content','wpestate'),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      'weight'=>100,
      'icon'   =>'wpestate_vc_logo',
      'description'=>esc_html__( 'Recent Items Slider Shortcode','wpestate'),
      "params" => array(
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Title","wpestate"),
          "param_name" => "title",
          "value" => "",
          "description" => esc_html__( "Section Title","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Category Id's","wpestate"),
          "param_name" => "category_ids",
          "value" => "",
          "description" => esc_html__( "list of category id's sepearated by comma (*only for products)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Brand Id's","wpestate"),
          "param_name" => "action_ids",
          "value" => "",
          "description" => esc_html__( "list of brand ids separated by comma (*only for products)","wpestate")
        ), 
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "City Id's ","wpestate"),
          "param_name" => "city_ids",
          "value" => "",
          "description" => esc_html__( "list of city ids separated by comma (*only for products)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Area Id's","wpestate"),
          "param_name" => "area_ids",
          "value" => "",
          "description" => esc_html__( "list of area ids separated by comma (*only for products)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "No of items","wpestate"),
          "param_name" => "number",
          "value" => 4,
          "description" => esc_html__( "how many items","wpestate")
        ),array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Show featured listings only?","wpestate"),
          "param_name" => "show_featured_only",
          "value" => "no",
          "description" => esc_html__( "Show featured listings only? (yes/no)","wpestate")
        ), array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Extra Class Name","wpestate"),
          "param_name" => "extra_class_name",
          "value" => "",
          "description" => esc_html__( "Extra Class Name","wpestate")
        ) ,array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Auto scroll period","wpestate"),
          "param_name" => "autoscroll",
          "value" => "0",
          "description" => esc_html__( "Auto scroll period in seconds - 0 for manual scroll, 1000 for 1 second, 2000 for 2 seconds and so on.","wpestate")
        ) 
      )
    )
  );


  vc_map( 
    array(
      "name" => esc_html__( "List items by ID","wpestate"),//done
      "base" => "list_items_by_id",
      "class" => "",
      "category" => esc_html__( 'Content','wpestate'),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      'weight'=>100,
      'icon'   =>'wpestate_vc_logo',
      'description'=>esc_html__( 'List Items by ID Shortcode','wpestate'),
      "params" => array(
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Title","wpestate"),
          "param_name" => "title",
          "value" => "",
          "description" => esc_html__( "Section Title","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "What type of items","wpestate"),
          "param_name" => "type",
          "value" => "product",
          "description" => esc_html__( "List products or articles","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Items IDs","wpestate"),
          "param_name" => "ids",
          "value" => "",
          "description" => esc_html__( "List of IDs separated by comma","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "No of items","wpestate"),
          "param_name" => "number",
          "value" => "3",
          "description" => esc_html__( "How many items do you want to show ?","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "No of items per row","wpestate"),
          "param_name" => "rownumber",
          "value" => 4,
          "description" => esc_html__( "The number of items per row","wpestate")
        ) , 
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Link to global listing","wpestate"),
          "param_name" => "link",
          "value" => "#",
          "description" => esc_html__( "link to global listing with http","wpestate")
        ) ,array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Extra Class Name","wpestate"),
          "param_name" => "extra_class_name",
          "value" => "",
          "description" => esc_html__( "Extra Class Name","wpestate")
        )
      )
    ) 
  );    

  vc_map(
    array(
      "name" => esc_html__( "Recent Items","wpestate"),//done
      "base" => "recent_items",
      "class" => "",
      "category" => esc_html__( 'Content','wpestate'),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      'weight'=>100,
      'icon'   =>'wpestate_vc_logo',
      'description'=>esc_html__( 'Recent Items Shortcode','wpestate'),
      "params" => array(
      array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Use without spaces between listings(yes/no)? (If yes, title or link to global listing will not show)","wpestate"),
          "param_name" => "full_row",
          "value" => "yes",
          "description" => esc_html__( "Use without spaces between listings? (If yes, title or link to global listing will not show)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Title","wpestate"),
          "param_name" => "title",
          "value" => "",
          "description" => esc_html__( "Section Title","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "What type of items","wpestate"),
          "param_name" => "type",
          "value" => "product",
          "description" => esc_html__( "list products or articles","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Category Id's","wpestate"),
          "param_name" => "category_ids",
          "value" => "",
          "description" => esc_html__( "list of category ids separated by comma","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Brand Id's","wpestate"),
          "param_name" => "action_ids",
          "value" => "",
          "description" => esc_html__( "list of brand ids separated by comma (*only for products)","wpestate")
        ), 
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "City Id's ","wpestate"),
          "param_name" => "city_ids",
          "value" => "",
          "description" => esc_html__( "list of city ids separated by comma (*only for products)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Area Id's","wpestate"),
          "param_name" => "area_ids",
          "value" => "",
          "description" => esc_html__( "list of area ids separated by comma (*only for products)","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "No of items","wpestate"),
          "param_name" => "number",
          "value" => 4,
          "description" => esc_html__( "how many items","wpestate")
        ) , 
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "No of items per row","wpestate"),
          "param_name" => "rownumber",
          "value" => 4,
          "description" => esc_html__( "The number of items per row","wpestate")
        ) , 
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Link to global listing","wpestate"),
          "param_name" => "link",
          "value" => "",
          "description" => esc_html__( "link to global listing","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Show featured listings only?","wpestate"),
          "param_name" => "show_featured_only",
          "value" => "no",
          "description" => esc_html__( "Show featured listings only? (yes/no)","wpestate")
        ) ,
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Extra Class Name","wpestate"),
          "param_name" => "extra_class_name",
          "value" => "",
          "description" => esc_html__( "Extra Class Name","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Random Pick (yes/no) ","wpestate"),
          "param_name" => "random_pick",
          "value" => "no",
          "description" => esc_html__( "Choose if products should display randomly on page refresh. (*only for products)","wpestate")
        ) 
      )
    )
  );

  vc_map(
    array(
      "name" => esc_html__( "Featured Product","wpestate"),
      "base" => "featured_property",
      "class" => "",
      "category" => esc_html__( 'Content','wpestate'),
      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
      'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
      'weight'=>100,
      'icon'   =>'wpestate_vc_logo',
      'description'=>esc_html__( 'Featured Product Shortcode','wpestate'),
      "params" => array(
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Product id","wpestate"),
          "param_name" => "id",
          "value" => "",
          "description" => esc_html__( "Product id","wpestate")
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_html__( "Type","wpestate"),
          "param_name" => "type",
          "value" => "type1",
          "description" => esc_html__( "Design Type (type1 or type2) ","wpestate")
        )
      )
    )
  );
endif;



////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_recent_posts_pictures') ):
  function wpestate_recent_posts_pictures($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $row_number;
    global $curent_fav;
    global $current_user;
    global $listing_type;
    global $property_unit_slider;
    $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
    $listing_type   =   get_option('wp_estate_listing_unit_type','');
    $current_user = wp_get_current_user();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);


    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area='';
    $title              =   '';
    $currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $full_row           =   '';
    $extra_class_name   =   '';
    $random_pick        =   '';
    $orderby            =   'meta_value';

    if ( isset($attributes['title']) ){
      $title=$attributes['title'];
    }

    $attributes = shortcode_atts( 
    array(
      'full_row'              =>  'yes',
      'title'                 =>  '',
      'type'                  => 'product',
      'category_ids'          =>  '',
      'action_ids'            =>  '',
      'city_ids'              =>  '',
      'area_ids'              =>  '',
      'number'                =>  4,
      'rownumber'             =>  4,
      'align'                 =>  'vertical',
      'link'                  =>  '',
      'show_featured_only'    =>  'no',
      'random_pick'           =>  'no',
      'extra_class_name'      =>  '',
    ), $attributes) ;


    if ( isset($attributes['category_ids']) ){
      $category=$attributes['category_ids'];
    }

    if ( isset($attributes['category_ids']) ){
      $category=$attributes['category_ids'];
    }

    if ( isset($attributes['action_ids']) ){
      $action=$attributes['action_ids'];
    }

    if ( isset($attributes['city_ids']) ){
      $city=$attributes['city_ids'];
    }

    if ( isset($attributes['area_ids']) ){
      $area=$attributes['area_ids'];
    }

    if ( isset($attributes['show_featured_only']) ){
      $show_featured_only=$attributes['show_featured_only'];
    }

    if( isset($attributes['full_row'])){
      $full_row=$attributes['full_row'];
    }     

    if (isset($attributes['random_pick'])){
      $random_pick=   $attributes['random_pick'];
      if($random_pick==='yes'){
        $orderby    =   'rand';
      }
    }

    if( isset($attributes['extra_class_name'])){
      $extra_class_name=$attributes['extra_class_name'];
    }        


    $post_number_total = $attributes['number'];
    if ( isset($attributes['rownumber']) ){
      $row_number        = $attributes['rownumber']; 
    }

    // max 4 per row
    if($row_number>5){
      $row_number=5;
    }

    if( $row_number == 4 ||  $row_number == 5 ){
      $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
      $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
      $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
      $row_number_col =  12;// col value is 12
    }

    $align=''; 
    $align_class='';
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
      $align="col-md-12";
      $align_class='the_list_view';
      $row_number_col='12';
    }


    if ($attributes['type'] == 'product') {
    $type = 'product';

    $category_array =   '';
    $action_array   =   '';
    $city_array     =   '';
    $area_array     =   '';
    $featured_array     =   '';

    // build category array
    if($category!=''){
      $category_of_tax=array();
      $category_of_tax=  explode(',', $category);
      $category_array=array(     
        'taxonomy'  => 'product_cat',
        'field'     => 'term_id',
        'terms'     => $category_of_tax
      );
    }


    // build action array
    if($action!=''){
      $action_of_tax=array();
      $action_of_tax=  explode(',', $action);
      $action_array=array(     
        'taxonomy'  => 'product_brand_category',
        'field'     => 'term_id',
        'terms'     => $action_of_tax
      );
    }

    // build city array
    if($city!=''){
      $city_of_tax=array();
      $city_of_tax=  explode(',', $city);
      $city_array=array(     
        'taxonomy'  => 'product_city',
        'field'     => 'term_id',
        'terms'     => $city_of_tax
      );
    }

    // build city array
    if($area!=''){
      $area_of_tax=array();
      $area_of_tax=  explode(',', $area);
      $area_array=array(     
        'taxonomy'  => 'product_area',
        'field'     => 'term_id',
        'terms'     => $area_of_tax
      );
    }


    $meta_query=array();                
    if($show_featured_only=='yes'){
      $featured_array=array(     
        'taxonomy' => 'product_visibility',
        'field' => 'slug',
        'terms'=>'featured'
      );
    }


    $args = array(
      'post_type'         => $type,
      'post_status'       => 'publish',
      'paged'             => 0,
      'posts_per_page'    => $post_number_total,
      'orderby'           => $orderby,
      'order'             => 'DESC',
      'meta_query'        => $meta_query,
      'tax_query'         => array( 
        $category_array,
        $action_array,
        $city_array,
        $area_array,
        $featured_array,
      )
    );
  } else {
    $type = 'post';
    $args = array(
      'post_type'         =>  'post',
      'status'            =>  'published',
      'paged'             =>  0,
      'posts_per_page'    =>  $post_number_total,
      'cat'               =>  $category
    );
  }


  if ( isset($attributes['link']) && $attributes['link'] != '') {
    if ($attributes['type'] == 'product') {
      $button .= '<div class="listinglink-wrapper">
      <a href="' . $attributes['link'] . '"> <span class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button more_list">'.esc_html__( 'More Listings','wpestate').' </span></a> 
      </div>';
    } else {
    $button .= '<div class="listinglink-wrapper">
      <a href="' . $attributes['link'] . '"> <span class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button more_list">  '.esc_html__( 'More Articles','wpestate').' </span></a> 
      </div>';
    }
  } else {
    $class = "nobutton";
  }


  if ($attributes['type'] == 'product') {
    if($random_pick !=='yes'){ 
      $recent_posts = new WP_Query($args);
      $count = 1; 
    }else{
      $recent_posts = new WP_Query($args); 
      $count = 1;
    }
  }else{
    $recent_posts = new WP_Query($args);
    $count = 1;
  }

  if($full_row==='yes'){
    $return_string .= '<div class="  '.$extra_class_name.' " >';
  }else{
    $return_string .= '<div class=" bottom-'.$type.' '.$class.' '.$extra_class_name.'" >';
    if($title!=''){
      $return_string .= '<h1 class="shortcode_title">'.$title.'</h1>';
    }
  }

  ob_start();  
  print '<div class="items_shortcode_wrapper';
    if($full_row==='yes'){
      print ' items_shortcode_wrapper_full ';
    }
    print'  ">';
    while ($recent_posts->have_posts()): $recent_posts->the_post();
      if($type == 'product'){
        if($full_row==='yes'){
            get_template_part('templates/property_unit_full_row');
        }else{
            get_template_part('templates/property_unit');
        }
      } else {
        if($full_row==='yes'){
            get_template_part('templates/blog_unit_full_row');
        }else{
            get_template_part('templates/blog_unit');
        }
      }
    endwhile;
    print '</div>';
    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    if($full_row !='yes'){
      $return_string .=$button;
    }
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;   
  }
endif; // end   wpestate_recent_posts_pictures 


if( !function_exists('wpestate_show_price') ):
function wpestate_show_price($post_id,$currency,$where_currency,$return=0){
  $product    = wc_get_product($post_id); 
  if(!empty($product)){   
    if($return==0){
      print $product->get_price_html();
    }else{
      return $product->get_price_html();
    }
  }
}
endif;



/*if( !function_exists('wpestate_create_property_type') ):
function wpestate_create_property_type() {
    
  // add custom taxonomy
    register_taxonomy('product_brand_category', 'product', array(
        'labels' => array(
            'name'              => esc_html__( 'Brand','wpestate'),
            'add_new_item'      => esc_html__( 'Add new option for "Brand" ','wpestate'),
            'new_item_name'     => esc_html__( 'Add new option for "Brand"','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => 'action' )
       )      
    );
  
    // add custom taxonomy
    register_taxonomy('product_city', 'product', array(
        'labels' => array(
            'name'              => esc_html__( 'City','wpestate'),
            'add_new_item'      => esc_html__( 'Add New City','wpestate'),
            'new_item_name'     => esc_html__( 'New City','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => 'city' )
        )
    );

    // add custom taxonomy
    register_taxonomy('product_area', 'product', array(
        'labels' => array(
            'name'              => esc_html__( 'Neighborhood / Area','wpestate'),
            'add_new_item'      => esc_html__( 'Add New Neighborhood / Area','wpestate'),
            'new_item_name'     => esc_html__( 'New Neighborhood / Area','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => 'area' )

        )
    );
  wpestate_ping_me();
}// end create property type
endif; // end   wpestate_create_property_type      

*/


////////////////////////////////////////////////////////////////////////////////////
/// featured property
////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_featured_property') ):
   
function wpestate_featured_property($attributes, $content = null) {
  
    global $property_unit_slider;
    $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
    $return_string  =   '';
    $prop_id        =   ''; 
    $sale_line      =   '';
    $desgin_class   =   '';
    $type           =   '';
    
    $attributes = shortcode_atts( 
      array(
        'id'                  => '',
        'type'                     => "type1",
      ), $attributes
    );

    if( isset($attributes['id'])){
      $prop_id=$attributes['id'];
    }
    
    if( isset($attributes['type'])){
      $type=$attributes['type'];
    }
    
    if ( isset($attributes['sale_line'])){
      $sale_line =  $attributes['sale_line'];
    }
    
    $args = array('post_type'   => 'product',
      'post_status' => 'publish',
      'p'           => $prop_id
    );

    if( $type =='type1' ){
      $desgin_class ='type_1_class';
    }
    
    $return_string= '<div class="featured_property '.$desgin_class.'">';
      $my_query = new WP_Query($args);
      ob_start(); 
      while ($my_query->have_posts() ): $my_query->the_post();
        get_template_part('templates/property_unit_featured'); 
      endwhile;
      $return_string .= ob_get_contents();
      ob_end_clean();  
      wp_reset_query();
    $return_string.='</div>'; 
    return $return_string;
}
endif; // end   wpestate_featured_property




///////////////////////////////////////////////////////////////////////////////////////////
// list items by ids function
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_list_items_by_id_function') ):

function wpestate_list_items_by_id_function($attributes, $content = null) {
    global $post;
    global $align;
    global $show_compare_only;
    global $currency;
    global $where_currency;
    global $col_class;
    global $is_shortcode;
    global $row_number_col;
    global $listing_type;
    global $property_unit_slider;
    $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') );
    $listing_type   =   get_option('wp_estate_listing_unit_type','');
    $currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $show_compare_only  =   'no';
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $rows               =   1;
    $ids                =   '';
    $ids_array          =   array();
    $post_number        =   1;
    $title              =   '';
    $is_shortcode       =   1;
    $row_number         =   '';
    
    
    $title              =   '';
    if ( isset($attributes['title']) ){
      $title=$attributes['title'];
    }
    
    $attributes = shortcode_atts( 
      array(
        'title'                 => '',
        'type'                  => 'product',
        'ids'                   =>  '',
        'number'                =>  3,
        'rownumber'             =>  4,
        'align'                 =>  'vertical',
        'link'                  =>  '#',
        'extra_class_name'      =>  ''
      ), $attributes
    );
    
    if ( isset($attributes['ids']) ){
      $ids=$attributes['ids'];
      $ids_array=explode(',',$ids);
    }
    
    if ( isset($attributes['title']) ){
      $title=$attributes['title'];    
    }

    $post_number_total = $attributes['number'];

    if ( isset($attributes['rownumber']) ){
      $row_number        = $attributes['rownumber']; 
    }
    
    // max 4 per row
    if($row_number>4){
      $row_number=4;
    }
    
    if( $row_number == 4 ){
      $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
      $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
      $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
      $row_number_col =  12;// col value is 12
    }
    
    
    $align=''; 
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
    }
    
    
    
    if ($attributes['type'] == 'product') {
       $type = 'product';
    } else {
       $type = 'post';
    }

    if ($attributes['link'] != '') {
        if ($attributes['type'] == 'product') {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button more_list">'.esc_html__( ' More Listings','wpestate').' </span></a>
                       </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button more_list">'.esc_html__( ' More Articles','wpestate').'</span></a>
                        </div>';
        }
    } else {
        $class = "nobutton";
    }

    
 
    
   
   $args = array(
        'post_type'         => $type,
        'post_status'       => 'publish',
        'paged'             => 0,
        'posts_per_page'    => $post_number_total, 
        'post__in'          => $ids_array,
        'orderby '          => 'none'
    );
 
    $recent_posts = new WP_Query($args);
   

    $return_string .= '<div class="article_container items_shortcode_wrapper">';
    if($title!=''){
        $return_string .= '<h1 class="shortcode_title">'.$title.'</h1>';
    }
     
    ob_start();  
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        if($type == 'product'){
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
               $col_class='col-md-12';
            }
            get_template_part('templates/property_unit');
           
        } else {
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                get_template_part('templates/blog_unit');
            }else{
                get_template_part('templates/blog_unit2');
            }
            
        }
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    $return_string .=$button;
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;
}
endif; // end   wpestate_list_items_by_id_function 


////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_slider_recent_posts_pictures') ):

function wpestate_slider_recent_posts_pictures($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $curent_fav;
    global $current_user;
    global $listing_type;
    global $property_unit_slider;
    $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') );

    $listing_type   =   get_option('wp_estate_listing_unit_type','');
    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area='';
    $title              =   '';
    $currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $autoscroll         =   '';
    

    $current_user = wp_get_current_user();
    $userID                         =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);


    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }
    
      $attributes = shortcode_atts( 
                array(
                    'title'                 =>  '',
                    'type'                  => 'product',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'number'                =>  4,
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'extra_class_name'      =>  '',
                    'autoscroll'            =>  0,
                ), $attributes) ;
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }
    
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }

    if ( isset($attributes['action_ids']) ){
        $action=$attributes['action_ids'];
    }

    if ( isset($attributes['city_ids']) ){
        $city=$attributes['city_ids'];
    }

    if ( isset($attributes['area_ids']) ){
        $area=$attributes['area_ids'];
    }
     
     if ( isset($attributes['show_featured_only']) ){
        $show_featured_only=$attributes['show_featured_only'];
    }
    if ( isset($attributes['autoscroll']) ){
        $autoscroll=intval ( $attributes['autoscroll'] );
    }    
    
    $post_number_total = $attributes['number'];
    if ( isset($attributes['rownumber']) ){
        $row_number        = $attributes['rownumber']; 
    }
   
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
    }
    
    $align=''; 
    $align_class='';
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
        $align_class='the_list_view';
        $row_number_col='12';
    }
    
    $attributes['type'] = 'product';
    
    if ($attributes['type'] == 'product') {
        $type = 'product';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        $featured_array     =   '';
        
        // build category array
        if($category!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category);
            $category_array=array(     
                            'taxonomy'  => 'product_cat',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action);
            $action_array=array(     
                            'taxonomy'  => 'product_brand_category',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city);
            $city_array=array(     
                            'taxonomy'  => 'product_city',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area);
            $area_array=array(     
                            'taxonomy'  => 'product_area',
                            'field'     => 'term_id',
                            'terms'     => $area_of_tax
                            );
        }
        
        
           $meta_query=array(); 
        
            if($show_featured_only=='yes'){
                $featured_array=array(     
                            'taxonomy' => 'product_visibility',
              'field' => 'slug',
              'terms'=>'featured'
                            );
            }
        
            $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'paged'             => 0,
                'posts_per_page'    => $post_number_total,
                'orderby'           => 'ID',
                'order'             => 'DESC',
                'meta_query'        => $meta_query,
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                    )
              
            );
            if($show_featured_only=='yes'){
                $args['meta_query'] =$meta_query;
                $args['orderby']    ='meta_value';
            }
       
          
    } else {
        $type = 'post';
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => 0,
            'posts_per_page' => $post_number_total,
            'cat'            => $category
        );
    }


    if ( isset($attributes['link']) && $attributes['link'] != '') {
        if ($attributes['type'] == 'product') {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.esc_html__( 'More Listings','wpestate').' </span></a> 
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">  '.esc_html__( 'More Articles','wpestate').' </span></a> 
               </div>';
        }
    } else {
        $class = "nobutton";
    }


    
  

    if ($attributes['type'] == 'product') {
    $recent_posts = new WP_Query($args);
    $count = 1;
        
    }else{
        $recent_posts = new WP_Query($args);
        $count = 1;
    }
   
    $return_string .= '<div class="article_container slider_container bottom-'.$type.' '.$class.'" >';
    
    $return_string .= '<div class="slider_control_left"><i class="fa fa-angle-left"></i></div>
                       <div class="slider_control_right"><i class="fa fa-angle-right"></i></div>';
    
    if($title!=''){
         $return_string .= '<h1 class="shortcode_title title_slider">'.$title.'</h1>';
    }
    
    $is_autoscroll='';
   
        $is_autoscroll=' data-auto="'.$autoscroll.'" ';
  
    
    $return_string .= '<div class="shortcode_slider_wrapper" '.$is_autoscroll.'><ul class="shortcode_slider_list">';
    
    
    ob_start();  
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        print '<li>';
        if($type == 'product'){
            get_template_part('templates/property_unit');
        } else {
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                get_template_part('templates/blog_unit');
            }else{
                get_template_part('templates/blog_unit2');
            }
            
        }
        print '</li>';
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    $return_string .=$button;
    
    $return_string .= '</ul></div>';// end shrcode wrapper
    $return_string .= '</div>';
    wp_reset_query();
    
    wp_reset_postdata();
    $is_shortcode       =   0;
    
   
    
    return $return_string;
    
    
}
endif; // end   wpestate_recent_posts_pictures 


////////////////////////////////////////////////////////////////////////////////
/// show hieracy action
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_action_select_list') ):
    
    function wpestate_get_action_select_list($args){
        $taxonomy           =   'product_brand_category';
        $categories          =   get_terms($taxonomy,$args);
       
        $categ_select_list =   ' <li role="presentation" data-value="all">'. __('All Brands','wpestate').'</li>';
       
        foreach ($categories as $categ) {
            $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
            $counter = $categ->count;
            if(isset($received['count'])){
                $counter = $counter+$received['count'];
            }
            
            $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }
            
        }
        return $categ_select_list;
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy categ
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_category_select_list') ):
    
     function wpestate_get_category_select_list($args){
        $taxonomy           =   'product_cat';
        $categories         =   get_terms($taxonomy,$args);
      
        $categ_select_list  =  '<li role="presentation" data-value="all">'. __('All Types','wpestate').'</li>'; 

        foreach ($categories as $categ) {
            $counter = $categ->count;
            $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
      if(isset($received['count'])){
                $counter = $counter+$received['count'];
            }
            
            $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }
        }
        return $categ_select_list;
    }
endif;




////////////////////////////////////////////////////////////////////////////////
/// show hieracy city
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_city_select_list') ):
   
     function wpestate_get_city_select_list($args){
        $categ_select_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Cities','wpestate').'</li>';
        $taxonomy           =   'product_city';
        $categories     =   get_terms($taxonomy,$args);
       
        foreach ($categories as $categ) {
            $string     =   wpestate_limit45 ( sanitize_title ( $categ->slug ) );              
            $slug       =   sanitize_key($string);
            $received   =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
            $counter    =   $categ->count;
            if( isset($received['count'])   ){
                $counter = $counter+$received['count'];
            }
            
            $categ_select_list  .=  '<li role="presentation" data-value="'.$categ->slug.'" data-value2="'.$slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }
            
        }
        return $categ_select_list;
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy area
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_area_select_list') ):
    
    function wpestate_get_area_select_list($args){
    $categ_select_list  =   '<li role="presentation" data-value="all">'.__('All Areas','wpestate').'</li>';
    $taxonomy           =   'product_area';
    $categories         =   get_terms($taxonomy,$args);
  
    foreach ($categories as $categ) {
        $term_meta      =   get_option( "taxonomy_$categ->term_id");
        $string         =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
        $slug           =   sanitize_key($string);
        $received       =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
        $counter        =   $categ->count;
        if( isset($received['count'])   ){
            $counter = $counter+$received['count'];
        }

        $categ_select_list  .=  '<li role="presentation" data-value="'.$categ->slug.'" data-parentcity="' . $slug . '">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
        if(isset($received['html'])){
            $categ_select_list     .=   $received['html'];  
        }

    }
    return $categ_select_list;
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// show hieracy categeg
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_hierarchical_category_childen') ):
    
     function wpestate_hierarchical_category_childen($taxonomy, $cat,$args,$base=1,$level=1  ) {
        $level++;
        $args['parent']             =   $cat;
        $children                   =   get_terms($taxonomy,$args);
        $return_array=array();
        $total_main[$level]=0;
        $children_categ_select_list =   '';
        foreach ($children as $categ) {
            
            $area_addon =   '';
            $city_addon =   '';

            if($taxonomy=='product_city'){
                $string       =     wpestate_limit45 ( sanitize_title ( $categ->slug ) );              
                $slug         =     sanitize_key($string);
                $city_addon   =     ' data-value2="'.$slug.'" ';
            }

            if($taxonomy=='product_area'){
                $term_meta    =   get_option( "taxonomy_$categ->term_id");
                $string       =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
                $slug         =   sanitize_key($string);
                $area_addon   =   ' data-parentcity="' . $slug . '" ';

            }
            
            $hold_base=  $base;
            $base_string='';
            $base++;
            $hold_base=  $base;
            
            if($level==2){
                $base_string='-';
            }else{
                $i=2;
                $base_string='';
                while( $i <= $level ){
                    $base_string.='-';
                    $i++;
                }
              
            }
    
            
            if($categ->parent!=0){
                $received =wpestate_hierarchical_category_childen( $taxonomy, $categ->term_id,$args,$base,$level ); 
            }
            
            
            $counter = $categ->count;
            if(isset($received['count'])){
                $counter = $counter+$received['count'];
            }
            
            $children_categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'" '.$city_addon.' '.$area_addon.' > '.$base_string.' '. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
           
            if(isset($received['html'])){
                $children_categ_select_list     .=   $received['html'];  
            }
          
            $total_main[$level]=$total_main[$level]+$counter;
            
            $return_array['count']=$counter;
            $return_array['html']=$children_categ_select_list;
            
            
        }
      //  return $children_categ_select_list;
 
        $return_array['count']=$total_main[$level];
    
     
        return $return_array;
    }
endif;


if( !function_exists('wpestate_ajax_filter_ondemand_listings_with_geo') ):
    
    function wpestate_ajax_filter_ondemand_listings_with_geo(){
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $listing_type;
        global $property_unit_slider;
        global $curent_fav;
        global $full_page;
        global $guest;
        global $guest_no;
        global $book_from;
        global $book_to;
        
        $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
        $listing_type               =   get_option('wp_estate_listing_unit_type','');
        $show_compare_only          =   'no';
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';     
        $city_array                 =   '';             
        $action_array               =   '';   
        $categ_array                =   '';

        $options        =   wpestate_page_details(intval($_POST['postid']));
        $allowed_html   =   array();

        if($options['content_class']=="col-md-12"  ){
            $full_page=1;
        }
        if(basename(get_page_template_slug(intval($_POST['postid']))) === 'property_list_half.php'){
            $full_page=0; 
        }
        $property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));
        if(basename(get_page_template_slug(intval($_POST['postid']))) === 'advanced_search_results.php' && $property_list_type_status==2){
            $full_page=0; 
        }
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses( $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'] ,$allowed_html) );   
            $action_array=array(
                'taxonomy'  => 'product_brand_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
        }

   
      

        $meta_query = $rooms = $baths = $price = array();
        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// chekcers
        //////////////////////////////////////////////////////////////////////////////////////
        $all_checkers=explode(",",$_POST['all_checkers']);

        foreach ($all_checkers as $cheker){
            if($cheker!=''){
                $check_array    =   array();
                $check_array['key']   =   $cheker;
                $check_array['value'] =  1;
                $check_array['compare']     = 'CHAR';
                $meta_query[]   =   $check_array;
            }        
        }
        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// price filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $price_low ='';
        if( isset($_POST['price_low'])){
            $price_low = intval($_POST['price_low']);
        }

        $price_max='';
        if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
            $price_max          = intval($_POST['price_max']);
            $price['key']       = 'property_price';
            
            $custom_fields = get_option( 'wp_estate_multi_curr', true);
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                if ($price_low != 0) {
                    $price_low      = $price_low / $custom_fields[$i][2];
                }
                if ($price_max != 0) {
                    $price_max      = $price_max / $custom_fields[$i][2];
                }
             
            }
  
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }
         
        //////////////////////////////////////////////////////////////////////////////////////
        ///// calendar filters
        //////////////////////////////////////////////////////////////////////////////////////

        $allowed_html   =   array();
        $book_from      =   '';
        $book_to        =   '';
        if( isset($_POST['check_in'])){
            $book_from      =  sanitize_text_field ( wp_kses ( $_POST['check_in'],$allowed_html) );
        }
        if( isset($_POST['check_out'])){
            $book_to        =  sanitize_text_field( wp_kses ( $_POST['check_out'],$allowed_html) );
        }
         
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $meta_order='prop_featured';
        $meta_directions='DESC';   
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    break;
            }
        }
        
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
        
        
        
        
        $ne_lat          = floatval($_POST['ne_lat']);
        $ne_lng          = floatval($_POST['ne_lng']);
        $sw_lat          = floatval($_POST['sw_lat']);
        $sw_lng          = floatval($_POST['sw_lng']);
        
        
        
        $long_array=array();
        $lat_array=array();
 
        $meta_query['relation'] = 'AND';
                    
            
        $min_lat    =  $sw_lat;
        $max_lat    =  $ne_lat;
        
        if($min_lat>$max_lat){
            $min_lat    =  $ne_lat;
            $max_lat    =  $sw_lat ;
        }
        
       
        $min_lng    =   $sw_lng;
        $max_lng    =   $ne_lng;
                
        if($min_lng>$max_lng){
            $min_lng = $ne_lng;
            $max_lng = $sw_lng;
        } 
        
        
        $long_array['key']       = 'product_longitude';
        $long_array['value']     =  array( $min_lng,$max_lng);
        $long_array['type']      = 'DECIMAL';
        $long_array['compare']   = 'BETWEEN';
        $meta_query[]            =  $long_array;

       
        $lat_array['key']       = 'product_latitude';
        $lat_array['value']     =  array( $min_lat,$max_lat);
        $lat_array['type']      = 'DECIMAL';
        $lat_array['compare']   = 'BETWEEN';
        $meta_query[]           =  $lat_array;
        
  
           
        ////////////////////////////////////////////////////////////////////////////
        // if we have check in and check out dates we need to double loop
        ////////////////////////////////////////////////////////////////////////////
        if ( $book_from!='' && $book_from!='' ){
            $args = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'post_type'               =>    'product',
                'post_status'             =>    'publish',
                'posts_per_page'          =>    '-1', 
                'meta_query'              =>    $meta_query,
                'tax_query'               => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );
        $args1 = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'post_type'               =>    'product',
                'post_status'             =>    'publish',
                'posts_per_page'          =>    '-1',
                'meta_query'              =>    $meta_query,
                'tax_query'               => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );
       
                add_filter('get_meta_sql','cast_decimal_precision');
                $prop_selection = new WP_Query($args);
                remove_filter('get_meta_sql');
                  
                $right_array=array();
                $right_array[]=0;
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    // print '</br>we check '.$post->ID.'</br>';
                    if( wpestate_check_booking_valability($book_from,$book_to,$post->ID) ){
                        $right_array[]=$post->ID;
                    }
                endwhile;

                wp_reset_postdata();
                $args = array(
                    'cache_results'           =>    false,
                    'update_post_meta_cache'  =>    false,
                    'update_post_term_cache'  =>    false,
                    'post_type'               =>    'product',
                    'post_status'             =>    'publish',
                    'paged'                   =>    $paged,
                    'posts_per_page'          =>    $prop_no,
                    'post__in'                =>    $right_array
                );
                //print_r($args);
               
                add_filter( 'posts_orderby', 'wpestate_my_order' );
                $prop_selection =   new WP_Query($args);
                remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }else{
            $args = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'post_type'               =>    'product',
                'post_status'             =>    'publish',
                'paged'                   =>    $paged,
                'posts_per_page'          =>    $prop_no,
                'meta_query'              =>    $meta_query,
                'tax_query'               => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );   
                add_filter('get_meta_sql','cast_decimal_precision');
                add_filter( 'posts_orderby', 'wpestate_my_order' );
                    $prop_selection =   new WP_Query($args);
                remove_filter( 'posts_orderby', 'wpestate_my_order' );
                remove_filter('get_meta_sql');
        }
      
        $counter          =     0;
        $compare_submit   =     wpestate_get_compare_link();
        $markers          =     array();
        $return_string='';
        ob_start(); 
 
        print '<span id="scrollhere"></span>';

      
        
        $listing_unit_style_half    =   get_option('wp_estate_listing_unit_style_half','');

     
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                if  (   $listing_unit_style_half == 1 && 
                        ( basename(get_page_template_slug(intval($_POST['postid']))) == 'property_list_half.php' ||  
                           ( basename(get_page_template_slug(intval($_POST['postid']))) == 'advanced_search_results.php' && $property_list_type_status==2 ) ) 
                    ){
                    get_template_part('templates/property_unit_wide');
                }else{
                    get_template_part('templates/property_unit');        
                }
                $markers[]=wpestate_pin_unit_creation( get_the_ID(),$currency,$where_currency,$counter );
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search_home'); 
        }else{
            print '<span class="no_results">'. esc_html__( "We didn't find any results","wpestate").'</>';
        }
        $templates = ob_get_contents();
        ob_end_clean(); 
        $return_string .=   '<div class="half_map_results">'.$prop_selection->found_posts.' '.esc_html__( ' Results found!','wpestate').'</div>';
        $return_string .=   $templates;
        echo json_encode(array('added'=>true,'arguments'=>json_encode($args),'arg1'=>json_encode($args1), 'markers'=>json_encode($markers),'response'=>$return_string ));
        die();
    }
  
endif; // end   ajax_filter_listings 
 

 
if( !function_exists('wpestate_ajax_filter_listings') ):
    
    function wpestate_ajax_filter_listings(){
     
        global $currency;
        global $where_currency;
        global $post;
        global $options;
        global $full_page;
        global $curent_fav;
        global $listing_type;
        global $property_unit_slider;

        $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
        $listing_type               =   get_option('wp_estate_listing_unit_type','');
        $current_user = wp_get_current_user();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $currency                 =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency           =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array               =   '';   
        $city_array               =   '';
        $action_array             =   '';
        $categ_array              =   '';
        $show_compare             =   1;

        if( isset($_POST['page_id']) ){
            $options                  =   wpestate_page_details(intval($_POST['page_id'])); 
        }
        
      
        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != esc_html__( 'All Types','wpestate') && $_POST['category_values']!=''&& $_POST['category_values']!='all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'],$allowed_html  ) );
            $categ_array=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != esc_html__( 'All Sizes','wpestate') ) && $_POST['action_values']!='' && $_POST['action_values']!='all'){
            $taxaction_include   =   sanitize_title ( wp_kses(  $_POST['action_values'],$allowed_html  ) );   
            $action_array=array(
                'taxonomy'  => 'product_brand_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != esc_html__( 'All Cities','wpestate') && $_POST['city'] && trim($_POST['city']) != 'all' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'product_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( isset( $_POST['area'] ) && trim($_POST['area']) != esc_html__( 'All Areas','wpestate') && $_POST['area'] && trim($_POST['area']) != 'all' ) {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'product_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }

               
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        if( isset($_POST['order'])){
            $order=wp_kses($_POST['order'],$allowed_html); 
        }
        switch ($order){
      case 0:
               $meta_order='_price';
               $meta_directions='DESC';
               break;
           case 1:
               $meta_order='_price';
               $meta_directions='DESC';
               break;
           case 2:
               $meta_order='_price';
               $meta_directions='ASC';
               break;
           case 3:
               $meta_order='_price';
               $meta_directions='DESC';
               break;
           case 4:
               $meta_order='_price';
               $meta_directions='ASC';
               break;
        }
        $paged      =   intval( $_POST['newpage'] );
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
         
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'paged'             => $paged,
            'posts_per_page'    => $prop_no,
            'orderby'           => 'meta_value_num', 
            'meta_key'          => $meta_order,
            'order'             => $meta_directions,
            'meta_query'        => array(),
            'tax_query'         => array(
                                'relation' => 'AND',
                                        $categ_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                )
        );
    
        if($options['content_class']=="col-md-12"){
            $full_page=1;
        }
        
        if( $order==0 ){
            add_filter( 'posts_orderby', 'wpestate_my_order' );
            $prop_selection = new WP_Query($args);
            remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }else{
            $prop_selection = new WP_Query($args);
        }
     
        print '<span id="scrollhere"></span>';  
        $counter = 0;
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
               get_template_part('templates/property_unit');
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax'); 
        }else{
            print '<span class="no_results">'. esc_html__( "We didn't find any results","wpestate").'</>';
        }
        wp_reset_query();
        die();
    }
  
 endif; // end   ajax_filter_listings_search 
 
 
 
if( !function_exists('wpestate_get_filtering_ajax_result') ):
    
    function wpestate_get_filtering_ajax_result(){
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        $current_user = wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array =   
        $city_array =  
        $action_array               = '';   
        $categ_array                = '';

        $options        =   wpestate_page_details(intval($_POST['postid']));
      
 
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }

     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'],$allowed_html ) );   
            $action_array=array(
                 'taxonomy' => 'product_brand_category',
                 'field'    => 'slug',
                 'terms'    => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        
        if (isset($_POST['city']) && trim($_POST['city']) != 'all' && $_POST['city']!='') {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'product_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['area']) && trim($_POST['area']) != 'all' && $_POST['area']!='') {
            $taxarea[] = sanitize_title ( wp_kses($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'product_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }
 
               
         
         
         
         
        $meta_query = $price = array();
        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// price filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $price_low ='';
        if( isset($_POST['price_low'])){
           $price_low = intval($_POST['price_low']);
        }

        $price_max='';
        if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
            $price_max         = intval($_POST['price_max']);
            $price['key']      = '_price';
            $price['value']    = array($price_low, $price_max);
            $price['type']     = 'numeric';
            $price['compare']  = 'BETWEEN';
            $meta_query[]      = $price;
        }



        //////////////////////////////////////////////////////////////////////////////////////
        ///// price filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $price_low ='';
        if( isset($_POST['price_low'])){
            $price_low = intval($_POST['price_low']);
        }

        $price_max='';
        if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
            $price_max          = intval($_POST['price_max']);
            $price['key']       = '_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }

        //////////////////////////////////////////////////////////////////////////////////////
        ///// calendar filters
        //////////////////////////////////////////////////////////////////////////////////////

        $allowed_html   =   array();
        $book_from      =   '';
        $book_to        =   '';
        if( isset($_POST['check_in'])){
            $book_from      =   wp_kses ( $_POST['check_in'],$allowed_html);
        }
        if( isset($_POST['check_out'])){
            $book_to        =   wp_kses ( $_POST['check_out'],$allowed_html);
        }

      
          
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'paged'             => '-1',
            'meta_query'        => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                   
                                    )
        );
        //   print_r($args);
        $prop_selection = new WP_Query($args);
        if( $prop_selection->have_posts() ){
            print $prop_selection->post_count;

        }else{
            print '0';
        }     
        die();
  }
  
 endif; // end   get_filtering_ajax_result 
 
 
 
if( !function_exists('wpestate_ajax_filter_listings_search') ):
    
    function wpestate_ajax_filter_listings_search(){
        global $post;
        global $current_user;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $full_page ;
        global $listing_type;
        global $property_unit_slider;

        $property_unit_slider   =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
        $listing_type           =   get_option('wp_estate_listing_unit_type','');       
        $full_page              =   0;
        $options                =   wpestate_page_details(intval($_POST['postid']));
      
        if($options['content_class']=="col-md-12"){
            $full_page=1;
        }
    
        $show_compare_only          =   'no';
        $current_user = wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array =   
        $city_array =  
        $action_array               = '';   
        $categ_array                = '';
        $allowed_html               = array();
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != 'all' and trim($_POST['city']) != '') {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'product_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

         if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'all' && trim($_POST['area']) != '') {           
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy' => 'product_area',
                'field'    => 'slug',
                'terms'    => $taxarea
            );
        }
 

        $meta_query     =   array();
        

        
        $country_array=array();
        if( isset($_POST['country'])  && $_POST['country']!='' ){
            $country                     =   sanitize_text_field(wp_kses ($_POST['country'],$allowed_html));
            $country                     =   str_replace('-', ' ', $country);
            $country_array['key']        =   'product_country';
            $country_array['value']      =   $country;
            $country_array['type']       =   'CHAR';
            $country_array['compare']    =   'LIKE'; 
            $meta_query[]                =   $country_array;
        }
        
        $allowed_html   =   array();
        $book_from      =   '';
        $book_to        =   '';
        if( isset($_POST['check_in'])){
            $book_from      =  sanitize_text_field( wp_kses ( $_POST['check_in'],$allowed_html));
        }
        if( isset($_POST['check_out'])){
            $book_to        =   sanitize_text_field(wp_kses ( $_POST['check_out'],$allowed_html));
        }
        
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,        
            'meta_query'        => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                    )
        );
    
     
        $prop_selection = new WP_Query($args);

        $counter          =   0;
        $compare_submit   =   wpestate_get_compare_link();
        
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                if( wpestate_check_booking_valability($book_from,$book_to,$post->ID) ){
                    get_template_part('templates/property_unit');
                }
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. esc_html__( "We didn't find any results","wpestate").'</>';
        }
        die();
}
endif; // end   ajax_filter_listings 
 

if( !function_exists('wpestate_custom_adv_ajax_filter_listings_search') ):
    
    function wpestate_custom_adv_ajax_filter_listings_search(){
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $listing_type;
        global $property_unit_slider;

        $property_unit_slider   =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 
        $listing_type           =   get_option('wp_estate_listing_unit_type','');
      
        $current_user = wp_get_current_user();
        $show_compare_only  =   'no';
        $userID             =   $current_user->ID;
        $user_option        =   'favorites'.$userID;
        $curent_fav         =   get_option($user_option);
        $currency           =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array         =   '';   
        $city_array         =   ''; 
        $action_array       =   '';   
        $categ_array        =   '';
        $meta_query         =   array();
        $options            =   wpestate_page_details(intval($_POST['postid']));
        $adv_search_what    =   get_option('wp_estate_adv_search_what','');
        $adv_search_how     =   get_option('wp_estate_adv_search_how','');
        $adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    =   get_option('wp_estate_adv_search_type','');

        $allowed_html   =   array();
        $new_key=0;
        foreach($adv_search_what as $key=>$term){
         
        $new_key=$key+1;  
        $new_key='val'.$new_key;
        if($term=='none'){

        }
        else if($term=='categories'){ // for property_category taxonomy

            if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                $taxcateg_include   =   array();
                $taxcateg_include[] =  sanitize_title( wp_kses($_POST[$new_key],$allowed_html) );
                $categ_array    =   array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $taxcateg_include
                );
            } 
        } /////////// end if categories


          else if($term=='types'){ // for property_action_category taxonomy
             
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxaction_include   =   array();   

                    $taxaction_include[] = sanitize_title ( wp_kses($_POST[$new_key],$allowed_html) );

                    $action_array=array(
                        'taxonomy'  => 'product_brand_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                 }
          } //////////// end for property_action_category taxonomy


          else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcity[]  = sanitize_title (wp_kses ($_POST[$new_key],$allowed_html));
                    $city_array = array(
                        'taxonomy' => 'product_city',
                        'field' => 'slug',
                        'terms' => $taxcity
                    );
              }
          } //////////// end for property_city taxonomy

          else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxarea[]  = sanitize_title(wp_kses ( $_POST[$new_key],$allowed_html ));
                    $area_array = array(
                        'taxonomy' => 'product_area',
                        'field' => 'slug',
                        'terms' => $taxarea
                    );
                }
          } //////////// end for property_area taxonomy


          else{ 

            // $slug=str_replace(' ','_',$term); 
            // $slug_name=str_replace(' ','-',$adv_search_label[$key]);
            $slug_name         =   wpestate_limit45(sanitize_title( $term ));
            $slug_name         =   sanitize_key($slug_name);
            $slug_name_key     =   $slug_name; 
             if( isset($_POST[$new_key]) && $adv_search_label[$key] != $_POST[$new_key] && $_POST[$new_key] != ''){ // if diffrent than the default values
                      $compare=$search_type=''; 
                      $compare_array=array();
                       //$adv_search_how

                      $compare=$adv_search_how[$key];
                      $slug_name_key=$slug_name;
                      $old_values=array(
                        'property-price',
                        'property-label',
                        'property-size',
                        'property-lot-size',
                        'property-rooms',
                        'property-bedrooms',
                        'property-bathrooms',
                        'property-bathrooms',
                        'property-address',
                        'property-county',
                        'property-state',
                        'property-zip',
                        'property-country',
                        'property-status',
                      );
                                
                        if(  in_array($slug_name,$old_values) ){
                            $slug_name_key=  str_replace('-', '_', $slug_name);
                        }
                                
                     
                      if($compare=='equal'){
                         $compare='='; 
                         $search_type='numeric';
                         $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='greater'){
                          $compare='>='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='smaller'){
                          $compare='<='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='like'){
                          $compare='LIKE'; 
                          $search_type='CHAR';
                          $term_value= sanitize_title (wp_kses( $_POST[$new_key],$allowed_html ));

                      }else if($compare=='date bigger'){
                          $compare='>='; 
                          $search_type='DATE';
                          $term_value= sanitize_title(wp_kses( $_POST[$new_key],$allowed_html) );

                      }else if($compare=='date smaller'){
                          $compare='<='; 
                          $search_type='DATE';
                          $term_value= sanitize_title(wp_kses( $_POST[$new_key],$allowed_html) );
                      }

                      $compare_array['key']        = $slug_name_key;
                      $compare_array['value']      = $term_value;
                      $compare_array['type']       = $search_type;
                      $compare_array['compare']    = $compare;
                      $meta_query[]                = $compare_array;

            }// end if diffrent
          }////////////////// end last else
       } ///////////////////////////////////////////// end for each adv search term

      
      
  

        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
       
        
        $args = array(
          'post_type'           => 'product',
          'post_status'         => 'publish',
          'paged'               => $paged,
          'posts_per_page'      => 30,
          'order'               => 'DESC',
          'meta_query'          => $meta_query,
          'tax_query'           => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                 )
        );
    
        
    
        //////////////////////////////////////////////////// in case of slider search
        if(get_option('wp_estate_show_slider_price','') =='yes') {
           $where_to_replace = -1;
            foreach ($args['meta_query'] as $key => $arr_compare) {
                if ($arr_compare['key']=='_price'){
                    $where_to_replace=$key;
                }
            }
          //  print 'to replace here '.$where_to_replace;
            if($where_to_replace!=-1){
                unset ( $args['meta_query'][$where_to_replace] );
           //     print 'after unser';
          //       print_r($args);
                      $compare_array['key']        = '_price';
                      $compare_array['value']      = intval ( $_POST['slider_min'] );
                      $compare_array['type']       = 'numeric';
                      $compare_array['compare']    =  '>='; 
                      $args['meta_query'][]        = $compare_array;
                      $compare_array['key']        = 'property_price';
                      $compare_array['value']      = intval ( $_POST['slider_max'] );
                      $compare_array['type']       = 'numeric';
                      $compare_array['compare']    =  '<='; 
                      $args['meta_query'][]        = $compare_array;
                
            }
        }
         
        ////////////////////////////////////////////////////////// end in case of slider search 
        //  print_r($args);
        $prop_selection     = new WP_Query($args);

        $counter            =   0;
        $compare_submit     =   wpestate_get_compare_link();
        print '<span id="scrollhere"></span>';

        if( !is_tax() ){
            print '<div class="compare_ajax_wrapper">';
                get_template_part('templates/compare_list'); 
            print'</div>';     
        }
      
   
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
               get_template_part('templates/property_unit');
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. esc_html__( "We didn't find any results","wpestate").'</>';
        }
        die();
  }
  
 endif; // end   ajax_filter_listings 
  

if( !function_exists('custom_adv_get_filtering_ajax_result') ):
    
    function custom_adv_get_filtering_ajax_result(){
        global $post;
        global $current_user;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        $allowed_html   =   array();
        $current_user = wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array =   
        $city_array =  
        $action_array               = '';   
        $categ_array                = '';
        $meta_query             =   array();
        $options        =   wpestate_page_details(intval($_POST['postid']));

        $adv_search_what    = get_option('wp_estate_adv_search_what','');
        $adv_search_how     = get_option('wp_estate_adv_search_how','');
        $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    = get_option('wp_estate_adv_search_type','');

        
        $new_key=0;
        foreach($adv_search_what as $key=>$term){
         
          $new_key=$key+1;  
          $new_key='val'.$new_key;
          if($term=='none'){

           }
           else if($term=='categories'){ // for property_category taxonomy
                
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcateg_include   =   array();
                    $taxcateg_include[] =   sanitize_title(wp_kses ( $_POST[$new_key],$allowed_html ));
                    $categ_array    =array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
                } 
           } /////////// end if categories


          else if($term=='types'){ // for property_action_category taxonomy
             
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxaction_include   =   array();   
                    $taxaction_include[] =  sanitize_title(wp_kses($_POST[$new_key],$allowed_html));
                    $action_array=array(
                        'taxonomy'  => 'product_brand_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
          } //////////// end for property_action_category taxonomy


          else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcity[] = sanitize_title(wp_kses ($_POST[$new_key],$allowed_html));
                    $city_array = array(
                        'taxonomy'  => 'product_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
          } //////////// end for property_city taxonomy

          else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxarea[]  =   sanitize_title( wp_kses($_POST[$new_key],$allowed_html));
                    $area_array =   array(
                        'taxonomy'  => 'product_area',
                        'field'     => 'slug',
                        'terms'     => $taxarea
                    );
                }
          } //////////// end for property_area taxonomy


          else{ 

             $slug=str_replace(' ','_',$term); 
             $slug_name=str_replace(' ','-',$adv_search_label[$key]);

             if( isset($_POST[$new_key]) && $adv_search_label[$key] != $_POST[$new_key] && $_POST[$new_key] != ''){ // if diffrent than the default values
                      $compare=$search_type=''; 
                      $compare_array=array();
                       //$adv_search_how

                      $compare=$adv_search_how[$key];

                      if($compare=='equal'){
                         $compare='='; 
                         $search_type='numeric';
                         $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='greater'){
                          $compare='>='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='smaller'){
                          $compare='<='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='like'){
                          $compare='LIKE'; 
                          $search_type='CHAR';
                          $term_value= sanitize_title ( wp_kses( $_POST[$new_key],$allowed_html ) );

                      }else if($compare=='date bigger'){
                          $compare='>='; 
                          $search_type='DATE';
                          $term_value= sanitize_title ( wp_kses( $_POST[$new_key],$allowed_html ) );

                      }else if($compare=='date smaller'){
                          $compare='<='; 
                          $search_type='DATE';
                          $term_value= sanitize_title( wp_kses( $_POST[$new_key],$allowed_html) );
                      }

                      $compare_array['key']        = $slug;
                      $compare_array['value']      = $term_value;
                      $compare_array['type']       = $search_type;
                      $compare_array['compare']    = $compare;
                      $meta_query[]                = $compare_array;

            }// end if diffrent
          }////////////////// end last else
       } ///////////////////////////////////////////// end for each adv search term

      
        
        $args = array(
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page'    =>  '-1',
        'meta_query'       => $meta_query,
        'tax_query'        => array(
          'relation' => 'AND',
          $categ_array,
          $action_array,
          $city_array,
          $area_array
        )
       );
    
    //  print_r($args);
 
      $prop_selection = new WP_Query($args);
      if( $prop_selection->have_posts() ){
          print $prop_selection->post_count;
       
      }else{
          print '0';
      }

            
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 

if( !function_exists('wpestate_ajax_filter_listings_search_onthemap') ):
    
    function wpestate_ajax_filter_listings_search_onthemap(){
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $listing_type;
        global $property_unit_slider;
        global $curent_fav;
        global $book_from;
        global $book_to;
        global $guest_no;
        $property_unit_slider       =   esc_html ( get_option('wp_estate_prop_list_slider','') ); 

        $listing_type   =   get_option('wp_estate_listing_unit_type','');
        $show_compare_only          =   'no';
        $current_user = wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';     
        $city_array                 =   '';             
        $action_array               =   '';   
        $categ_array                =   '';

        $options        =   wpestate_page_details(intval($_POST['postid']));
        $allowed_html   =   array();

      
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses( $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }

        if (isset($_POST['product_type']) && trim($_POST['product_type']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses( $_POST['product_type'] ,$allowed_html ) );
            $product_type_array=array(
              'taxonomy'  => 'product_type',
              'field'     => 'slug',
              'terms'     => array('variable', $taxcateg_include),
              'operator'    => 'IN'
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'] ,$allowed_html) );   
            $action_array=array(
                'taxonomy'  => 'product_brand_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) && trim($_POST['city']) != 'all' && $_POST['city']!='') {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'product_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        if (isset($_POST['area']) && trim($_POST['area']) != 'all' && $_POST['area']!='') {
            $taxarea[] = sanitize_title ( wp_kses($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'product_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }
 
      
 

        $meta_query = $price = array();
        

        $country_array=array();
        if( isset($_POST['country'])  && $_POST['country']!='' ){
            $country                     =   sanitize_text_field ( wp_kses ($_POST['country'],$allowed_html) );
            $country                     =   str_replace('-', ' ', $country);
            $country_array['key']        =   '_country';
            $country_array['value']      =   $country;
            $country_array['type']       =   'CHAR';
            $country_array['compare']    =   'LIKE'; 
            $meta_query[]                =   $country_array;
        }
           
        if( isset($_POST['city']) && $_POST['city']=='' && isset($_POST['property_admin_area']) && $_POST['property_admin_area']!=''   ){
            $admin_area_array=array();
            $admin_area                     =   sanitize_text_field ( wp_kses ($_POST['property_admin_area'],$allowed_html) );
            $admin_area                     =   str_replace(" ", "-", $admin_area);
            $admin_area                     =   str_replace("\'", "", $admin_area);
            $admin_area_array['key']        =   'product_admin_area';
            $admin_area_array['value']      =   $admin_area;
            $admin_area_array['type']       =   'CHAR';
            $admin_area_array['compare']    =   'LIKE'; 
            $meta_query[]                   =   $admin_area_array;
        }

        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// chekcers
        //////////////////////////////////////////////////////////////////////////////////////
        $all_checkers=explode(",",$_POST['all_checkers']);

        foreach ($all_checkers as $cheker){
            if($cheker!=''){
                $check_array    =   array();
                $check_array['key']   =   $cheker;
                $check_array['value'] =  1;
                $check_array['compare']     = 'CHAR';
                $meta_query[]   =   $check_array;
            }        
        }
        
        //////////////////////////////////////////////////////////////////////////////////////
        ///// price filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $price_low ='';
        if( isset($_POST['price_low'])){
            $price_low = intval($_POST['price_low']);
        }

        $price_max='';
        if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
            $price_max          = intval($_POST['price_max']);
            $price['key']       = '_price';
            
            $custom_fields = get_option( 'wp_estate_multi_curr', true);
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                if ($price_low != 0) {
                    $price_low      = $price_low / $custom_fields[$i][2];
                }
                if ($price_max != 0) {
                    $price_max      = $price_max / $custom_fields[$i][2];
                }
             
            }
  
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }
         
        //////////////////////////////////////////////////////////////////////////////////////
        ///// calendar filters
        //////////////////////////////////////////////////////////////////////////////////////

        $allowed_html   =   array();
        $book_from      =   '';
        $book_to        =   '';
        if( isset($_POST['check_in'])){
            $book_from      =  sanitize_text_field ( wp_kses ( $_POST['check_in'],$allowed_html) );
        }
        if( isset($_POST['check_out'])){
            $book_to        =  sanitize_text_field( wp_kses ( $_POST['check_out'],$allowed_html) );
        }
         
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $meta_order='prop_featured';
        $meta_directions='DESC';   
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='_price';
                    $meta_directions='DESC';
                    break;
                case 2:
            }
        }
        
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
        
        ////////////////////////////////////////////////////////////////////////////
        // if we have check in and check out dates we need to double loop
        ////////////////////////////////////////////////////////////////////////////
        if ( $book_from!='' && $book_from!='' ){
            $args = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'post_type'               =>    'product',
                'post_status'             =>    'publish',
                'posts_per_page'          =>    '-1',
                'meta_query'              =>    $meta_query,
                'tax_query'               => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $product_type_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );
       
     
                $prop_selection = new WP_Query($args);
                $right_array=array();
                $right_array[]=0;
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    // print '</br>we check '.$post->ID.'</br>';
                    if( wpestate_check_booking_valability($book_from,$book_to,$post->ID) ){
                        $right_array[]=$post->ID;
                    }
                endwhile;

                wp_reset_postdata();
                $args = array(
                    'cache_results'           =>    false,
                    'update_post_meta_cache'  =>    false,
                    'update_post_term_cache'  =>    false,
                    'post_type'               =>    'product',
                    'post_status'             =>    'publish',
                    'paged'                   =>    $paged,
                    'posts_per_page'          =>    $prop_no,
                    'post__in'                =>    $right_array
                );
                //print_r($args);
               
                add_filter( 'posts_orderby', 'wpestate_my_order' );
                $prop_selection =   new WP_Query($args);
                remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }else{
            $args = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'post_type'               =>    'product',
                'post_status'             =>    'publish',
                'paged'                   =>    $paged,
                'posts_per_page'          =>    $prop_no,
                'meta_query'              =>    $meta_query,
                'tax_query'               => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $product_type_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );   
                $prop_selection =   new WP_Query($args);
       
        }
      
        $counter          =     0;
        $compare_submit   =     wpestate_get_compare_link();
        $markers          =     array();
        $return_string='';
        ob_start(); 
 
        print '<span id="scrollhere"></span>';

        $listing_unit_style_half    =   get_option('wp_estate_listing_unit_style_half','');

     
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                if($listing_unit_style_half == 1){
                    get_template_part('templates/property_unit');
                }else{
                    get_template_part('templates/property_unit');        
                }
                $markers[]=wpestate_pin_unit_creation( get_the_ID(),$currency,$where_currency,$counter );
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search_home'); 
        }else{
            print '<span class="no_results">'. esc_html__( "We didn't find any results","wpestate").'</>';
        }
       // print '</div>';
        $templates = ob_get_contents();
        ob_end_clean(); 
        $return_string .=   '<div class="half_map_results">'.$prop_selection->found_posts.' '.esc_html__( ' Results found!','wpestate').'</div>';
        $return_string .=   $templates;
        echo json_encode(array('added'=>true,'arguments'=>json_encode($args), 'markers'=>json_encode($markers),'response'=>$return_string ));
        die();
    }
  
endif; // end   ajax_filter_listings 



if( !function_exists('wpestate_ajax_filter_listings_search_on_main_map') ):
    
    function wpestate_ajax_filter_listings_search_on_main_map(){
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        $current_user = wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';     
        $city_array                 =   '';             
        $action_array               =   '';   
        $categ_array                =   '';
        $allowed_html               =   array();
        $meta_query                 =   array();
      
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) && trim($_POST['city']) != 'all' && $_POST['city']!='') {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'product_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        if (isset($_POST['area']) && trim($_POST['area']) != 'all' && $_POST['area']!='') {
            $taxarea[] = sanitize_title ( wp_kses($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'product_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }
 
      
        $guest_array=array();
        
        $country_array=array();
        if( isset($_POST['country'])  && $_POST['country']!='' ){
            $country                     =   sanitize_text_field( wp_kses ($_POST['country'],$allowed_html) );
            $country                     =   str_replace('-', ' ', $country);
            $country_array['key']        =   '_country';
            $country_array['value']      =   $country;
            $country_array['type']       =   'CHAR';
            $country_array['compare']    =   'LIKE'; 
            $meta_query[]                =   $country_array;
        }
        
        if( isset($_POST['city']) && $_POST['city']=='' && isset($_POST['property_admin_area']) && $_POST['property_admin_area']!=''   ){
            $admin_area_array=array();
            $admin_area                     =   sanitize_text_field( wp_kses ($_POST['property_admin_area'],$allowed_html) );
            $admin_area                     =   str_replace(" ", "-", $admin_area);
            $admin_area                     =   str_replace("\'", "", $admin_area);
            $admin_area_array['key']        =   'product_admin_area';
            $admin_area_array['value']      =   $admin_area;
            $admin_area_array['type']       =   'CHAR';
            $admin_area_array['compare']    =   'LIKE'; 
            $meta_query[]                   =   $admin_area_array;

        }
   
           
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// calendar filters
        //////////////////////////////////////////////////////////////////////////////////////

       
        $book_from      =   '';
        $book_to        =   '';
        if( isset($_POST['check_in'])){
            $book_from      =   sanitize_text_field ( wp_kses ( $_POST['check_in'],$allowed_html) );
        }
        if( isset($_POST['check_out'])){
            $book_to        =   sanitize_text_field ( wp_kses ( $_POST['check_out'],$allowed_html) );
        }
         
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
      
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_query'        => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                   
                                    )
        );
    
        $prop_selection = new WP_Query($args);
        $counter    =   0;
        $markers    =   array();
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
        if( wpestate_check_booking_valability($book_from,$book_to,$post->ID) ){
            $counter++;
            $markers[]=wpestate_pin_unit_creation( get_the_ID(),$currency,$where_currency,$counter );
        
        }
        endwhile;
        echo json_encode(array('added'=>true,'arguments'=>json_encode($args), 'markers'=>json_encode($markers),'counter'=>$counter ));
        die();
    }
  
endif; // end   ajax_filter_listings
 
 

if( !function_exists('wpestate_theme_slider') ):

function  wpestate_theme_slider(){
    $theme_slider   =   get_option( 'wp_estate_theme_slider', true); 
    $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Select Products ','wpestate').'</div>
        <div class="option_row_explain">'.__('Select Products for slider - *hold CTRL for multiple select ','wpestate').'</div>'; 
    $args = array(      'post_type'         =>  'product',
                        'post_status'       =>  'publish',
                        'paged'             =>  0,
                        'posts_per_page'    =>  -1 
                 );

        $recent_posts = new WP_Query($args);
        print '<select name="theme_slider[]"  id="theme_slider"  multiple="multiple">';
        while ($recent_posts->have_posts()): $recent_posts->the_post();
             $theid=get_the_ID();
             print '<option value="'.$theid.'" ';
             if( is_array($theme_slider) && in_array($theid, $theme_slider) ){
                 print ' selected="selected" ';
             }
             print'>'.get_the_title().'</option>';
        endwhile;
        print '</select>';
        
    print '</div>';    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Number of milisecons before auto cycling an item','wpestate').'</div>
        <div class="option_row_explain">'.__('Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide. ','wpestate').'</div>    
            <input  type="text" id="slider_cycle" name="slider_cycle"  value="'.$slider_cycle.'"/> 
        </div>';
        
    print ' <div class="estate_option_row_submit">
        <input type="submit" name="submit"  class="new_admin_submit " value="'.__('Save Changes','wpestate').'" />
        </div>';
     
}

endif; // end wpestate_theme_slider




if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
        $attr=array(
            'class' =>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_label_main', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $site_url = site_url();
        $counter    =   0;

        

        $slides        =   '';
        $indicators    =   '';
        $defaulturl    =  get_stylesheet_directory_uri();
        $defaultslider =  '<img width="1920" height="790" src="'.$defaulturl ."/img/image_default_slider.png" .'" class="img-responsive wp-post-image" alt="">';
        $args = array(  
                    'post_type'        => 'home_slider',
                    'post_status'      => 'publish',
                    // 'post__in'         => $theme_slider,
                    'posts_per_page' => -1,
                    'orderby'=>'menu_order',
                    'order'=>'ASC'
                  );


        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }

        $search_type        =   get_option('wp_estate_adv_search_type','');
        $theme_slider_class =   '';
        if($search_type != 'oldtype'){ 
            $theme_slider_class = 'theme_slider_wrapper_type2';
        }
        
        print '<div class="theme_slider_wrapper '.$theme_slider_class.' '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
            $theid=get_the_ID();
            $slide= get_the_post_thumbnail( $theid, 'wpestate_property_full_map',$attr );

            if($slide){

            }else{
              
              $slide = $defaultslider ;
            }

            $slide_link = get_post_meta($theid, 'slide_link', true);
            $link_text = get_post_meta($theid, 'link_text', true);

            $listingTitle    =   get_the_title(); 
            $listingText    =   get_the_content(); 
            $sliderLink    =   "<a class='theme-slider-view' style='width:100%'' href='".$slide_link."'>".$link_text."</a>"; 

            /*if ( $counter == 2 ) {
              $listingTitle    =   "Let your Equipment Work for You"; 
              $listingText    =   "Why have your equipment collecting dust when it can generate revenue 24/7"; 
              $sliderLink    =   "<a class='theme-slider-view' style='width:100%'' href='".$site_url."/add-new-equipment/'>Place a Listing </a>"; 
            }
            else if ( $counter  == 1 ){ 

              $listingTitle    =   "Good, Honest, Hardworking People";
              $listingText    =   "Building relationships and growing your business with people you trust";
              $sliderLink    =   "<a class='theme-slider-view' style='width:100%'' href='".$site_url."/advanced-search/'>View available equipment</a>";
            }
            else{ 
              $listingTitle    =   "Access equipment at a fraction of rental company rates";
              $listingText    =   "Your neighbor might have what you're looking for";
              $sliderLink    =   "<a class='theme-slider-view' style='width:100%'' href='".$site_url."/about-us/'>Find out more</a>";
            }*/

            if($counter==0){
                $active=" active ";
            }else{
                $active=" ";
            }
            
            $measure_sys    =   get_option('wp_estate_measure_sys','');
            $beds           =   intval( get_post_meta($theid, 'property_bedrooms', true) );
            $baths          =   intval( get_post_meta($theid, 'property_bathrooms', true) );
            $size           =   number_format ( intval( get_post_meta($theid, 'property_size', true) ) );

            if($measure_sys=='ft'){
                $size.=' '.esc_html__( 'ft','wpestate').'<sup>2</sup>';
            }else{
                $size.=' '.esc_html__( 'm','wpestate').'<sup>2</sup>';
            }

            $slides.= '
            <div class="item '.$active.'">
                <div class="slider-content-wrapper">  
                    <div class="slider-content">
                        <div class="slider-title">
                            <h2><a href="javascript:void(0);">'.$listingTitle.'</a> </h2>
                        </div>
                        <div class="listing-desc-slider"> 
                            <span>'. $listingText.'</span>
                        </div>
                        '.$sliderLink.'
                    </div> 
                </div>  
                <div class="slider-content-cover"></div>  
                <a href="'.esc_url ( get_permalink() ).'"> '.$slide.'</a>
            </div>';

            /*
            <a class="theme-slider-view" href="'.esc_url ( get_permalink() ).'">'.esc_html__( 'View more','wpestate').'</a>
            <div class="theme-slider-price">
              <div class="price-slider-wrapper">
                <span class="price-slider">';
                  $price_per_guest_from_one       =   floatval( get_post_meta($theid, 'price_per_guest_from_one', true) ); 
                  if($price_per_guest_from_one==1){
                    $slides.=  wpestate_show_price($theid,$currency,$where_currency,1).'</span>/'.esc_html__( 'guest','wpestate');
                  }else{
                    $slides.=  wpestate_show_price($theid,$currency,$where_currency,1).'</span>/'.esc_html__( 'night','wpestate');
                  }
                $slides.='
              </div>        
            </div>*/

            $indicators.= '
            <li data-target="#estate-carousel" data-slide-to="'.($counter).'" class="'. $active.'">
            </li>';
            $counter++;
        endwhile;
        wp_reset_query();
        print ' 
            <div class="carousel-inner">
              '.$slides.'
            </div>

            <ol class="carousel-indicators">
                '.$indicators.'
            </ol>
                <a id="carousel-control-theme-next"  class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev"  class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
            </div>';
            ///////////////////////////////////////////////////////////////////////////////////////////////////
    } 
endif;