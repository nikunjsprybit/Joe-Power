<?php
// Template Name: User Dashboard My Reservations
// Wp Estate Pack
if ( !is_user_logged_in() ) {   
    wp_redirect(  esc_html( home_url() ) );exit();
} 


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
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$currency                       =   wpestate_curency_submission_pick();
$options                        =   wpestate_page_details($post->ID);
get_header();
?> 



<?php
$title_search='';
 $new_mess=0;
if( isset($_POST['wpestate_prop_title']) ){
    $title=sanitize_text_field($_POST['wpestate_prop_title']);
    

    $args = array(
                    'post_type'         => 'estate_property',
                    'posts_per_page'    => -1,
                    's'                 =>  $title
                 );
    $new_mess=1;
    
    add_filter( 'posts_search', 'wpestate_search_by_title_only', 500, 2 );
    $prop_selection =   new WP_Query($args);
    remove_filter( 'posts_search', 'wpestate_search_by_title_only', 500 );

    $right_array=array();
    $right_array[]=0;

    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
            $right_array[]=$post->ID;
           // print get_the_title($post->ID).',';
    endwhile;
    wp_reset_postdata();
    $title_search= array(
                array(
                    'key'     => 'booking_id',
                    'value'   => $right_array,
                    'compare' => 'IN',
                    ),
                );
}
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
        
        <div class="dashboard-margin">
            <div class="dashboard-header">
                <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                    <h1 class="entry-title listings-title-dash"><?php the_title(); ?></h1>
                <?php } ?>
            </div>  
             <?php 
            global $WCFM;
            if ( 
                (isset($_GET['action'])) 
                && ( 
                    ($_GET['action'] == 'add') 
                    || ( $_GET['action'] == 'edit' 
                        && isset($_GET['id']) && 
                        !empty($_GET['id']) 
                        ) 
                    ) 
                ) {
                // Load Scripts
                $WCFM->library->load_scripts( 'wcfm-coupons-manage' );
                
                // Load Styles
                $WCFM->library->load_styles( 'wcfm-coupons-manage' );
                
                // Load View
                $WCFM->library->load_views( 'wcfm-coupons-manage' );
            } else{
                // Load Scripts
                $WCFM->library->load_scripts( 'wcfm-coupons' );
                
                // Load Styles
                $WCFM->library->load_styles( 'wcfm-coupons' );
                
                // Load View
                $WCFM->library->load_views( 'wcfm-coupons' );
            }      ?>
            </div>
    </div> <?php 
}
wp_reset_query();
get_footer(); 
?>