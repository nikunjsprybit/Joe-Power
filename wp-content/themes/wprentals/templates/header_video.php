<?php
global $post;
if( isset($post->ID) ){
    $video_url           = 	get_post_meta($post->ID, 'video_url', true);
}else{
    $video_url           =	'http://demo1.wprentals.org/wp-content/uploads/2017/10/video.mp4'; 
}
?>
<div class="wpestate_header_video full_screen_no parallax_effect_yes" style=" height:580px; "><video id="hero-vid" class="header_video" poster="" width="100%" height="100%" autoplay="" muted="" loop="">
	<source src="<?php echo $video_url; ?>" type="video/mp4">
	<source src="" type="video/webm">
				<source src="" type="video/ogg">

</video><div class="wpestate_header_video_overlay" style="opacity:0.7;background-image:url();"></div><div class="heading_over_video_wrapper"><h1 class="heading_over_video">Let your Equipment Work for You</h1><div class="subheading_over_video">Why have your equipment collecting dust when it can generate revenue 24/7</div></div></div>