<?php
//======================================================================
// Testimonials Template
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
$section_template_class = 'testimonials';
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
// Testimonials Loop
//-----------------------------------------------------
 if ($show == 'on'){ 
	$testimonials = get_post_meta($post->ID, $key, array() );
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
		
	if (!empty( $testimonials ) ) { ?>

		<?php
		$i = 1;
		foreach( $testimonials as $testimonial ) {
			/* Count number of boxes and output HTML accordingly */
			$testimonial_count = count($testimonial);
			switch ($testimonial_count) {
				case 1:
					$bootstrap_tier = 'col-md-12';
					break;
				case 2:
					$bootstrap_tier = 'col-md-6';
					break;
				default:
					$bootstrap_tier = 'col-md-4';
				break;
			}
			foreach($testimonial as $value => $element){  
				$panel_count = convertNumber($i);
				$panel_count = ucwords(strtolower($panel_count));
				if ($i == 1){
					$first = "in";
				}else{
					$first = "";
				}	
				?>
				<?php // Group every 3 blocks in a row class
                if(themo_is_first($testimonial, $value) || ($i-1) % 3 == 0){ ?>
                <div class="row"> <?php  
                } ?>
                 <div class="<?php echo $bootstrap_tier ?> ">
                        <figure class="quote">
                        <?php if(isset($element[$key."_quote"]) && $element[$key."_quote"] > ""){ ?>
                            <blockquote class="blockquote-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .blockquote-'.$i); ?>"><?php echo $element[$key."_quote"] ; ?></blockquote>
                        <?php } ?>
                        <?php if(isset($element[$key.'_photo']) && $element[$key.'_photo'] > ""){ ?>
                            <?php $img_src = return_metabox_image($element[$key."_photo"], null, "themo_testimonials", true, $alt); ?>
                            <img class="circle circle-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .circle-'.$i); ?>" src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($alt);?>">
                        <?php } ?>
                         <?php if( (isset($element[$key.'_position']) && $element[$key.'_position'] > "") || (isset($element['title']) && $element['title'] > "")){ ?>
                            <figcaption class="figcaption-<?php echo $i;?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .figcaption-'.$i); ?>"><?php echo $element['title'] ; ?> <span><?php echo $element[$key.'_position'] ; ?></span></figcaption>
                        <?php } ?>
                        </figure>   
				</div><!-- /.col-md-4 -->
                <?php // Group every 4 blocks in a row class
                if (themo_is_last($testimonial, $value) || $i % 3 == 0){ ?>
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

