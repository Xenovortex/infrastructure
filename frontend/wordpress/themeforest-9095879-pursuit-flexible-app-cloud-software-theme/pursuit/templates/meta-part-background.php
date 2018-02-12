<?php
//-----------------------------------------------------
// BACKGROUND & PADDING OPTIONS out OUTPUT Inline Style Sheet
//-----------------------------------------------------
$parallax_classes="";
$parallax_data="";

/* We can also use arrays if present */
if(isset($options_array) && !empty( $options_array )){
	//$section_id = $key.$i;
	$background_show = $options_array[$key.'_show_background'];
	$background =  $options_array[$key.'_background'];
	$background_parallax_show =  $options_array[$key.'_parallax'];
	$text_contrast =  $options_array[$key.'_text_contrast'];
	$padding_show = $options_array[$key.'_padding'];
	$top_padding = $options_array[$key.'_top_padding'];
	$bottom_padding = $options_array[$key.'_bottom_padding'];
    $background_video_MP4 = $options_array[$key.'_background_video_mp4'];
}else{
	//$section_id = $key.$i;
	$background_show = get_post_meta($post->ID, $key.'_show_background', true );
	$background = get_post_meta($post->ID, $key.'_background', true );
	$background_parallax_show = get_post_meta($post->ID, $key.'_parallax', true );
	$text_contrast = get_post_meta($post->ID, $key.'_text_contrast', true );
	$padding_show = get_post_meta($post->ID, $key.'_padding', true );
	$top_padding = get_post_meta($post->ID, $key.'_top_padding', true );
	$bottom_padding = get_post_meta($post->ID, $key.'_bottom_padding', true );
    $background_video_MP4 = get_post_meta($post->ID, $key.'_background_video_mp4', true );
}

// If there is a unique ID specified, use it, else use the key.
if(isset($section_uid) && $section_uid > ''){
	$section_key = $section_uid;
}else{
	$section_key = $key;
}

// If the page has a sidebar, hide background options, except for Page Header.
if (isset($page_layout) && (isset($key))){
	if(($page_layout == 'right' || $page_layout == 'left') && ($key != 'themo_page_header_1')) {
		$background_show = 'off';
	}
}

themo_return_meta_box_background_markup($background_show,$background,$background_parallax_show,$parallax_classes,$parallax_data,$background_css,$background_js,$section_key,$text_contrast,$background_video_MP4);
themo_return_meta_box_padding_markup($padding_show,$top_padding,$bottom_padding,$padding_css,$section_key);

if ($background_css > "" || $padding_css > ""){ ?>
<style scoped>
<?php echo $background_css;  // PARALLAX INLINE CSS ?>
<?php echo $padding_css;  // PADDING CSS ?>
</style>
<?php }