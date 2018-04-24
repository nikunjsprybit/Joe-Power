<?php
session_start();
// Template Name: Vendor Dashboard
// Wp Estate Pack
get_header();
  
    
    
$options            =   wpestate_page_details($post->ID);
$company_name       =   esc_html( stripslashes ( get_option('wp_estate_company_name', '') ) );
$company_picture    =   esc_html( get_option('wp_estate_company_contact_image', '') );
$company_email      =   esc_html( get_option('wp_estate_email_adr', '') );
$mobile_no          =   esc_html ( get_option('wp_estate_mobile_no','') );
$telephone_no       =   esc_html( get_option('wp_estate_telephone_no', '') );
$fax_ac             =   esc_html( get_option('wp_estate_fax_ac', '') );
$skype_ac           =   esc_html( get_option('wp_estate_skype_ac', '') );

if (function_exists('icl_translate') ){
    $co_address      =   icl_translate('wpestate','wp_estate_co_address_text', ( get_option('wp_estate_co_address') ) );
}else{
    $co_address      =   ( get_option('wp_estate_co_address', '') );
}

$facebook_link      =   esc_html( get_option('wp_estate_facebook_link', '') );
$twitter_link       =   esc_html( get_option('wp_estate_twitter_link', '') );
$google_link        =   esc_html( get_option('wp_estate_google_link', '') );
$linkedin_link      =   esc_html ( get_option('wp_estate_linkedin_link','') );
$pinterest_link     =   esc_html ( get_option('wp_estate_pinterest_link','') );
$agent_email        =   $company_email;
?>
<div class="row is_dashboard">
    <!-- <div class="<?php //print $options['content_class'];?>"> -->
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <!-- <div class="single-content"> -->    <!-- single-content contact-content -->
                <?php the_content(); ?>
            <!-- </div> -->
        <?php endwhile; // end of the loop. ?>
    <!-- </div> -->
<?php  //include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>