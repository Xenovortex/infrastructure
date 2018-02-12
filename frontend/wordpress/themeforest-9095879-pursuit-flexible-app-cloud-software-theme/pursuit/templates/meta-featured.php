<!-- START FEATURED TEMPLATE -->
<?php
//======================================================================
// Features Template 
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
$section_template_class = 'features';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>
<div class="features-inner">

<?php
//-----------------------------------------------------
// Meta Box Header / Subtext
//-----------------------------------------------------
$partName = 'header';
include( locate_template('templates/meta-part-' . $partName . '.php') );
?>
		
        
<?php
//-----------------------------------------------------
// Featured
//-----------------------------------------------------
if ($show == 'on'){ 
	$features = get_post_meta($post->ID, $key, array());
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
	
	if (!empty( $features ) ) { ?>
			<?php
			$i = 1;
			foreach( $features as $feature ) {                    
				foreach($feature as $value => $element){  ?>
					<?php // Group every 2 blocks in a row class
					if(themo_is_first($feature, $value) || $i % 2){ ?>
					<div class="row"> <?php  
					} ?>
					<?php
                    /* Get Formatted Link */
                    list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
                    ?>
					<div class="col-md-6">
						<div class="feature-block">
							<?php if(isset($element[$key.'_image']) && $element[$key.'_image'] > ""){ ?>
								<?php $img_src = return_metabox_image($element[$key."_image"], null, "themo_featured", true, $alt); ?>
                            	<?php echo $a_href; ?><img class="feature-img-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .feature-img-'.$i); ?>" src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt);?>"><?php echo $a_href_close; ?>
							<?php } ?>
							<?php if(isset($element['title']) && $element['title'] > ""){ ?>
								<h3 class="feature-title-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .feature-title-'.$i); ?>"><?php echo $a_href; ?><?php echo $element['title'] ; ?><?php echo $a_href_close; ?></h3>
							<?php } ?>
							<?php if(isset($element[$key.'_text']) && $element[$key.'_text'] > ""){ ?>
								<div class="feature-text-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .feature-text-'.$i); ?>"><?php echo themo_content($element[$key.'_text']); ?></div>
							<?php } ?>
						</div><!-- /.feature-block -->
					</div><!-- /.col-md-6 -->
                    <?php // Group every 2 blocks in a row class
					if (themo_is_last($feature, $value) || $i % 2 === 0){ ?>
					</div><!--/row-->
					<?php } ?>
				<?php
				$i++;
				} // end foreach inner
			} // end featured outer ?>
		</div> <!-- /.featured-inner -->
	<?php } // end inner if / then ?>
<?php } // end outer if / then  ?>

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
<!-- END FEATURED TEMPLATE -->