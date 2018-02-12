<?php
//-----------------------------------------------------
// Border Settings and Output
//-----------------------------------------------------

$border_show = "";
$border_display = "";
$border_full_width = "";

/* We can also use arrays if present */
if(isset($options_array) && !empty( $options_array )){
	if(isset($options_array[$key.'_show_border'])){
		$border_show = $options_array[$key.'_show_border'];
	}
	if(isset($options_array[$key.'_border'])){
		$border_display = $options_array[$key.'_border'];
	}
	if(isset($options_array[$key.'_border_full_width'])){
		$border_full_width = $options_array[$key.'_border_full_width'];
	}

}else{
	$border_show = get_post_meta($post->ID, $key.'_show_border', true );
	$border_display = get_post_meta($post->ID, $key.'_border', true );
	$border_full_width = get_post_meta($post->ID, $key.'_border_full_width', true );
}
echo themo_return_meta_box_borders($border_show,$border_display,'top',$border_full_width); ?>