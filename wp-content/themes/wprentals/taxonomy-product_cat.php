<?php
get_header();
global $term;
global $taxonmy;
global $options;
$options        =   wpestate_page_details('');
$filtred        =   0;
$show_compare   =   1;
$compare_submit =   wpestate_get_compare_link();


$taxonmy    = get_query_var('taxonomy');
$term       = get_query_var( 'term' );

$args = array(
    'post_type'         => 'product',
    'post_status'       => 'publish',
    'paged'             => $paged,
    'orderby'           => 'meta_value',
    'order'             => 'DESC',
    'tax_query' => array(
		array(
			'taxonomy' => $taxonmy,
			'field'    => 'slug',
			'terms'    => $term,
		),
	),
);
$prop_selection = new WP_Query($args);

$property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));

if ( $property_list_type_status == 2 ){
    get_template_part('templates/normal_map_core');
}else{
    get_template_part('templates/normal_map_core');
}

wp_localize_script('wpestate_googlecode_regular', 'googlecode_regular_vars2', array('markers2'           =>  $selected_pins,));
get_footer(); 
?>