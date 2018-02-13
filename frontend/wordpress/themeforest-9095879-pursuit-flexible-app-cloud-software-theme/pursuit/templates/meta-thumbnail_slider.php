<?php
//======================================================================
// Thumbnail Slider
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
$section_template_class = 'thumb-slider';
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
// Thumbnail Slider
//-----------------------------------------------------
if ($show == 'on'){ 
	//echo $key;
	$thumbnails = get_post_meta($post->ID, $key, array() );
	
	// Animation
	$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );
	
	// Image Orientation
	$image_orientation = get_post_meta($post->ID, $key.'_image_orientation', true );
	
	$image_size = 'themo_thumbnail_slider';
	
	if($image_orientation === 'portrait'){
		$image_size = 'themo_thumbnail_slider_portrait';
	}	
	
	// Lightbox Support
	$lightbox_enabled = get_post_meta($post->ID, $key.'_lightbox', true );
	
	
	//echo $themo_enable_animate;
	//echo "KEY: ".$key;

	if (!empty( $thumbnails ) ) { ?>
    
    <?php //the_meta(); ?>
    
	
	
	<div class="row">
        <div id="<?php echo $key;?>_inner" class="thumb-flex-slider flexslider flex-<?php echo $image_orientation; ?> col-xs-12">
            <ul class="slides gallery">
                <?php
                $i = 1;
                foreach( $thumbnails as $slider ) { // Loop through each thumbnail slide
                    foreach($slider as $value => $element){ 
						$unique_img_class = 'thumb-flex-slider-img-'.$i;
					?>
                        <li class="<?php echo $unique_img_class . themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .'.$unique_img_class); ?>">
                            
                            <?php
							/* Get Formatted Link */
							list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key);
							?>
							
							<?php 
								if($element[$key.'_image']){
									$img_src = return_metabox_image($element[$key."_image"], null, $image_size, true, $alt);
									if($lightbox_enabled === 'on'){
										$content = "<a href='".$element[$key."_image"]."' data-parent='slides'><img src=".$img_src." class='img-responsive' alt=".$alt."></a>";
										$lighbox = themo_add_lighbox_data($content);
										echo $lighbox;
									}else{
										echo $a_href; ?><img src="<?php echo esc_url($img_src); ?>" class="img-responsive " alt="<?php echo esc_attr($alt);?>"><?php echo $a_href_close; ?>
                                	<?php 
									}
								} 
							?>
                            
                            <?php if($element['title']){ ?>	
                                <p class="thumb-title">
									<?php echo $a_href; ?><?php echo $element['title']; ?><?php echo $a_href_close; ?>
                                    <?php if($element[$key.'_small_text']){ ?>	
                                        <span><?php echo $element[$key.'_small_text']; ?></span>
                                    <?php } ?>
                                </p>
                            <?php } 
                            $i++;
                            ?>
                        </li><?php
                    $i++;
                    } // end inner loop
                } // end outer loop ?>
            </ul><!-- /.slides -->
        </div> <!-- /.thumb-flex-slider -->
    </div><!-- /.row -->
    <script>
	jQuery(window).load(function() {
		start_thumbnail_slider('#<?php echo $key;?>_inner');
	});
	</script>
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
