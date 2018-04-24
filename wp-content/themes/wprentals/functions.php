<?php
require_once get_template_directory().'/libs/css_js_include.php';
require_once get_template_directory().'/libs/metaboxes.php';
require_once get_template_directory().'/libs/plugins.php';
require_once get_template_directory().'/libs/help_functions.php';
require_once get_template_directory().'/libs/pin_management.php';
require_once get_template_directory().'/libs/ajax_functions.php';
require_once get_template_directory().'/libs/ajax_functions_edit.php';
require_once get_template_directory().'/libs/ajax_functions_booking.php';
require_once get_template_directory().'/libs/ajax_upload.php';
require_once get_template_directory().'/libs/3rdparty.php';
require_once get_template_directory().'/libs/theme-setup.php';
require_once get_template_directory().'/libs/general-settings.php';
require_once get_template_directory().'/libs/listing_functions.php';
require_once get_template_directory().'/libs/theme-slider.php';
require_once get_template_directory().'/libs/agents.php';
require_once get_template_directory().'/libs/invoices.php';
require_once get_template_directory().'/libs/searches.php';
require_once get_template_directory().'/libs/membership.php';
require_once get_template_directory().'/libs/property.php';
require_once get_template_directory().'/libs/booking.php';
require_once get_template_directory().'/libs/messages.php';
require_once get_template_directory().'/libs/shortcodes_install.php';
require_once get_template_directory().'/libs/shortcodes.php';
require_once get_template_directory().'/libs/widgets.php';
require_once get_template_directory().'/libs/events.php';
require_once get_template_directory().'/libs/icalendar.php';
require_once get_template_directory().'/libs/reviews.php';
require_once get_template_directory().'/libs/emailfunctions.php';
require_once get_template_directory().'/libs/sms_functions.php';
require_once get_template_directory().'/libs/rcapi_functions.php';

//require_once get_template_directory().'/libs/plugins/wordpress-importer.php';


$facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
if($facebook_status=='yes'){
    require_once get_template_directory().'/libs/resources/facebook_sdk5/Facebook/autoload.php';
}


load_theme_textdomain('wpestate', get_template_directory() . '/languages');

define('ULTIMATE_NO_EDIT_PAGE_NOTICE', true);
define('ULTIMATE_NO_PLUGIN_PAGE_NOTICE', true);
define('CLUBLINK', 'rentalsclub.org');
define('CLUBLINKSSL', 'https');
# Disable check updates - 
define('BSF_6892199_CHECK_UPDATES',false);

# Disable license registration nag -
define('BSF_6892199_NAG', false);


function wpestate_admin_notice() {
    global $pagenow;
    global $typenow;
    
    if (!empty($_GET['post'])) {
        $allowed_html   =   array();
        $post = get_post(wp_kses($_GET['post'],$allowed_html));
        $typenow = $post->post_type;
    }

    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    if($api_key===''){
        print '<div class="error">
            <p>'.esc_html__( 'Google Maps will NOT WORK without a correct Api Key. Get one from ','wpestate').'<a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">'.esc_html__('here','wpestate').'</a></p>
        </div>';
    }
    
    if ( WP_MEMORY_LIMIT < 96 ) { 
        print '<div class="error">
            <p>'.esc_html__( 'Wordpress Memory Limit is set to ', 'wpestate' ).' '.WP_MEMORY_LIMIT.' '.esc_html__( 'Recommended memory limit should be at least 96MB. Please refer to : ','wpestate').'<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">'.esc_html__('Increasing memory allocated to PHP','wpestate').'</a></p>
        </div>';
    }
    
    if (!defined('PHP_VERSION_ID')) {
        $version = explode('.', PHP_VERSION);
        define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }

    if(PHP_VERSION_ID<50600){
        $version = explode('.', PHP_VERSION);
        print '<div class="error">
            <p>'.__( 'Your PHP version is ', 'wpestate' ).' '.$version[0].'.'.$version[1].'.'.$version[2].'. We recommend upgrading the PHP version to at least 5.6.1. The upgrade should be done on your server by your hosting company. </p>
        </div>';
    }
    
    if ( !extension_loaded('mbstring')) { 
        print '<div class="error">
            <p>'.__( 'MbString extension not detected. Please contact your hosting provider in order to enable it.', 'wpestate' ).'</p>
        </div>';
    }
    
    //print  $pagenow.' / '.$typenow .' / '.basename( get_page_template($post) );
    
    if (is_admin() &&   $pagenow=='post.php' && $typenow=='page' && basename( get_page_template($post))=='property_list_half.php' ){
        $header_type    =   get_post_meta ( $post->ID, 'header_type', true);
      
        if ( $header_type != 5){
            print '<div class="error">
            <p>'.esc_html__( 'Half Map Template - make sure your page has the "media header type" set as google map ', 'wpestate' ).'</p>
            </div>';
        }
       
    }
    
    if (is_admin() &&   $pagenow=='edit-tags.php'  && $typenow=='estate_property') {
    
        print '<div class="error">
            <p>'.esc_html__( 'Please do not manually change the slugs when adding new terms. If you need to edit a term name copy the new name in the slug field also.', 'wpestate' ).'</p>
        </div>';
    }
    
    
    if (is_admin() &&  ( $pagenow=='post-new.php' || $pagenow=='post.php') && $typenow=='estate_property') {
    
        print '<div class="error">
            <p>'.esc_html__( 'Please add properties from front end interface using an user with subscriber level registered in front end', 'wpestate' ).'</p>
        </div>';
    }
  
    if(wpestate_get_ical_link()==home_url()){
        print '<div class="update-nag">
            <p>'.esc_html__( 'You need to create a page with the template ICAL FEED (if you want to use icalendar export/import feature)', 'wpestate' ).'</p>
        </div>';
    }

     if(wpestate_get_dashboard_allinone()==home_url()){
        print '<div class="update-nag">
            <p>'.esc_html__( 'You need to create a page with the template All in one calendar (if you want to use all in one calendar feature)', 'wpestate' ).'</p>
        </div>';
    }
    
    $current_tz= date_default_timezone_get();
    if( wpestate_isValidTimezoneId2($current_tz)!= 1 ){
         print '<div class="update-nag">
            <p>'.esc_html__( 'It looks like you may have a problem with the server date.timezone settings and may encounter errors like the one described here:', 'wpestate' ).'<a href="http://help.wprentals.org/2015/12/21/calendar-doesnt-work-calendar-issues/">http://help.wprentals.org/2015/12/21/calendar-doesnt-work-calendar-issues/</a> '.esc_html__('Please resolve these issues with your hosting provider.','wpestate').' </p>
        </div>';
    }
}
 
function wpestate_isValidTimezoneId2($tzid){
    $valid = array();
    $tza = timezone_abbreviations_list();
   
    foreach ($tza as $zone)
        
      foreach ($zone as $item)
        $valid[$item['timezone_id']] = true;
    unset($valid['']);
    return !!$valid[$tzid];
}

add_action( 'admin_notices', 'wpestate_admin_notice' );

add_action('after_setup_theme', 'wp_estate_init');
if (!function_exists('wp_estate_init')):

    function wp_estate_init() {

        global $content_width;
        if (!isset($content_width)) {
            $content_width = 1800;
        }

        load_theme_textdomain('wpestate', get_template_directory() . '/languages');
        set_post_thumbnail_size(940, 198, true);
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support('custom-background');
        add_theme_support("title-tag");
        wp_estate_setup();
        add_action('widgets_init', 'register_wpestate_widgets');
        add_action('init', 'wpestate_shortcodes');
        wp_oembed_add_provider('#https?://twitter.com/\#!/[a-z0-9_]{1,20}/status/\d+#i', 'https://api.twitter.com/1/statuses/oembed.json', true);
        wpestate_image_size();
        add_filter('excerpt_length', 'wp_estate_excerpt_length');
        add_filter('excerpt_more', 'wpestate_new_excerpt_more');
        add_action('tgmpa_register', 'wpestate_required_plugins');
        add_action('wp_enqueue_scripts', 'wpestate_scripts'); // function in css_js_include.php
        add_action('admin_enqueue_scripts', 'wpestate_admin'); // function in css_js_include.php
        update_option( 'image_default_link_type', 'file' );
    }

endif; // end   wp_estate_init  



///////////////////////////////////////////////////////////////////////////////////////////
/////// If admin create the menu
///////////////////////////////////////////////////////////////////////////////////////////
if (is_admin()) {
    add_action('admin_menu', 'wpestate_manage_admin_menu');
}

if (!function_exists('wpestate_manage_admin_menu')):
    function wpestate_manage_admin_menu() {
        global $theme_name;
        add_theme_page(esc_html__('WpRentals Options','wpestate'),esc_html__('WpRentals Options','wpestate'), 'administrator', 'libs/theme-admin.php', 'wpestate_new_general_set');
        add_theme_page('Import WpRentals Themes', 'WpRentals Import', 'administrator', 'libs/theme-import.php', 'wpestate_new_import' );
        require_once get_template_directory().'/libs/property-admin.php';
        require_once get_template_directory().'/libs/pin-admin.php';
        require_once get_template_directory().'/libs/theme-admin.php';
        require_once get_template_directory().'/libs/theme-import.php'; 
    }
endif; // end   wpestate_manage_admin_menu 

//////////////////////////////////////////////////////////////////////////////////////////////
// page details : setting sidebar position etc...
//////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_page_details')):

    function wpestate_page_details($post_id) {
        $return_array = array();

        
        if ($post_id != '' && !is_home() && !is_tax() && !is_search()) {
            $sidebar_name   = esc_html(get_post_meta($post_id, 'sidebar_select', true));
            $sidebar_status = esc_html(get_post_meta($post_id, 'sidebar_option', true));
        } else {
            $sidebar_name   = esc_html(get_option('wp_estate_blog_sidebar_name', ''));
            $sidebar_status = esc_html(get_option('wp_estate_blog_sidebar', ''));
        }

        if ('' == $sidebar_name) {
            $sidebar_name = 'primary-widget-area';
        }
        if ('' == $sidebar_status) {
            $sidebar_status = 'right';
        }


        if ('left' == $sidebar_status) {
            $return_array['content_class'] = 'col-md-8 col-md-push-4 ';
            $return_array['sidebar_class'] = 'col-md-4 col-md-pull-8 ';
        } else if ($sidebar_status == 'right') {
            $return_array['content_class'] = 'col-md-8 ';
            $return_array['sidebar_class'] = 'col-md-4 ';
        } else {
            $return_array['content_class'] = 'col-md-12';
            $return_array['sidebar_class'] = 'none';
        }

        $return_array['sidebar_name'] = $sidebar_name;

        return $return_array;
    }

endif; // end   wpestate_page_details 



///////////////////////////////////////////////////////////////////////////////////////////
/////// generate custom css
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head', 'wpestate_generate_options_css');
if (!function_exists('wpestate_generate_options_css')):

    function wpestate_generate_options_css() {
        $general_font   = esc_html(get_option('wp_estate_general_font', ''));
        $custom_css     = stripslashes(get_option('wp_estate_custom_css'));
        $color_scheme   = esc_html(get_option('wp_estate_color_scheme', ''));
        $on_child_theme= esc_html ( get_option('wp_estate_on_child_theme','') );
        if ($general_font != '' || $color_scheme == 'yes' || $custom_css != '') {
            echo "<style type='text/css'>";
            if ($general_font != '' && $on_child_theme!=1) {
                require_once get_template_directory().'/libs/custom_general_font.php';
            }


            if ($color_scheme == 'yes' && $on_child_theme!=1) {
                require_once get_template_directory().'/libs/customcss.php';
            }
            print $custom_css;
            echo "</style>";
        }
    }

endif; // end   generate_options_css 
///////////////////////////////////////////////////////////////////////////////////////////
///////  Display navigation to next/previous pages when applicable
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wp_estate_content_nav')) :
    function wp_estate_content_nav($html_id) {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) :
            ?>
            <nav id="<?php echo esc_attr($html_id); ?>">
                <h3 class="assistive-text"><?php esc_html_e('Post navigation', 'wpestate'); ?></h3>
                <div class="nav-previous"><?php next_posts_link(esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'wpestate')); ?></div>
                <div class="nav-next"><?php previous_posts_link(esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wpestate')); ?></div>
            </nav><!-- #nav-above -->
            <?php
        endif;
    }

endif; // wpestate_content_nav

///////////////////////////////////////////////////////////////////////////////////////////
///////  Comments
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_comment')) :

    function wpestate_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php esc_html_e('Pingback:', 'wpestate'); ?> <?php comment_author_link(); ?><?php edit_comment_link(esc_html__( 'Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
            default :
                ?>




        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

            <?php
                $avatar =esc_url( wpestate_get_avatar_url(get_avatar($comment, 55)));
                print '<div class="blog_author_image singlepage" style="background-image: url(' . esc_url($avatar) . ');">';
                print '</div>';
                ?>

                <div id="comment-<?php comment_ID(); ?>" class="comment">     
                <?php edit_comment_link(esc_html__( 'Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?>
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                        <?php
                        print '<div class="comment_name">' . get_comment_author_link() . '</div>';
                        print '<span class="comment_date">' . esc_html__( ' on ', 'wpestate') . ' ' . get_comment_date() . '</span>';
                        ?>
                        </div><!-- .comment-author .vcard -->

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'wpestate'); ?></em>
                    <br />
                <?php endif; ?>

                </div>

                <div class="comment-content">
                <?php comment_text(); ?>

                <?php comment_reply_link(array_merge($args, array('reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__( 'Reply', 'wpestate'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                </div>

            </div><!-- #comment-## -->
            <?php
            break;
        endswitch;
    }

endif; // ends check for  wpestate_comment 
////////////////////////////////////////////////////////////////////////////////
/// Add new profile fields
////////////////////////////////////////////////////////////////////////////////

add_filter('user_contactmethods', 'wpestate_modify_contact_methods');
if (!function_exists('wpestate_modify_contact_methods')):

    function wpestate_modify_contact_methods($profile_fields) {

        // Add new fields
        $profile_fields['facebook']     = esc_html__('Facebook','wpestate');
        $profile_fields['twitter']      = esc_html__('Twitter','wpestate');
        $profile_fields['linkedin']     = esc_html__('Linkedin','wpestate');
        $profile_fields['pinterest']    = esc_html__('Pinterest','wpestate');
        $profile_fields['phone']        = esc_html__('Phone','wpestate');
        $profile_fields['mobile']       = esc_html__('Mobile','wpestate');
        $profile_fields['skype']        = esc_html__('Skype','wpestate');
        $profile_fields['title']        = esc_html__('Title/Position','wpestate');
        $profile_fields['custom_picture']       = esc_html__('Picture Url','wpestate');
        $profile_fields['small_custom_picture'] = esc_html__('Small Picture Url','wpestate');
        $profile_fields['package_id']           = esc_html__('Package Id','wpestate');
        $profile_fields['package_activation']   = esc_html__('Package Activation','wpestate');
        $profile_fields['package_listings']     = esc_html__('Listings available','wpestate');
        $profile_fields['package_featured_listings']    = esc_html__('Featured Listings available','wpestate');
        $profile_fields['profile_id']                   = esc_html__('Paypal Recuring Profile','wpestate');
        $profile_fields['user_agent_id']                = esc_html__('User Owner Id','wpestate');
        $profile_fields['stripe']       = esc_html__( 'Stripe Consumer Profile','wpestate');
        $profile_fields['stripe_subscription_id']       = esc_html__( 'Stripe Subscription Id','wpestate');
        $profile_fields['has_stripe_recurring']       = esc_html__( 'Has Recurring Stripe ','wpestate');
      
        $profile_fields['i_speak']      = esc_html__('I Speak','wpestate');
        $profile_fields['live_in']      = esc_html__('Live In','wpestate');
        $profile_fields['payment_info']      = esc_html__('Payment Info','wpestate');
        $profile_fields['user_type']    = esc_html__('User Type(0-can rent and book / 1 can only book)','wpestate');
        return $profile_fields;
    }

endif; // end   wpestate_modify_contact_methods 




if (!current_user_can('activate_plugins')) {
    
    if (!function_exists('wpestate_admin_bar_render')):
        function wpestate_admin_bar_render() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
        }
    endif;

    add_action('wp_before_admin_bar_render', 'wpestate_admin_bar_render');

    add_action('admin_init', 'wpestate_stop_access_profile');
    if (!function_exists('wpestate_stop_access_profile')):
        function wpestate_stop_access_profile() {
            global $pagenow;

            if (defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE === true) {
                wp_die(esc_html__( 'Please edit your profile page from site interface.', 'wpestate'));
            }

            if ($pagenow == 'user-edit.php') {
                wp_die(esc_html__( 'Please edit your profile page from site interface.', 'wpestate'));
            }
        }
    endif; // end   wpestate_stop_access_profile 
}// end user can activate_plugins


///////////////////////////////////////////////////////////////////////////////////////////
// get attachment info
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_get_attachment')):
    function wpestate_get_attachment($attachment_id) {

        $attachment = get_post($attachment_id);
        return array(
            'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => esc_url( get_permalink($attachment->ID) ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );
    }
endif;


add_action('get_header', 'wpestate_my_filter_head');
if (!function_exists('wpestate_my_filter_head')):
    function wpestate_my_filter_head() {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
endif;

///////////////////////////////////////////////////////////////////////////////////////////
// loosing session fix
///////////////////////////////////////////////////////////////////////////////////////////
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

///////////////////////////////////////////////////////////////////////////////////////////
// forgot pass action
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head', 'wpestate_hook_javascript');
if (!function_exists('wpestate_hook_javascript')):
    function wpestate_hook_javascript() {
        global $wpdb;
        $allowed_html = array();
        if (isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
            $reset_key  =   sanitize_text_field ( wp_kses($_GET['key'], $allowed_html) );
            $user_login =   sanitize_text_field( wp_kses($_GET['login'], $allowed_html) );
            $user_data  =   $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users 
    WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));


            if (!empty($user_data)) {
                $user_login = $user_data->user_login;
                $user_email = $user_data->user_email;

                if (!empty($reset_key) && !empty($user_data)) {
                    $new_password = wp_generate_password(7, false);
                    wp_set_password($new_password, $user_data->ID);
                    
                    $arguments=array(
                        'user_pass'        =>  $new_password,
                    );
                    wpestate_select_email_type($user_email,'password_reseted',$arguments);
                    $mess = '<div class="login-alert">' . esc_html__( 'A new password was sent via email!', 'wpestate') . '</div>';
                    
                } else {
                    exit('Not a Valid Key.');
                }
            }// end if empty
            print '<div class="login_alert_full" id="forgot_notice">' . esc_html__( 'We have just sent you a new password. Please check your email!', 'wpestate') . '</div>';
        }
    }
endif;

if ( !function_exists('wpestate_get_pin_file_path_read')):
    
    function wpestate_get_pin_file_path_read(){
        if (function_exists('icl_translate') ) {
            $path=trailingslashit( get_template_directory_uri() ).'/pins-'.apply_filters( 'wpml_current_language', 'en' ).'.txt';
        }else{
            $path=trailingslashit( get_template_directory_uri() ).'/pins.txt';
        }
   
        return $path;
    }

endif;

if ( !function_exists('wpestate_get_pin_file_path_write')):
    
    function wpestate_get_pin_file_path_write(){
        if (function_exists('icl_translate') ) {
            $path=get_template_directory().'/pins-'.apply_filters( 'wpml_current_language', 'en' ).'.txt';
        }else{
            $path=get_template_directory().'/pins.txt';
        }
 
        return $path;
    }

endif;


add_filter( 'redirect_canonical','wpestate_disable_redirect_canonical',10,2 ); 
function wpestate_disable_redirect_canonical( $redirect_url ,$requested_url){
    //print '$redirect_url'.$redirect_url;
    //print '$requested_url'.$requested_url;
    if ( is_page_template('property_list.php') || is_page_template('property_list_half.php') ){
      //  print 'bag false';
        $redirect_url = false;
    }
    
   
    return $redirect_url;
}



if ( !function_exists('wpestate_check_user_level')):
    function wpestate_check_user_level(){
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;
        $user_login                     =   $current_user->user_login;
        $separate_users_status          =   esc_html ( get_option('wp_estate_separate_users','') );   
        $publish_only                   =   esc_html ( get_option('wp_estate_publish_only','') );   
        
      
        if (trim($publish_only) != '' ){
            $user_array=explode(',',$publish_only);
          
            if ( in_array ($user_login,$user_array)){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        if($separate_users_status=='no'){
            return true;
        }else{
            $user_level = intval( get_user_meta($userID,'user_type',true));
        
            if($user_level==0){ // user can book and rent
                return true;
            }else{// user can only book
                if( basename(get_page_template()) == 'user_dashboard.php' || 
                basename(get_page_template()) == 'user_dashboard_add_step1.php' || 
                basename(get_page_template()) == 'user_dashboard_edit_listing.php' || 
                basename(get_page_template()) == 'user_dashboard_my_bookings.php'  || 
                basename(get_page_template()) == 'user_dashboard_packs.php'  || 
                basename(get_page_template()) == 'user_dashboard_searches.php' ||
                basename(get_page_template()) == 'user_dashboard_allinone.php'  )    {
                   
                    return false;
                }
                
            }
            
        }
        
    }
endif;


function estate_create_onetime_nonce($action = -1) {
    $time = time();
  // print $time.$action;
   $nonce = wp_create_nonce($time.$action);
    return $nonce . '-' . $time;
}
//1455041901register_ajax_nonce_topbar

function estate_verify_onetime_nonce( $_nonce, $action = -1) {
    $parts  =   explode( '-', $_nonce );
    $nonce  =   $toadd_nonce    = $parts[0]; 
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }
    
    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    $used_nonces[$toadd_nonce] = $expires;
    asort( $used_nonces );
    update_option( '_sh_used_nonces',$used_nonces );
    return true;
}




function estate_verify_onetime_nonce_login( $_nonce, $action = -1) {
    $parts = explode( '-', $_nonce );
    $nonce =$toadd_nonce= $parts[0];
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $expires2   = (int) $generated + 120;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }
    
    //Get used nonces
    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    //Add nonce in the stack after 2min
    if($time > $expires2){
        $used_nonces[$toadd_nonce] = $expires;
        asort( $used_nonces );
        update_option( '_sh_used_nonces',$used_nonces );
    }
    return true;
}




///////////////////////////////////////////////////////////////////////////////////////////
// prevent changing the author id when admin hit publish
///////////////////////////////////////////////////////////////////////////////////////////

add_action( 'transition_post_status', 'wpestate_correct_post_data',10,3 );

if( !function_exists('wpestate_correct_post_data') ):
    
function wpestate_correct_post_data( $strNewStatus,$strOldStatus,$post) {
    /* Only pay attention to posts (i.e. ignore links, attachments, etc. ) */
    if( $post->post_type !== 'estate_property' )
        return;

    if( $strOldStatus === 'new' ) {
        update_post_meta( $post->ID, 'original_author', $post->post_author );
    }

       
    
    /* If this post is being published, try to restore the original author */
    if( $strNewStatus === 'publish' ) {
    
         
            $originalAuthor_id =$post->post_author;
            $user = get_user_by('id',$originalAuthor_id); 
            if(!$user){
                return;
            }
            $user_email=$user->user_email;
            
      
            
            
            if( $user->roles[0]=='subscriber'){
                $arguments=array(
                    'post_id'           =>  $post->ID,
                    'property_url'      =>  get_permalink($post->ID),
                    'property_title'    =>  get_the_title($post->ID)
                );
                
                if($strOldStatus=='pending'){
                      
                    if( $user->roles[0]=='subscriber'){
                        $arguments=array(
                            'post_id'           =>  $post->ID,
                            'property_url'      =>  get_permalink($post->ID),
                            'property_title'    =>  get_the_title($post->ID)
                        );



                        wpestate_select_email_type($user_email,'approved_listing',$arguments);    

                    }
                   
                }
            }
    }
}
endif; // end   wpestate_correct_post_data 



function wpestate_double_tax_cover($property_area,$property_city,$post_id){
        $prop_city_selected                  =   get_term_by('name', $property_city, 'property_city');
        $prop_area_selected                  =   get_term_by('name', $property_area, 'property_area');
        if(isset($prop_area_selected->term_id)){ // we have this tax
            //print  $prop_area_selected->term_id.' / '.$prop_area_selected->name;
            //print  $prop_city_selected->term_id.' / '.$prop_city_selected->name;
            $term_meta = get_option( "taxonomy_$prop_area_selected->term_id");
            
            if( $term_meta['cityparent'] !=  $property_city){
                $new_property_area=$property_area.', '.$property_city;
            }else{
                  $new_property_area=$property_area;
            }
            wp_set_object_terms($post_id,$new_property_area,'property_area'); 
            return $new_property_area;
        }else{
            wp_set_object_terms($post_id,$property_area,'property_area'); 
            return $property_area;
        }
                   
}


function wpestate_ping_me(){
    if( get_option( 'wpestate_pingme','no')!='yes'){    
        $url=CLUBLINKSSL."://www.".CLUBLINK."/ping-me/";
        $my_theme = wp_get_theme();
        $args=array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => json_encode(array( 
                                'servername'    =>  $_SERVER['SERVER_NAME'], 
                                'http_host'     =>  $_SERVER['HTTP_HOST'],
                                'theme_version' =>  $my_theme->get( 'Version' )
                        )),
                'cookies' => array()
            );

        $response = wp_remote_post( $url, $args ); 
        update_option( 'wpestate_pingme','yes' );
    }
}

function wpestate_search_by_title_only( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}



function wpestate_file_upload_max_size() {
  static $max_size = -1;

  if ($max_size < 0) {
    // Start with post_max_size.
    $max_size = wpestate_parse_size(ini_get('post_max_size'));

    // If upload_max_size is less, then reduce. Except if upload_max_size is
    // zero, which indicates no limit.
    $upload_max = wpestate_parse_size(ini_get('upload_max_filesize'));
    if ($upload_max > 0 && $upload_max < $max_size) {
      $max_size = $upload_max;
    }
  }
  return $max_size;
}

function wpestate_parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}


if(!function_exists('convertAccentsAndSpecialToNormal')):
function convertAccentsAndSpecialToNormal($string) {
    $table = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Ă'=>'A', 'Ā'=>'A', 'Ą'=>'A', 'Æ'=>'A', 'Ǽ'=>'A',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ă'=>'a', 'ā'=>'a', 'ą'=>'a', 'æ'=>'a', 'ǽ'=>'a',

        'Þ'=>'B', 'þ'=>'b', 'ß'=>'Ss',

        'Ç'=>'C', 'Č'=>'C', 'Ć'=>'C', 'Ĉ'=>'C', 'Ċ'=>'C',
        'ç'=>'c', 'č'=>'c', 'ć'=>'c', 'ĉ'=>'c', 'ċ'=>'c',

        'Đ'=>'Dj', 'Ď'=>'D', 'Đ'=>'D',
        'đ'=>'dj', 'ď'=>'d',

        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ĕ'=>'E', 'Ē'=>'E', 'Ę'=>'E', 'Ė'=>'E',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'ę'=>'e', 'ė'=>'e',

        'Ĝ'=>'G', 'Ğ'=>'G', 'Ġ'=>'G', 'Ģ'=>'G',
        'ĝ'=>'g', 'ğ'=>'g', 'ġ'=>'g', 'ģ'=>'g',

        'Ĥ'=>'H', 'Ħ'=>'H',
        'ĥ'=>'h', 'ħ'=>'h',

        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'Ĭ'=>'I', 'Į'=>'I',
        'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'į'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'ı'=>'i',

        'Ĵ'=>'J',
        'ĵ'=>'j',

        'Ķ'=>'K',
        'ķ'=>'k', 'ĸ'=>'k',

        'Ĺ'=>'L', 'Ļ'=>'L', 'Ľ'=>'L', 'Ŀ'=>'L', 'Ł'=>'L',
        'ĺ'=>'l', 'ļ'=>'l', 'ľ'=>'l', 'ŀ'=>'l', 'ł'=>'l',

        'Ñ'=>'N', 'Ń'=>'N', 'Ň'=>'N', 'Ņ'=>'N', 'Ŋ'=>'N',
        'ñ'=>'n', 'ń'=>'n', 'ň'=>'n', 'ņ'=>'n', 'ŋ'=>'n', 'ŉ'=>'n',

        'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ō'=>'O', 'Ŏ'=>'O', 'Ő'=>'O', 'Œ'=>'O',
        'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'œ'=>'o', 'ð'=>'o',

        'Ŕ'=>'R', 'Ř'=>'R',
        'ŕ'=>'r', 'ř'=>'r', 'ŗ'=>'r',

        'Š'=>'S', 'Ŝ'=>'S', 'Ś'=>'S', 'Ş'=>'S',
        'š'=>'s', 'ŝ'=>'s', 'ś'=>'s', 'ş'=>'s',

        'Ŧ'=>'T', 'Ţ'=>'T', 'Ť'=>'T',
        'ŧ'=>'t', 'ţ'=>'t', 'ť'=>'t',

        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ŭ'=>'U', 'Ů'=>'U', 'Ű'=>'U', 'Ų'=>'U',
        'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'ű'=>'u', 'ų'=>'u',

        'Ŵ'=>'W', 'Ẁ'=>'W', 'Ẃ'=>'W', 'Ẅ'=>'W',
        'ŵ'=>'w', 'ẁ'=>'w', 'ẃ'=>'w', 'ẅ'=>'w',

        'Ý'=>'Y', 'Ÿ'=>'Y', 'Ŷ'=>'Y',
        'ý'=>'y', 'ÿ'=>'y', 'ŷ'=>'y',

        'Ž'=>'Z', 'Ź'=>'Z', 'Ż'=>'Z', 'Ž'=>'Z',
        'ž'=>'z', 'ź'=>'z', 'ż'=>'z', 'ž'=>'z',

        '“'=>'"', '”'=>'"', '‘'=>"'", '’'=>"'", '•'=>'-', '…'=>'...', '—'=>'-', '–'=>'-', '¿'=>'?', '¡'=>'!', '°'=>' degrees ',
        '¼'=>' 1/4 ', '½'=>' 1/2 ', '¾'=>' 3/4 ', '⅓'=>' 1/3 ', '⅔'=>' 2/3 ', '⅛'=>' 1/8 ', '⅜'=>' 3/8 ', '⅝'=>' 5/8 ', '⅞'=>' 7/8 ',
        '÷'=>' divided by ', '×'=>' times ', '±'=>' plus-minus ', '√'=>' square root ', '∞'=>' infinity ',
        '≈'=>' almost equal to ', '≠'=>' not equal to ', '≡'=>' identical to ', '≤'=>' less than or equal to ', '≥'=>' greater than or equal to ',
        '←'=>' left ', '→'=>' right ', '↑'=>' up ', '↓'=>' down ', '↔'=>' left and right ', '↕'=>' up and down ',
        '℅'=>' care of ', '℮' => ' estimated ',
        'Ω'=>' ohm ',
        '♀'=>' female ', '♂'=>' male ',
        '©'=>' Copyright ', '®'=>' Registered ', '™' =>' Trademark ',
    );

    $string = strtr($string, $table);
    // Currency symbols: £¤¥€  - we dont bother with them for now
    $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);

    return $string;
}
endif;


add_filter('show_admin_bar', '__return_false');



/*add_action( 'after_setup_theme', 'yourtheme_setup' );

function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
*/

/*........Address Meta box.............*/
add_action( 'add_meta_boxes', 'wpestate_add_product_metaboxes' );
function wpestate_add_product_metaboxes() {
    global $post;
    add_meta_box('product-address-sectionid', 'Address', 'product_address_box', 'product', 'normal', 'default');
    //add_meta_box('estate_property-googlemap',       esc_html__( 'Place It On The Map', 'wpestate'),    'map_estate_box', 'product', 'normal', 'default');
}


function product_address_box($post) {
    global $post;
    wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
    $mypost = $post->ID;
    
    print' 
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td width="33%" align="left" valign="top">
          <p class="meta-options">
          <label for="property_address">'.esc_html__( 'Address: ','wpestate').'</label><br />
          <textarea type="text" id="property_address"  size="40" name="property_address" rows="3" cols="42">' . esc_html(get_post_meta($mypost, 'property_address', true)) . '</textarea>
          </p>
      </td>

      <td width="33%" align="left" valign="top">
          <p class="meta-options">
          <label for="property_county">'.esc_html__( 'County: ','wpestate').'</label><br />
          <input type="text" id="property_county"  size="40" name="property_county" value="' . esc_html(get_post_meta($mypost, 'property_county', true)) . '">
          </p>
      </td>
      
      <td width="33%" align="left" valign="top">
           <p class="meta-options">
          <label for="property_state">'.esc_html__( 'State: ','wpestate').'</label><br />
          <input type="text" id="property_state" size="40" name="property_state" value="' . esc_html(get_post_meta($mypost, 'property_state', true)) . '">
          </p>
      </td>
    </tr>

    <tr>
      <td align="left" valign="top">   
          <p class="meta-options">
          <label for="property_zip">'.esc_html__( 'Zip: ','wpestate').'</label><br />
          <input type="text" id="property_zip" size="40" name="property_zip" value="' . esc_html(get_post_meta($mypost, 'property_zip', true)) . '">
          </p>
      </td>

      <td align="left" valign="top">
          <p class="meta-options">
          <label for="property_country">'.esc_html__( 'Country: ','wpestate').'</label><br />

          ';
      print wpestate_country_list(esc_html(get_post_meta($mypost, 'property_country', true)));
      print '     
          </p>
      </td>

    
    </tr>

    <tr>';
     
    $status_values          =   esc_html( get_option('wp_estate_status_list') );
    $status_values_array    =   explode(",",$status_values);
    $prop_stat              =   stripslashes( get_post_meta($mypost, 'property_status', true) );
    $property_status        =   '';
    foreach ($status_values_array as $key=>$value) {
        if (function_exists('icl_translate') ){
            //do_action( 'wpml_register_single_string', 'wpestate','property_status', $value );
            //$value     =   icl_translate('wpestate','wp_estate_property_status_'.$value, stripslashes($value) ) ;             
             do_action( 'wpml_register_single_string', 'wpestate','property_status_'.$value, $value );
        }

        $value = stripslashes(trim($value));
        $property_status.='<option value="' . $value . '"';
        if ($value == $prop_stat) {
            $property_status.='selected="selected"';
        }
        $property_status.='>' . $value . '</option>';
    }

      echo '<td align="left" valign="top">          
      </td>
    </tr>
    </table> 

    ';
}


function save_metabox_callback( $post_id ) {
    $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
    $nonce_action = 'custom_nonce_action';

    if ( ! isset( $nonce_name ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( isset( $_POST['property_address'] ) ) {
        $property_address               =   $_POST['property_address'];
        update_post_meta($post_id, 'property_address', $property_address);
    }
    if ( isset( $_POST['property_state'] ) ) {
        $property_state                 =   $_POST['property_state'];
        update_post_meta($post_id, 'property_state', $property_state);
    }
    if ( isset( $_POST['property_zip'] ) ) {
        $property_zip                   =   $_POST['property_zip'];
        update_post_meta($post_id, 'property_zip', $property_zip);
    }
    if ( isset( $_POST['property_country'] ) ) {
        $country_selected               =   $_POST['property_country'];   
        update_post_meta($post_id, 'property_country', $country_selected);
    }

    if ( isset( $_POST['property_county'] ) ) {
        $property_county               =   $_POST['property_county'];   
        update_post_meta($post_id, 'property_county', $property_county);
    }
    update_post_meta($post_id, 'page_custom_zoom', 16);
    update_post_meta($post_id, 'google_camera_angle', 0);
     
}
add_action( 'save_post', 'save_metabox_callback' );


function get_lat_long($address) {
    $array = array();
    if (empty($address)) {
        return $array;
    }

   $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
   $geo = json_decode($geo, true);
   if ($geo['status'] = 'OK') {
	  $latitude = $geo['results'][0]['geometry']['location']['lat'];
	  $longitude = $geo['results'][0]['geometry']['location']['lng'];
	  $array = array('lat'=> $latitude ,'lng'=>$longitude);
   }
   return $array;
}



function searchfilter($query) {
    if ($query->is_search && !is_admin() ) {
        $query->set('post_type',array('product'));
    }
    return $query;
}
add_filter('pre_get_posts','searchfilter'); 


/* 
...........load_more_products_on_Click............
 */

add_action('wp_ajax_load_more_prodoucts', 'load_more_prodoucts_callback');
add_action('wp_ajax_nopriv_load_more_prodoucts', 'load_more_prodoucts_callback');

function load_more_prodoucts_callback(){
    global $row_number_col;   
    $options    =   wpestate_page_details('');
    $unit_class =   "col-md-6";
    $row_number_col=6;

    if($options['content_class'] == "col-md-12"){
        $unit_class="col-md-4";    
        $row_number_col=4;
    }
    $row_number_col=4;
    if ( isset($_POST['perpage']) && !empty($_POST['perpage']) && isset($_POST['currentpage']) && !empty($_POST['currentpage']) ) { ?>
        <?php
        $themeUrl = get_stylesheet_directory_uri(); 
        $page =  $_POST['currentpage'] * $_POST['perpage'];
        $args = array(
            'offset' => $page,
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => $_POST['perpage'],
        );

        if ( isset($_POST['search_string']) && !empty($_POST['search_string']) ) {
            $args['s'] = $_POST['search_string'];
        }

        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); 
                get_template_part('templates/blog_unit');
            }
        }
       
    }
    die();
}

/* 
...........load_more_equplist_on_click............
 */

add_action('wp_ajax_load_more_equplist', 'load_more_equplist_callback');
add_action('wp_ajax_nopriv_load_more_equplist', 'load_more_equplist_callback');

function load_more_equplist_callback(){
    global $row_number_col;   
    $col_class = 'col-md-4';
    if ( isset($_POST['perpage']) && !empty($_POST['perpage']) && isset($_POST['currentpage']) && !empty($_POST['currentpage']) ) { ?>
        <?php
        $themeUrl = get_stylesheet_directory_uri(); 
        $page =  $_POST['currentpage'] * $_POST['perpage'];
        $args = array(
            'offset' => $page,
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => $_POST['perpage']
        );

        add_geo_filter();
        $the_query = new WP_Query( $args );
		remove_geo_filter();
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); 
                get_template_part('templates/property_unit');
            }
        }
       
    }
    die();
}


/* 
...........load_more_advance_search_equplist_on_click............
 */

add_action('wp_ajax_load_more_advance_search_equplist', 'load_more_advance_search_equplist_callback');
add_action('wp_ajax_nopriv_load_more_advance_search_equplist', 'load_more_advance_search_equplist_callback');

function load_more_advance_search_equplist_callback(){
    global $row_number_col;   
    $col_class = 'col-md-4';
    if ( isset($_POST['perpage']) && !empty($_POST['perpage']) && isset($_POST['currentpage']) && !empty($_POST['currentpage']) ) { ?>
        <?php
        $themeUrl = get_stylesheet_directory_uri(); 
        $page =  $_POST['currentpage'] * $_POST['perpage'];
        $args = array(
            'offset' => $page,
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => $_POST['perpage']
        );

        if( isset($_POST['category'])){
            $category  =  sanitize_text_field( wp_kses ($_POST['category'],$allowed_html));
        }

        if ( $category != '' && $category != 'All') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'name',
                    'terms'    => explode(', ', $category),
                    'operator' => 'IN'
                )
            );
        }

        if ( isset($_POST['search_location']) && !empty($_POST['search_location']) ) {
            $args['s'] = $_POST['search_location'];
        }
		add_geo_filter();
        $the_query = new WP_Query( $args );
		remove_geo_filter(); 
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); 
                get_template_part('templates/property_unit');
            }
        }
    }
    die();
}

/* 
...........load_prodoucts_subcategory............
 */

add_action('wp_ajax_load_prodoucts_subcategory', 'load_prodoucts_subcategory_callback');
add_action('wp_ajax_nopriv_load_prodoucts_subcategory', 'load_prodoucts_subcategory_callback');

function load_prodoucts_subcategory_callback(){
	$categories = array();
    if ( isset($_POST['id']) && !empty($_POST['id']) ) {
		$sub_cats					=	get_post_meta($_POST['id'],'product_subcats',true);
        $product_child_categories   = 	get_terms( 'product_cat', 'orderby=name&hide_empty=0&parent=' . absint( $_POST['id'] ) );
        if(!empty($sub_cats)){
			$categories = explode(',',$sub_cats);
		}
        if ( $product_child_categories ) { ?>
            <script type="text/javascript">
                $("#product_subcats").select2({
                    placeholder: "Choose ..."
                });
            </script>
            <select id="product_subcats" name="product_subcats[]" class="product_subcats wcfm-select wcfm_ele simple variable external grouped booking" multiple="multiple" style="width: 60%; margin-bottom: 10px;">
                <?php foreach ( $product_child_categories as $child_cat ) {
                    echo '<option value="' . esc_attr( $child_cat->term_id ) . '"' . selected( in_array( $child_cat->term_id, $categories ), true, false ) . '>'.esc_html( $child_cat->name ).'</option>';
                } ?>
            </select><?php
        }
        else{ echo "not_found"; }
    }
    die();
}

/*add custom field*/
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <h3>Extra profile information</h3>

    <table class="form-table">

        <tr>
            <th><label for="hobbies">My Hobbies are</label></th>

            <td>
                <div><textarea name="hobbies" class="form-control about_me_profile" id="hobbies" row="5" cols="30"><?php echo esc_attr( get_the_author_meta( 'hobbies', $user->ID ) ); ?></textarea></div>
                <span class="description">Please enter your Hobbies.</span>
            </td>
        </tr>

    </table>
<?php }


/*save  field*/
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id) {
update_usermeta(  $user_id , 'hobbies', $_POST['hobbies'] );
    if ( !current_user_can( 'edit_user',  $user_id  ) )
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_usermeta(  $user_id , 'hobbies', $_POST['hobbies'] );
}
/*end*/

/*ad filter for wp editor*/

function myformatTinyMCE($in) {
    $in['statusbar'] = false;

    return $in; 
}
add_filter('tiny_mce_before_init', 'myformatTinyMCE' );


function wpse95025_rename_media_button( $translation, $text ) {
    if('Add Media' === $text ) {
        return 'Add Photos';
    }
    return $translation;
}
add_filter( 'gettext', 'wpse95025_rename_media_button', 10, 2 );

/*end*/

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function jowPower_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'jowPower_header_add_to_cart_fragment' );


/**
 * Selects the distance from a haversine formula
 */
function geo_exp_posts_fields($fields){
	global $wpdb;
	
	
	$fields .= ", lat.meta_value AS latitude ";
	$fields .= ", lng.meta_value AS longitude ";
	return $fields;
}
/**
 * Makes joins as necessary in order to select lat/long metadata
 */
function geo_exp_posts_join($join, $query){
	global $wpdb;

	$join .= " INNER JOIN {$wpdb->postmeta} AS lat ON {$wpdb->posts}.ID = lat.post_id ";
	$join .= " INNER JOIN {$wpdb->postmeta} AS lng ON {$wpdb->posts}.ID = lng.post_id ";
 
	return $join;
}

/**
 * Adds where clauses to compliment joins
 */
function geo_exp_posts_where($where){
	
	$where .= ' AND lat.meta_key="property_latitude" ';
	$where .= ' AND lng.meta_key="property_longitude" ';
	$user_location 	=	get_user_location();
	
	$user_lat		=	$user_location['lat'];
	$user_long		=	$user_location['long'];
	
	$where 		.= 	sprintf(" AND ( 3959 * acos( 
							cos( radians( '%s' ) ) * 
							cos( radians( lat.meta_value ) ) * 
							cos( radians( lng.meta_value ) - radians( '%s' ) ) + 
							sin( radians( '%s' ) ) * 
							sin( radians( lat.meta_value ) ) 
							) ) <= 15000000 ", trim($user_lat), trim($user_long), trim($user_lat)); 
							
	return $where;
}

function add_geo_filter(){
	add_filter( 'posts_fields', 'geo_exp_posts_fields', 10, 2 );
	add_filter( 'posts_join', 'geo_exp_posts_join', 10, 2 );
	add_filter( 'posts_where', 'geo_exp_posts_where', 10, 2 );
}

function remove_geo_filter(){
	remove_filter( 'posts_fields', 'geo_exp_posts_fields', 10, 2 );
	remove_filter( 'posts_fields', 'geo_exp_posts_join', 10, 2 );
	remove_filter( 'posts_where', 'geo_exp_posts_where', 10, 2 );
}

function get_user_location(){
	global $wpdb;
	$myip 	=	$_SERVER['REMOTE_ADDR'];
	//http://ip-api.com/json/208.80.152.201
	
	$user_location	=	json_decode(base64_decode($_COOKIE['user_location']), true);
	
	if( isset($_REQUEST['zip_code'])){
		$zip_code       	=  	sanitize_text_field( ( $_REQUEST['zip_code']) );
		
		if(isset($user_location['zip']) && $user_location['zip']!=$zip_code){
			$lat_long_data 	=	get_lat_long_by_zip_code($zip_code);
			
			return $lat_long_data;
		}else if(!empty($user_location)){
			return $user_location;
		}
	}elseif(!empty($user_location)){
		return $user_location;
	}
	
	if($myip!=""){		
		$response = wp_remote_get( 'http://ip-api.com/json/'.$myip );
		if ( is_array( $response ) ) {
		  $header	 	= 	$response['headers']; // array of http header lines
			if($response['body']!=""){
				$body 		= 	$response['body']; // use the content
				setcookie( 'user_location', base64_encode($body));
				
				$location_data 	=	json_decode($body, true);
				if($location_data['zip']!=""){
					
					$wpdb->insert( 
							$wpdb->prefix."zipcodes", 
							array( 
								'zipcode'     => $location_data['zip'],
								'latitude'    => $location_data['lat'],
								'longitude'    => $location_data['long'],
							));
				}
				return $location_data;
			}
		}
	}
}

function get_lat_long_by_zip_code($zipcode){
	global $wpdb;
	
	$thezipdata = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}zipcodes WHERE zipcode=%s", $zipcode), ARRAY_A );
	
	if(!empty($thezipdata)){
		$latitude	=	$thezipdata['latitude'];
		$longitude	=	$thezipdata['longitude'];
		return array('zip'=>$zipcode,'lat'=>$latitude, 'long'=>$longitude);
	}else{
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
		$details	=	file_get_contents($url);
		$result 	= 	json_decode($details,true);
		$latitude	=	$result['results'][0]['geometry']['location']['lat'];
		$longitude	=	$result['results'][0]['geometry']['location']['lng'];
		$wpdb->insert( 
						$wpdb->prefix."zipcodes", 
						array( 
							'zipcode'     => $zipcode,
							'latitude'    => $latitude,
							'longitude'    => $longitude,
						)
					);
		return array('zip'=>$zipcode,'lat'=>$latitude, 'long'=>$longitude);
	}
}


/*............Booking Product Choose Rental option.............*/

function rent_type_field_option() {
    global $product;
    /* $ID = $product->get_id();
    $get_product = get_product( $ID );
    if( !$get_product->is_type( 'booking' ) ){
        return;
    } */
    ?>
    <div class="rent-type-field">
        <label for="selete_rent_type">Select Rental period</label>
        <select id="selete_rent_type" class="" name="selete_rent_type">
            <option value="">Select Rental period </option>
            <option value="Day(s)" class="attached enabled">Day(s)</option>
            <option value="Week(s)" class="attached enabled">Week(s)</option>
            <option value="Month(s)" class="attached enabled">Month(s)</option>
        </select>
    </div>
    <?php
}
// add_action( 'woocommerce_before_booking_form', 'rent_type_field_option', 1 );


function rent_type_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
    $selete_rent_type = filter_input( INPUT_POST, 'selete_rent_type' );
 
    if ( empty( $selete_rent_type ) ) {
        return $cart_item_data;
    }
 
    $cart_item_data['selete_rent_type'] = $selete_rent_type;
 
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'rent_type_to_cart_item', 10, 3 );


function rent_type_text_cart( $product_name, $cart_item, $cart_item_key ) {
    if ( empty( $cart_item['selete_rent_type'] ) ) {
        return $product_name;
    }
    return sprintf( '%s <p><strong>%s</strong>: %s</p>', $product_name, __( 'Rental period', 'iconic' ), $cart_item['selete_rent_type'] );
}
add_filter( 'woocommerce_cart_item_name', 'rent_type_text_cart', 10, 3 );


function rent_type_text_to_order_items( $item, $cart_item_key, $values, $order ) {
    if ( empty( $values['selete_rent_type'] ) ) {
        return;
    }
    $item->add_meta_data( __( 'Rental period', 'iconic' ), $values['selete_rent_type'] );
}
 
add_action( 'woocommerce_checkout_create_order_line_item', 'rent_type_text_to_order_items', 10, 4 );



/*..........Set Custom Price.........*/
function add_custom_price( $cart_object ) {

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if( function_exists('get_product') ){
            $get_product = get_product( $cart_item['product_id'] );
            if( $get_product->is_type( 'booking' ) ){
                $product = get_product( $cart_item['product_id'] );
                if( $product->is_type( 'booking' ) ){
                    if ( isset($cart_item['selete_rent_type']) && !empty($cart_item['selete_rent_type']) ) {
                        $wc_booking_day_cost = get_post_meta($booking_id, '_wc_booking_day_cost',true );
                        $wc_booking_week_cost = get_post_meta($booking_id, '_wc_booking_week_cost',true );
                        $wc_booking_month_cost = get_post_meta($booking_id, '_wc_booking_month_cost',true );


                        if ( $cart_item['selete_rent_type'] == 'Day(s)' ) {
                            $custom_price = $wc_booking_day_cost;
                        }
                        if ( $cart_item['selete_rent_type'] == 'Week(s)' ) {
                            $custom_price = $wc_booking_week_cost;
                        }
                        else if ( $cart_item['selete_rent_type'] == 'Month(s)' ) {
                            $custom_price = $wc_booking_month_cost;
                        }
                        $cart_item['data']->set_price($custom_price);   
                    }
                }
            }

        }
    }
}
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );
if(!function_exists('pr1')){
	function pr1($arr=array()){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}


add_action('wp_ajax_load_calander_events', 'load_calander_events');
add_action('wp_ajax_nopriv_load_calander_events', 'load_calander_events');

function load_calander_events(){
    global $wpdb, $current_user;
	
	$args = array(
			'post_type'        =>  'estate_property',
			'author'           =>  $current_user->ID,

		'posts_per_page'    => -1,
		'post_status'      =>  array( 'any' )
	);
	$prop_selection 	= 	new WP_Query($args);
	
	if( !$prop_selection->have_posts() ){
		$calendar_data		=	array();	
	}else{
		while ($prop_selection->have_posts()): $prop_selection->the_post();          
			$post_id            		=   get_the_ID();
			$calendar_data[$post_id] 	= 	get_post_meta($post_id, 'booking_dates',true);
		endwhile;
	}
	wp_reset_query();
	if(!empty($calendar_data)){
		// foreach($calendar_data as $event)
	}
	pr1($calendar_data);
	die;
}

add_action('after_wcfm_products_manage_meta_save', function($new_product_id, $wcfm_products_manage_form_data=array()){
	
	$wcfm_products_manage_form_data = 	array();
	$products_sub_category			=	"";
	parse_str($_POST['wcfm_products_manage_form'], $wcfm_products_manage_form_data);
	
	/*Address Field Save*/
	$property_address 	= 	$wcfm_products_manage_form_data['property_address'];
	$property_county 	= 	$wcfm_products_manage_form_data['property_county'];
	$property_state 	= 	$wcfm_products_manage_form_data['property_state'];
	$property_zip 		= 	$wcfm_products_manage_form_data['property_zip'];
	$property_country 	= 	$wcfm_products_manage_form_data['property_country'];
	
	$product_subcats 	= 	$wcfm_products_manage_form_data['product_subcats'];
	
	if(!empty($product_subcats)){
		$products_sub_category = implode(',',$product_subcats);
		update_post_meta($new_product_id, 'product_subcats', $products_sub_category);
	}
	update_post_meta($new_product_id, 'property_address', $property_address);
	update_post_meta($new_product_id, 'property_county', $property_county);
	update_post_meta($new_product_id, 'property_state', $property_state);
	update_post_meta($new_product_id, 'property_zip', $property_zip);
	update_post_meta($new_product_id, 'property_country', $property_country);
	
	$featuredimages	=	$wcfm_products_manage_form_data['featuredimages'];
	
	$featured_img 	= 	$wcfm_products_manage_form_data['featured'];
	if(!empty($featuredimages)){
		if (($key = array_search($featured_img, $featuredimages)) !== false) {
			unset($featuredimages[$key]);
		}
		update_post_meta($new_product_id, '_product_image_gallery', implode(",", $featuredimages));
	}
	// _product_image_gallery
	if(isset($wcfm_products_manage_form_data['featured']) && !empty($wcfm_products_manage_form_data['featured'])){
		set_post_thumbnail($new_product_id, $wcfm_products_manage_form_data['featured']);
	}
	$address 			= 	$property_address.' '.$property_county.' '.$property_state.' '.$property_country.' '.$property_zip;
	
	$prepAddr 			= 	str_replace(' ','+',$address);
	$prepAddr 			= 	str_replace('++','+',$prepAddr);
	$geocode			=	file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyBtR7FNueNAiCok149fQTjG9cLzreJt3d4&sensor=false');
	$output				= 	json_decode($geocode);
	$latitude 			= 	$output->results[0]->geometry->location->lat;
	$longitude 			= 	$output->results[0]->geometry->location->lng;

	update_post_meta($new_product_id, 'prepAddr', $prepAddr);
	update_post_meta($new_product_id, 'property_latitude', $latitude);
	update_post_meta($new_product_id, 'property_longitude', $longitude);

	if ( $wcfm_products_manage_form_data['product_type'] == 'booking' ) {
		
		update_post_meta($new_product_id, '_wc_booking_cost', 0);
		update_post_meta($new_product_id, '_wc_display_cost', wc_clean($wcfm_products_manage_form_data['_wc_booking_day_cost']));
		
		$product_data 	=	array
							(
								array
									(
										'type' => 'blocks',
										'cost' => '',
										'modifier' => '', 
										'base_cost' => wc_clean($wcfm_products_manage_form_data['_wc_booking_week_cost']),
										'base_modifier' => '', 
										'from' => 7,
										'to' => 7
									),
								array
									(
										'type' => 'blocks',
										'cost' => '',
										'modifier' => '', 
										'base_cost' => wc_clean($wcfm_products_manage_form_data['_wc_booking_month_cost']),
										'base_modifier' => '',
										'from' => 30,
										'to' => 31
									)

							);
		// add per week and per month price					
		update_post_meta($new_product_id, '_short_description', stripslashes( html_entity_decode( $wcfm_products_manage_form_data['excerpt'], ENT_QUOTES, 'UTF-8' ) ));
		update_post_meta($new_product_id, '_wc_booking_pricing', $product_data);
		update_post_meta($new_product_id, '_wc_booking_calendar_display_mode', 1);
		update_post_meta($new_product_id, '_wc_booking_min_persons_group', 1);
		update_post_meta($new_product_id, '_wc_booking_availability', array());
		update_post_meta($new_product_id, '_wc_booking_min_date', wc_clean($wcfm_products_manage_form_data['_wc_booking_min_date']));
		update_post_meta($new_product_id, '_wc_booking_min_date_unit', wc_clean($wcfm_products_manage_form_data['_wc_booking_min_date_unit']));
		update_post_meta($new_product_id, '_wc_booking_min_duration', 1);
		update_post_meta($new_product_id, '_wc_booking_max_duration', 30);
		update_post_meta($new_product_id, '_wc_booking_max_date_unit', wc_clean($wcfm_products_manage_form_data['_wc_booking_max_date_unit']));
		update_post_meta($new_product_id, '_wc_booking_duration_type', 'customer');
		update_post_meta($new_product_id, '_wc_booking_duration_unit', 'day');
		update_post_meta($new_product_id, '_wc_booking_duration', 1);
		update_post_meta($new_product_id, '_wc_booking_enable_range_picker', 1);
		update_post_meta($new_product_id, '_wc_booking_max_date', wc_clean($wcfm_products_manage_form_data['_wc_booking_max_date']));
		update_post_meta($new_product_id, '_wc_booking_buffer_period', wc_clean($wcfm_products_manage_form_data['_wc_booking_buffer_period']));
		update_post_meta($new_product_id, '_wc_booking_max_persons_group', 1);
		update_post_meta($new_product_id, '_wc_booking_person_cost_multiplier', '');
		update_post_meta($new_product_id, '_wc_booking_person_qty_multiplier', '');
		update_post_meta($new_product_id, '_wc_booking_qty', 1);
		update_post_meta($new_product_id, '_wc_booking_resources_assignment', 'customer');
		if(isset($wcfm_products_manage_form_data['_wc_booking_requires_confirmation'])){
			update_post_meta($new_product_id, '_wc_booking_requires_confirmation', wc_clean($wcfm_products_manage_form_data['_wc_booking_requires_confirmation']));	
			
		}
		update_post_meta($new_product_id, '_wc_booking_day_cost', $wcfm_products_manage_form_data['_wc_booking_day_cost'] );
		update_post_meta($new_product_id, '_wc_booking_week_cost', $wcfm_products_manage_form_data['_wc_booking_week_cost'] );
		update_post_meta($new_product_id, '_wc_booking_month_cost', $wcfm_products_manage_form_data['_wc_booking_month_cost'] );
		
	}
});

//save payment field for stripe
add_action( 'user_register', 'wprentels_registration_save', 10, 1 );
function wprentels_registration_save( $user_id ) {
    update_user_meta($user_id, 'vendor_payment_mode', 'stripe_masspay');
    update_user_meta($user_id, '_vendor_payment_mode', 'stripe_masspay');
}

function filter_plugin_updates( $value ) {
    unset( $value->response['dc-woocommerce-multi-vendor/dc_product_vendor.php'] );
    unset( $value->response['woocommerce/woocommerce.php'] );
    unset( $value->response['woocommerce-bookings/woocommerce-bookings.php'] );
    unset( $value->response['wc-frontend-manager/wc_frontend_manager.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );