<?php
/**
 * WCFM plugin controllers
 *
 * Plugin Orders Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers
 * @version   1.0.0
 */

class WCFM_Orders_WCVendors_Controller {
	
	public function __construct() {
		global $WCFM;
		
		$this->processing();
	}
	
	public function processing() {
		global $WCFM, $wpdb, $_POST, $start_date, $end_date;
		
		$length = $_POST['length'];
		$offset = $_POST['start'];
		
		$user_id = get_current_user_id();
		
		$can_view_orders = WC_Vendors::$pv_options->get_option( 'can_show_orders' );
		$vendor_products = $WCFM->wcfm_marketplace->wcv_get_vendor_products( $user_id );
		
		$order_summary   = WCV_Queries::get_orders_for_products( $vendor_products );
		
		// Generate Products JSON
		$wcfm_orders_json = '';
		$wcfm_orders_json = '{
														"draw": ' . $_POST['draw'] . ',
														"recordsTotal": ' . count($order_summary) . ',
														"recordsFiltered": ' . count($order_summary) . ',
														"data": ';
		
		if ( !empty( $order_summary ) ) {
			$index = 0;
			$totals = 0;
			$wcfm_orders_json_arr = array();
			
			foreach ( $order_summary as $order ) {
	
				$the_order = new WC_Order( $order->order_id );
				//$the_order = wc_get_order( $order );
				$valid_items = WCV_Queries::get_products_for_order( $the_order->id );
				$valid = array();
				$needs_shipping = false; 
	
				$items = $the_order->get_items();
	
				foreach ($items as $key => $value) {
					if ( in_array( $value['variation_id'], $valid_items) || in_array( $value['product_id'], $valid_items ) ) {
						$valid[] = $value;
					}
				}
				
				$order_date = ( version_compare( WC_VERSION, '2.7', '<' ) ) ? $the_order->order_date : $the_order->get_date_created(); 
	
				// Status
				$wcfm_orders_json_arr[$index][] =  '<span class="order-status tips wcicon-status-' . sanitize_title( $the_order->get_status() ) . ' text_tip" data-tip="' . wc_get_order_status_name( $the_order->get_status() ) . '"></span>';
				
				// Order
				if ( $the_order->user_id ) {
					$user_info = get_userdata( $the_order->user_id );
				}
	
				if ( ! empty( $user_info ) ) {
	
					$username = '';
	
					if ( $user_info->first_name || $user_info->last_name ) {
						$username .= esc_html( sprintf( _x( '%1$s %2$s', 'full name', $WCFM->text_domain ), ucfirst( $user_info->first_name ), ucfirst( $user_info->last_name ) ) );
					} else {
						$username .= esc_html( ucfirst( $user_info->display_name ) );
					}
	
				} else {
					if ( $the_order->billing_first_name || $the_order->billing_last_name ) {
						$username = trim( sprintf( _x( '%1$s %2$s', 'full name', $WCFM->text_domain ), $the_order->billing_first_name, $the_order->billing_last_name ) );
					} else if ( $the_order->billing_company ) {
						$username = trim( $the_order->billing_company );
					} else {
						$username = __( 'Guest', $WCFM->text_domain );
					}
				}
	
				if( $can_view_orders )
					$wcfm_orders_json_arr[$index][] =  '<a href="' . get_wcfm_view_order_url($the_order->id, $the_order) . '" class="wcfm_order_title">#' . esc_attr( $the_order->get_order_number() ) . '</a> by ' . $username;
				else
					$wcfm_orders_json_arr[$index][] =  '#' . esc_attr( $the_order->get_order_number() ) . ' by ' . $username;
				
				// Purchased
				$order_item_details = '<div class="order_items" cellspacing="0">';
				$product_id = '';       
				foreach ($valid as $key => $item) {
					
					// Get variation data if there is any. 
					$variation_detail = !empty( $item['variation_id'] ) ? WCV_Orders::get_variation_data( $item[ 'variation_id' ] ) : ''; 
				
					$order_item_details .= '<div class=""><span class="qty">' . $item['qty'] . 'x</span><span class="name">' . $item['name'];
					if ( !empty( $variation_detail ) ) $order_item_details .= '<span class="img_tip" data-tip="' . $variation_detail . '"></span>';
					$order_item_details .= '</span></div>';
				}
				$order_item_details .= '</div>';
				$wcfm_orders_json_arr[$index][] = '<a href="#" class="show_order_items">' . sprintf( _n( '%d item', '%d items', count($valid), $WCFM->text_domain ), count($valid) ) . '</a>' . $order_item_details;
				
				// Total
				/*$status = __( 'N/A', 'woocommerce-product-vendors' );

				if ( 'due' === $order->status ) {
					$status = '<span class="wcpv-unpaid-status">' . esc_html__( 'DUE', $WCFM->text_domain ) . '</span>';
				}

				if ( 'paid' === $order->status ) {
					$status = '<span class="wcpv-paid-status">' . esc_html__( 'PAID', $WCFM->text_domain ) . '</span>';
				}

				if ( 'reversed' === $order->status ) {
					$status = '<span class="wcpv-void-status">' . esc_html__( 'REVERSED', $WCFM->text_domain ) . '</span>';
				}*/
				
				$sum = WCV_Queries::sum_for_orders( array( $the_order->id ), array('vendor_id'=>get_current_user_id()) ); 
				$total = $sum[0]->line_total; $totals += $total;
				$wcfm_orders_json_arr[$index][] =  '<span class="order_total">' . wc_price( $total ) . '</span>';
				
				// Date
				$wcfm_orders_json_arr[$index][] = date_i18n( wc_date_format(), strtotime( $order_date ) );
				
				// Action
				if( $can_view_orders )
					$wcfm_orders_json_arr[$index][] =  apply_filters ( 'wcvendors_orders_actions', '<a class="wcfm-action-icon" href="' . get_wcfm_view_order_url($the_order->id, $the_order) . '"><span class="fa fa-eye text_tip" data-tip="' . esc_attr__( 'View Details', $WCFM->text_domain ) . '"></span></a>', $user_id, $the_order );
				else
					$wcfm_orders_json_arr[$index][] =  apply_filters ( 'wcvendors_orders_actions', '', $user_id, $the_order );
				
				$index++;
			}
		}
		if( !empty($wcfm_orders_json_arr) ) $wcfm_orders_json .= json_encode($wcfm_orders_json_arr);
		else $wcfm_orders_json .= '[]';
		$wcfm_orders_json .= '
													}';
													
		echo $wcfm_orders_json;
	}
}