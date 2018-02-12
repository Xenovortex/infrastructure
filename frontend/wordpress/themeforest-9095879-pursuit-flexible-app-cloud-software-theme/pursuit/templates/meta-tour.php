<?php
//======================================================================
// Tour Template 
//======================================================================
?>

<section <?php if($key > ""){echo 'id="'.$key.'"';} ?> class="floated-blocks">
<?php 
/*****************************
	Careers | Show job postings
*****************************/

if ($show == 'on'){ 
	$themo_float = get_post_meta($post->ID, $key, array());
	if (!empty( $themo_float ) ) {
		$i = 0;
		foreach( $themo_float as $row ) {                    
			foreach($row as $value => $element){ 			
				// Image Float
				if (!isset($element[$key.'_photo_align'])){
					$element[$key.'_photo_align'] = "centred";
				}
					// Default image size
					$image_size = 'themo_team';
					
					switch ($element[$key.'_photo_align']) {
						case 'right':
							$align_class = "img-right";
							$bootstrap_tier_content = "col-sm-8";
							$bootstrap_tier_image = "col-sm-4";
							break;
						case 'left':
							$align_class = "img-left";
							$bootstrap_tier_content = "col-sm-8";
							$bootstrap_tier_image = "col-sm-4";
							break;
						case 'centered':
							$align_class = "img-center";
							$bootstrap_tier_content = "col-sm-12";
							$bootstrap_tier_image = "col-sm-12";
							$image_size = 'themo_full_width';
							break;
					}
			
				// Image Sticky
				switch ($element[$key.'_photo_sticky']) {
					case 'bottom':
						$sticky_class = "img-sticky-bottom";
						break;
					case 'top':
						$sticky_class = "img-sticky-top";
						break;
					default:
						$sticky_class = "";
				}
				?>
				<?php
                
				$options_array = $element;
				$section_uid = $key."_".$i;
				
				// Add large styling class if selected.
				$large_style_class = "";
				if (isset($element[$key.'_large_styling']) && $element[$key.'_large_styling'] == 'on'){ 
					$large_style_class = "large-tour ";
				}
				
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
                $section_template_class = 'float-block '. $large_style_class . $align_class;
				// add large-tour after float-block
                include( locate_template('templates/meta-part-' . $partName . '.php') );
				
				
				// Animation
				$themo_enable_animate = $element[$key.'_animate'] ;
				$themo_animation_style = $element[$key.'_animate_style'];
				?>
                
					<div class="row">                                                
                        <div class="float-content <?php echo $bootstrap_tier_content; ?>">
                            <div class="center-table-con">
                                <div class="center-table-cell">                                    
									<?php
                                    if ($element['title'] > ''){ ?>
                                        <h2 class="tour-content-title tour-title-<?php echo $i;?>  <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$section_uid.' .tour-title-'.$i); ?>"><?php echo $element['title']; ?></h2>
                                    <?php }
                                    if ($element[$key.'_text'] > ''){ ?>
                                        <div class="tour-content-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$section_uid.' .tour-content-'.$i); ?>"><?php echo themo_content($element[$key.'_text']); ?></div>
                                    <?php } ?>
									<div class="tour-button-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$section_uid.' .tour-button-'.$i); ?>"><?php do_shortocde_button($element, $key);?></div>                                 
                                </div>
                            </div>                        
                        </div>                        						
						<?php if ($element[$key.'_photo'] > ''){ ?>
                        <div class="float-img <?php echo $bootstrap_tier_image; ?>">
                            <div class="center-table-con">
                                <div class="center-table-cell <?php echo $sticky_class; ?>">
                           			<?php echo return_metabox_image($element[$key."_photo"],"img-responsive", $image_size); ?>
                            	</div>
                        	</div>
                        </div>
                        <?php } ?>
					</div>
                    
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

			 <?php $i++;
			} // end inner loop
		} // end outer loop ?>
	<?php } // end inner if / then ?>
<?php } // end outer if / then  ?>
</section>

<?php
$background_array = "";
$section_uid = "";
