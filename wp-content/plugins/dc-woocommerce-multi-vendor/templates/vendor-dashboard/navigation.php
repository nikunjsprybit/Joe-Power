<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH')) {
    exit;
}
global $WCMp;

sksort($nav_items, 'position', true);
$vendor = get_wcmp_vendor(get_current_user_id());
if (!$vendor->image) {
    $vendor->image = $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
}

$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  

$user_title             =   get_the_author_meta( 'title' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );

$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$user_small_picture     =   wp_get_attachment_image_src( $image_id, 'thumbnail');
$user_small_picture_img =   $user_small_picture[0];
if($user_small_picture_img==''){
    $user_small_picture_img=get_template_directory_uri().'/img/default_user.png';
}


$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/img/default_user.png';
}

do_action('wcmp_before_vendor_dashboard_navigation');
?>
<div class="user_tab_menu col-md-3" id="user_tab_menu_container"> <!-- wcmp_side_menu  -->
    <div class="wcmp_top_logo_div"> 
        <div class="profile-image-wrapper">
            <div id="profile-image-menu"  
                data-profileurl="<?php echo $user_custom_picture;?>" 
                data-smallprofileurl="<?php echo $image_id;?>" 
                style="background-image: url('<?php echo $user_small_picture_img; ?>');"></div>
            <div class="profile_wellcome"><?php echo $user_login;?></div>        
        </div>
        <h3 class="profile_wellcome">
            <?php echo get_user_meta(get_current_user_id(), '_vendor_page_title', true) ? get_user_meta(get_current_user_id(), '_vendor_page_title', true) : __('Shop Name', $WCMp->text_domain); ?>
        </h3>
        <ul class="shop_url">
            <li class="shop"><a target="_blank" href="<?php echo apply_filters('wcmp_vendor_shop_permalink', $vendor->permalink); ?>"><?php _e('Shop', $WCMp->text_domain); ?></a> </li>
            <?php if (apply_filters('wcmp_show_vendor_announcements', true)) : ?>
                <li class="announcements"><a target="_self" href="<?php echo wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_vendor_announcements_endpoint', 'vendor', 'general', 'vendor-announcements')); ?>"><?php _e('Announcements', $WCMp->text_domain); ?></a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="custom_user_dashboard user_dashboard_links">
        <ul>
            <?php foreach ($nav_items as $key => $item): ?>
                <?php if (current_user_can($item['capability']) || $item['capability'] === true): ?>
                    <li class="<?php if(!empty($item['submenu'])){ echo 'hasmenu';} ?>">
                        <?php if(array_key_exists($WCMp->endpoints->get_current_endpoint(), $item['submenu'])){ $force_active = true;} else {$force_active = false;}
                        if ($item['label'] == 'Dashboard') { $url = site_url().'/wcmp/'; } else{ $url = $item['url']; }
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="<?php echo $item['link_target'] ?>" data-menu_item="<?php echo $key ?>" class="<?php echo implode(' ', array_map('sanitize_html_class', wcmp_get_vendor_dashboard_nav_item_css_class($key, $force_active))); ?>  <?php if(in_array('active', wcmp_get_vendor_dashboard_nav_item_css_class($key, $force_active))){ echo 'user_tab_active'; } ?>">
                            <i class=" <?php echo $item['nav_icon'] ?>"></i>
                            <span class="writtings"><?php echo esc_html($item['label']); ?></span>
                        </a>
                        <?php if ( ($item['label'] != 'Dashboard') && !empty($item['submenu']) && is_array($item['submenu'])): sksort($item['submenu'], 'position', true) ?>
                        <ul class="submenu" <?php if(!in_array('active', wcmp_get_vendor_dashboard_nav_item_css_class($key, $force_active))){ echo 'style="display:none"'; } ?>>
                                <?php foreach ($item['submenu'] as $submenukey => $submenu): ?>
                                    <?php
                                    if ($submenu['label'] == 'Add Product') {
                                        $submenuUrl = site_url().'/add-new-equipment/';;
                                        $submenulabel = 'Add New Equipment';
                                    } elseif ($submenu['label'] == 'Products') {
                                        $submenuUrl = site_url().'/user-dashboard/';
                                        $submenulabel = 'My Equipments';
                                    } elseif ($submenu['label'] == 'by Date') {
                                        $submenuUrl = site_url().'/reports/';
                                        $submenulabel = $submenu['label'];
                                    } elseif ($submenu['label'] == 'Out of stock') {
                                        $submenuUrl = site_url().'/reports/?status=stock-report';
                                        $submenulabel = $submenu['label'];
                                    } else{
                                        $submenuUrl = $submenu['url'];
                                        $submenulabel = $submenu['label'];
                                    }
                                    if ( $submenu['label'] != 'Shipping') { ?>
                                        <?php if(current_user_can($submenu['capability']) || $submenu['capability'] === true): ?>
                                            <li class="<?php echo implode(' ', array_map('sanitize_html_class', wcmp_get_vendor_dashboard_nav_item_css_class($submenukey))); ?>">
                                                <a href="<?php echo esc_url($submenuUrl); ?>" target="<?php echo $submenu['link_target'] ?>">- <?php echo esc_html($submenulabel); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php do_action('wcmp_after_vendor_dashboard_navigation'); ?>