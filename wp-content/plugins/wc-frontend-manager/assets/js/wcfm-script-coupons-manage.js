jQuery(document).ready( function($) {
	// Collapsible
  $('.page_collapsible').collapsible({
		defaultOpen: 'wcfm_general_options',
		speed: 'slow',
		loadOpen: function (elem) { //replace the standard open state with custom function
				elem.next().show();
		},
		loadClose: function (elem, opts) { //replace the close state with custom function
				elem.next().hide();
		}
	});
	$('.page_collapsible').collapsible('closeAll');
	$('.page_collapsible:first').collapsible('open');
	
	// Datepicker
	$('.wcfm_datepicker').each(function() {
	  $(this).datepicker({
      dateFormat : 'yy-mm-d',
      changeMonth: true,
      changeYear: true
    });
  });
  
	function wcfm_coupons_manage_form_validate() {
		$is_valid = true;
		$('.wcfm-message').html('').removeClass('wcfm-error').slideUp();
		var title = $.trim($('#wcfm_coupons_manage_form').find('#title').val());
		if(title.length == 0) {
			$is_valid = false;
			$('#wcfm_coupons_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + wcfm_coupons_manage_messages.no_title).addClass('wcfm-error').slideDown();
		}
		return $is_valid;
	}
	
	// Draft Coupon
	$('#wcfm_coupon_manager_draft_button').click(function(event) {
	  event.preventDefault();
	  
	  // Validations
	  $is_valid = wcfm_coupons_manage_form_validate();
	  
	  if($is_valid) {
			$('#wcfm-content').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			var data = {
				action                   : 'wcfm_ajax_controller',
				controller               : 'wcfm-coupons-manage',
				wcfm_coupons_manage_form : $('#wcfm_coupons_manage_form').serialize(),
				status                   : 'draft'
			}	
			$.post(woocommerce_params.ajax_url, data, function(response) {
				if(response) {
					$response_json = $.parseJSON(response);
					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
					if($response_json.status) {
						$('#wcfm_coupons_manage_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + $response_json.message).addClass('wcfm-success').slideDown();
					} else {
						$('#wcfm_coupons_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + $response_json.message).addClass('wcfm-error').slideDown();
					}
					if($response_json.id) $('#coupon_id').val($response_json.id);
					$('#wcfm-content').unblock();
				}
			});	
		}
	});
	
	// Submit Coupon
	$('#wcfm_coupon_manager_submit_button').click(function(event) {
	  event.preventDefault();
	  
	  // Validations
	  $is_valid = wcfm_coupons_manage_form_validate();
	  var _this = $(this);
	  if($is_valid) {
	  		$('.loading_icon').show();
	  		_this.attr('disabled', 'disabled');
			$('#wcfm-content').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			var data = {
				action                   : 'wcfm_ajax_controller',
				controller               : 'wcfm-coupons-manage',
				wcfm_coupons_manage_form : $('#wcfm_coupons_manage_form').serialize(),
				status                   : 'submit'
			}	
			$.post(woocommerce_params.ajax_url, data, function(response) {
				if(response) {
					$response_json = $.parseJSON(response);
					if($response_json.status) {
						window.location = $response_json.redirect;
					} else {
						$('.wcfm-message').html('').removeClass('wcfm-success').slideUp();
						$('#wcfm_coupons_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + $response_json.message).addClass('wcfm-error').slideDown();
						$('.loading_icon').hide();
		  				_this.removeAttr('disabled', 'disabled');
					}
					if($response_json.id) $('#coupon_id').val($response_json.id);
					$('#wcfm-content').unblock();
				}
			});
		}
	});
} );