<?php
global $WCFM;

$user = wp_get_current_user();
if( !current_user_can( 'edit_shop_coupons' )  && !in_array( 'dc_vendor', (array) $user->roles )) {
	_e( "<span class='permission_restrict'>You don't have permission to access this page. Please contact site administrator for assistance.</span>", $WCFM->text_domain );
	return;
}

/*get_wcfm_coupons_manage_url()*/

do_action( 'before_wcfm_coupons' );
?>

<div class="collapse wcfm-collapse" id="wcfm_coupons_listing">

	<?php
	if( $allow_wp_admin_view = apply_filters( 'wcfm_allow_wp_admin_view', true ) ) {
		?>
		<a target="_blank" class="wcfm_wp_admin_view text_tip" href="<?php echo admin_url('edit.php?post_type=shop_coupon'); ?>" data-tip="<?php _e( 'WP Admin View', $WCFM->text_domain ); ?>"><span class="fa fa-user-secret"></span></a>
		<?php
	}
	$user = wp_get_current_user();
	if( $has_new = apply_filters( 'wcfm_add_new_coupon_sub_menu', true )  || in_array( 'dc_vendor', (array) $user->roles )) { 
		echo '<a id="add_new_coupon_dashboard" href="'.wpestate_my_reservations_link().'/?action=add"><span class="fa fa-gift"></span><span class="text">' . __('Add New Coupon', $WCFM->text_domain) . '</span></a>';
	}
	?>
	<div class="wcfm-clearfix"></div>
	<div class="wcfm-container">
		<div id="wcfm_coupons_listing_expander" class="wcfm-content">
			<table id="wcfm-coupons" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php _e( 'Code', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Type', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Amt', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Usage Limit', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Expiry date', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Action', $WCFM->text_domain ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><?php _e( 'Code', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Type', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Amt', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Usage Limit', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Expiry date', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Action', $WCFM->text_domain ); ?></th>
					</tr>
				</tfoot>
			</table>
			<div class="wcfm-clearfix"></div>
		</div>
	</div>
</div>
	
<?php
do_action( 'after_wcfm_coupons' );
?>