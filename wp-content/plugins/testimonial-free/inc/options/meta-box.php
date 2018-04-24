<?php

function sp_testimonial_free_meta_box() {
	add_meta_box( 'sp_testimonial_free_meta_box_section', esc_html__('Testimonial Options', 'testimonial-free'),
		'display_sp_testimonial_free_meta_box',
		'testimonial-free', 'normal', 'high'
	);
}
add_action( 'admin_init', 'sp_testimonial_free_meta_box' );


function display_sp_testimonial_free_meta_box( $client_designation) {
	//
	$tf_designation = esc_html( get_post_meta( $client_designation->ID, 'tf_designation', true ) );

	?>
	<div class="sp-meta-box-framework">

		<div class="sp-mb-element sp-mb-field-text">
			<div class="sp-mb-title">
				<label for="tf_client_designation"><?php esc_html_e('Designation:', 'testimonial-free') ?></label>
				<p class="sp-mb-desc"><?php esc_html_e('Type client designation here.', 'testimonial-free') ?></p>
			</div>
			<div class="sp-mb-field-set">
				<input type="text" id="tf_client_designation" name="tf_client_designation" value="<?php echo esc_html($tf_designation); ?>"/>
			</div>
			<div class="clear"></div>
		</div>

	</div>

	<?php
}


function add_sp_testimonial_free_fields( $client_designation_id, $client_designation) {

	if ( $client_designation->post_type == 'testimonial-free' ) {
		// Store data in post meta table if present in post data
		$tf_client_designation = sanitize_text_field($_POST['tf_client_designation']);

		if ( isset($tf_client_designation ) ) {
			update_post_meta( $client_designation_id, 'tf_designation', $tf_client_designation );
		}
	}
}
add_action( 'save_post', 'add_sp_testimonial_free_fields', 10, 2 );