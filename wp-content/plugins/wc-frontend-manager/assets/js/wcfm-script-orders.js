$wcfm_orders_table = '';
$order_status = '';	

jQuery(document).ready(function($) {
	
	$wcfm_orders_table = $('#wcfm-orders').DataTable( {
		"processing": true,
		"serverSide": true,
		"responsive": true,
		"columns"   : [
										{ responsivePriority: 2 },
										{ responsivePriority: 1 },
										{ responsivePriority: 4 },
										{ responsivePriority: 5 },
										{ responsivePriority: 3 },
										{ responsivePriority: 1 }
								],
		"columnDefs": [ { "targets": 0, "orderable" : false }, 
									  { "targets": 1, "orderable" : false }, 
										{ "targets": 2, "orderable" : false }, 
										{ "targets": 3, "orderable" : false }, 
										{ "targets": 4, "orderable" : false }, 
										{ "targets": 5, "orderable" : false },
									],
		'ajax': {
			"type"   : "POST",
			"url"    : woocommerce_params.ajax_url,
			"data"   : function( d ) {
				d.action       = 'wcfm_ajax_controller',
				d.controller   = 'wcfm-orders',
				d.order_status = GetURLParameter( 'order_status' )
			},
			"complete" : function () {
				initiateTip();
				
				$('.show_order_items').click(function(e) {
					e.preventDefault();
					$(this).next('div.order_items').toggleClass( "order_items_visible" );
					return false;
				});
				
				// Fire wcfm-orders table refresh complete
				$( document.body ).trigger( 'updated_wcfm-orders' );
			}
		}
	} );
} );