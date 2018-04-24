<?php
/*
Template name: Agriculture Sub Category Listing
*/
get_header(); 
get_template_part('templates/breadcrumbs'); ?>
<div class="col-md-12 agri_title">
    <h2><?php echo get_the_title(); ?></h2>
</div>

<div class="col-md-12 agri-listing">
    <div class="row content-fixed">
        <?php 
        global $post;
        $parentTerm = get_term_by('slug', $post->post_name, 'product_cat'); 
        if ( isset($parentTerm->term_id) && !empty($parentTerm->term_id) ) {
            $product_child_categories   = get_terms('product_cat', 'orderby=name&hide_empty=0&parent='.$parentTerm->term_id); ?>
            <?php foreach ($product_child_categories as $key => $value) { 
                $cat_thumb_id = get_woocommerce_term_meta( $value->term_id, 'thumbnail_id', true );
                $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' ); 

                if ( isset($shop_catalog_img[0]) && !empty($shop_catalog_img[0]) ) {
                    $url = $shop_catalog_img[0];
                }
                else{
                    $url = get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
                } 
                $get_term_link = get_term_link($value->term_id, 'product_cat');
                if ($value->slug == 'construction-agriculture' ) {
                     $get_term_link = site_url().'/construction/';
                } 
                else if($value->slug == 'agriculturefarm'){
                     $get_term_link = site_url().'/agriculture/';
                }
                $term = get_term($value->term_id, 'product_cat' ); ?>
                <div class="col-md-4">
                    <a href="<?php echo $get_term_link; ?>" data-slug="<?php echo $value->slug; ?>">
                        <div class="agri-listing-box">
                            <div class="agri-listing-img">
                        		<img height="300px" src="<?php echo $url; ?>" >
                        	</div>
                        	<div class="agri-listing-info">
                        		<h3><?php echo $value->name; ?></h3>
                        		<p>(<?php echo $term->count; ?>)</p>
                        	</div>
                        </div>
                    </a>
                </div>
            <?php 
			} 
        } else{
            echo "<h2>Nothing Found.</h2>";
        } ?>
    </div>
</div>   
<?php get_footer(); ?>