<?php 
global $WCMp;
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  
$add_link               =   wpestate_get_dasboard_add_listing();
$dash_profile           =   wpestate_get_dashboard_profile_link();
$dash_pack              =   get_wpestate_packages_link();
$dash_favorite          =   wpestate_get_dashboard_favorites();
$dash_link              =   wpestate_get_dashboard_link();
$dash_searches          =   wpestate_get_searches_link();
$dash_inbox             =   get_inbox_wpestate_booking();
$dash_invoice           =   get_invoices_wpestate();
$dash_my_bookings       =   wpestate_my_booking_link();
$dash_my_reservations   =   wpestate_my_reservations_link();
$dash_allinone          =   wpestate_get_dashboard_allinone();
$activeprofile          =   '';
$activeedit             =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$activesearch           =   '';
$activemypack           =   '';
$activeallinone         =   '';
$activeedit             =   '';
$activeprice            =   '';
$activedetails          =   '';
$activeimages           =   '';
$activeamm              =   '';
$activecalendar         =   '';
$activemybookins        =   '';
$activemyreservations   =   '';
$activeinbox            =   '';
$activelocation         =   '';
$activeinvoice          =   '';

$user_pack              =   get_the_author_meta( 'package_id' , $userID );    
$clientId               =   esc_html( get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
$home_url               =   esc_html( home_url() );

$allowed_html           =   array();

if ( basename( get_page_template() ) == 'user_dashboard.php' || is_page('my-equipment')){
    $activedash  =   'user_tab_active';    
}else if ( basename( get_page_template() ) == 'user_dashboard_add_step1.php' ){
    $activeadd   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_edit_listing.php' ){

    $action = sanitize_text_field ( wp_kses ( $_GET['action'],$allowed_html) );
    if ($action == 'description'){
        $activeedit   =   'user_tab_active';
    }else if ($action =='location'){
        $activelocation   =   'user_tab_active';
        $activeedit       =   '';
    }else if ($action =='price'){
        $activeprice   =   'user_tab_active';
        $activeedit    =   '';
    }else if ($action =='details'){
        $activedetails   =   'user_tab_active';
        $activeedit      =   '';
    }else if ($action =='images'){
        $activeimages   =   'user_tab_active';
        $activeedit     =   '';
    }else if ($action =='amenities'){
        $activeamm   =   'user_tab_active';
        $activeedit  =   '';
    }else if ($action =='calendar'){
        $activecalendar   =   'user_tab_active';
        $activeedit       =   '';
    }
                
                
}else if ( basename( get_page_template() ) == 'user_dashboard_profile.php' ){
    $activeprofile   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_favorite.php' ){
    $activefav   =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_searches.php' ){
    $activesearch  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_inbox.php' ){
    $activeinbox  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_invoices.php' ){
    $activeinvoice  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_my_bookings.php' ){
    $activemybookins  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_my_reservations.php' ){
    $activemyreservations  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_edit_listing.php' ){
    $activemyreservations  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_packs.php' ){
    $activemypack  =   'user_tab_active';
}else if( basename( get_page_template() )=='user_dashboard_allinone.php' ){
    $activeallinone =   'user_tab_active';
}

$user_title             =   get_the_author_meta( 'title' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );

$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$user_small_picture     =   wp_get_attachment_image_src( $image_id, 'thumbnail');
$user_small_picture_img =   $user_small_picture[0];
if($user_small_picture_img==''){
    $user_small_picture_img=get_template_directory_uri().'/img/default_user.png';
}


$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/img/default_user.png';
}

$vendor = get_wcmp_vendor(get_current_user_id());

if( in_array( 'dc_vendor', (array) $current_user->roles ) || in_array( 'administrator', (array) $current_user->roles) ) {
    $allow = 'allow';
}
else{ $allow = ''; }
?>

<!-- <div id="user_tab_menu_trigger"><i class="fa fa-user"></i> <?php esc_html_e('User Menu','wpestate'); ?></div> -->

<div class="user_tab_menu col-md-3" id="user_tab_menu_container">
    <div class="wcmp_top_logo_div"> 
        <div class="profile-image-wrapper">
            <div id="profile-image-menu"  
                data-profileurl="<?php echo $user_custom_picture;?>" 
                data-smallprofileurl="<?php echo $image_id;?>" 
                style="background-image: url('<?php echo $user_small_picture_img; ?>');"></div>

            <div class="profile_wellcome"><?php echo $user_login;?></div>    
        </div>
        
        <?php if( $allow == 'allow' ) { ?>
            <h3 class="profile_wellcome">
                <?php echo get_user_meta(get_current_user_id(), '_vendor_page_title', true) ? get_user_meta(get_current_user_id(), '_vendor_page_title', true) : __('Shop Name', $WCMp->text_domain); ?>
            </h3>
            <ul class="shop_url">
                <li class="shop"><a target="_blank" href="<?php echo apply_filters('wcmp_vendor_shop_permalink', $vendor->permalink); ?>"><?php _e('Shop', $WCMp->text_domain); ?></a> </li>
                <?php if (apply_filters('wcmp_show_vendor_announcements', true)) : ?>
                    <li class="announcements"><a target="_self" href="<?php echo wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_announcements_endpoint', 'vendor', 'general', 'vendor-announcements')); ?>"><?php _e('Announcements', $WCMp->text_domain); ?></a></li>
                <?php endif; ?>
            </ul>
        <?php } ?>
    </div>
    
    <?php
    $paid_submission_status = esc_html ( get_option('wp_estate_paid_submission','') );  
    $user_pack              =   get_the_author_meta( 'package_id' , $userID );
    $user_registered        =   get_the_author_meta( 'user_registered' , $userID );
    $user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
    $is_membership          =   0;
    if ($paid_submission_status == 'membership'  && wpestate_check_user_level()){
        wpestate_get_pack_data_for_user_top($userID,$user_pack,$user_registered,$user_package_activation); 
        $is_membership=1;             
    }
    
    
    if ( $is_membership==1){
        $stripe_profile_user    =   get_user_meta($userID,'stripe',true);
        $subscription_id        =   get_user_meta( $userID, 'stripe_subscription_id', true );
        $enable_stripe_status   =   esc_html ( get_option('wp_estate_enable_stripe','') );
        if( $stripe_profile_user!='' && $subscription_id!='' && $enable_stripe_status==='yes'){
            echo '<span id="stripe_cancel" data-original-title="'.esc_html__( 'subscription will be cancel at the end of current period','wpestate').'" data-stripeid="'.$userID.'">'.esc_html__( 'cancel stripe subscription','wpestate').'</span>';
        }
    }
        
    ?>
    
    
    <div class="custom_user_dashboard user_dashboard_links user_dashboard_links_menu">

        <a href="<?php echo $home_url; ?>/wcmp/" target="_self" data-menu_item="dashboard" class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--dashboard  ">
            <i class=" fa fa-tachometer"></i>
            <span class="writtings">Dashboard</span>
        </a>

        <?php if( $dash_profile!=$home_url ){ ?>
            <a href="<?php print $dash_profile;?>"  class="<?php print $activeprofile; ?>"><i class="fa fa-user"></i> <?php esc_html_e('My Profile','wpestate');?></a>
        <?php } ?>

        <?php if( $dash_pack!=$home_url && $paid_submission_status=='membership' && wpestate_check_user_level() && $allow == 'allow'){ ?>
            <a href="<?php print $dash_pack;?>" class="<?php print $activemypack; ?>"><i class="fa fa-tasks"></i> <?php esc_html_e('My Subscription','wpestate');?></a>
        <?php } ?>

        <?php if( $dash_link!=$home_url  && wpestate_check_user_level()  && $allow == 'allow'){ ?>
            <a href="<?php print $dash_link;?>"     class="<?php print $activedash; ?>"> <i class="fa fa-map-marker"></i> <?php esc_html_e('My Equipment','wpestate');?></a>
        <?php } ?>

        <?php if( $add_link!=$home_url  && wpestate_check_user_level()  && $allow == 'allow'){ 
              $edit_class="";?>
            
            <a href="<?php print $add_link;?>"      class="<?php print $activeadd; print $edit_class; ?>"> <i class="fa fa-plus-circle"></i><?php esc_html_e('Add New Equipment','wpestate');?></a>  
           
           
            <?php
          
            /*if ( isset($_GET['listing_edit'] ) && is_numeric($_GET['listing_edit'])) {
                $edit_class         =   " edit_class ";
                $post_id            =   intval($_GET['listing_edit']);
                $edit_link          =   wpestate_get_dasboard_edit_listing();
                $edit_link          =   esc_url_raw ( add_query_arg( 'listing_edit', $post_id, $edit_link) ) ;
                $edit_link_desc     =   esc_url_raw ( add_query_arg( 'action', 'General', $edit_link) ) ;
                $edit_link_location =   esc_url_raw ( add_query_arg( 'action', 'Featured image', $edit_link) ) ;
                $edit_link_price    =   esc_url_raw ( add_query_arg( 'action', 'Categories', $edit_link) ) ;
                $edit_link_details  =   esc_url_raw ( add_query_arg( 'action', 'Inventory', $edit_link) ) ;
                $edit_link_images   =   esc_url_raw ( add_query_arg( 'action', 'Shipping', $edit_link) ) ;
                $edit_link_amenities =  esc_url_raw ( add_query_arg( 'action', 'Attributes', $edit_link) ); 
                $edit_link_calendar =   esc_url_raw ( add_query_arg( 'action', 'Linkedpro', $edit_link) ); 
            ?>
            

            <div class=" property_edit_menu">     
                <a href="<?php print $edit_link_desc;?>"        class="<?php print $activeedit;?>">        <?php esc_html_e('General','wpestate');?></a>
                <a href="<?php print $edit_link_price;?>"       class="<?php print $activeprice;?>">       <?php esc_html_e('Featured image','wpestate');?></a>  
                <a href="<?php print $edit_link_images;?>"      class="<?php print $activeimages;?>">      <?php esc_html_e('Categories','wpestate');?></a>
                <a href="<?php print $edit_link_details;?>"     class="<?php print $activedetails;?>">     <?php esc_html_e('Inventory','wpestate');?></a>
                <a href="<?php print $edit_link_location;?>"    class="<?php print $activelocation;?>">    <?php esc_html_e('Shipping','wpestate');?></a>  
                <a href="<?php print $edit_link_amenities;?>"   class="<?php print $activeamm;?>">         <?php esc_html_e('Attributes','wpestate');?></a>  
                <a href="<?php print $edit_link_calendar;?>"    class="<?php print $activecalendar;?>">    <?php esc_html_e('Linkedpro','wpestate');?></a>     
            </div>

            <?php    
            } // secondary level*/
        ?>
        <?php } ?>

        <?php if( $dash_allinone!=$home_url  && wpestate_check_user_level()  && $allow == 'allow'){ ?>
            <a href="<?php print $dash_allinone;?>" class="<?php print $activeallinone; ?>"><i class="fa fa-calendar"></i> <?php esc_html_e('Calendar','wpestate');?></a>
        <?php } ?>  

        <?php if( $allow == 'allow'){ ?>
            <a href="<?php echo $home_url; ?>/dashboard/shop-front/" target="_self" data-menu_item="store-settings" class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--store-settings hasmenu">
                <i class=" fa fa-gear"></i>
                <span class="writtings">Store Settings</span>
            </a> 

            <?php /* ?>
            <ul class="submenu" data-parent="store-settings" style="display:none; list-style-type: none;">
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--shop-front">
                    <a href="<?php echo $home_url; ?>/wcmp/shop-front/" target="_self">- Shop Front</a>
                </li>
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-billing">
                    <a href="<?php echo $home_url; ?>/wcmp/vendor-billing/" target="_self">- Billing</a>
                </li>
                <!-- <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-shipping">
                    <a href="<?php //echo $home_url; ?>/wcmp/vendor-shipping/" target="_self">- Shipping</a>
                </li> -->
            </ul>
            <?php */ ?>

<?php /*  ?>            <a href="javascript:void(0);" target="_self" data-menu_item="vendor-report" class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-report hasmenu">
                <i class=" fa fa-pie-chart"></i>
                <span class="writtings">Stats / Reports</span>
            </a>
            <ul class="submenu" data-parent="vendor-report" style="display:none; list-style-type: none;">
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-report">
                    <a href="<?php echo $home_url; ?>/wcmp/vendor-report/" target="_self">- Overview</a>
                </li>
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--wcfm-reports-sales-by-date">
                    <a href="<?php echo $home_url; ?>/reports" target="_self">- by Date</a>
                </li>
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--wcfm-reports-out-of-stock">
                    <a href="<?php echo $home_url; ?>/reports/?status=stock-report" target="_self">- Out of stock</a>
                </li>
            </ul>
<?php */  ?>         
            
     
            <?php /*if( $dash_favorite!=$home_url ){ ?>
                <a href="<?php print $dash_favorite;?>" class="<?php print $activefav; ?>"><i class="fa fa-heart"></i> <?php esc_html_e('Favorites','wpestate');?></a>
            <?php }*/ ?>

            <?php if( $dash_searches!=$home_url ){ ?>
                <a href="<?php print $dash_searches;?>" class="<?php print $activesearch; ?>"><i class="fa fa-search"></i> <?php esc_html_e('Saved Searches','wpestate');?></a>
            <?php } ?>
        <?php } ?>  

        <?php if( $dash_my_bookings!=$home_url  && wpestate_check_user_level()){ ?>
            <a href="<?php print $dash_my_bookings;?>" class="<?php print $activemybookins; ?>"><i class="fa fa-folder-open-o"></i> <?php esc_html_e('My Bookings','wpestate');?></a>
        <?php } ?>


        <?php if( $dash_my_reservations!=$home_url && $allow == 'allow'){ ?>
            <a href="<?php print $dash_my_reservations;?>" class="<?php print $activemyreservations; ?>"><i class="fa fa-folder-open"></i> <?php esc_html_e('Discounts','wpestate');?></a>
        <?php } ?>   
            
        <?php if( $dash_inbox!=$home_url ){ ?>
                <a href="javascript:void(0);" target="_self" data-menu_item="vendor-payments" class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-payments  hasmenu <?php print $activeinbox; ?>">
                <i class="fa fa-folder-open"></i>
                <span class="writtings">Orders</span>
            </a>
            <ul class="submenu" data-parent="vendor-payments" style="display:none; list-style-type: none;">
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--transaction-details">
                    <a href="<?php echo $home_url.'/wcmp/vendor-orders/';?>">- Orders List</a>
                </li>
                <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--transaction-details">
                    <a href="<?php echo $home_url; ?>/wcmp/transaction-details/" target="_self">- History</a>
                </li>
            </ul>
        <?php } ?>
            
        <?php if( $dash_invoice!=$home_url && wpestate_check_user_level()  && $allow == 'allow'){ ?>
            <a href="<?php print $dash_invoice;?>" class="<?php print $activeinvoice; ?>"><i class="fa fa-file-o"></i> <?php esc_html_e('Invoices','wpestate');?></a>
        <?php } ?>

        <!-- <a href="javascript:void(0);" target="_self" data-menu_item="vendor-payments" class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--vendor-payments  hasmenu">
            <i class=" fa fa-google-wallet"></i>
            <span class="writtings">Payments</span>
        </a>
        <ul class="submenu" data-parent="vendor-payments" style="display:none; list-style-type: none;">
            <li class="wcmp-venrod-dashboard-nav-link wcmp-venrod-dashboard-nav-link--transaction-details">
                <a href="<?php echo $home_url; ?>/wcmp/transaction-details/" target="_self">- History</a>
            </li>
        </ul> -->
            
     
            
        <a href="<?php echo wp_logout_url();?>" title="Logout"><i class="fa fa-power-off"></i> <?php esc_html_e('Log Out','wpestate');?></a>
    </div>
      <?php // get_template_part('templates/user_memebership_profile');  ?>




</div>

<script type="text/javascript">
    jQuery(document).ready( function(){
        console.log(123);
        jQuery('.user_dashboard_links_menu').on('click', '.hasmenu', function(){
            var _this = jQuery(this).data('menu_item');
            jQuery('.submenu').hide();
            jQuery('.submenu[data-parent="'+_this+'"]').toggle();
        });
    });
</script>
