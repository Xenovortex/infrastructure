<?php
//-----------------------------------------------------
// Preloader, Section, Container Open
//-----------------------------------------------------
?>

<?php
// If there is a unique ID specified, use it, else use the key.
if(isset($section_uid) && $section_uid > ""){
	$section_key = $section_uid;
}else{
	$section_key = $key;
}
?>

<?php 

// If there is a anchor link for one pager style, create output
if($section_key > ""){
	$anchor_id_markup = "";
	$anchor_key = get_post_meta($post->ID, $key.'_anchor', true );
	if($anchor_key > ""){
		$anchor_id_markup = "id='$anchor_key'";
	}
	/*if($anchor_key > ""){
		$anchor_ahref = "<a name='$anchor_key' class='metabox-anchor'></a>";
	}*/
};

// Check for parallax background images, if present, add preloading classes.
if (strpos($parallax_classes,'parallax-preload') > 0){
	echo '<div '.$anchor_id_markup.' class="preloader loading">';
}else{
	echo '<div '.$anchor_id_markup.' >';
}

?>

<?php //if(isset($anchor_ahref) && $anchor_ahref > ""){echo $anchor_ahref;} ?>
<section <?php if($section_key > ""){echo 'id="'.$section_key.'"';} ?> class="<?php echo $anchor_key_class; ?> <?php echo $section_template_class; ?> <?php echo $parallax_classes ; ?>" <?php echo $parallax_data ; ?> >
<?php echo $inner_container_open;?>