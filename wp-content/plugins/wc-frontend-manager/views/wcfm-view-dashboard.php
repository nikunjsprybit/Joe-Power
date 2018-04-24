<?php
global $WCFM, $wpdb;

$on_hold_count    = 0;
$processing_count = 0;

foreach ( wc_get_order_types( 'order-count' ) as $type ) {
	$counts           = (array) wp_count_posts( $type );
	$on_hold_count    += isset( $counts['wc-on-hold'] ) ? $counts['wc-on-hold'] : 0;
	$processing_count += isset( $counts['wc-processing'] ) ? $counts['wc-processing'] : 0;
}


// Get products using a query - this is too advanced for get_posts :(
$stock          = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
$nostock        = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
$transient_name = 'wc_low_stock_count';

if ( false === ( $lowinstock_count = get_transient( $transient_name ) ) ) {
	$query_from = apply_filters( 'woocommerce_report_low_in_stock_query_from', "FROM {$wpdb->posts} as posts
		INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
		INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
		WHERE 1=1
		AND posts.post_type IN ( 'product', 'product_variation' )
		AND posts.post_status = 'publish'
		AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
		AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'
		AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{$nostock}'
	" );
	$lowinstock_count = absint( $wpdb->get_var( "SELECT COUNT( DISTINCT posts.ID ) {$query_from};" ) );
	set_transient( $transient_name, $lowinstock_count, DAY_IN_SECONDS * 30 );
}

$transient_name = 'wc_outofstock_count';

if ( false === ( $outofstock_count = get_transient( $transient_name ) ) ) {
	$query_from = apply_filters( 'woocommerce_report_out_of_stock_query_from', "FROM {$wpdb->posts} as posts
		INNER JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id
		INNER JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id
		WHERE 1=1
		AND posts.post_type IN ( 'product', 'product_variation' )
		AND posts.post_status = 'publish'
		AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
		AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$nostock}'
	" );
	$outofstock_count = absint( $wpdb->get_var( "SELECT COUNT( DISTINCT posts.ID ) {$query_from};" ) );
	set_transient( $transient_name, $outofstock_count, DAY_IN_SECONDS * 30 );
}

include_once( WC()->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php' );

include_once( WC()->plugin_path() . '/includes/admin/reports/class-wc-report-sales-by-date.php' );

$wcfm_report_sales_by_date = new WC_Report_Sales_By_Date();

$wcfm_report_sales_by_date->chart_colours = array(
	'sales_amount'     => '#b1d4ea',
	'net_sales_amount' => '#3498db',
	'average'          => '#b1d4ea',
	'net_average'      => '#3498db',
	'order_count'      => '#dbe1e3',
	'item_count'       => '#ecf0f1',
	'shipping_amount'  => '#5cc488',
	'coupon_amount'    => '#f1c40f',
	'refund_amount'    => '#e74c3c'
);

$wcfm_report_sales_by_date->calculate_current_range( '7day' );
$report_data   = $wcfm_report_sales_by_date->get_report_data();

do_action( 'before_wcfm_dashboard' );
?>

<?php /* ?>
<div class="collapse wcfm-collapse" id="wcfm_dashboard">

	<?php do_action( 'begin_wcfm_dashboard' ); ?>
	
	<div class="wcfm_dashboard_wc_status">
	  <div class="wcfm_dashboard_wc_status_data">
			<div class="page_collapsible" id="wcfm_dashboard_wc_status">
				<span class="fa fa-line-chart"></span>
				<span class="dashboard_widget_head"><?php _e('Store Status', $WCFM->text_domain); ?></span>
			</div>
			<div class="wcfm-container">
				<div id="wcfm_dashboard_wc_status_expander" class="wcfm-content">
					<ul class="wc_status_list">
						<?php
						if ( current_user_can( 'view_woocommerce_reports' ) && ( $report_data ) ) {
							?>
							<li class="sales-this-month">
							  <span class="fa fa-shopping-cart"></span>
								<a href="<?php echo get_wcfm_reports_url( 'month' ); ?>">
									<?php printf( __( '<strong>%s</strong><br /> net sales in last 7 days', $WCFM->text_domain ), wc_price( $report_data->net_sales ) ); ?>
								</a>
							</li>
							<?php
						}
						 
						if ( current_user_can( 'view_woocommerce_reports' ) && ( $top_seller = $this->get_top_seller() ) && $top_seller->qty ) {
							?>
							<li class="best-seller-this-month">
							  <span class="fa fa-cube"></span>
								<a href="<?php echo apply_filters( 'sales_by_product_report_url',  get_wcfm_reports_url( ), $top_seller->product_id ); ?>">
									<?php printf( __( '%s top seller in last 7 days (sold %d)', $WCFM->text_domain ), '<strong>' . get_the_title( $top_seller->product_id ) . '</strong><br />', $top_seller->qty ); ?>
								</a>
							</li>
							<?php
						}
						?>
						<?php if ( current_user_can( 'edit_shop_orders' ) ) { ?>
						<li class="processing-orders">
						  <span class="fa fa-life-ring"></span>
							<a href="<?php echo get_wcfm_orders_url( 'processing' ); ?>">
								<?php printf( _n( "<strong>%s order</strong><br /> processing", "<strong>%s orders</strong><br /> processing", $processing_count, $WCFM->text_domain ), $processing_count ); ?>
							</a>
						</li>
						<li class="on-hold-orders">
						  <span class="fa fa-minus-circle"></span>
							<a href="<?php echo get_wcfm_orders_url( 'on-hold' ); ?>">
								<?php printf( _n( "<strong>%s order</strong><br /> on-hold", "<strong>%s orders</strong><br /> on-hold", $on_hold_count, $WCFM->text_domain ), $on_hold_count ); ?>
							</a>
						</li>
						<?php } ?>
						
						<li class="low-in-stock">
						  <span class="fa fa-sort-amount-desc"></span>
							<a href="<?php echo apply_filters( 'low_in_stock_report_url',  get_wcfm_reports_url( ) ); ?>">
								<?php printf( _n( "<strong>%s product</strong><br /> low in stock", "<strong>%s products</strong><br /> low in stock", $lowinstock_count, $WCFM->text_domain ), $lowinstock_count ); ?>
							</a>
						</li>
						<li class="out-of-stock">
						  <span class="fa fa-times-circle-o"></span>
							<a href="<?php echo get_wcfm_reports_url( '', 'wcfm-reports-out-of-stock' ); ?>">
								<?php printf( _n( "<strong>%s product</strong><br /> out of stock", "<strong>%s products</strong><br /> out of stock", $outofstock_count, $WCFM->text_domain ), $outofstock_count ); ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		
		<?php if ( current_user_can( 'view_woocommerce_reports' ) ) { ?>
		<div class="wcfm_dashboard_wc_status_graph">
		  <div class="wcfm_dashboard_wc_reports">
				<div class="page_collapsible" id="wcfm_dashboard_wc_reports"><span class="fa fa-pie-chart"></span><span class="dashboard_widget_head"><?php _e('Sales by Product', $WCFM->text_domain); ?></span></div>
				<div class="wcfm-container">
					<div id="wcfm_dashboard_wc_reports_expander" class="wcfm-content">
						<a href="<?php echo apply_filters( 'sales_by_product_report_url',  get_wcfm_reports_url( ), ( $top_seller ) ? $top_seller->product_id : '' ); ?>">
							<div id="sales-piechart"></div>
						</a>
					</div>
				</div>
			</div>
			
		  <div class="wcfm_dashboard_wc_reports">
				<div class="page_collapsible" id="wcfm_dashboard_wc_reports"><span class="fa fa-bar-chart"></span><span class="dashboard_widget_head"><?php _e('Sales by Date', $WCFM->text_domain); ?></span></div>
				<div class="wcfm-container">
					<div id="wcfm_dashboard_wc_reports_expander" class="wcfm-content">
						<div id="poststuff" class="woocommerce-reports-wide">
							<div class="postbox">
								<div class="inside">
									<a href="<?php echo get_wcfm_reports_url( 'month' ); ?>">
										<?php $wcfm_report_sales_by_date->get_main_chart(); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	
			<?php do_action('after_wcfm_dashboard_sales_report'); ?>
		</div>
	  <?php } ?>
	</div>
	
	  <?php if( $store_steeing = apply_filters( 'wcfm_store_settings', true ) ) { ?>
		<div class="wcfm-clearfix"></div><br />
		<!-- collapsible -->
		<div class="page_collapsible wcfm_dashboard_wc_settings" id="wcfm_dashboard_wc_settings">
		  <span class="fa fa-cog"></span>
		  <span class="dashboard_widget_head"><?php _e('Store Settings', $WCFM->text_domain); ?></span>
		</div>
		<div class="wcfm-container">
			<div id="wcfm_dashboard_wc_settings_expander" class="wcfm-content">
				<table class="wc_status_table widefat" cellspacing="0">
					<tbody>
						<tr>
							<td data-export-label="Force SSL"><?php _e( 'Force SSL', $WCFM->text_domain ); ?>:</td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'Does your site force a SSL Certificate for transactions?', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo 'yes' === get_option( 'woocommerce_force_ssl_checkout' ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>'; ?></td>
						</tr>
						<tr>
							<td data-export-label="Currency"><?php _e( 'Currency', $WCFM->text_domain ) ?></td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'What currency prices are listed at in the catalog and which currency gateways will take payments in.', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo get_woocommerce_currency(); ?> (<?php echo get_woocommerce_currency_symbol() ?>)</td>
						</tr>
						<tr>
							<td data-export-label="Currency Position"><?php _e( 'Currency Position', $WCFM->text_domain ) ?></td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'The position of the currency symbol.', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo get_option( 'woocommerce_currency_pos' ); ?></td>
						</tr>
						<tr>
							<td data-export-label="Thousand Separator"><?php _e( 'Thousand Separator', $WCFM->text_domain ) ?></td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'The thousand separator of displayed prices.', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo wc_get_price_thousand_separator(); ?></td>
						</tr>
						<tr>
							<td data-export-label="Decimal Separator"><?php _e( 'Decimal Separator', $WCFM->text_domain ) ?></td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'The decimal separator of displayed prices.', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo wc_get_price_decimal_separator(); ?></td>
						</tr>
						<tr>
							<td data-export-label="Number of Decimals"><?php _e( 'Number of Decimals', $WCFM->text_domain ) ?></td>
							<td class="help"><span class="img_tip" data-tip="<?php _e( 'The number of decimal points shown in displayed prices.', $WCFM->text_domain ); ?>"></span></td>
							<td><?php echo wc_get_price_decimals(); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- end collapsible -->
	  <?php } ?>
	
</div> <?php */ ?>
