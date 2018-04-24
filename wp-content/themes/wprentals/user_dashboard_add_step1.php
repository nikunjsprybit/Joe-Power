<?php
// Template Name: User Dashboard Submit - Step 1
// Wp Estate Pack

get_header();

///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////

$current_user = wp_get_current_user(); ?> 
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
    <div id="cover"></div>
    <div class="row 
        <?php 
        if( is_user_logged_in() ){
            echo 'is_dashboard'; 
            if ( !wpestate_check_user_level()){
                wp_redirect(  esc_html( home_url() ) );exit(); 
            }
        }else{
            echo 'no_log_submit';
        }
        ?> ">
           
        <?php
        if( wpestate_check_if_admin_page($post->ID) ){
            if ( is_user_logged_in() ) {   
                //get_template_part('templates/user_menu'); 
            }  
        }
        ?> 
        
        <div class="dashboard-margin 
        <?php if ( !is_user_logged_in() ) {
            // echo 'dashboard-margin-nolog';
        }
        ?>
        "> 
        
        <?php   
        $remaining_listings =   wpestate_get_remain_listing_user($userID,$user_pack);

        if($remaining_listings  === -1){
           $remaining_listings=11;
        }
        $paid_submission_status= esc_html ( get_option('wp_estate_paid_submission','') );


        if( is_user_logged_in() && !isset( $_GET['listing_edit'] ) && $paid_submission_status == 'membership' && $remaining_listings != -1 && $remaining_listings < 1 ) {
            print '<h4 class="nosubmit">'.esc_html__( 'Your current package doesn\'t let you publish more properties! You need to upgrade your subscription.','wpestate' ).'</h4>';
        }else{
           
        ?>
            
            <div class="dashboard-header">
                <?php get_template_part('templates/submission_guide');?>
            </div>
            
            <?php get_template_part('templates/ajax_container'); ?>
            <div class="">
               <?php 
            global $WCFM;
                // Load Scripts
                $WCFM->library->load_scripts( 'wcfm-products-manage' );
                
                // Load Styles
                $WCFM->library->load_styles( 'wcfm-products-manage' );
                
                // Load View
                $WCFM->library->load_views( 'wcfm-products-manage' );

               ?>
            </div>   
        <?php 
        } 
        ?>      
        </div>
    </div>   
<?php } ?>
<?php get_footer(); ?>