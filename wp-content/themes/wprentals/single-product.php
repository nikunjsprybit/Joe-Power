<?php
// Single Equipment
// Wp Estate Pack
get_header();
global $feature_list_array;
global $propid;
global $post_attachments;
global $options;

global $where_currency;
global $property_description_text;
global $property_details_text;
global $property_features_text;
global $property_adr_text;
global $property_price_text;
global $property_pictures_text;
global $propid;
global $gmap_lat;
global $gmap_long;
global $unit;
global $currency;
global $use_floor_plans;
global $wpdb;


$current_user = wp_get_current_user();
$propid = $post->ID;

$bookingData = $wpdb->get_results("select post_id from wp_postmeta where meta_key = '_booking_product_id' and meta_value = '".$propid."'");
$dateRange = $bookStartDate = $bookEndDate = $bookpostArray = array();
foreach ($bookingData as $key => $value) {
    $bookStartDate[$key] = date('Y-m-d', strtotime(get_post_meta($value->post_id, '_booking_start', true)));
    $bookEndDate[$key] = date('Y-m-d', strtotime(get_post_meta($value->post_id, '_booking_end', true)));

    $begin = new DateTime($bookStartDate[$key]);
    $end = new DateTime($bookEndDate[$key]);
    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

    foreach ($daterange as $date) {
        array_push($dateRange, $date->format("Y-m-d"));
    }
    array_push($dateRange, $bookEndDate[$key]);
}

$bookinDates = implode('","', $dateRange);


$options = wpestate_page_details($post->ID);
$gmap_lat = floatval(get_post_meta($post->ID, 'property_latitude', true));
$gmap_long = floatval(get_post_meta($post->ID, 'property_longitude', true));
$unit = esc_html(get_option('wp_estate_measure_sys', ''));
$currency = esc_html(get_option('wp_estate_currency_label_main', ''));
$use_floor_plans = intval(get_post_meta($post->ID, 'use_floor_plans', true));

$data = get_post_meta($propid, '_booking_product_id');


if (function_exists('icl_translate')) {
    $where_currency = icl_translate('wpestate', 'wp_estate_where_currency_symbol', esc_html(get_option('wp_estate_where_currency_symbol', '')));
    $property_description_text = icl_translate('wpestate', 'wp_estate_property_description_text', esc_html(get_option('wp_estate_property_description_text')));
    $property_details_text = icl_translate('wpestate', 'wp_estate_property_details_text', esc_html(get_option('wp_estate_property_details_text')));
    $property_features_text = icl_translate('wpestate', 'wp_estate_property_features_text', esc_html(get_option('wp_estate_property_features_text')));
    $property_adr_text = icl_translate('wpestate', 'wp_estate_property_adr_text', esc_html(get_option('wp_estate_property_adr_text')));
    $property_price_text = icl_translate('wpestate', 'wp_estate_property_price_text', esc_html(get_option('wp_estate_property_price_text')));
    $property_pictures_text = icl_translate('wpestate', 'wp_estate_property_pictures_text', esc_html(get_option('wp_estate_property_pictures_text')));
} else {
    $where_currency = esc_html(get_option('wp_estate_where_currency_symbol', ''));
    $property_description_text = esc_html(get_option('wp_estate_property_description_text'));
    $property_details_text = esc_html(get_option('wp_estate_property_details_text'));
    $property_features_text = esc_html(get_option('wp_estate_property_features_text'));
    $property_adr_text = stripslashes(esc_html(get_option('wp_estate_property_adr_text')));
    $property_price_text = esc_html(get_option('wp_estate_property_price_text'));
    $property_pictures_text = esc_html(get_option('wp_estate_property_pictures_text'));
}


$agent_id = '';
$content = '';
$userID = $current_user->ID;
$user_option = 'favorites' . $userID;
$curent_fav = get_option($user_option);
$favorite_class = 'isnotfavorite';
$favorite_text = esc_html__('Add to Favorites', 'wpestate');
$feature_list = esc_html(get_option('wp_estate_feature_list'));
$feature_list_array = explode(',', $feature_list);
$pinteres = array();
$property_city = get_the_term_list($post->ID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($post->ID, 'property_area', '', ', ', '');



$property_category = get_the_term_list($post->ID, 'property_category', '', ', ', '');
$property_category_terms = get_the_terms($post->ID, 'property_category');

if (is_array($property_category_terms)) {
    $temp = array_pop($property_category_terms);
    $property_category_terms_icon = $temp->slug;
    $place_id = $temp->term_id;
    $term_meta = get_option("taxonomy_$place_id");
    if (isset($term_meta['category_icon_image']) && $term_meta['category_icon_image'] != '') {
        $property_category_terms_icon = $term_meta['category_icon_image'];
    } else {
        $property_category_terms_icon = get_template_directory_uri() . '/img/' . $temp->slug . '-ico.png';
    }
}



$property_action = get_the_term_list($post->ID, 'property_action_category', '', ', ', '');
$property_action_terms = get_the_terms($post->ID, 'property_action_category');

if (is_array($property_action_terms)) {
    $temp = array_pop($property_action_terms);
    $place_id = $temp->term_id;
    $term_meta = get_option("taxonomy_$place_id");
    if (isset($term_meta['category_icon_image']) && $term_meta['category_icon_image'] != '') {
        $property_action_terms_icon = $term_meta['category_icon_image'];
    } else {
        $property_action_terms_icon = get_template_directory_uri() . '/img/' . $temp->slug . '-ico.png';
    }
}

$slider_size = 'small';
$guests = floatval(get_post_meta($post->ID, 'guest_no', true));
$bedrooms = floatval(get_post_meta($post->ID, 'property_bedrooms', true));
$bathrooms = floatval(get_post_meta($post->ID, 'property_bathrooms', true));

$status = stripslashes(esc_html(get_post_meta($post->ID, 'property_status', true)));
if (function_exists('icl_translate')) {
//    $status     =   icl_translate('wpestate','wp_estate_property_status_'.$status, $status ) ;     
    $status = apply_filters('wpml_translate_single_string', $property_status, 'wpestate', 'property_status_' . $property_status);
}

if ($curent_fav) {
    if (in_array($post->ID, $curent_fav)) {
        $favorite_class = 'isfavorite';
        $favorite_text = esc_html__('Favorite', 'wpestate') . '<i class="fa fa-star"></i>';
    }
}

if (has_post_thumbnail()) {
    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_full_map');
}


if ($options['content_class'] == 'col-md-12') {
    $slider_size = 'full';
}
?>


<?php
$listing_page_type = get_option('wp_estate_listing_page_type', '');
do_action('woocommerce_before_single_product');
if ($listing_page_type == 2) {
    get_template_part('templates/equ_listing_page_1');
} else {
    get_template_part('templates/equ_listing_page_1');
}
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery(".wc-bookings-booking-form-button.single_add_to_cart_button.button").attr('disabled', true);
        var today, prev_date, prev_date_string;
        today = new Date();

        jQuery("#start_date1,#end_date1").blur();

        var array = ["<?php echo $bookinDates; ?>"];
        jQuery("#start_date1").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: today,
            beforeShowDay: function (date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [array.indexOf(string) == -1]
            }
        }, jQuery.datepicker.regional[control_vars.datepick_lang]).focus(function () {
            jQuery(this).blur()
        }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');

        jQuery("#start_date1").change(function () {
            var arrays = ["<?php echo $bookinDates; ?>"];
            prev_date = wpestate_UTC_addDays(jQuery('#start_date1').val(), 0);
            jQuery("#end_date1").removeAttr('disabled');
            jQuery("#end_date1").datepicker("destroy");
            jQuery("#end_date1").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: prev_date,
                beforeShowDay: function (dates) {
                    var strings = jQuery.datepicker.formatDate('yy-mm-dd', dates);
                    return [arrays.indexOf(strings) == -1]
                }
            }, jQuery.datepicker.regional[control_vars.datepick_lang]);
        });


        jQuery("#end_date1").change(function () {
            jQuery(".wc-bookings-booking-form-button.single_add_to_cart_button.button").removeAttr('disabled');
        });
        jQuery("#end_date1").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: today,
        }, jQuery.datepicker.regional[control_vars.datepick_lang]).focus(function () {
            jQuery(this).blur()
        });
    });
</script>

<?php
get_footer();
?>