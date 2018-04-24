<?php
// Template Name: All in one calendar
// Wp Estate Pack
if ( !is_user_logged_in() ) {   
    wp_redirect(  esc_html( home_url() ) );exit();
} 
if ( !wpestate_check_user_level()){
   wp_redirect(  esc_html( home_url() ) );exit(); 
}

wp_register_style('fullcalander', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css', '');
// wp_register_style('fullcalanderprint', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.print.css', '');
wp_enqueue_style( 'fullcalander' );
// wp_enqueue_style( 'fullcalanderprint' );
wp_register_script('moment', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js');
wp_enqueue_script('moment');
wp_register_script('fullcalander', 
                        '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.js', array('jquery','jquery-migrate','moment'));
wp_enqueue_script('fullcalander');
wp_register_script('customscript', get_template_directory_uri().'/js/custom.js', array('fullcalander','jquery'));

wp_enqueue_script('customscript');

global $user_login;
$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation        =   get_the_author_meta( 'package_activation' , $userID );   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   wpestate_curency_submission_pick();
$edit_link                      =   wpestate_get_dasboard_edit_listing();
$processor_link                 =   wpestate_get_procesor_link();

$wp_estate_currency_symbol = esc_html( get_option('wp_estate_currency_label_main', '') );
get_header();
$options=wpestate_page_details($post->ID);
// $calander_data 	=	get_calander_data_json_for_vendor();
?> 

<?php 
if( !is_user_logged_in() ){ ?>
    <script type="text/javascript">
        window.location = '<?php echo home_url(); ?>';
    </script>
<?php }
else if ( !in_array('dc_vendor', $current_user->roles) && !in_array('administrator', $current_user->roles) ) {
    add_filter('wcmp_vendor_registration_submit', function ($text) {
        return 'Apply to become a vendor';
    });
    echo do_shortcode('[vendor_registration]');
} else { ?>
    <div class="row is_dashboard">
        <?php
        if( wpestate_check_if_admin_page($post->ID) ){
            if ( is_user_logged_in() ) {   
                get_template_part('templates/user_menu'); 
            }  
        }
        ?> 
        <div class=" dashboard-margin">
            
            <div class="dashboard-header">
                <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                    <h1 class="entry-title listings-title-dash"><?php the_title(); ?></h1>
                <?php } ?>
            </div>  
            
            <div class="row admin-list-wrapper inbox-wrapper">    
                <div id="calendar"></div>    
            </div>
        </div>
    </div>  
<?php } 
get_footer(); 
?>