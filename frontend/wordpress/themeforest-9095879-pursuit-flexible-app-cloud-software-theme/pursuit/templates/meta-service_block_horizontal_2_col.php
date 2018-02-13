<?php
//======================================================================
// Service Blocks - Careers
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
$section_template_class = 'service-blocks-horiz';
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
// Service Blocks - Careers
//-----------------------------------------------------	
if ($show == 'on'){ 
	$service_boxes = get_post_meta($post->ID, $key, array() );
	
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
	
	// Icon Style
	$icon_style = get_post_meta($post->ID, $key."_icon_style", true);
	if($icon_style == 'standard'){
		$icon_style_class = 'med-icon';
		$block_style_class = 'standard-block';
	}else{
		$icon_style_class = 'circle-med-icon';
		$block_style_class = 'circle-block';
	}
	
	if (!empty( $service_boxes ) ) {
		$i = 1;
		foreach( $service_boxes as $box ) {                    
			foreach($box as $value => $element){ ?>
            	<?php
                /* Get Formatted Link */
                list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
                ?>
						
				<?php // Group every 2 blocks in a row class
				if(themo_is_first($box, $value) || $i % 2){ ?>
				<div class="row"> <?php  
				} ?>
				
				<?php
				 // ICONS
				$glyphicon = false;
				$glyphicon_class = "";
				if(isset($element[$key.'_glyphicons_icon_set'])){
					if($element[$key.'_glyphicons_icon_set'] > "" && $element[$key.'_glyphicons_icon_set'] != 'none'){
						$glyphicon_class = $element[$key.'_glyphicons_icon_set']." ".$element[$key.'_glyphicons-icon'];
						$glyphicon = true;
					}
				}
				?>
                        
                <div class="service-block service-block-<?php echo $i;?> <?php echo $block_style_class; ?> col-xs-12 col-sm-6  <?php echo $bootstrap_tier ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .service-block-'.$i); ?>">
					<?php if($glyphicon){ ?>
                        <div class="<?php echo $icon_style_class; ?>">
                        	<?php echo $a_href; ?><i class="accent <?php echo esc_attr($glyphicon_class); ?>"></i><?php echo $a_href_close; ?>
						</div>
					<?php } ?>
					<div class="service-block-text">
                    <h3><?php echo $a_href . $element['title'] . $a_href_close;?></h3>
					<?php echo themo_content($element[$key.'_text']); ?>
                    </div>
				</div>
				
				<?php // Group every 2 blocks in a row class
				 if (themo_is_last($box, $value) || $i % 2 === 0){ ?>
						</div><!--/row-->
				<?php } ?>
				
			<?php 
			$i++;
			} // end inner loop
		} // end outer loop ?>
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