<?php
global $WCFM, $wp;

$wcfm_reports_menus = apply_filters( 'wcfm_reports_menus', array( 
	'sales-by-date' => __( 'Sales by date', $WCFM->text_domain), 
	'out-of-stock' => __( 'Out of stock', $WCFM->text_domain)
) );

$site_url = site_url(); ?>
<ul class="wcfm_reports_menus">
	<?php
	$is_first = true;
	foreach( $wcfm_reports_menus as $wcfm_reports_menu_key => $wcfm_reports_menu) {
		if ( $wcfm_reports_menu == 'Sales by date' ) {
			$url = $site_url.'/reports/';
		}
		else{
			$url = $site_url.'/reports/?status=stock-report';
		}
		// get_wcfm_reports_url( '', 'wcfm-reports-' . $wcfm_reports_menu_key )
		?>
		<li class="wcfm_reports_menu_item">
		  <?php
		  if($is_first) $is_first = false;
		  else echo " | ";
		  ?>
		  <a class="<?php echo isset( $wp->query_vars['wcfm-reports-' . $wcfm_reports_menu_key] ) ? 'active' : ''; ?>" href="<?php echo $url; ?>"><?php echo $wcfm_reports_menu; ?></a>
		</li>
		<?php
	}
	?>
</ul>