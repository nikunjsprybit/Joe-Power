</div><!-- end content_wrapper started in header or full_width_row from prop list -->

<script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('body').on('click', '#user_menu_u', function (event) {
            if (jQuery('#user_menu_open').is(":visible")) {
                jQuery('#user_menu_open').removeClass('iosfixed').fadeOut(400);
            } else {
                jQuery('#user_menu_open').fadeIn(400);
            }
            event.stopPropagation();
        });

        function changePoductType(thisVal){
            jQuery('.user_dashboard_panel_guide a[href="#inventory"]').remove();
            if ( thisVal == 'booking' ) {
                jQuery('.user_dashboard_panel_guide a[href="#inventory"]').remove();
                jQuery('#wcfm_products_manage_form #categories .btnNext').attr('href', '#shipping');
                jQuery('#wcfm_products_manage_form #categories .btnNext').attr('active-tab', '5');

                jQuery('#wcfm_products_manage_form #shipping .btnPrevious').attr('href', '#categories');
                jQuery('#wcfm_products_manage_form #shipping .btnPrevious').attr('active-tab', '3');
            }
            else{
                // jQuery('.user_dashboard_panel_guide a[href="#inventory"]').show();

                jQuery('<a href="#inventory" data-toggle="tab" class="">Inventory</a>').insertAfter('.user_dashboard_panel_guide a[href="#categories"]');

                jQuery('#wcfm_products_manage_form #categories .btnNext').attr('href', '#inventory');
                jQuery('#wcfm_products_manage_form #categories .btnNext').attr('active-tab', '4');
                jQuery('#wcfm_products_manage_form #shipping .btnPrevious').attr('href', '#inventory');
                jQuery('#wcfm_products_manage_form #shipping .btnPrevious').attr('active-tab', '4');
                
            }
        }


        jQuery('#wcfm_products_manage_form').on('change', '#product_type', function() {
            var thisVal = jQuery(this).val();
            changePoductType(thisVal);
        });

        var proType = jQuery('#product_type').val();
        changePoductType(proType);

        

        jQuery('.products_manage_yoast').hide();

    }); 
    </script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>       
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("#select_category").select2();
                jQuery('#select_category').change(function() { 
                    jQuery("#category_main_mobile").val( jQuery(this).val() ); 
                });
        });
    </script>

<?php 

if ( !is_user_logged_in() ) { ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.custom_place, .custom_wpestate_rentals').attr('href', 'javascript:void(0);');
            
            jQuery('.theme-slider-view').each( function() {
                if( jQuery(this).attr('href') == '<?php echo site_url(); ?>/add-new-equipment/' ){
                    jQuery(this).attr('href', 'javascript:void(0);').addClass('listing_not_allow');
                }
            });
            
            jQuery(document).on('click', '.custom_place, .listing_not_allow, .custom_wpestate_rentals', function() {
                jQuery('#topbarlogin').click();
            });

        });
    </script>
<?php } 

$footer_background          =   get_option('wp_estate_footer_background','');
$repeat_footer_back_status  =   get_option('wp_estate_repeat_footer_back','');
$footer_style               =   '';
$footer_back_class          =   '';

if ($footer_background!=''){
    $footer_style='style=" background-image: url('.$footer_background.') "';
}

if( $repeat_footer_back_status=='repeat' ){
    $footer_back_class = ' footer_back_repeat ';
}else if( $repeat_footer_back_status=='repeat x' ){
    $footer_back_class = ' footer_back_repeat_x ';
}else if( $repeat_footer_back_status=='repeat y' ){
    $footer_back_class = ' footer_back_repeat_y ';
}else if( $repeat_footer_back_status=='no repeat' ){
    $footer_back_class = ' footer_back_repeat_no ';
}
 

if( !is_search() && !is_category() && !is_tax() &&  !is_tag() &&  !is_archive() && wpestate_check_if_admin_page($post->ID) ){
    // do nothing for now  
  
} else if(!is_search() && !is_category() && !is_tax() &&  !is_tag() &&  !is_archive() && basename(get_page_template($post->ID)) == 'property_list_half.php'){
    // do nothing for now   
  
} else if( ( is_category() || is_tax() ) &&  get_option('wp_estate_property_list_type','')==2){
    // do nothing for now
  
} else if(  is_page_template('advanced_search_results.php') &&  get_option('wp_estate_property_list_type_adv','')==2){


} else if(  is_page_template('vendor_dashboard.php') ){
    // do nothing for now
 
}else{  
?>


<footer id="colophon" <?php echo $footer_style; ?> class=" <?php echo $footer_back_class;?> ">    
    <div id="footer-widget-area" class="row">
        <?php  get_sidebar('footer');?>
    </div><!-- #footer-widget-area -->

    <div class="sub_footer">  
        <div class="sub_footer_content">
            <span class="copyright">
                <?php      
                if (function_exists('icl_translate') ){
                    print $property_copy_text      =   icl_translate('wpestate','wp_estate_property_copyright_text', stripslashes ( esc_html( get_option('wp_estate_copyright_message') ) ) );
                }else{
                    print stripslashes ( esc_html (get_option('wp_estate_copyright_message', '') ) );
                }
                ?>
            </span>

            <div class="subfooter_menu">
                <?php      
                    wp_nav_menu( array(
                        'theme_location'    => 'footer_menu',
                        'depth'             => 1                           
                    ));  
                ?>
            </div>  
        </div>  
    </div>
</footer><!-- #colophon -->
<?php } // end property_list_half?>
<?php get_template_part('templates/footer_buttons');?>
<?php wp_get_schedules(); ?>
<?php wp_footer();  ?>

<?php
    $ga = esc_html(get_option('wp_estate_google_analytics_code', ''));
    if ($ga != '') {  ?>
        <script>
            //<![CDATA[
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '<?php echo $ga; ?>', '<?php     echo $_SERVER['SERVER_NAME']; ?>');
          ga('send', 'pageview');
        //]]>
        </script>
<?php
    }
?>
</div> <!-- end class container -->
<?php get_template_part('templates/social_share'); ?>
</div>

</body>
</html>