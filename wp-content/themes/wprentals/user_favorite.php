<?php
// Template Name: User Favorite
// Wp Estate Pack

if (!is_user_logged_in()) {
    wp_redirect(esc_html(home_url()));
    exit();
}

if (!wpestate_check_user_level()) {
    wp_redirect(esc_html(home_url()));
    exit();
}

$current_user = wp_get_current_user();
$userID = $current_user->ID;
$user_login = $current_user->user_login;
$user_pack = get_the_author_meta('package_id', $userID);
$user_registered = get_the_author_meta('user_registered', $userID);
$user_package_activation = get_the_author_meta('package_activation', $userID);
$paid_submission_status = esc_html(get_option('wp_estate_paid_submission', ''));
$price_submission = floatval(get_option('wp_estate_price_submission', ''));
$submission_curency_status = wpestate_curency_submission_pick();
$edit_link = wpestate_get_dasboard_edit_listing();
$floor_link = '';
$processor_link = wpestate_get_procesor_link();
$th_separator = get_option('wp_estate_prices_th_separator', '');
if (isset($_GET['delete_id'])) {
    if (!is_numeric($_GET['delete_id'])) {
        exit('you don\'t have the right to delete this');
    } else {
        $delete_id = intval($_GET['delete_id']);
        $the_post = get_post($delete_id);
        if ($current_user->ID != $the_post->post_author) {
            exit('you don\'t have the right to delete this');
            ;
        } else {
            // delete attchaments
            $arguments = array(
                'numberposts' => -1,
                'post_type' => 'product',
                'post_parent' => $delete_id,
                'post_status' => null,
                'exclude' => get_post_thumbnail_id(),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            $post_attachments = get_posts($arguments);

            foreach ($post_attachments as $attachment) {
                wp_delete_post($attachment->ID);
            }
            wp_delete_post($delete_id);
            $dash_link = wpestate_get_dashboard_link();
            wp_redirect(esc_html($dash_link));
            exit();
        }
    }
}

get_header();
$options = wpestate_page_details($post->ID);
$new_mess = 0;

$title_search = '';
if (isset($_POST['wpestate_prop_title'])) {
    $title_search = sanitize_text_field($_POST['wpestate_prop_title']);
}
?>  

<?php if (!is_user_logged_in()) { ?>
    <script type="text/javascript">
        window.location = '<?php echo home_url(); ?>';
    </script>
    <?php
} else if (!in_array('dc_vendor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
    add_filter('wcmp_vendor_registration_submit', function ($text) {
        return 'Apply to become a vendor';
    });
    echo do_shortcode('[vendor_registration]');
} else {
    ?>
    <div class="row is_dashboard">
        <?php
//        if (wpestate_check_if_admin_page($post->ID)) {
            if (is_user_logged_in()) {
                get_template_part('templates/user_menu');
            }
//        }
        ?> 

        <div class="dashboard-margin">

            <div class="dashboard-header">
                <?php if (esc_html(get_post_meta($post->ID, 'page_show_title', true)) != 'no') { ?>
                    <h1 class="entry-title listings-title-dash"><?php the_title(); ?></h1>
                <?php } ?>
            </div>    
            


            <div class="row admin-list-wrapper flex_wrapper_list">    
                <?php
                global $wpdb;
                $current_user = wp_get_current_user();
                $currentuser_fav = 'favorites' . $current_user->ID;
//                $favorite_Data = $wpdb->get_results($wpdb->prepare("select * from wp_options where option_name = '" . $currentuser_fav . "'"));
                $post_data = get_option($currentuser_fav);
//                $post_data = get_option('favorites6');
                //$comma_seperate_postid = implode(',', $post_data);

                if (!$post_data) {
                    if ($new_mess == 1) {
                        print '<h4 class="no_favorites">' . esc_html__('No results!', 'wpestate') . '</h4>';
                    } else {
                        print '<h4 class="no_list_yet">' . esc_html__('You don\'t have any favorites yet! ', 'wpestate') . '</h4>';
                    }
                }
                ?>      
                <div id="wcfm_products_listing">

                    <div class="wcfm-clearfix"></div>
                    <div class="wcfm-container">
                        <div id="wcfm_products_listing_expander" class="wcfm-content">

                            <?php
                            if(count($post_data) >0){
                            //$query = new WP_Q
                            //uery(array('post_type' => 'product', 'post__in' => array($comma_seperate_postid)));
                            foreach ($post_data as $postid) {
                                $img = wp_get_attachment_url(get_post_thumbnail_id($postid));
                                $data = get_post($postid);
                                $price = get_post_meta($postid, '_regular_price', true);
                                $sale = get_post_meta($postid, '_sale_price', true);
                                //echo '<pre>'; print_r($data); exit;
                                ?>

                                <div class="col-md-4 flexdashbaord" id="proid-3420">
                                    <div class="dasboard-prop-listing">

                                        <div class="blog_listing_image dashboard_imagine">

                                            <a href="<?php echo get_post_permalink($postid); ?>">
                                                <img src="<?php echo ($img) ? $img : get_template_directory_uri().'/img/defaultimage_prop.jpg'; ?>" alt="Placeholder" width="300" class="woocommerce-placeholder wp-post-image" height="300"></a>				        
                                        </div>

                                        <div class="prop-info">
                                            <div class="title_and_price">
                                                <h4 class="listing_title">
                                                    <a href="<?php echo get_post_permalink($postid); ?>" class="wcfm_product_title"><?php echo substr($data->post_title, 0, 15); ?></a>	 
                                                </h4>
                                            </div>


                                            <div class="user_dashboard_listed title_and_price">
                                                <!--<h4 class="listing_title custom_listing_title">For Rent</h4>-->
                                                <div class="user_dashboard_listed">
<!--                                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?php // echo $price; ?></span>                  -->
                                                </div>
                                            </div>
                                        </div> 

                                    </div>
                                </div>


                            <?php } 
}?>

                        </div>
                        <div class="wcfm-clearfix"></div>
                    </div>
                </div>

            </div>

            <?php
            //  endwhile;

            kriesi_pagination($prop_selection->max_num_pages, $range = 2);
            ?>    
        </div>
    </div>
    </div>  
    <?php wp_reset_query(); ?>
<?php } ?>
<?php get_footer(); ?>