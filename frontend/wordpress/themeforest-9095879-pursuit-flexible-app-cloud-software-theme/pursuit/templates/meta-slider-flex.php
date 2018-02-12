<?php
/*****************************
	Flexslider Template
*****************************/

$key = 'themo_slider';

$show = get_post_meta($post->ID, $key.'_sortorder_show', true );
$show_flex = get_post_meta($post->ID, $key.'_flex_show', true );
$show_shortcode = get_post_meta($post->ID, $key.'_shortcode_show', true );

if($show == 'on') { // Slider Enabled
	if($show_flex == 'on') { // Use Flex Slider
		
	
	
	// If there is a anchor link for one pager style, create output
	if($key > ""){
		$anchor_markup_open = "";
		$anchor_markup_close = "";
		$anchor_key = get_post_meta($post->ID, $key.'_anchor', true );
		if($anchor_key > ""){
			$anchor_markup_open = "<div id='$anchor_key'>";
			$anchor_markup_close = "</div>";
		}
		/*if($anchor_key > ""){
			$anchor_ahref = "<a name='$anchor_key' class='metabox-anchor'></a>";
		}*/
	};

	// Slider Conversion Form Status and shortocde
	$slider_form_status = get_post_meta($post->ID, $key.'_global_form_show', true );
	
	if($slider_form_status == 'on') {
		$slider_form_shortcode = get_post_meta($post->ID, $key.'_form_global_shortcode', true );
	}

	$themo_enable_animate = get_post_meta($post->ID, $key.'__animate', true );
	$themo_animation_style = get_post_meta($post->ID, $key.'__animate_style', true );
	
	$slides = get_post_meta($post->ID, $key."_flex", array() );
				
	$i = 0;

	// Flex slider Options
	if ( function_exists( 'ot_get_option' ) ) {
		  $themo_flex_animation  = ot_get_option( 'themo_flex_animation', "fade" );
		  $themo_flex_easing  = ot_get_option( 'themo_flex_easing', "swing" );
		  $themo_flex_animationloop  = themo_return_on_off_boolean(ot_get_option( 'themo_flex_animationloop', 'on' ));
		  $themo_flex_smoothheight  = themo_return_on_off_boolean(ot_get_option( 'themo_flex_smoothheight', 'off' ));
		  $themo_flex_slideshowspeed  = ot_get_option( 'themo_flex_slideshowspeed', 7000 );
		  $themo_flex_animationspeed  = ot_get_option( 'themo_flex_animationspeed', 600 );
		  $themo_flex_randomize  = themo_return_on_off_boolean(ot_get_option( 'themo_flex_randomize', 'off' ));
		  $themo_flex_pauseonhover  =themo_return_on_off_boolean( ot_get_option( 'themo_flex_pauseonhover', 'on' ));
		  $themo_flex_touch  = themo_return_on_off_boolean(ot_get_option( 'themo_flex_touch', 'on' ));
		  $themo_flex_directionnav  = themo_return_on_off_boolean(ot_get_option( 'themo_flex_directionnav', 'on' ));
		} 
	$themo_flex_settings = "'$themo_flex_animation', '$themo_flex_easing',
							$themo_flex_animationloop, $themo_flex_smoothheight, $themo_flex_slideshowspeed, $themo_flex_animationspeed,
							$themo_flex_randomize, $themo_flex_pauseonhover, $themo_flex_touch, $themo_flex_directionnav";
	
	?>
	<?php echo $anchor_markup_open; ?>
    <div id="main-flex-slider" class="flexslider">
        <ul class="slides">
        <?php
        $i = 0;
		$js_transparent_header_adjust = "";
        foreach( $slides as $slide_array ) {
            foreach($slide_array as $slide => $element){
			
			$js_transparent_header_adjust .= "adjust_padding_transparent_header('#main-flex-slider .themo_slider_$i'); ";
			
			/*****************************
                Slider Background Output.
                Includes: Color, background-repeat, background-attachment, background-postition, background-size, background-image
                Parameter #1 = background array from OptionTree that contains all values above.
                Parameter #2 = CSS Identifier, can be a class or ID
                Function outputs CSS inside of an internal style sheet.							
            *****************************/
           $slider_bg_css = "";
           $text_contrast =  $element[$key.'__text_contrast'];
		   
		   if($text_contrast == 'light'){ // Add Text White Class
				$text_contrast_class = "light-text";
			}else{
				$text_contrast_class = "";
			}
			
			// Add large styling class if selected.
			$large_style_class = "";
			
			if (isset($element[$key.'_large_styling']) && $element[$key.'_large_styling'] == 'on'){ 
				$large_style_class = "lrg-txt ";
			}
		   
		    if($element[$key.'__background']){
                // Return b/g image. If it's full width use backstretch for mobile / touch screens.
				list($background_settings,$is_full_width,$background_image_filtered) = themo_custom_background($element[$key.'__background'],".slider-bg");
			
				$slider_bg_css = $background_settings;
				
            }
			/* END Slider Background Output. */
				
			$padding_css = '';
						
			if(isset($element[$key.'__padding']) && $element[$key.'__padding'] == 'on'){
				
				$top_padding = $element[$key.'__top_padding'];
				$bottom_padding = $element[$key.'__bottom_padding'];
				
				
				$padding_css = "#main-flex-slider .".$key."_".$i."{padding-top:".$top_padding."px ; padding-bottom:".$bottom_padding."px }\n";
				
				/*if ($top_padding > 0){
					$padding_css = ".".$key."_".$i."{padding-top:".$top_padding."px !important}\n";
				}
				if ($bottom_padding > 0){
					$padding_css .= ".".$key."_".$i."{padding-bottom:".$bottom_padding."px !important}\n";
				}*/
				
			}
			
			if ($padding_css > ""){ ?>
			<style>
            <?php echo $padding_css;  // PADDING CSS ?>
            </style>
            <?php }


            ?>
            <li>
                <div class="slider-bg <?php echo $text_contrast_class; ?> <?php echo $key."_".$i; ?>" <?php echo $slider_bg_css;?>  >
                    <?php echo $inner_container_open;?>
                        <div class="row <?php echo $large_style_class; ?>">
                            
							<?php $i++; ?>
                                <?php 
                            /*****************************
                                 Slider Title, Subtitle and button
                            *****************************/
                            
                            if($element['title']) {?> 
                            	<h1 class="slider-title <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .slider-title'); ?>"><?php echo $element['title']; ?> </h1>
							<?php } // Title
                            if($element[$key.'_subtitle']) { ?>
								<div class="slider-subtitle <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .slider-subtitle'); ?>"><?php echo themo_content($element[$key.'_subtitle']); ?> </div>
							<?php } // Subtitle
							
							// Check for link target
							$button_link_target = '';
							if(isset($element[$key.'__button_link_target']) && is_array($element[$key.'__button_link_target'])){
								if($element[$key.'__button_link_target'][0] > "")
								$button_link_target = "target='".$element[$key.'__button_link_target'][0]."'";
							}					
							
							// Button
							$meta_box_show_button = $element[$key.'__show_button']; // get button state
							if($meta_box_show_button == 'on'){
								$page_header_button_text = $element[$key.'__button_text']; // button text
								$page_header_button_link = $element[$key.'__button_link']; // button link
								$page_header_button_style = $element[$key.'__button_style']; // button style


								$button_link_target = false;
								$button_link_target = $element[$key.'__button_link_target'];

								if(isset($button_link_target) && is_array($button_link_target)){
									if($button_link_target[0] > ""){
										$button_link_target = $button_link_target[0];
									}
								}

								$page_header_button = do_shortcode("[button text='$page_header_button_text' url='$page_header_button_link' type='$page_header_button_style' target='$button_link_target']"); // Returns Page header button
								$page_header_button = "<div class='page-title-button ".themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .page-title-button')."'>".$page_header_button."</div>";
								echo $page_header_button;
							}
                            
                            /* END Slider Title, Subtitle and button */
                
                            /*****************************
                                Slider Image 
                            *****************************/
                            if($element[$key.'_image']) {

							/* Get Formatted Link */
							list($a_href,$a_href_text,$a_href_close) = return_formatted_link($element,$key.'_');
							?>
							<?php $slider_image = $a_href . return_metabox_image($element[$key."_image"],"hero", "themo_full_width") . $a_href_close ?>
                            <?php echo "<div class='page-title-image ".themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .page-title-image')."'>".$slider_image."</div>"; ?>
							<?php } /* END Slider Image */ ?>
                            
                            <?php
                            /*****************************
                                Slider Conversion Form Shortcode.
                                Uses Global if enabled, else uses individual.
                            *****************************/
                            if($slider_form_status == 'on' && $slider_form_shortcode > "") { ?>
                                <div class="simple-conversion <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .simple-conversion');?>"> <?php
                                	echo do_shortcode( $slider_form_shortcode ); 
									?>
                                    
                                </div> <?php
                            }elseif($element[$key.'_form_shortcode'] > ''){?>
                               <div class="simple-conversion <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#main-flex-slider .simple-conversion');?>"> <?php
                                	echo do_shortcode( $element[$key.'_form_shortcode'] );
									?>
                                </div> <?php
                            }
                            /* END Slider Conversion Form */
                            ?>
                        </div><!-- /.row -->
                    <?php echo $inner_container_close;?>
                    </div><!-- /.slider-bg -->
            
            </li>
         <?php
          } // END FOR EACH 
         } // END FOR EACH ?>
         
        </ul>
        
    </div><!-- /.main-flex-slider -->
    <?php echo $anchor_markup_close; ?>
   <script>
	   jQuery(window).load(function() {
            <?php echo $js_transparent_header_adjust; ?>
			start_flex_slider('#main-flex-slider',<?php echo $themo_flex_settings; ?>);
        });
    </script>
    
     <?php
	// backstretch for mobile support
	//if ($background_js > ""){ ?>
		<!--script>
    		if (Modernizr.touch) {
				<?php //echo $background_js;  ?>
			}
    	</script-->
    <?php //} ?>

<?php 
}elseif($show_shortcode == 'on') { // Use Other Slider via Shortocde
		include( locate_template( 'templates/meta-slider-shortcode.php' ) );
	}
}
