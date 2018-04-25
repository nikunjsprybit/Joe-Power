<?php
global $owner_id;
global $agent_id;
global $comments_data;
$current_user = wp_get_current_user();
$userID = $current_user->ID;

while (have_posts()) : the_post();
    $agent_id = get_the_ID();
    $owner_id = get_post_meta($agent_id, 'user_agent_id', true);
    $user_agent_id = wpestate_user_for_agent($agent_id);
    $thumb_id = get_post_thumbnail_id($post->ID);
    $preview = wp_get_attachment_image_src($thumb_id, 'wpestate_property_places');
    $preview_img = $preview[0];
    if ($preview_img == '') {
        $preview_img = get_template_directory_uri() . '/img/default_user.png';
    }
    $term = get_query_var('term');
    $term_data = get_queried_object();
    $place_id = $term_data->term_id;
    $category_attach_id = '';
    $category_tax = '';
    $category_featured_image = '';
    $category_name = '';
    $preview_img = '';
    $term_meta = get_option("taxonomy_$place_id");
    $category_tagline = '';
    $page_tax = '';
    $vendor = get_wcmp_vendor_by_term(get_queried_object()->term_id);
    $preview_img = get_the_author_meta('custom_picture', $vendor->ID);
    if ($preview_img == '') {
        $preview_img = get_template_directory_uri() . '/img/default_user.png';
    }
    if (isset($term_meta['category_tax'])) {
        $category_tax = $term_meta['category_tax'];
        $term = get_term($place_id, $category_tax);
        $category_name = $term->name;
    }

    if (isset($term_meta['category_tagline'])) {
        $category_tagline = stripslashes($term_meta['category_tagline']);
    }


    $agent_skype = esc_html(get_post_meta($post->ID, 'agent_skype', true));
    $agent_phone = esc_html(get_post_meta($post->ID, 'agent_phone', true));
    $agent_mobile = esc_html(get_post_meta($post->ID, 'agent_mobile', true));
    $agent_email = is_email(get_post_meta($post->ID, 'agent_email', true));
    $agent_posit = esc_html(get_post_meta($post->ID, 'agent_position', true));
    if (function_exists('icl_translate')) {
        $agent_posit = icl_translate('wpestate', 'agent_position', esc_html(get_post_meta($post->ID, 'agent_position', true)));
    } else {
        $agent_posit = esc_html(get_post_meta($post->ID, 'agent_position', true));
    }

    $agent_facebook = esc_html(get_post_meta($post->ID, 'agent_facebook', true));
    $agent_twitter = esc_html(get_post_meta($post->ID, 'agent_twitter', true));
    $agent_linkedin = esc_html(get_post_meta($post->ID, 'agent_linkedin', true));
    $agent_pinterest = esc_html(get_post_meta($post->ID, 'agent_pinterest', true));
    $name = get_the_title();
    $content = apply_filters('the_content', get_the_content());
    $content = str_replace(']]>', ']]&gt;', $content);
endwhile; // end of the loop.   
wp_reset_postdata();
$comments_data = wpestate_review_composer($agent_id);
wp_reset_postdata();
?>

<div class="owner-page-wrapper">

    <div class="owner-page-wrapper-inside row">

        <div class="col-md-2">
            <div class="owner-image-container" style="background-image: url('<?php echo $preview_img; ?>');"></div>
        </div>    
        <div class="col-md-10">
            <h1 class="entry-title-agent"><?php echo ucfirst($vendor->user_data->display_name); ?></h1>
            <?php if (isset($comments_data['list_rating'])) { ?>
                <div class="property_ratings_agent">
                    <?php
                    $counter = 0;
                    while ($counter < 5) {
                        $counter++;
                        if ($counter <= $comments_data['list_rating']) {
                            print '<i class="fa fa-star"></i>';
                        } else {
                            print '<i class="fa fa-star-o"></i>';
                        }
                    }
                    ?>
                    <span class="owner_total_reviews">(<?php
                        if (isset($comments_data['coments_no'])) {
                            echo $comments_data['coments_no'];
                        }
                        ?>)</span>
                    <br>
                    <?php
                    if (empty($comments_data['coments_no'])) {
                        echo 'No one has rated ' . ucfirst($vendor->user_data->display_name);
                    }
                    ?>
                </div>
            <?php } ?>
            <div class="agent_menu">
                <?php
                $user_to_agent = wpestate_user_booked_from_agent($userID, $user_agent_id);
                $agent_to_user = wpestate_user_booked_from_agent($user_agent_id, $userID);
                if (is_user_logged_in() && ($user_to_agent == 1 || $agent_to_user == 1 || $userID == $user_agent_id )) {

                    print '<div class="owner_contact_details phonedetails">';
                    if ($agent_phone) {
                        print '<div class="property_menu_item"><span class="contact_title"><i class="fa fa-phone"></i></span> <a href="tel:' . $agent_phone . '">' . $agent_phone . '</a></div>';
                    }

                    if ($agent_mobile) {
                        print '<div class="property_menu_item"><span class="contact_title"><i class="fa fa-mobile"></i></span> <a href="tel:' . $agent_mobile . '">' . $agent_mobile . '</a></div>';
                    }
                    print '</div>';

                    print '<div class="owner_contact_details">';
                    if ($agent_email) {
                        print '<div class="property_menu_item agent_email_class"><span class="contact_title"><i class="fa fa-envelope-o"></i></span> <a href="mailto:' . $agent_email . '">' . $agent_email . '</a></div>';
                    }
                    if ($agent_skype) {
                        print '<div class="property_menu_item"><span class="contact_title"><i class="fa fa-skype"></i></span> ' . $agent_skype . '</div>';
                    }

                    print '</div>';
                }
                ?>

            </div>  

            <?php
            if (is_user_logged_in() && ( $user_to_agent == 1 || $agent_to_user == 1 || $userID == $user_agent_id )) {
                ?>
                <!--  <div class="social_icons_owner"> -->
                <div class="property_menu_item social_icons_owner">
                    <?php
                    if ($agent_facebook != '') {
                        print ' <a href="' . $agent_facebook . '"><i class="fa fa-facebook"></i></a>';
                    }
                    if ($agent_twitter != '') {
                        print ' <a href="' . $agent_twitter . '"><i class="fa fa-twitter"></i></a>';
                    }
                    if ($agent_linkedin != '') {
                        print ' <a href="' . $agent_linkedin . '"><i class="fa fa-linkedin"></i></a>';
                    }
                    if ($agent_pinterest != '') {
                        print ' <a href="' . $agent_pinterest . '"><i class="fa fa-pinterest"></i></a>';
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <div class="agent_personal_details" id="about_me">
                <?php print $content; ?>
            </div>
            <div id="contact_me_long_owner" class=" owner_read_more" data-postid="<?php echo $agent_id; ?>"><?php esc_html_e('Contact Owner', 'wpestate'); ?></div>
        </div>   
    </div> 
</div> 
<?php if (isset($comments_data['list_rating']) && $comments_data['list_rating'] !== 0) { ?>
    <div class="owner-page-wrapper-reviews">
        <div class="owner-page-wrapper-inside">
            <?php get_template_part('templates/agent_reviews'); ?>
        </div>     
    </div>
<?php } ?>