<?php
// Template Name: User Dashboard Favorite
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect(  esc_html( home_url() ) );exit();
} 

$current_user = wp_get_current_user();   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   wpestate_curency_submission_pick();
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$currency                       =   esc_html( get_option('wp_estate_currency_label_main', '') );
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

get_header();
$options=wpestate_page_details($post->ID);
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
                <div><?php
                global $WCFM;
                
                if ( isset($_GET['status']) && $_GET['status'] == 'stock-report') {
                    // Load Scripts
                    $WCFM->library->load_scripts( 'wcfm-reports-out-of-stock' );
                    
                    // Load Styles
                    $WCFM->library->load_styles( 'wcfm-reports-out-of-stock' );
                    
                    // Load View
                    $WCFM->library->load_views( 'wcfm-reports-out-of-stock' );
                }
                else{
                    // Load Scripts
                    $WCFM->library->load_scripts( 'wcfm-reports-sales-by-date' );
                    
                    // Load Styles
                    $WCFM->library->load_styles( 'wcfm-reports-sales-by-date' );
                    
                    // Load View
                    $WCFM->library->load_views( 'wcfm-reports-sales-by-date' );
                }
                
                ?>
                </div>

            
          
        </div>
    </div>  
<?php } ?>

<?php 
wp_reset_query();
get_footer(); 
?>