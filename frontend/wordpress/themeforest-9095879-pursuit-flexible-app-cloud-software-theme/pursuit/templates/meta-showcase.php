<?php
//======================================================================
// META FAQs Template 
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
$section_template_class = 'showcase';
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
// Showcase | Heading, Content & Image
//-----------------------------------------------------	
$floating_block_show = get_post_meta($post->ID, $key.'_show_floating_block', true );

	 if($floating_block_show == 'on'){
		$tour_content_heading = get_post_meta($post->ID, $key.'_content_heading', true );
		$tour_content = get_post_meta($post->ID, $key.'_content', true );
		$tour_image = get_post_meta($post->ID, $key.'_image', true );
		$tour_image_float = get_post_meta($post->ID, $key.'_image_float', true );
		
		// Animation
		$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
		$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
		
		/*if($tour_content > "" && $tour_image > ""){
			$cols = '6';
			$bootstrap_tier_content = 'col-sm-'.$cols;
		}else{
			$cols = '12';
			$bootstrap_tier_content = 'col-sm-'.$cols;
		}*/
		
		// Default to col-sm-6
		$cols = '6';
		$bootstrap_tier_content = 'col-sm-'.$cols;
		
		$centered = '';
		// Default image size
		$image_size = 'themo_showcase';
		
		switch ($tour_image_float) {
			case 'left':
				$image_align = ' col-sm-pull-'.$cols;
				$text_align = ' col-sm-push-'.$cols;
				break;
			case 'centered':
				$cols = '12';
				$bootstrap_tier_content = 'col-sm-'.$cols;
				$image_align = '';
				$text_align = '';
				$centered = 'centered';
				$image_size = 'themo_full_width';
				break;
			default:
				$image_align = '';
				$text_align = '';
		}?>
		
		
        <?php 
		//-----------------------------------------------------
		// Showcase Image & Paragraph
		//-----------------------------------------------------	
		if($tour_content > "" || $tour_image > ""){?>
            <div class="float-section row">
                <div class="<?php echo $bootstrap_tier_content . $text_align;?>">		
                    <?php
					//-----------------------------------------------------
					// Showcase Title
					//-----------------------------------------------------	
					if($tour_content_heading > ""){?>
						<h3 class="showcase-title <?php echo $centered; ?>"><?php echo $tour_content_heading;?></h3>	
					<?php } ?>
					<?php echo themo_content($tour_content); ?>
                </div>
                <?php if($tour_image > ""){?>
                	<?php if($centered  === "centered"){?>
                	<div class="showcase_image <?php echo $bootstrap_tier_content . $image_align;?>">
                    <?php }else{ ?> 
                    <div class="showcase_image <?php echo $bootstrap_tier_content . $image_align . themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .showcase_image');?>">		
                    <?php } ?>
                    	<?php echo return_metabox_image($tour_image,"img-responsive", $image_size); ?>
                	</div>   
                <?php } ?>
            </div>
            <?php } ?>
        <?php } ?>
		
		<?php
		//-----------------------------------------------------
		// Showcase Bullet List
		//-----------------------------------------------------	
		if($show == 'on'){
			$tours = get_post_meta($post->ID, $key, array());
			if (!empty($tours)){ ?>
                <div class="service-blocks">
                <?php  $i = 1;    
                    foreach( $tours as $tour ) {                    
                        foreach($tour as $value => $element){ ?>
                        
						<?php
                        /* Get Formatted Link */
                        list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
                        ?>

						<?php // Group every 2 blocks in a row class
                        if(themo_is_first($tour, $value) || $i % 2){ ?>
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
                        <div class="service-block col-sm-6 service-block-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .service-block-'.$i);?>">
                            <?php if($glyphicon){ ?>
							<div class="med-icon"><?php echo $a_href; ?><i class="accent <?php echo esc_attr($glyphicon_class); ?>"></i><?php echo $a_href_close; ?></div>
                            <?php } ?>
                           <h3><?php echo $a_href.$element['title'].$a_href_close;?></h3>
                           <?php echo themo_content($element[$key.'_text']); ?>
                        </div>
                        
                        <?php // Group every 2 blocks in a row class
                        if (themo_is_last($tour, $value) || $i % 2 === 0){ ?>
                        </div><!--/row-->
                        <?php } ?>
               
		                <?php $i++;
                    } // end inner loop
                } // end outer loop ?>
            </div> <!-- /.service-blocks --> 
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


