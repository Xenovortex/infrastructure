<?php
/*****************************
	Master Slider Template
*****************************/

if(isset($post->ID)){
	$postID = $post->ID;
}else{
	$postID = get_the_ID();
}

$metadata = get_post_meta($postID);

$key = 'themo_slider_master';
$show = "on"; // Default to ON
$show = get_post_meta($postID, $key.'_show', true );

$shortcode = get_post_meta($postID, $key.'_shortcode', true );

if(isset($show) && $show != 'off' && isset($shortcode) && $shortcode > "" ){
	echo do_shortcode(sanitize_text_field($shortcode));
}
