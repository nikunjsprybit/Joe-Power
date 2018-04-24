<?php
// Search
// Wp Estate Pack
global $row_number_col;   
get_header();
$options    =   wpestate_page_details('');
$unit_class =   "col-md-6";
$row_number_col=6;

if($options['content_class'] == "col-md-12"){
    $unit_class="col-md-4";    
    $row_number_col=4;
}
$row_number_col=4;

global $wp_query;

if ( isset($wp_query->query_vars) && isset($wp_query->query_vars['posts_per_page']) ) {
    $posts_per_page = $wp_query->query_vars['posts_per_page'];
}

?>


<div class="row content-fixed">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" col-md-12 ">
  
        <div class="blog_list_wrapper row">    
            <?php
                if (have_posts()){
                    print ' <h1 class="entry-title-search">'. esc_html__(  'Search Results for: ','wpestate');print '"' . get_search_query() . '"'.'</h1>';
                    while (have_posts()) : the_post(); 
                        get_template_part('templates/blog_unit');                
                    endwhile; ?>

                    <?php $totalPage = ceil($wp_query->found_posts /  $posts_per_page); ?>

                    <?php if( $wp_query->found_posts >  $posts_per_page){ ?>
                        <div class="col-md-12 load_more_row" style="text-align: center;">
                            <button type="button" id="load_more" data-count="<?php echo $wp_query->found_posts; ?>" data-totalpage="<?php echo $totalPage; ?>" data-perpage="<?php echo $posts_per_page; ?>">
                                <i class="fa fa-spinner fa-pulse loading_icon" style="display: none;"></i> 
                                <span>Load More</span>
                            </button>
                        </div>
                    <?php } ?>

                <?php }else{ ?>
                    <h1 class="entry-title-search"><?php esc_html_e( 'We didn\'t find any results. Please try again with different search parameters. ', 'wpestate' ); ?></h1>
                    <form method="get" class="searchform" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="text" class="form-control search_res_form" name="s" id="s" value="<?php esc_attr (esc_html_e( 'Type Keyword', 'wpestate' )); ?>" />
                        <input type="submit" id="submit-form" class="wpb_btn-info wpb_regularsize wpestate_vc_button  vc_button" value="<?php esc_attr ( esc_html_e( 'Search', 'wpestate') ); ?>">
                        <?php
                        if (function_exists('icl_translate') ){
                            print do_action( 'wpml_add_language_form_field' );
                        }
                        ?>
                    </form>

                <?php
                }
                wp_reset_query();
            ?>

            
        </div>
        <?php //kriesi_pagination('', $range = 2); ?>     
    </div><!-- end 8col container-->
    
<?php // include(locate_template('sidebar.php')); ?>
</div>   

<script type="text/javascript">
    jQuery(document).ready( function() {
        var count = jQuery('#load_more').data('count');
        var perpage = jQuery('#load_more').data('perpage');
        var totalpage = jQuery('#load_more').data('totalpage');
        var search_string = '<?php echo $_GET["s"]; ?>';
        var currentPage = 1;
        jQuery('#load_more').on('click', function() {
            jQuery('#load_more .loading_icon').show();
            jQuery('#load_more').attr('disabled', 'disabled');
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url("/admin-ajax.php"); ?>',
                data: {
                    action: 'load_more_prodoucts',
                    'count': count,
                    'perpage': perpage,
                    'totalpage': totalpage,
                    'currentpage': currentPage,
                    'search_string': search_string
                },
                success: function(data) {
                    jQuery(data).insertBefore('.load_more_row');
                    jQuery('#load_more .loading_icon').hide();
                    currentPage = parseInt(currentPage)+1;
                    if ( currentPage >= totalpage ) {
                        jQuery('.load_more_row').remove();
                    }
                    jQuery('#load_more').removeAttr('disabled');
                }
            });
        });
    });
</script>


<?php get_footer(); ?>