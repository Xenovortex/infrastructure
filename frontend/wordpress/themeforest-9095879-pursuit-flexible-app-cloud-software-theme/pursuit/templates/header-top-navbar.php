<?php 
// Get logo from admin options.
// Fetch ID and pull logo size.
if(isset($post->ID )&& $post->ID > ""){
	$postID = $post->ID;
}else{
	$postID = "";
}


if ( function_exists( 'ot_get_option' ) ) {
	
	/*-----------------------------------------------------
		Enable Transparent Header if:
		* Theme Options has it enabled and its not forced disabled on page settings.
		* There is flex slider or page header for the page loaded
	-----------------------------------------------------*/
	
	// Check for Slider
	$slider = false;
	$key = 'themo_slider';
	$show = get_post_meta($postID, $key.'_sortorder_show', true );
	$show_flex = get_post_meta($postID, $key.'_flex_show', true );
	$show_shortcode = get_post_meta($postID, $key.'_shortcode_show', true );

	if($show == 'on' && $show_flex == 'on') { // Slider Enabled
		$slider = true;
	}

	// Check for Master Slider
	$master_slider = false;
	$show = false;
	$shortcode = false;

	$key = 'themo_slider_master';
	$show = get_post_meta($postID, $key.'_show', true );
	$shortcode = get_post_meta($postID, $key.'_shortcode', true );

	if($show == 'on' && $shortcode > "" ) { // Master Slider Enabled
		$master_slider = true;
	}

	// Check for Page Header
	$page_header = false;
	$key = 'themo_page_header_1';
	$show = get_post_meta($postID, $key.'_show', true );
	$show_header = get_post_meta($postID, $key.'_show_header', true );
	$show_map = get_post_meta($postID, 'themo_map_1_show', true ); // Returns Show Map (on / off)
	$map_in_header = get_post_meta($postID, 'themo_map_1_in_heder', true );
	
	if($show == 'on' && $show_header == 'on' && !($map_in_header == 'on' && $show_map == 'on')) { // Slider Enabled
		$page_header = true;
	}
	
	// Check for Force Transparency Disable on Page
	$disable_nav_transparency = get_post_meta($postID, 'themo_page_disable_nav_transparency', true );
	
	
	// Check theme Transparency Option Setting
	$transparent_header = ot_get_option( 'themo_transparent_header', 'off' );
	
	if(isset($transparent_header) && !empty( $transparent_header ) && $transparent_header == 'on' && ($slider || $page_header || $master_slider) && $disable_nav_transparency !== 'on')
	{
		$transparency = true;
		$transparent_header = 'data-transparent-header="true"';	
	}else{
		$transparency = false;
		$transparent_header = '';
	}
	
	// Alternative logo for Transparent Header Enabled?
	$transparent_logo_enabled = ot_get_option( 'themo_logo_transparent_header_enable', 'off' );
	
	// To support for transparent header we want to keep a copy of the main logo, and use it when user scrolls (sticky header).
	$logo_main = ot_get_option( 'themo_logo');
	
	if(!$logo_main > ""){
		$logo_main = get_template_directory_uri() . '/assets/images/logo.png' ;
		$logo_main_retina = get_template_directory_uri() . '/assets/images/logo@2x.png';
	}else{
		$logo_main_retina = "";
	}
	
	// If transparent logo is enabled and transparency enabled, then replace logo.
	if($transparency && $transparent_logo_enabled == 'on'){
		$logo = ot_get_option( 'themo_logo_transparent_header' );
		if(!$logo > ""){
			$logo = get_template_directory_uri() . '/assets/images/logo_white.png';
			$logo_retina = get_template_directory_uri() . '/assets/images/logo_white@2x.png';
		}else{
			$logo_retina = "";
		}
	}else{
		$logo = $logo_main;
		$logo_retina = $logo_main_retina;
	}
	
	/*-----------------------------------------------------
		Logo & Retina Logo
	-----------------------------------------------------*/
	
	$id = themo_custom_get_attachment_id( $logo );
	
	// If this is a WordPress Attachment then get src, height, width and retina version too.
	if($id > 0){
		$image_attributes  = wp_get_attachment_image_src( $id, 'themo-logo' ); // ADD logo image size when ready. eg.  wp_get_attachment_image_src( $id, 'image-size' );
		list($logo_retina, $logo_retina_height, $logo_retina_width) = return_retina_logo($id);
	}
	
	if(isset($image_attributes) && !empty( $image_attributes ) )
	{
		$logo_src = "src='".$image_attributes[0]."'";
		$logo_height = " height='".$image_attributes[2]."'";
		$logo_width =  " width='".$image_attributes[1]."'";
		
		$logo_retina_src = "src='".$logo_retina."'";
		$logo_retina_height = " height='".$logo_retina_height."'";
		$logo_retina_width =  " width='".$logo_retina_width."'";
		
	}else{
		$logo_src = "src='".$logo."'";
		$logo_height = "";
		$logo_width =  "";
		
		if($logo_retina > ""){
			$logo_retina_src = "src='".$logo_retina."'";
			$logo_retina_height = "";
			$logo_retina_width =  "";
		}
	}
	
	$id_main = themo_custom_get_attachment_id( $logo_main );
	
	if($id_main > 0){
		$image_attributes_main  = wp_get_attachment_image_src( $id_main, 'themo-logo' ); // ADD logo image size when ready. eg.  wp_get_attachment_image_src( $id, 'image-size' );
		list($logo_main_retina, $logo_main_retina_height, $logo_main_retina_width) = return_retina_logo($id_main);
	}
	
	if(isset($image_attributes_main) && !empty( $image_attributes_main ) )
	{
		$logo_src_main = "src='".$image_attributes_main[0]."'";
		$logo_height_main = " height='".$image_attributes_main[2]."'";
		$logo_width_main =  "width='".$image_attributes_main[1]."'";
		
		$logo_main_retina_src = "src='".$logo_main_retina."'";
		$logo_main_retina_height = " height='".$logo_main_retina_height."'";
		$logo_main_retina_width =  " width='".$logo_main_retina_width."'";
	}else{
		$logo_src_main = "src='".$logo_main."'";
		$logo_height_main = "";
		$logo_width_main =  "";
		
		if($logo_main_retina > ""){
			$logo_main_retina_src = "src='".$logo_main_retina."'";
			$logo_main_retina_height = "";
			$logo_main_retina_width =  "";
		}
	}	
}
?>

<header class="banner navbar navbar-default navbar-static-top" role="banner" <?php echo $transparent_header;?>>
	<div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div id="logo">
                <a href="<?php echo home_url(); ?>/">
                   	<?php if($transparency && $transparent_logo_enabled == 'on') { ?>
                    <img class="logo-trans logo-reg" <?php echo $logo_src . $logo_height . $logo_width ;?>  alt="<?php bloginfo("name" ); ?>" />
                    <?php }elseif($transparency && $transparent_logo_enabled == 'off'){ ?>
                    <img class="logo-trans logo-reg" <?php echo $logo_src_main . $logo_height_main ." ". $logo_width_main ;?>   alt="<?php bloginfo("name" ); ?>" />
                    <?php }?>
                    <img class="logo-main logo-reg" <?php echo $logo_src_main . $logo_height_main ." ". $logo_width_main ;?>   alt="<?php bloginfo("name" ); ?>" />                    
				</a>
            </div>
        </div>

    	<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      	<?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      	?>
    	</nav>
	</div>
</header>