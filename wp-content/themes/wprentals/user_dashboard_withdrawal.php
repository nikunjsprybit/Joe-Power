<?php
// Template Name: User Dashboard withdrawal Page
// Wp Estate Pack

$current_user = wp_get_current_user();
$dash_withdrawal_link = wpestate_withdrawal_link();



?> 
<?php get_header(); ?>
<div class="row is_dashboard">   
    <?php
    if( wpestate_check_if_admin_page($post->ID) ){
        if ( is_user_logged_in() ) {   
            get_template_part('templates/user_menu'); 
        }  
    }
    ?> 
    
    <div class=" dashboard-margin">
        
        <?php while (have_posts()) : the_post(); ?>
       
            <div class="dashboard-header">
                <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                    <h1 class="entry-title entry-title-profile"><?php the_title(); ?></h1>
                <?php } ?>
            </div>
        
            <div class="single-content"><?php the_content();?></div><!-- single content-->
           <?php endwhile; // end of the loop. ?>
          
    </div>
</div> 



<?php get_footer(); ?>