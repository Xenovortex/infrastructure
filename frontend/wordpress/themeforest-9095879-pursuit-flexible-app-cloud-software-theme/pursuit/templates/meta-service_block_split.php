<?php
//======================================================================
// Service Block Split - Template
//======================================================================
?>
<?php
//-----------------------------------------------------
// GET BACKGROUND
//-----------------------------------------------------
$partName = 'background';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// GET BORDER
//-----------------------------------------------------
$partName = 'border';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>


<?php
//-----------------------------------------------------
// Preloader, Section, Container Open
//-----------------------------------------------------
$partName = 'preload-container';
$section_template_class = 'service-split';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>


<?php
//-----------------------------------------------------
// Meta Box Header / Subtext
//-----------------------------------------------------
$partName = 'header';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// Column Sizing
//-----------------------------------------------------
$html_show = get_post_meta($post->ID, $key.'_show_content', true );

if ($html_show == 'on' && $show = 'on'){ // switch between 50% / 50% or 100% width.
	$bootstrap_tier = 'col-sm-6';	
}else{
	$bootstrap_tier = 'col-sx-12';
}

//-----------------------------------------------------
// Reverse Float Alignment
//-----------------------------------------------------
$contact_reverse = get_post_meta($post->ID, $key.'_reverse', true ); // Reverse Floats
$bootstrap_tier_pull = "";
$bootstrap_tier_push = "";

if ($contact_reverse == 'on'){
	$bootstrap_tier_pull = ' col-sm-pull-6';
	$bootstrap_tier_push = ' col-sm-push-6';
}

?>


<div class="row">
	<?php
	//-----------------------------------------------------
	// SIDE BAR?
	//-----------------------------------------------------
	$page_layout = get_post_meta($post->ID, 'themo_page_layout', true );
	if($page_layout == 'right' || $page_layout == 'left'){
		
		$bootstrap_tier = 'col-sm-12';
		$bootstrap_tier_pull = "";
		$bootstrap_tier_push = "";
		if ($contact_reverse == 'on'){
			themo_print_service_block_HTML($html_show,$post,$key,$bootstrap_tier,$bootstrap_tier_pull);
			themo_print_service_block($show,$post,$key,$bootstrap_tier,$bootstrap_tier_push);
		}else{
			themo_print_service_block($show,$post,$key,$bootstrap_tier,$bootstrap_tier_push);
			themo_print_service_block_HTML($html_show,$post,$key,$bootstrap_tier,$bootstrap_tier_pull);
		}
	}else{
		
		themo_print_service_block($show,$post,$key,$bootstrap_tier,$bootstrap_tier_push);
		themo_print_service_block_HTML($html_show,$post,$key,$bootstrap_tier,$bootstrap_tier_pull);
	}
	
	?>
	

</div><!-- /.row -->

<?php
//-----------------------------------------------------
// Preloader, Section, Container Close
//-----------------------------------------------------
$partName = 'preload-container-close';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>

<?php
//-----------------------------------------------------
// GET BORDER CLOSE
//-----------------------------------------------------
$partName = 'border-close';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>