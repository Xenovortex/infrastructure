<?php
//======================================================================
// Service Boxes - Vertical
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
$section_template_class = 'icon-blocks';
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
// Service Blocks
//-----------------------------------------------------
	if ($show == 'on'){ // is this featured enabled? 	
		$service_boxes = get_post_meta($post->ID, $key, array() );
		
		// Animation
		$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
		$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
		?>
            <?php
            if (!empty($service_boxes)) { // Check if we have something to report ?>
            	<div class="row">
				<?php
				$i = 1;
				foreach( $service_boxes as $box ) {                    
					
					/* Count number of boxes and output HTML accordingly */
					$box_count = count($box);
					switch ($box_count) {
						case 1:
							$bootstrap_tier = 'col-md-6 col-md-offset-3';
							break;
						case 2:
							$bootstrap_tier = 'col-md-6';
							break;
						default:
							$bootstrap_tier = 'col-md-4';
						break;
					}
			
					foreach($box as $value => $element){
						
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
						<?php
							/* Get Formatted Link */
							list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
                        ?>
						
                            <div class="icon-block icon-block-<?php echo $i;?> <?php echo $bootstrap_tier ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .icon-block-'.$i,200); ?>">
                                <div class="circle-lrg-icon">
                                    <?php if($glyphicon){ ?><?php echo $a_href; ?><i class="<?php echo esc_attr($glyphicon_class); ?>"></i><?php echo $a_href_close; ?><?php } ?>
                                </div>
                                <h3><?php echo $a_href; ?><?php echo $element['title']; ?><?php echo $a_href_close; ?></h3>
                                <?php echo themo_content($element[$key.'_text']); ?>
                            </div>
						<?php
						if ($i++ == 3) break;
				} // end inner loop
			} // end outer loop ?>
            </div><!--/row-->
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

