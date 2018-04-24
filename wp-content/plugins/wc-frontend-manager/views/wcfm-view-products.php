<?php
global $WCFM;

$user = wp_get_current_user();
if( !current_user_can( 'edit_products' )  && !in_array( 'dc_vendor', (array) $user->roles )) {
	_e( "<span class='permission_restrict'>You don't have permission to access this page. Please contact site administrator for assistance.</span>", $WCFM->text_domain );
	return;
}

?>

<div  id="wcfm_products_listing">
  <?php do_action( 'before_wcfm_products' ); ?>
  
	<div class="wcfm-clearfix"></div>
	<div class="wcfm-container">
		<div id="wcfm_products_listing_expander" class="wcfm-content">
			<?php 
			global $WCFM;
			$controllers_path = $WCFM->plugin_path . 'controllers/';
			require_once( $controllers_path . 'wcfm-controller-products.php' );
			$products = new WCFM_Products_Controller();
			?>
			<div class="wcfm-clearfix"></div>
		</div>
	</div>
	<?php
	do_action( 'after_wcfm_products' );
	?>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#wcfm_products_listing').on('click', '.equ_delete', function() {
				var rconfirm = confirm("Are you sure and want to delete this 'Product'?\nYou can't undo this action ...");
				if(rconfirm){
					var proid = jQuery(this).data('proid');
					var data = {
						action : 'delete_wcfm_product',
						proid : proid
					}	
					jQuery.ajax({
						type:		'POST',
						url: woocommerce_params.ajax_url,
						data: data,
						success:	function(response) {
							jQuery('#proid-'+proid).remove();
						}
					});
				}
				else {
					return false;
				}
			});
		});
	</script>
</div>
