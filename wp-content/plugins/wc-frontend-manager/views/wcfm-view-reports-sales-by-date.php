<?php
global $wp, $WCFM, $wpdb;

if( isset( $wp->query_vars['wcfm-reports-sales-by-date'] ) && !empty( $wp->query_vars['wcfm-reports-sales-by-date'] ) ) {
	$wcfm_report_type = $wp->query_vars['wcfm-reports-sales-by-date'];
}

include_once( WC()->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php' );
include_once( WC()->plugin_path() . '/includes/admin/reports/class-wc-report-sales-by-date.php' );

$wcfm_report_sales_by_date = new WC_Report_Sales_By_Date();

$ranges = array(
	'year'         => __( 'Year', $WCFM->text_domain ),
	'last_month'   => __( 'Last Month', $WCFM->text_domain ),
	'month'        => __( 'This Month', $WCFM->text_domain ),
	'7day'         => __( 'Last 7 Days', $WCFM->text_domain )
);

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

$current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : '7day';

if ( ! in_array( $current_range, array( 'custom', 'year', 'last_month', 'month', '7day' ) ) ) {
	$current_range = '7day';
}

$wcfm_report_sales_by_date->calculate_current_range( $current_range );

?>

<div class="col-sm-12" id="wcfm_report_details">

  <?php require_once( $WCFM->library->views_path . 'wcfm-view-reports-menu.php' ); ?>
  <div class="wcfm-clearfix"></div>
  
	<!-- collapsible -->
	<div class="page_collapsible wcfm_reports_sales_by_date" id="wcfm_reports_sales_by_date">
	  
	  <?php if ( 'custom' === $current_range && isset( $_GET['start_date'], $_GET['end_date'] ) ) : ?>
		<?php _e('Sales BY Date', $WCFM->text_domain); ?> - <?php echo esc_html( sprintf( _x( 'From %s to %s', 'start date and end date', $WCFM->text_domain ), wc_clean( $_GET['start_date'] ), wc_clean( $_GET['end_date'] ) ) ); ?><span></span>
		<?php else : ?>
		  <?php _e('Sales BY Date', $WCFM->text_domain); ?> - <?php echo esc_html( $ranges[ $current_range ] ); ?><span></span>
		<?php endif; ?>
		
	</div>
	<div class="wcfm-container">
		<div id="wcfm_reports_sales_by_date_expander" class="wcfm-content">
		
		  <?php
				include( $WCFM->plugin_path . '/views/reports/wcfm-html-report-sales-by-date.php');
		  ?>
		
		</div>
	</div>
</div>