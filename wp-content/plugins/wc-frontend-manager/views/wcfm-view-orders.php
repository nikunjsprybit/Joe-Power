<?php
global $WCFM;

do_action( 'before_wcfm_orders' );

?>

<div class="col-sm-12" id="wcfm_orders_listing">

	
	<div class="wcfm-clearfix"></div>
	<div class="wcfm-container">
		<div id="wwcfm_orders_listing_expander" class="wcfm-content">
			<table id="wcfm-orders" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><span class="wcicon-status-processing text_tip" data-tip="<?php _e( 'Status', $WCFM->text_domain ); ?>"></span></th>
						<th><?php _e( 'Order', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Purchased', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Total', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Date', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Actions', $WCFM->text_domain ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><span class="wcicon-status-processing text_tip" data-tip="<?php _e( 'Status', $WCFM->text_domain ); ?>"></span></th>
						<th><?php _e( 'Order', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Purchased', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Total', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Date', $WCFM->text_domain ); ?></th>
						<th><?php _e( 'Actions', $WCFM->text_domain ); ?></th>
					</tr>
				</tfoot>
			</table>
			<div class="wcfm-clearfix"></div>
		</div>
	</div>
</div>
	
<?php
do_action( 'after_wcfm_orders' );
?>