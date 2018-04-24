jQuery( document ).ready( function( $ ) {
  jQuery('.menu_tip').each(function() {                                                  
		jQuery(this).qtip({
			content: jQuery(this).attr('data-tip'),
			position: {
				my: 'center right',
				at: 'center left',
				viewport: jQuery(window)
			},
			show: {
				event: 'mouseover',
				solo: true
			},
			hide: {
				inactive: 6000,
				fixed: true
			},
			style: {
				classes: 'qtip-dark qtip-shadow qtip-rounded qtip-wcfm-menu-css'
			}
		});
	});
	
	$( '#wcfm_menu .wcfm_menu_item' ).each( function() {
		$(this).mouseover( function() {
			var hideTime;
			$hover_block = $(this).find( '.wcfm_sub_menu_items' );
			clearTimeout(hideTime);
			$hover_block.show( 'slow', function() {
				hideTime = setTimeout(function() {
					$( '.wcfm_sub_menu_items' ).hide( 'slow' );
					$hover_block.removeClass( 'moz_class' );
				}, 30000);  
			} );
		} );
	} );
} );