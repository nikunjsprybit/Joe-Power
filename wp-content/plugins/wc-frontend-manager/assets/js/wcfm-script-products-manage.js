var removed_person_types = [];
jQuery( document ).ready( function( $ ) {
	
	
	// Collapsible
	$('.page_collapsible').collapsible({
		defaultOpen: 'wcfm_products_manage_form_general_head',
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
	
	$("#product_cats").select2({
		placeholder: "Choose ..."
	});
	
	$('.product_taxonomies').each(function() {
	  $("#" + $(this).attr('id')).select2({
			placeholder: "Choose " + $(this).attr('id') + " ..."
		});
	});
	
	$("#upsell_ids").select2({
		placeholder: "Choose ..."
	});
	
	$("#crosssell_ids").select2({
		placeholder: "Choose ..."
	});
	
	$("#grouped_products").select2({
		placeholder: "Choose ..."
	});
	
	$('.variations').click(function() {
		if($(this).hasClass('collapse-open')) {
			resetVariationsAttributes();
		}
	});
	
	function addVariationManageStockProperty() {
		$('.variation_manage_stock_ele').each(function() {
			$(this).off('change').on('change', function() {
				if($(this).is(':checked')) {
					$(this).parent().find('.variation_non_manage_stock_ele').removeClass('non_stock_ele_hide');
				} else {
					$(this).parent().find('.variation_non_manage_stock_ele').addClass('non_stock_ele_hide');
				}
			}).change();
		});
		
		$('.variation_is_virtual_ele').each(function() {
			$(this).off('change').on('change', function() {
				if($(this).is(':checked')) {
					$(this).parent().find('.variation_non_virtual_ele').addClass('non_virtual_ele_hide');
				} else {
					$(this).parent().find('.variation_non_virtual_ele').removeClass('non_virtual_ele_hide');
				}
			}).change();
		});
		
		$('.variation_is_downloadable_ele').each(function() {
			$(this).off('change').on('change', function() {
				if($(this).is(':checked')) {
					$(this).parent().find('.variation_downloadable_ele').removeClass('downloadable_ele_hide');
					$(this).parent().find('.variation_downloadable_ele').next('.upload_button').removeClass('downloadable_ele_hide');
				} else {
					$(this).parent().find('.variation_downloadable_ele').addClass('downloadable_ele_hide');
					$(this).parent().find('.variation_downloadable_ele').next('.upload_button').addClass('downloadable_ele_hide');
				}
			}).change();
		});
	}
	addVariationManageStockProperty();
	
	$('.manage_stock_ele').change(function() {
	  if($(this).is(':checked')) {
	  	$(this).parent().find('.non_manage_stock_ele').removeClass('non_stock_ele_hide');
	  } else {
	  	$(this).parent().find('.non_manage_stock_ele').addClass('non_stock_ele_hide');
	  }
	}).change();
	
	$('.variation_manage_stock').change(function() {
	  if($(this).is(':checked')) {
	  	$(this).parent().find('.variation_non_manage_stock').removeClass('non_stock_ele_hide');
	  } else {
	  	$(this).parent().find('.variation_non_manage_stock').addClass('non_stock_ele_hide');
	  }
	}).change();
	
	if($('#product_type').length > 0) {
		var pro_types = [ "simple", "variable", "grouped", "external", "booking" ];
		$('#product_type').change(function() {
			var product_type = $(this).val();
			$('#wcfm_products_manage_form .page_collapsible').addClass('wcfm_head_hide');
			$('#wcfm_products_manage_form .wcfm-container').addClass('wcfm_block_hide');
			$('.wcfm_ele').addClass('wcfm_ele_hide');
			
			$('.'+product_type).removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
			
			if( $.inArray( product_type, pro_types ) == -1 ) {
				$('.simple').removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
				$('.non-'+product_type).addClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
				product_type = 'simple';
			}
			
			if( product_type != 'simple' ) {
				$('#is_downloadable').attr( 'checked', false );
				$('#is_virtual').attr( 'checked', false );
			}
			$('#is_downloadable').change();
			$('#is_virtual').change();
		}).change();
		
		// Downloadable
		$('#is_downloadable').change(function() {
		  if($(this).is(':checked')) {
		  	$('.downlodable').removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  } else {
		  	$('.downlodable').addClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  }
		}).change();
		$('.is_downloadable_hidden').change(function() {
		  if($(this).val() == 'enable') {
		  	$('.downlodable').removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  } else {
		  	$('.downlodable').addClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  }
		}).change();
		if($('#is_downloadable').length == 0) $('.downlodable').addClass('downloadable_ele_hide');
		
		// Virtual
		$('#is_virtual').change(function() {
		  if($(this).is(':checked')) {
		  	$('.nonvirtual').addClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  } else {
		  	$('.nonvirtual').removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  }
		}).change();
		$('.is_virtual_hidden').change(function() {
		  if($(this).val() == 'enable') {
		  	$('.nonvirtual').addClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  } else {
		  	$('.nonvirtual').removeClass('wcfm_ele_hide wcfm_block_hide wcfm_head_hide');
		  }
		}).change();
	} else {
		$('#wcfm_products_manage_form .page_collapsible').addClass('wcfm_head_hide');
		$('#wcfm_products_manage_form .wcfm-container').addClass('wcfm_block_hide');
		$('.wcfm_ele').addClass('wcfm_ele_hide');
	}
	
	$('.wcfm_datepicker').each(function() {
	  $(this).datepicker({
      dateFormat : $(this).data('date_format'),
      changeMonth: true,
      changeYear: true
    });
  });
  
  $( "#sale_date_from" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#sale_date_upto" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#sale_date_upto" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#sale_date_from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
  $('.multi_input_holder').each(function() {
	  var multi_input_holder = $(this);
	  addMultiInputProperty(multi_input_holder);
	});
	
	function addMultiInputProperty(multi_input_holder) {
	  if(multi_input_holder.children('.multi_input_block').length == 1) multi_input_holder.children('.multi_input_block').children('.remove_multi_input_block').css('display', 'none'); 
    multi_input_holder.children('.multi_input_block').each(function() {
      if($(this)[0] != multi_input_holder.children('.multi_input_block:last')[0]) {
        $(this).children('.add_multi_input_block').remove();
      }
    });
    
    multi_input_holder.children('.multi_input_block').children('.add_multi_input_block').off('click').on('click', function() {
      var holder_id = multi_input_holder.attr('id');
      var holder_name = multi_input_holder.data('name');
      var multi_input_blockCount = multi_input_holder.data('length');
      multi_input_blockCount++;
      var multi_input_blockEle = multi_input_holder.children('.multi_input_block:first').clone(false);
      
      multi_input_blockEle.find('textarea,input:not(input[type=button],input[type=submit],input[type=checkbox],input[type=radio])').val('');
       multi_input_blockEle.find('input[type=checkbox]').attr('checked', false);
      multi_input_blockEle.children('.wcfm-wp-fields-uploader,.multi_input_block_element:not(.multi_input_holder)').each(function() {
        var ele = $(this);
        var ele_name = ele.data('name');
        if(ele.hasClass('wcfm-wp-fields-uploader')) {
					var uploadEle = ele;
					ele_name = uploadEle.find('.multi_input_block_element').data('name');
					uploadEle.find('img').attr('src', '').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_display').addClass('placeHolder');
					uploadEle.find('.multi_input_block_element').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount).attr('name', holder_name+'['+multi_input_blockCount+']['+ele_name+']');
					uploadEle.find('.upload_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_button').show();
					uploadEle.find('.remove_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_remove_button').hide();
					addWCFMUploaderProperty(uploadEle);
				} else {
					ele.attr('name', holder_name+'['+multi_input_blockCount+']['+ele_name+']');
					ele.attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount);
        }
        
        if(ele.hasClass('wcfm_datepicker')) {
          ele.removeClass('hasDatepicker').datepicker({
            dateFormat : ele.data('date_format'),
            changeMonth: true,
            changeYear: true
          });
        } else if(ele.hasClass('time_picker')) {
          $('.time_picker').timepicker('remove').timepicker({ 'step': 15 });
          ele.timepicker('remove').timepicker({ 'step': 15 });
        }
      });
      
      // Nested multi-input block property
      multi_input_blockEle.children('.multi_input_holder').each(function() {
        setNestedMultiInputIndex($(this), holder_id, holder_name, multi_input_blockCount);
      });
       
      
      multi_input_blockEle.children('.remove_multi_input_block').off('click').on('click', function() {
      	var remove_ele_parent = $(this).parent().parent();
				var addEle = remove_ele_parent.children('.multi_input_block').children('.add_multi_input_block').clone(true);
				$(this).parent().remove();
				remove_ele_parent.children('.multi_input_block').children('.add_multi_input_block').remove();
				remove_ele_parent.children('.multi_input_block:last').append(addEle);
				if(remove_ele_parent.children('.multi_input_block').length == 1) remove_ele_parent.children('.multi_input_block').children('.remove_multi_input_block').css('display', 'none');
			});
      
      multi_input_blockEle.children('.add_multi_input_block').remove();
      multi_input_holder.append(multi_input_blockEle);
      multi_input_holder.children('.multi_input_block:last').append($(this));
      if(multi_input_holder.children('.multi_input_block').length > 1) multi_input_holder.children('.multi_input_block').children('.remove_multi_input_block').css('display', 'block');
      multi_input_holder.data('length', multi_input_blockCount);
      
      addVariationManageStockProperty();
    });
    
    if(!multi_input_holder.hasClass('multi_input_block_element')) {
			multi_input_holder.children('.multi_input_block').css('padding-bottom', '40px');
		}
		if(multi_input_holder.children('.multi_input_block').children('.multi_input_holder').length > 0) {
			multi_input_holder.children('.multi_input_block').css('padding-bottom', '40px');
		}
    
    multi_input_holder.children('.multi_input_block').children('.remove_multi_input_block').off('click').on('click', function() {
    	var remove_ele_parent = $(this).parent().parent();
      var addEle = remove_ele_parent.children('.multi_input_block').children('.add_multi_input_block').clone(true);
      // For Attributes
      if( $(this).parent().find( $('input[data-name="is_taxonomy"]').data('name') == 1 ) ) {
				$taxonomy = $(this).parent().find( $('input[data-name="tax_name"]') ).val();
				$( 'select.wcfm_attribute_taxonomy' ).find( 'option[value="' + $taxonomy + '"]' ).removeAttr( 'disabled' );
			}
      $(this).parent().remove();
      remove_ele_parent.children('.multi_input_block').children('.add_multi_input_block').remove();
      remove_ele_parent.children('.multi_input_block:last').append(addEle);
      if(remove_ele_parent.children('.multi_input_block').length == 1) remove_ele_parent.children('.multi_input_block').children('.remove_multi_input_block').css('display', 'none');
    });
  }
  
  function resetMultiInputIndex(multi_input_holder) {
  	var holder_id = multi_input_holder.attr('id');
		var holder_name = multi_input_holder.data('name');
		var multi_input_blockCount = 0;
		
		multi_input_holder.find('.multi_input_block').each(function() {
			$(this).children('.wcfm-wp-fields-uploader,.multi_input_block_element:not(.multi_input_holder)').each(function() {
				var ele = $(this);
				var ele_name = ele.data('name');
				if(ele.hasClass('wcfm-wp-fields-uploader')) {
					var uploadEle = ele;
					ele_name = uploadEle.find('.multi_input_block_element').data('name');
					uploadEle.find('img').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_display').addClass('placeHolder');
					uploadEle.find('.multi_input_block_element').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount).attr('name', holder_name+'['+multi_input_blockCount+']['+ele_name+']');
					uploadEle.find('.upload_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_button').show();
					uploadEle.find('.remove_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_remove_button').hide();
				} else {
					var multiple = ele.attr('multiple');
					if (typeof multiple !== typeof undefined && multiple !== false) {
						ele.attr('name', holder_name+'['+multi_input_blockCount+']['+ele_name+'][]');
					} else {
						ele.attr('name', holder_name+'['+multi_input_blockCount+']['+ele_name+']');
					}
					ele.attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount);
				}
			});
			multi_input_blockCount++;
		});
  }
  
  function setNestedMultiInputIndex(nested_multi_input, holder_id, holder_name, multi_input_blockCount) {
		nested_multi_input.children('.multi_input_block:not(:last)').remove();
		var multi_input_id = nested_multi_input.attr('id');
		multi_input_id = multi_input_id.replace(holder_id + '_', '');
		var multi_input_id_splited = multi_input_id.split('_');
		var multi_input_name = '';
		for(var i = 0; i < (multi_input_id_splited.length -1); i++) {
		 if(multi_input_name != '') multi_input_name += '_';
		 multi_input_name += multi_input_id_splited[i];
		}
		nested_multi_input.attr('data-name', holder_name+'['+multi_input_blockCount+']['+multi_input_name+']');
		nested_multi_input.attr('id', holder_id+'_'+multi_input_name+'_'+multi_input_blockCount);
		nested_multi_input.children('.multi_input_block').children('.wcfm-wp-fields-uploader,.multi_input_block_element:not(.multi_input_holder)').each(function() {
		  var ele = $(this);
		  var ele_name = ele.data('name');
		  if(ele.hasClass('wcfm-wp-fields-uploader')) {
				var uploadEle = ele;
				ele_name = uploadEle.find('.multi_input_block_element').data('name');
				uploadEle.find('img').attr('src', '').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_display').addClass('placeHolder');
				uploadEle.find('.multi_input_block_element').attr('id', holder_id+'_'+multi_input_name+'_'+multi_input_blockCount + '_' + ele_name + '_0').attr('name', holder_name+'['+multi_input_blockCount+']['+multi_input_name+'][0]['+ele_name+']');
				uploadEle.find('.upload_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_button').show();
				uploadEle.find('.remove_button').attr('id', holder_id + '_' + ele_name + '_' + multi_input_blockCount + '_remove_button').hide();
				addWCFMUploaderProperty(uploadEle);
			} else {
				var multiple = ele.attr('multiple');
				if (typeof multiple !== typeof undefined && multiple !== false) {
					ele.attr('name', holder_name+'['+multi_input_blockCount+']['+multi_input_name+'][0]['+ele_name+'][]');
				} else {
					ele.attr('name', holder_name+'['+multi_input_blockCount+']['+multi_input_name+'][0]['+ele_name+']');
				}
				ele.attr('id', holder_id+'_'+multi_input_name+'_'+multi_input_blockCount + '_' + ele_name + '_0');
		  }
		  
		  if(ele.hasClass('wcfm_datepicker')) {
				ele.removeClass('hasDatepicker').datepicker({
					dateFormat : ele.data('date_format'),
					changeMonth: true,
					changeYear: true
				});
			} else if(ele.hasClass('time_picker')) {
				$('.time_picker').timepicker('remove').timepicker({ 'step': 15 });
				ele.timepicker('remove').timepicker({ 'step': 15 });
			}
		});
		
		addMultiInputProperty(nested_multi_input);
		
		if(nested_multi_input.children('.multi_input_block').children('.multi_input_holder').length > 0) nested_multi_input.children('.multi_input_block').css('padding-bottom', '40px');
		
		nested_multi_input.children('.multi_input_block').children('.multi_input_holder').each(function() {
			setNestedMultiInputIndex($(this), holder_id+'_'+multi_input_name+'_0', holder_name+'['+multi_input_blockCount+']['+multi_input_name+']', 0);
		});
	}
	
	// Add Taxonomy Attribute Rows.
	$( 'button.wcfm_add_attribute' ).on( 'click', function() {
		var attribute    = $( 'select.wcfm_attribute_taxonomy' ).val();
		
		if(attribute) {
			var data         = {
				action:   'wcfmu_generate_taxonomy_attributes',
				taxonomy: attribute
			};
	
			$('#attributes').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			
			$.ajax({
				type:		'POST',
				url: woocommerce_params.ajax_url,
				data: data,
				success:	function(response) {
					if(response) {
						$response = $(response);
						$('#attributes').append($response.find('.multi_input_block'));
						addMultiInputProperty($('#attributes'));
						resetMultiInputIndex($('#attributes'));
						$('#product_type').change();
						
						$('#attributes').find('.multi_input_block:last').each(function() {
							$(this).find('input[data-name="is_variation"]').change(function() {
								resetVariationsAttributes();
							});
						});
						
						// Fire wcfm-orders table refresh complete
						$( document.body ).trigger( 'updated_taxonomy_attribute' );
					}
				}
			});
		}

		if ( attribute ) {
			$( 'select.wcfm_attribute_taxonomy' ).find( 'option[value="' + attribute + '"]' ).attr( 'disabled','disabled' );
			$( 'select.wcfm_attribute_taxonomy' ).val( '' );
		}
		
		$('#attributes').unblock();
		
		return false;
	});
	
	if($('#select_attributes').length > 0) {
		$('#attributes').append($('#select_attributes').html());
		$('#select_attributes').remove();
		addMultiInputProperty($('#attributes'));
		resetMultiInputIndex($('#attributes'));
		$('#attributes').find('.multi_input_block').find('select').select2({
			placeholder: "Search for a attribute ..."
		});
	}
	
	$('#attributes').find('.multi_input_block').each(function() {
	  if( $(this).find( $('input[data-name="is_taxonomy"]').data('name') == 1 ) ) {
	  	$taxonomy = $(this).find( 'input[data-name="tax_name"]' ).val();
	  	$( 'select.wcfm_attribute_taxonomy' ).find( 'option[value="' + $taxonomy + '"]' ).attr( 'disabled','disabled' );
	  }
	});
	
	$('#attributes').find('.multi_input_block').each(function() {
	  $(this).find('input[data-name="is_variation"]').change(function() {
	    resetVariationsAttributes();
	  });
	});
	
	function resetVariationsAttributes() {
		$('#variations').block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});
		var data = {
			action : 'wcfm_generate_variation_attributes',
			wcfm_products_manage_form : $('#wcfm_products_manage_form').serialize()
		}	
		$.ajax({
			type:		'POST',
			url: woocommerce_params.ajax_url,
			data: data,
			success:	function(response) {
				if(response) {
					$.each($.parseJSON(response), function(attr_name, attr_value) {
						var select_html = '<p class="variations_'+attr_name.toLowerCase()+' wcfm_title attribute_ele_new selectbox_title"><strong>' + jsUcfirst( attr_name.replace( "pa_", "" ) ) + '</strong></p><select name="attribute_'+attr_name.toLowerCase()+'" class="wcfm-select wcfm_ele attribute_ele attribute_ele_new variable multi_input_block_element" data-name="attribute_'+attr_name.toLowerCase()+'"><option value="">Any ' + jsUcfirst( attr_name.replace( "pa_", "" ) ) + ' ..</option>';
						$.each(attr_value, function(k, attr_val) {
							select_html += '<option value="'+k+'">'+attr_val+'</option>';
						});
						
						select_html += '</select>';
						$('#variations').find('.multi_input_block').each(function() {
							if($(this).find('select[data-name="attribute_'+attr_name.toLowerCase()+'"]').length > 0) {
								$attr_selected_val = $(this).find('select[data-name="attribute_'+attr_name.toLowerCase()+'"]').val();
								$(this).find('select[data-name="attribute_'+attr_name.toLowerCase()+'"]').replaceWith($(select_html));
								$(this).find('select[data-name="attribute_'+attr_name.toLowerCase()+'"]').val($attr_selected_val);
							} else if($(this).find('input[data-name="attribute_'+attr_name.toLowerCase()+'"]').length > 0) {
								$attr_selected_val = $(this).find('input[data-name="attribute_'+attr_name.toLowerCase()+'"]').val();
								$(this).find('input[data-name="attribute_'+attr_name.toLowerCase()+'"]').replaceWith($(select_html));
								$(this).find('select[data-name="attribute_'+attr_name.toLowerCase()+'"]').val($attr_selected_val);
							} else {
								$(this).prepend(select_html);
							}
						});
					});
					$('.attribute_ele_old').remove();
					$('.attribute_ele_new').addClass('attribute_ele_old').removeClass('attribute_ele_new');
					resetMultiInputIndex($('#variations'));
					$('#variations').unblock();

					$('#wcfm_products_manage_form .selectbox_title').text('Select Rent and/or sale type');
					$('select option[value=""]').text('Select Rent and/or sale type');
					$('select option[value="equipmentprice"]').text('Equipment Price');
					$('select option[value="rentalrateperday"]').text('Rental Rate/Day');
					$('select option[value="rentalrateperweek"]').text('Rental Rate/Week');
					$('select option[value="rentalratepermonth"]').text('Rental Rate/Month');

					$('#product_parent_cats option[value=""]').text('Choose ...');
					$('#_wc_booking_calendar_display_mode option[value=""]').text('Choose ...');
					$('#attributes_is_variation_0').prop('checked', true);
				}
			},
			dataType: 'html'
		});	
	}
	resetVariationsAttributes();
	
	// Creating Variation attributes
	$('#variations').find('.multi_input_block').each(function() {
		$multi_input_block = $(this);
	  $attributes = $multi_input_block.find('input[data-name="attributes"]');
	  $attributes_val = $attributes.val();
	  if($attributes_val.length > 0) {
	  	$.each($.parseJSON($attributes_val), function(attr_key, attr_val) {
	  		$multi_input_block.prepend('<input type="hidden" name="'+attr_key+'" data-name="'+attr_key+'" value="'+attr_val+'" />');
	  	});
	  }
	});
	
	// Track Deleting Variation
	var removed_variations = [];
	$('#variations').find('.remove_multi_input_block').click(function() {
	  removed_variations.push($(this).parent().find('.variation_id').val());
	});
	
	// step1 validation
	$(document).find(".next_step1").click(function(){
		
		var $next_step	=	jQuery(this).attr('data-nextstep');
		if(wcfm_products_manage_form_validate_step1()){
			jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').trigger('click');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
			});
		}else{
			return false;
		}
	});
	
	// step2 validation
	$(document).find(".next_step2").click(function(){
		
		var $next_step	=	jQuery(this).attr('data-nextstep');
		if(wcfm_products_manage_form_validate_step2()){
			jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').trigger('click');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
			});
		}else{
			return false;
		}
	});
	// step3 validation
	$(document).find(".next_step3").click(function(){
		var $next_step	=	jQuery(this).attr('data-nextstep');
		if(wcfm_products_manage_form_validate_step3()){
			jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').trigger('click');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
			});
		}else{
			return false;
		}
	});
	
	// step4 validation
	$(document).find(".next_step4").click(function(){
		var $next_step	=	jQuery(this).attr('data-nextstep');
		if(wcfm_products_manage_form_validate_step4()){
			jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').trigger('click');
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+$next_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
			});
		}else{
			return false;
		}
	});
	function remove_navbar_active_class(){
		$(document).find(".user_dashboard_panel_guide .nav-tabs a").each(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}
		});
	}
	function remove_tab_content_active_class(){
		$(document).find(".tab-content .tab-pane").each(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}
		});
	}
	$(document).find(".user_dashboard_panel_guide .nav-tabs a").click(function(){
		var selected_step	=	jQuery(this).attr('data-step');
		var stepcount		=	jQuery(this).attr('data-stepcount');
		if(stepcount == 2){
			if(wcfm_products_manage_form_validate_step1()){
			remove_navbar_active_class();
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+selected_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
				});
			}else{
				return false;
			}
		}else if(stepcount == 3){
			if(wcfm_products_manage_form_validate_step2()){
			remove_navbar_active_class();
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+selected_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
				});
			}else{
				return false;
			}
		}else if(stepcount == 4){
			if(wcfm_products_manage_form_validate_step3()){
			remove_navbar_active_class();
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+selected_step+'"]').addClass('active');
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
				});
			}else{
				return false;
			}
		}else if(stepcount == 5){
			if(wcfm_products_manage_form_validate_step4() && wcfm_products_manage_form_validate_step1() && wcfm_products_manage_form_validate_step2() && wcfm_products_manage_form_validate_step3()){
			remove_navbar_active_class();
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+selected_step+'"]').addClass('active');
			if($('.products_manage_availability').hasClass('check_collapsible_open') && $(this).hasClass('menuLinkedpro') ){
				$('.products_manage_costs').addClass('collapse-open').removeClass('collapse-close');
				$('.products_manage_costs_fields').show();

				$('.products_manage_availability').addClass('collapse-open').removeClass('collapse-close').removeClass('check_collapsible_open');
				$('.products_manage_availability_fildes').show();
			}
			jQuery('html, body').animate({
				'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
				});
			}else{
				return false;
			}
		}else{
			remove_navbar_active_class();
			jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#'+selected_step+'"]').addClass('active');
			jQuery('html, body').animate({
			'scrollTop' : jQuery(".user_dashboard_panel_guide").position().top
			});
		}
		
	});
	
	$('.btnPrevious').click(function(){
		var prev_step	=	$(this).data('prevstep');
		$('.user_dashboard_panel_guide .nav-tabs a[href="#'+prev_step+'"]').trigger('click');
		if(prev_step == 'address'){
			$('#image').removeClass('active');
			$('#image').removeClass('in');
		}
	});
	
	function wcfm_products_manage_form_validate_step1() {		
		$is_valid = true;
		var product_subcats = $.trim($('#wcfm_products_manage_form').find('#product_subcats').val());
		var product_parent_cats = $.trim($('#wcfm_products_manage_form').find('#product_parent_cats').val());
		var description = '';
		if(tinyMCE.activeEditor) 
			description = tinyMCE.activeEditor.getContent();
		else
			description = $.trim($('#wcfm_products_manage_form').find('#description').val());
		
		var title = $.trim($('#wcfm_products_manage_form').find('#title').val());
		
		$('#wcfm_products_manage_form .wcfm-message-general').html('').removeClass('wcfm-error');
		$('#product_subcats').next().find(".select2-selection.select2-selection--multiple").removeClass('valreq')
		$('#product_parent_cats').removeClass('valreq')
		$('#title').removeClass('valreq')
		$('#general1 #wp-description-wrap').removeClass('valreqdes')
		if(product_parent_cats.length == 0) {
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-general').html('<span class="wcicon-status-cancelled"></span> Please select Category before submit.').addClass('wcfm-error').slideDown();
			$('#product_parent_cats').addClass('valreq');

			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
			return false;
		} else if(product_subcats.length == 0 && product_parent_cats.length != 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-general').html('<span class="wcicon-status-cancelled"></span> Please select Subcategory before submit.').addClass('wcfm-error').slideDown();
			$('#product_subcats').next().find(".select2-selection.select2-selection--multiple").addClass('valreq');
			
			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}
		else if(title.length == 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-general').html('<span class="wcicon-status-cancelled"></span>' + wcfm_products_manage_messages.no_title).addClass('wcfm-error').slideDown();
			$('#title').addClass('valreq');

			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}
		else if(description.length == 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-general').html('<span class="wcicon-status-cancelled"></span> Please insert description before submit.').addClass('wcfm-error').slideDown();
			$('#general1 #wp-description-wrap').addClass('valreqdes');

			$('html, body').animate({
				'scrollTop' : $(".valreqdes").position().top - 200
			});
		}
		return $is_valid;
	}
	
	function wcfm_products_manage_form_validate_step2() {		
		
		$is_valid = true;
		var property_zip = $.trim($('#wcfm_products_manage_form').find('#property_zip').val());
		var property_county = $.trim($('#wcfm_products_manage_form').find('#property_county').val());
		$('#wcfm_products_manage_form .wcfm-message-address').html('').removeClass('wcfm-error');
		$('#property_county').removeClass('valreq');
		$('#property_zip').removeClass('valreq');
		
		if(property_county.length == 0) {
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-address').html('<span class="wcicon-status-cancelled"></span> Please insert City name before submit.').addClass('wcfm-error').slideDown();
			$('#property_county').addClass('valreq');

			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}
		else if(property_zip.length == 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-address').html('<span class="wcicon-status-cancelled"></span> Please insert Zip Code before submit.').addClass('wcfm-error').slideDown();
			$('#property_zip').addClass('valreq');
			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}
		return $is_valid;
	}
	
	function wcfm_products_manage_form_validate_step3() {		
		
		$is_valid = true;
		var featured_img = $('#wcfm_products_manage_form').find("[name^='featuredimages']");
		$('#wcfm_products_manage_form .wcfm-message-image').html('').removeClass('wcfm-error');
		$('#wcfm_products_manage_form_gallery_expander .box.has-advanced-upload').removeClass('valreqimg');
		
		if(featured_img.length == 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-image').html('<span class="wcicon-status-cancelled"></span> Please select image before submit.').addClass('wcfm-error').slideDown();
			$('#wcfm_products_manage_form_gallery_expander .box.has-advanced-upload').addClass('valreqimg');
			$('html, body').animate({
				'scrollTop' : $(".valreqimg").position().top - 200
			});
		}
		return $is_valid;
	}
	
	function wcfm_products_manage_form_validate_step4() {		
		
		$is_valid = true;
		return $is_valid;
	}
	
	function wcfm_products_manage_form_validate_step5(){		
		
		$is_valid = true;
		var _wc_booking_day_cost = $.trim($('#wcfm_products_manage_form').find('#_wc_booking_day_cost').val());
		var _wc_booking_week_cost = $.trim($('#wcfm_products_manage_form').find('#_wc_booking_week_cost').val());
		var _wc_booking_month_cost = $.trim($('#wcfm_products_manage_form').find('#_wc_booking_month_cost').val());
		$('#wcfm_products_manage_form .wcfm-message-linkedpro').html('').removeClass('wcfm-error');
		$('#wcfm_products_manage_form #_wc_booking_day_cost').removeClass('valreq');
		$('#wcfm_products_manage_form #_wc_booking_week_cost').removeClass('valreq');
		$('#wcfm_products_manage_form #_wc_booking_month_cost').removeClass('valreq');
		
		if(_wc_booking_day_cost.length == 0) {
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-linkedpro').html('<span class="wcicon-status-cancelled"></span> Please add per day price before submit.').addClass('wcfm-error').slideDown();
			$('#wcfm_products_manage_form #_wc_booking_day_cost').addClass('valreq');
			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}else if(_wc_booking_week_cost.length == 0) {
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-linkedpro').html('<span class="wcicon-status-cancelled"></span> Please add per week price before submit.').addClass('wcfm-error').slideDown();
			$('#wcfm_products_manage_form_gallery_expander .box.has-advanced-upload').addClass('valreq');
			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}else if(_wc_booking_month_cost.length == 0) {
			
			$is_valid = false;
			$('#wcfm_products_manage_form .wcfm-message-linkedpro').html('<span class="wcicon-status-cancelled"></span> Please add per month price before submit.').addClass('wcfm-error').slideDown();
			$('#wcfm_products_manage_form_gallery_expander .box.has-advanced-upload').addClass('valreq');
			$('html, body').animate({
				'scrollTop' : $(".valreq").position().top - 200
			});
		}
		return $is_valid;
	}
	

	$('.content_wrapper_dashboard').on('keyup change', '.valreq', function() {
		$(this).css('border-color', '#e7e9ef').removeClass('valreq');
		$('#general1 #wp-description-wrap').css('border-style', 'none');
		$('#title').css('border-color', '#e7e9ef');
		$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
	});

	$("#product_subcats").select2().on("change", function(e) {
		$('#categories .select2-selection').css('border-color', '#e7e9ef').removeClass('valreq');
		$('#title').css('border-color', '#e7e9ef');
		$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
	});
	
	// Draft Product
	$('#wcfm_products_simple_draft_button').click(function(event) {
	  event.preventDefault();
	  
	  // Validations
	  $is_valid = wcfm_products_manage_form_validate();
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
			var description = '';
			if(tinyMCE.activeEditor) description = tinyMCE.activeEditor.getContent();
			var data = {
				action : 'wcfm_ajax_controller',
				controller : 'wcfm-products-manage', 
				wcfm_products_manage_form : $('#wcfm_products_manage_form').serialize(),
				description : description,
				status : 'draft',
				removed_variations : removed_variations,
				removed_person_types : removed_person_types
			}
			var formData = new FormData($('#wcfm_products_manage_form'));
			$.ajax({
				type:'POST',
				url: woocommerce_params.ajax_url+"?action=wcfm_ajax_controller&controller=wcfm-products-manage&description="+description+"&status=draft",
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					if(response) {
						var response_json = $.parseJSON(response);


						$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
						if(response_json.status) {
							$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + response_json.message).addClass('wcfm-success').slideDown( "slow", function() {
								if( response_json.redirect ) window.location = response_json.redirect;	
							} );
						} else {
							$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + response_json.message).addClass('wcfm-error').slideDown();
						}
						if(response_json.id) $('#pro_id').val(response_json.id);
						$('#wcfm-content').unblock();
						$('.loading_icon').hide();
						_this.removeAttr('disabled', 'disabled');
					}
				},
				error: function(data){
					console.log("error");
					console.log(data);
				}
			});
			/* 
			$.post(woocommerce_params.ajax_url, data, function(response) {
				if(response) {
					var response_json = $.parseJSON(response);


					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
					if(response_json.status) {
						$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + response_json.message).addClass('wcfm-success').slideDown( "slow", function() {
							if( response_json.redirect ) window.location = response_json.redirect;	
						} );
					} else {
						$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + response_json.message).addClass('wcfm-error').slideDown();
					}
					if(response_json.id) $('#pro_id').val(response_json.id);
					$('#wcfm-content').unblock();
					$('.loading_icon').hide();
	  				_this.removeAttr('disabled', 'disabled');
				}
			});	 */
		}
	});
	
	// Submit Product
	$('#wcfm_products_simple_submit_button').click(function(event) {
	  event.preventDefault();
	  
	  // Validations
		$is_valid1 = wcfm_products_manage_form_validate_step1();
		if(!$is_valid1){
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#general1"]').trigger('click');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#general1"]').addClass('active');
			return false;
		}
		$is_valid2 = wcfm_products_manage_form_validate_step2();
		if(!$is_valid2){
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#address"]').trigger('click');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#address"]').addClass('active');
			return false;
		}
		$is_valid3 = wcfm_products_manage_form_validate_step3();
		if(!$is_valid3){
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#image"]').trigger('click');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#image"]').addClass('active');
			return false;
		}
		$is_valid4 = wcfm_products_manage_form_validate_step4();
		if(!$is_valid4){
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#shipping"]').trigger('click');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#shipping"]').addClass('active');
			return false;
		}
		$is_valid5 = wcfm_products_manage_form_validate_step5();
		if(!$is_valid5){
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a').removeClass('active');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#linkedpro"]').trigger('click');
			//*jQuery('.user_dashboard_panel_guide .nav-tabs a[href="#linkedpro"]').addClass('active');
			return false;
		}

	  var _this = $(this);
	  if($is_valid1 && $is_valid2 && $is_valid3 && $is_valid4 && $is_valid5) {
			$('.loading_icon').show();
	  		_this.attr('disabled', 'disabled');
			$('#wcfm-content').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			var description = '';
			if(tinyMCE.activeEditor) description = tinyMCE.activeEditor.getContent();
			var formdata = {
				action : 'wcfm_ajax_controller',
				controller : 'wcfm-products-manage',
				wcfm_products_manage_form : $('#wcfm_products_manage_form').serialize(),
				description : description,
				status : 'submit',
				removed_variations : removed_variations,
				removed_person_types : removed_person_types
			}	
			// var formData = new FormData($('#wcfm_products_manage_form'));
			$.ajax({
				type:'POST',
				url: woocommerce_params.ajax_url,
				data:formdata,
				success:function(response){
					if(response) {
						var response_json = $.parseJSON(response);

						$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
						if(response_json.status) {
							$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + response_json.message).addClass('wcfm-success').slideDown( "slow", function() {
							  if( response_json.redirect ) window.location = response_json.redirect;	
							} );
						} else {
							$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + response_json.message).addClass('wcfm-error').slideDown();
						}
						if(response_json.id) $('#pro_id').val(response_json.id);
						$('#wcfm-content').unblock();
						$('.loading_icon').hide();
						_this.removeAttr('disabled', 'disabled');
					}
				},
				error: function(data){
					console.log("error");
					console.log(data);
				}
			});
			/* $.post(woocommerce_params.ajax_url, data, function(response) {
				if(response) {
					var response_json = $.parseJSON(response);

					$('.wcfm-message').html('').removeClass('wcfm-error').removeClass('wcfm-success').slideUp();
					if(response_json.status) {
						$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-completed"></span>' + response_json.message).addClass('wcfm-success').slideDown( "slow", function() {
						  if( response_json.redirect ) window.location = response_json.redirect;	
						} );
					} else {
						$('#wcfm_products_manage_form .wcfm-message').html('<span class="wcicon-status-cancelled"></span>' + response_json.message).addClass('wcfm-error').slideDown();
					}
					if(response_json.id) $('#pro_id').val(response_json.id);
					$('#wcfm-content').unblock();
					$('.loading_icon').hide();
	  				_this.removeAttr('disabled', 'disabled');
				}
			}); */
		}
	});
	
	function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
} );
