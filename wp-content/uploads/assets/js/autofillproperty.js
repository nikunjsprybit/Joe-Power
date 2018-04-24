jQuery(document).ready(function(){
	
	jQuery("#post-body-content").append("<input style='float:right;' type='button' id='add_description' class='button' value='Add Description'>");
	jQuery("#acf-field_582b0399ad721-input").on("change", function() {
		project_id	 =	jQuery(this).val();
		jQuery.ajax({
			url: autofillproperty.ajaxurl,
			data: {'project_id':project_id,'action':'get_project_details'},
			type:'get',
			dataType:'json',
			success:function(res){
				//Property Type
				jQuery("[name='acf[field_55681a8db9d18]'][value="+(res.property_type)+"]").attr('checked',true);
				
				//Construction Status
				jQuery("[name='acf[field_58b5497830c01]'][value="+(res.construction_status)+"]").attr('checked',true);
				
				//Property Location
				jQuery("[name='acf[field_5562dee6753f7]'][value="+(res.property_location)+"]").attr('checked',true);
				
				//Storeys
				jQuery("#acf-field_5816d25a529a4").val(res.property_storeys);
				
				//Year Built hidden
				jQuery("#acf-field_58202bdfe0bbe").val(res.year_built);
				
				//Year Built datepicker
				jQuery("#acf-field_58202bdfe0bbe").next().val(res.year_built.substring(0,4));
				
				//Video ID
				jQuery("#acf-field_553624b2bfe22").val(res.property_video_id);
				
				//Video Provider
				jQuery("#acf-field_5536246ebfe21").val(res.property_video_provider);
				
				//Address
				jQuery("#acf[field_55362588bfe26][address]").val(res.property_google_maps.address);
				
				//Latitude
				jQuery("#acf[field_55362588bfe26][lat]").val(res.property_google_maps.lat);
				
				//Longitude
				jQuery("#acf[field_55362588bfe26][lng]").val(res.property_google_maps.lng);
				
				//Map
				jQuery("#acf-field_55362588bfe26").find(".search").val(res.property_google_maps.address);
				
				//Project
				if(res.project!=""){
					jQuery("#acf-field_58103e790ad0f-input").val(res.project);
					jQuery("#acf-field_58103e790ad0f").val(res.project);
					jQuery("#s2id_acf-field_58103e790ad0f-input").addClass('select2-allowclear').find("a.select2-choice").removeClass('select2-default').find(" span.select2-chosen").html(res.project_name);
				}
				
				// trigger map
				jQuery("#acf-field_55362588bfe26").find(".actions.acf-soh-target").find("a[data-name='search']").trigger('click');
				
				// Property Features
				jQuery.each(res.property_features, function (index, value){
					jQuery("[name='acf[field_55681b1ab9d1a][]'][value="+(value)+"]").attr('checked',true);
				});
			}	
		});
    });
	jQuery("#acf-field_55366a9855cb1, #acf-field_5892f42a4056c").keyup(function(){
		price 				=	jQuery("#acf-field_55366a9855cb1").val();
		before_price		=	jQuery("#acf-field_5892f42a4056c").val();
		size				=	jQuery("#acf-field_55366b2555cb3").val();
		if(before_price!="" && price!=""){
			difference_price	=	((1 - price/before_price) * 100).toFixed(2);	
			jQuery("#acf-field_5892f4534056d").val(difference_price);
		}
		if(price!="" && size!=""){
			jQuery("#acf-field_58be5ae57f7b3").val(parseInt(price/size));	
		}
	});
	
	jQuery("#acf-field_55366b2555cb3").keyup(function(){
		
		price 				=	jQuery("#acf-field_55366a9855cb1").val();
		size				=	jQuery("#acf-field_55366b2555cb3").val();
		if(price!="" && size!=""){
			jQuery("#acf-field_58be5ae57f7b3").val(parseInt(price/size));	
		}
	});
	// add description templates
	jQuery("#add_description").click(function(){
		lang 		=	jQuery("#post-body-content").find('ul.qtranxs-lang-switch-wrap li.active').attr('lang');
		$form_data 	=	jQuery("#post").serializeArray();
		
		// remvoe action field value
		jQuery.each($form_data, function(index, item) {
			if (item.name == 'action') {
				delete $form_data[index];      
			}
			// for deal radio buttons
			if (item.name == 'acf[field_55681ad3b9d19]') {
				$form_data[index].value =	jQuery("[name='acf[field_55681ad3b9d19]']:checked").nextAll("span:eq(0)").text();
			}
			// for ownership checboxes
			if (item.name == 'acf[field_58202bb3e0bbd][]') {
				$form_data[index].value =	jQuery("[name='acf[field_58202bb3e0bbd][]'][value="+($form_data[index].value)+"]").nextAll("span:eq(0)").text();
			}
			// for property type radio
			if (item.name == 'acf[field_55681a8db9d18]') {
				$form_data[index].value =	jQuery("[name='acf[field_55681a8db9d18]']:checked").nextAll("span:eq(0)").text();
			}
			// for view checboxes
			if (item.name == 'acf[field_58202de9a18ba][]') {
				$form_data[index].value =	jQuery("[name='acf[field_58202de9a18ba][]'][value="+($form_data[index].value)+"]").nextAll("span:eq(0)").text();
				
			}
			// for Construction Status radio
			if (item.name == 'acf[field_58b5497830c01]') {
				$form_data[index].value =	jQuery("[name='acf[field_58b5497830c01]']:checked").nextAll("span:eq(0)").text();
			}
			// for Property Location radio
			if (item.name == 'acf[field_5562dee6753f7]') {
				$form_data[index].value =	jQuery("[name='acf[field_5562dee6753f7]']:checked").nextAll("span:eq(0)").text();
			}
			// for Property Features checboxes
			if (item.name == 'acf[field_55681b1ab9d1a][]') {
				$form_data[index].value =	jQuery("[name='acf[field_55681b1ab9d1a][]'][value="+($form_data[index].value)+"]").nextAll("span:eq(0)").text();
				
			}
		});
		jQuery.ajax({
			url: autofillproperty.ajaxurl+"?lang="+lang+"&action=get_content_template",
			data: jQuery.param($form_data),
			type:'post',
			success:function(res){
				window.parent.send_to_editor(res);
				window.parent.tb_remove();
			}	
		});
	});
});