jQuery(document).ready(function ($) {
	if(jQuery('#calendar').length>0){	
		var todayDate = moment().startOf('day');
		var YM = todayDate.format('YYYY-MM');
		var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
		var TODAY = todayDate.format('YYYY-MM-DD');
		var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

		jQuery('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			editable: false,
			eventLimit: false, // allow "more" link when too many events
			navLinks: true,
			events: function (start, end, timezone, callback) {
				jQuery.ajax({
					url: wc_add_to_cart_params.ajax_url,
					dataType: 'json',
					data: {
						action:'load_calander_events_ajax',
						start: start.format(),
						end: end.format()
					},
					success: function(res){
						var events = [];
						if(res!=""){						
							// res	=	JSON.parse(res);
							if(res.length>0){
								jQuery.each(res, function (index, booking){								
									events.push({
										id: booking.id,
										title: booking.title,
										start: booking.start,
										end: booking.end
									});
								});
							}
						}
						console.log(events);
						callback(events);
					}
				});
			}
			/* events: {
				url: wc_add_to_cart_params.ajax_url,
				data:{action:'load_calander_events_ajax'},
				success: function(res){
					var events = [];
					if(res!=""){						
						// res	=	JSON.parse(res);
						if(res.length>0){
							jQuery.each(res, function (index, booking){								
								events.push({
									id: booking.id,
									title: booking.title,
									start: booking.start,
									end: booking.end
								});
							});
						}
					}
					callback(events);
				}
			}, */
		});
	}
	
	jQuery(".wc-bookings-booking-form-button.single_add_to_cart_button.button").attr('disabled',true);
    var today, prev_date,prev_date_string;
    today = new Date();
  
    jQuery("#start_date1,#end_date1").blur();
    
    jQuery("#start_date1").datepicker({
        dateFormat : "yy-mm-dd",
        minDate: today
    }, jQuery.datepicker.regional[control_vars.datepick_lang]).focus(function () {
			jQuery(this).blur()
	}).datepicker('widget').wrap('<div class="ll-skin-melon"/>');
		
    jQuery("#start_date1").change(function () {
        prev_date = wpestate_UTC_addDays( jQuery('#start_date1').val(),0 );
        jQuery("#end_date1").removeAttr('disabled');
        jQuery("#end_date1").datepicker("destroy");
        jQuery("#end_date1").datepicker({
            dateFormat : "yy-mm-dd",
            minDate: prev_date
        }, jQuery.datepicker.regional[control_vars.datepick_lang]);
    });
	
	jQuery("#end_date1").change(function () {
        jQuery(".wc-bookings-booking-form-button.single_add_to_cart_button.button").removeAttr('disabled');
    });
    jQuery("#end_date1").datepicker({
        dateFormat : "yy-mm-dd",
        minDate: today
    }, jQuery.datepicker.regional[control_vars.datepick_lang]).focus(function () {
			jQuery(this).blur()
    });
});	