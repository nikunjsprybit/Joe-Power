<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

// Testimonial Free shortcode
function sp_testimonial_free_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'color'      => '#52b3d9',
		'nav'        => 'true',
		'pagination' => 'true',
		'autoplay' => 'true',
	), $atts, 'testimonial-free' ) );


	$args = array(
		'post_type'      => 'testimonial-free',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => -1,
	);

	$que = new WP_Query( $args );


	$custom_id = uniqid();

	$outline = '';

	$outline .= '
    <script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery("#sp-testimonial-free' . $custom_id . '").owlCarousel({
			items: 1,
			singleItem : true,
			navigation: ' . $nav . ',
			navigationText: ["<i class=\'fa fa-angle-left\'></i>","<i class=\'fa fa-angle-right\'></i>"],
			pagination: ' . $pagination . ',
			autoHeight: true,
			autoPlay: '.$autoplay.',
			slideSpeed: 900,
			stopOnHover: false,
		});

    });
    </script>';


	if ( $nav == 'false' ) {
		echo "<style type='text/css'>
				.sp-testimonial-section .testimonial-free{
					margin: 0;
				}
				.sp-testimonial-section .owl-controls .owl-buttons div:hover{
					color: #000;
				}
				</style>";
	}


	$outline .= '<style type="text/css">
				.sp-testimonial-section .owl-controls .owl-buttons div:hover{
					color: ' . $color . ';
				}
				.sp-testimonial-section .owl-controls .owl-pagination .owl-page.active{
					background-color: ' . $color . ';
				}
				</style>';

	$outline .= '<div id="sp-testimonial-free' . $custom_id . '" class="sp-testimonial-section">';
	if ( $que->have_posts() ) {
		while ( $que->have_posts() ) : $que->the_post();

			$tf_designation = esc_html( get_post_meta( get_the_ID(), 'tf_designation', true ) );


			$outline .= '<div class="testimonial-free text-center">';
			if ( has_post_thumbnail( $que->post->ID ) ) {
				$outline .= '<div class="tf-client-image">';
				$outline .= get_the_post_thumbnail( $que->post->ID, 'tf-client-image-size', array( 'class' => "tf-client-img" ) );
				$outline .= '</div>';
			}
			$outline .= '<div class="tf-client-testimonial">';
			$outline .= get_the_content();
			$outline .= '</div>';
			$outline .= '<h2 class="tf-client-name">';
			$outline .= get_the_title();
			$outline .= '</h2>';
			if ( $tf_designation ) {
				$outline .= '<h6 class="tf-client-designation">';
				$outline .= $tf_designation;
				$outline .= '</h6>';
			}


			$outline .= '</div>'; //testimonial free


		endwhile;
	} else {
		$outline .= '<h2 class="sp-not-found-any-testimonial">' . esc_html__( 'No testimonials found', 'testimonial-free' ) . '</h2>';
	}
	$outline .= '</div>';


	wp_reset_query();


	return $outline;

}

add_shortcode( 'testimonial-free', 'sp_testimonial_free_shortcode' );