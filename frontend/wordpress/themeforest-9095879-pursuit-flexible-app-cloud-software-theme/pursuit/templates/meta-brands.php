<?php
//======================================================================
// Brands
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
$section_template_class = 'brands';
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
// Brands
//-----------------------------------------------------
if ($show == 'on'){  
	$logo_list = get_post_meta($post->ID, $key, array() );
	$logo_list_before = get_post_meta($post->ID, $key.'_before', true );

	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
}
?>
<div class="row">
<?php 
$i = 0;
	if(isset($logo_list) && !empty($logo_list)){

		foreach( $logo_list as $logo ) {
			foreach($logo as $value => $element){
				/* Get Formatted Link */
				list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
				?>
				
				<?php if($element[$key.'_image']){ ?>	
					<?php $img_src = return_metabox_image($element[$key."_image"], null, "themo_brands", true, $alt); ?>
					<?php echo $a_href; ?><img class="brand-img-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .brand-img-'.$i); ?>" src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt);?>"><?php echo $a_href_close; ?>
				<?php } ?>
			<?php 
			$i++;
			}
			
		}
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
 
