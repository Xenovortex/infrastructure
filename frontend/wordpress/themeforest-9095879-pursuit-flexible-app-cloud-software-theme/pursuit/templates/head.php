<?php
/* Themovation Theme Options */
if ( function_exists( 'ot_get_option' ) ) {
	/* Favicon Support */	
	$favicon = ot_get_option( 'themo_favicon', get_template_directory_uri() . '/assets/images/favicon.ico' ); // Get favicon option
	
	if($favicon > ""){
		$favicon_url_path = parse_url($favicon, PHP_URL_PATH); // get the path
		$path_parts = pathinfo($favicon_url_path); // split into parts
		
		$is_ping = (strtolower($path_parts['extension']) == 'png' ? true : false); // if png, boolean!
		$is_ico = (strtolower($path_parts['extension']) == 'ico' ? true : false); // if ico, boolean!
	
		if( $is_ping ){ // HTML output
			$favicon_html = "<link rel=\"shortcut icon\" href=\"$favicon\" type=\"image/png\">\n";
			$favicon_html .= "<link rel=\"icon\" href=\"$favicon\" type=\"image/png\">";
		}elseif ($is_ico){
			$favicon_html = "<link rel=\"shortcut icon\" href=\"$favicon\" type=\"image/icon\">\n";
			$favicon_html .= "<link rel=\"icon\" href=\"$favicon\" type=\"image/icon\">";
		}
	}else{
		$favicon_html = "";
	}
	/* CUSTOM CSS Support */
	$custom_css_outfall = "\n<!-- Theme Custom CSS outfall -->\n<style>\n";

	/* CUSTOM Typography Support */
	$themo_body_font = ot_get_option( 'themo_body_font' ); // Get Body Typography Settings
	$themo_menu_font = ot_get_option( 'themo_menu_font' ); // Get Menu Typography Settings
	$themo_headings_font = ot_get_option( 'themo_headings_font' ); // Get Headings Typography Settings

	if (!empty($themo_body_font)){
		$custom_css_outfall .= themo_return_typography_styles(array_filter($themo_body_font),"body,p");
	}
	if (!empty($themo_menu_font)){
		$custom_css_outfall .= themo_return_typography_styles(array_filter($themo_menu_font),".navbar .navbar-nav > li > a");
	}
	if (!empty($themo_headings_font)){
		$custom_css_outfall .= themo_return_typography_styles(array_filter($themo_headings_font),"h1, h2, h3, h4, h5, h6");
	}
	
	/* Custom Background Support */
	$full_width = ot_get_option( 'themo_wide_layout' );
	$backstretch = ot_get_option( 'themo_backstretch' );
	
  	if ($full_width == 'off'){ 
		// We have a boxed layout, check for BG styling.
		// Return b/g image. If it's full width use backstretch js
		$boxed_layout_background = ot_get_option( 'themo_boxed_layout_background' );
		list($background_settings, $is_full_width, $background_image_filtered) = themo_custom_background($boxed_layout_background,'',false);
		
		if($background_settings > "" && $is_full_width && $backstretch == 'on'){
			$background_js = "$.backstretch('".$background_image_filtered."');";
			
			global $body_backstretch_js;
			$body_backstretch_js = "\n<!-- Theme Custom JS for Full BG image via backstretch JS -->\n<script>\n";
			$body_backstretch_js .= "jQuery(document).ready(function($) {\n";

			// If we only want to use on touch devices
			//$body_backstretch_js .= "if (Modernizr.touch) {\n";
			$body_backstretch_js .= "$background_js\n";
			//$body_backstretch_js .= "}\n";
			$body_backstretch_js .= "});\n";
			$body_backstretch_js .= "</script>\n";
			
			// Are we opting to use JS vs CSS? Commented out for now
			//$background_css = 'body{'.$background_settings.'}';
			//$custom_css_outfall .= $background_css;
		}elseif($background_settings > ""){
			// Are we opting to use JS vs CSS? Commented out for now
			$background_css = 'body{'.$background_settings.'}';
			$custom_css_outfall .= $background_css;
		}

	}
	
	/* Custom Color */
	$custom_color_primary = ot_get_option( 'themo_color_primary', THEMO_COLOR_PRIMARY ); // Get favicon option
	$custom_color_accent = ot_get_option( 'themo_color_accent', THEMO_COLOR_ACCENT ); // Get favicon option
	$custom_color_css = "\n/* Custom Color CSS $custom_color_primary */\n";
	$custom_color_css .= "#main-flex-slider .slides h1,.accent,.light-text .btn-ghost:hover,.light-text .googlemap a,.light-text .pricing-column.highlight .btn-ghost:hover,.light-text .pricing-column.highlight .btn-standard,.navbar .navbar-nav .dropdown-menu li a:hover,.navbar .navbar-nav .dropdown-menu li.active a,.navbar .navbar-nav .dropdown-menu li.active a:hover,.page-title h1,.panel-title i,.pricing-column.highlight .btn-ghost:hover,.pricing-column.highlight .btn-standard,.pricing-cost,.simple-cta span,.team-member-social a .soc-icon:hover,a{color:$custom_color_primary}.footer .widget-title:after,.navbar .navbar-nav>li.active>a:after,.navbar .navbar-nav>li.active>a:focus:after,.navbar .navbar-nav>li.active>a:hover:after,.navbar .navbar-nav>li>a:hover:after{background-color:$custom_color_primary}.accordion .accordion-btn .btn-ghost:hover,.btn-ghost:hover,.btn-standard,.circle-lrg-icon i,.circle-lrg-icon span,.light-text .pricing-table .btn-ghost:hover,.pager li>a:hover,.pager li>span:hover,.pricing-column.highlight{background-color:$custom_color_primary;border-color:$custom_color_primary}.accordion .accordion-btn .btn-ghost,.btn-ghost,.circle-lrg-icon i:hover,.circle-lrg-icon span:hover,.light-text .pricing-table .btn-ghost{color:$custom_color_primary;border-color:$custom_color_primary}.search-form input:focus,.widget select:focus,form input:focus,form select:focus,form textarea:focus{border-color:$custom_color_primary!important}.circle-med-icon i,.circle-med-icon span,.frm_form_submit_style,.frm_form_submit_style:hover,.with_frm_style .frm_submit input[type=button],.with_frm_style .frm_submit input[type=button]:hover,.with_frm_style .frm_submit input[type=submit],.with_frm_style .frm_submit input[type=submit]:hover,.with_frm_style.frm_login_form input[type=submit],.with_frm_style.frm_login_form input[type=submit]:hover,form input[type=submit],form input[type=submit]:hover{background:$custom_color_primary}.footer .tagcloud a:hover,.headhesive--clone .navbar-nav>li.active>a:after,.headhesive--clone .navbar-nav>li.active>a:focus:after,.headhesive--clone .navbar-nav>li.active>a:hover:after,.headhesive--clone .navbar-nav>li>a:hover:after,.search-submit,.search-submit:hover,.simple-conversion .with_frm_style input[type=submit],.simple-conversion .with_frm_style input[type=submit]:focus,.simple-conversion form input[type=submit],.simple-conversion form input[type=submit]:focus,.widget .tagcloud a:hover{background-color:$custom_color_primary!important}.btn-cta{background-color:$custom_color_accent}";
	
	$custom_css_outfall .= "$custom_color_css\n";
	
	/* Custom CSS */
	$custom_css = ot_get_option( 'themo_custom_css' ); // Get favicon option
	if ($custom_css > ""){
		$custom_css_outfall .= "$custom_css\n";
	}
	$custom_css_outfall .= "</style>\n";
	
	/* Google Analytics Tracking Code */
	$analytics_tracking_code = ot_get_option( 'themo_google_analytics_tracking_code' ); // Get Google Analytics Tracking Code
	$analytics_tracking_code_script = "";
	if ($analytics_tracking_code > ""){
		$analytics_tracking_code_script = "\n<!-- Google Analytics Tracking Code -->\n$analytics_tracking_code\n";
	}
}
/* END Theme Options */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(home_url()); ?>/feed/">
  
	<?php 
	/* Theme options output */
	echo $favicon_html; // favicon
	themo_print_google_font_link();
	echo $custom_css_outfall ; // custom css
	echo $analytics_tracking_code_script; // Google Analytics Tracking
	/* END options output */
	?>
    
    
</head>
