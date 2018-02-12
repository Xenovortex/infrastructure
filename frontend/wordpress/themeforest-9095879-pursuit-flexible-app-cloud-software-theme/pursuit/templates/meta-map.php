<?php
//======================================================================
// MAP
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
$section_template_class = 'full-map';
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
// Map
//-----------------------------------------------------

$display_in_page_header = get_post_meta($post->ID, $key.'_in_heder', true );
$gmap_shortcode = get_post_meta($post->ID, $key.'_shortcode', true );
if ($gmap_shortcode > "" && $display_in_page_header == 'off'){
?>
<div class="row">
<div class="col-xs-12"><div class="aligncenter"><?php echo do_shortcode($gmap_shortcode); ?></div></div>
</div>
<?php } ?>


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
