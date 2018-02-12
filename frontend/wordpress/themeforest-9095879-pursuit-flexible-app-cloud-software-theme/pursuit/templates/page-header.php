<?php
//======================================================================
// Page Header Template
//======================================================================
?>

<?php
//-----------------------------------------------------
// Set Key
//-----------------------------------------------------
$key = 'themo_page_header';
$i = 1;
$key = 'themo_page_header_'.$i;

//-----------------------------------------------------
// Display On?
//-----------------------------------------------------
//echo "Page ID: " . $post->ID;	

$show = get_post_meta($post->ID, $key.'_show', true );
$show_header = get_post_meta($post->ID, $key.'_show_header', true );
$page_header_float = get_post_meta($post->ID, $key.'_header_float', true );

// Animation
$themo_enable_animate = get_post_meta($post->ID, $key.'_animate', true );
$themo_animation_style = get_post_meta($post->ID, $key.'_animate_style', true );

// Anchor
if($key > ""){
	$anchor_id_markup = "";
	$anchor_key = get_post_meta($post->ID, $key.'_anchor', true );
	if($anchor_key > ""){
		$anchor_id_markup = "id='$anchor_key'";
	}
};


if($page_header_float == ''){
	$page_header_float = "centered";
}

if ($show == 'on'){ ?>

	<?php	
	// Default Header Styling
	$page_subheader_default = '<div class="subheader"></div>';
	$page_subheader_default_show = true; // Show subheader by default
	
	// Default Title Text
	$page_header_title = the_title( '<h1>', '</h1>', false );
	$page_header_text = "";
	$page_header_button_text = "";
	$page_header_button_link = "";
	$page_header_button_style = "";
	$page_header_button = "";
	?>
    
	<?php
	//-----------------------------------------------------
	// Header and Subtext
	//-----------------------------------------------------
	if($show_header == 'on'){ // Show header / subetext?
		$meta_box_heading = get_post_meta($post->ID, $key.'_header', true ); // get heading
		$meta_box_subtext = get_post_meta($post->ID, $key.'_subtext', true ); // get subtext


		$meta_box_float = get_post_meta($post->ID, $key.'_header_float', true ); // get alignment 		
        
		$page_header_title = "<h1 class='page-title-h1 ".themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .page-title-h1')."'>" . $meta_box_heading. "</h1>"; // Returns Page header title
		$page_header_text = "";
		if($meta_box_subtext > ""){
			$page_header_text = "<h4 class='page-title-h4 ".themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .page-title-h4')."'>" . $meta_box_subtext. "</h4>"; // Returns Page header text
		}

		// Button
		$meta_box_show_button = get_post_meta($post->ID, $key.'_show_button', true ); // get button state
		if($meta_box_show_button == 'on'){
			$page_header_button_text = get_post_meta($post->ID, $key.'_button_text', true ); // button text
			$page_header_button_link = get_post_meta($post->ID, $key.'_button_link', true ); // button link
			$page_header_button_style = get_post_meta($post->ID, $key.'_button_style', true ); // button style

            $button_link_target = get_post_meta($post->ID, $key.'_button_link_target', true );

            if(isset($button_link_target) && is_array($button_link_target)){
                if($button_link_target[0] > ""){
                    $button_link_target = $button_link_target[0];
                }
            }

            $page_header_button = do_shortcode("[button text='$page_header_button_text' url='$page_header_button_link' type='$page_header_button_style'  target='$button_link_target']"); // Returns Page header button
			$page_header_button = "<div class='page-title-button ".themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.' .page-title-button')."'>".$page_header_button."</div>";
		}
		
		
		//$page_header_float = get_post_meta($post->ID, $key.'_float', true ); // Returns Page header Float	
	?>
    
	<?php
	//-----------------------------------------------------
	// MAP
	//-----------------------------------------------------
	$show_map = get_post_meta($post->ID, 'themo_map_1_show', true ); // Returns Show Map (on / off)
	$gmap_shortcode = get_post_meta($post->ID, 'themo_map_1_shortcode', true ); // Returns Google Map 
	$map_in_header = get_post_meta($post->ID, 'themo_map_1_in_heder', true ); // Returns Google Map
	
	
	$gmap_show = false;

	
	// Check if gmail is in header  / output
	if ($map_in_header == 'on' && $gmap_shortcode > "" && $show_map == 'on'){ 
	$gmap_show = true;
	$page_subheader_default_show = false; // Don't show subheader, we'll replace with gmaip ?>
		<div class="aligncenter"><?php echo do_shortcode($gmap_shortcode); ?></div>
	<?php } ?>
	<?php
	//-----------------------------------------------------
	// Background
	//-----------------------------------------------------
	$background_show = get_post_meta($post->ID, $key.'_show_background', true );
		
	if($background_show == "on" && !$gmap_show){ 
		$page_subheader_default_show = false; // Don't show subheader, we'll replace with an image 
		$partName = 'background';
		include( locate_template('templates/meta-part-' . $partName . '.php') );
		?>
        <?php
		//-----------------------------------------------------
		// GET BORDER
		//-----------------------------------------------------
		$partName = 'border';
		include( locate_template('templates/meta-part-' . $partName . '.php') );
		// If there is a anchor link for one pager style, create output
		?>
   		<div <?php echo $anchor_id_markup; ?> class="preloader loading">
			<section <?php if($key > ""){echo 'id="'.$key.'"';} ?> class="<?php echo $parallax_classes ; ?>" <?php echo $parallax_data ; ?> >
				<div class='container'>
					<div class='row'>
						<div class="<?php echo 'page-title ' . $page_header_float; ?>">
							<?php echo $page_header_title; ?>
							<?php echo $page_header_text; ?>
                            <?php echo $page_header_button; ?>
						</div>
					</div><!-- /.row -->
				</div><!-- /.container -->
			</section>
		</div>
        <?php
		//-----------------------------------------------------
		// GET BORDER CLOSE
		//-----------------------------------------------------
		$partName = 'border-close';
		include( locate_template('templates/meta-part-' . $partName . '.php') );
		?>
    <?php
	// backstretch for mobile support
	if ($background_js > ""){ ?>
		<script>
    		jQuery(document).ready(function($) {
				if (Modernizr.touch) {
					<?php echo $background_js;  ?>
				}
			});
    	</script>
    <?php } ?>
	<?php }elseif($show_header == 'on' && !$gmap_show){ 
	$page_subheader_default_show = false; // Don't show subheader, we'll replace with an image 
	echo $page_subheader_default;
	?>
    <?php
	//-----------------------------------------------------
	// GET BORDER
	//-----------------------------------------------------
	$partName = 'border';
	include( locate_template('templates/meta-part-' . $partName . '.php') );
	?>
        <div class="container">
            <div class="row">
                <section <?php if($key > ""){echo 'id="'.$key.'"';} ?> class="<?php echo 'page-title ' . $page_header_float; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.'.page-title'); ?>">
                    <?php echo $page_header_title ?>
                    <?php echo $page_header_text ?>
					<?php echo $page_header_button; ?>
                </section>	
             </div>
        </div>
    <?php
	//-----------------------------------------------------
	// GET BORDER CLOSE
	//-----------------------------------------------------
	$partName = 'border-close';
	include( locate_template('templates/meta-part-' . $partName . '.php') );
	?>
	<?php }
		 // background ?>
<?php } // Header = on ?>

<?php 
// Output subheader if no map or image
if ($page_subheader_default_show){
	echo $page_subheader_default; ?>

	<?php
    //-----------------------------------------------------
    // GET BORDER
    //-----------------------------------------------------
    $partName = 'border';
    include( locate_template('templates/meta-part-' . $partName . '.php') );
    ?>    
    <div class="container">
            <div class="row">
                <section <?php if($key > ""){echo 'id="'.$key.'"';} ?> class="<?php echo 'page-title ' . $page_header_float; ?> <?php echo themo_return_entrance_animation_class($themo_enable_animate,$themo_animation_style,'#'.$key.'.page-title'); ?>">
                    <?php echo $page_header_title ?>
                </section>	
             </div>
        </div>
	<?php
    //-----------------------------------------------------
    // GET BORDER CLOSE
    //-----------------------------------------------------
    $partName = 'border-close';
    include( locate_template('templates/meta-part-' . $partName . '.php') );
    ?>      
<?php } 
?>
        
<?php } // Show = on?>

