jQuery(document).ready( function($) {
	if( $("#timezone").length > 0 ) {
		$("#timezone").select2({
			placeholder: "Choose ..."
		});
	}
	
	// Save Settings
	$('#wcfmsettings_save_button').click(function(event) {
	  event.preventDefault();
	  
	  var profile = '';
		if( ( typeof tinyMCE != 'undefined' ) && tinyMCE.activeEditor) profile = tinyMCE.activeEditor.getContent();
  
	  // Validations
	  $is_valid = true; //wcfm_coupons_manage_form_validate();
	  
	  if($is_valid) {
			$('#wcfm_settings_form').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			var data = {
				action             : 'wcfm_ajax_controller',
				controller         : 'wcfm-settings',
				wcfm_settings_form : $('#wcfm_settings_form').serialize(),
				profile            : profile
			}	
			$.post(woocommerce_params.ajax_url, data, function(response) {
				if(response) {
					$response_json = $.parseJSON(response);
					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
					if($response_json.status) {
						$('#wcfm_settings_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + $response_json.message).addClass('wcfm-success').slideDown();
						if( $response_json.file ) $('#wcfm_custom_css-css').attr( 'href', $response_json.file );
					} else {
						$('#wcfm_settings_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + $response_json.message).addClass('wcfm-error').slideDown();
					}
					$('#wcfm_settings_form').unblock();
				}
			});	
		}
	});
});