<?php
/**
 * Enqueue scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/bootstrap.css
 * 2. /theme/assets/css/app.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.10.2.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr-2.6.2.min.js
 * 3. /theme/assets/js/plugins.js (in footer)
 * 4. /theme/assets/js/main.js    (in footer)
 */ 
function roots_scripts() {
	
	/********************************
		Glyphicons Styles
	********************************/
	// Register
	wp_register_style('glyphicons', get_template_directory_uri() . '/assets/css/glyphicons.css', array(), '1');
	//wp_register_style('glyphicons_halflings', get_template_directory_uri() . '/assets/css/halflings.css', array(), '1');
	//wp_register_style('glyphicons_social', get_template_directory_uri() . '/assets/css/social.css', array(), '1');
	//wp_register_style('glyphicons_filetypes', get_template_directory_uri() . '/assets/css/filetypes.css', array(), '1');
  
	// Eenqueue
	wp_enqueue_style('glyphicons');
	wp_enqueue_style('glyphicons_halflings');
	wp_enqueue_style('glyphicons_social');
	wp_enqueue_style('glyphicons_filetypes');


	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('jquery');

	/********************************
		Modernizr
	********************************/
	wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', array(), '2.7.0', false);
	wp_enqueue_script('modernizr');

	/********************************
		Parallax - Stellar
	********************************/  
	wp_register_script('imagesloaded', get_template_directory_uri() . '/assets/js/vendor/imagesloaded.pkgd.min.js', array(), '3.1.4', true);
  	wp_enqueue_script('imagesloaded');
	
	wp_register_script('stellar', get_template_directory_uri() . '/assets/js/vendor/jquery.stellar.min.js', array(), '0.6.22', true);
  	wp_enqueue_script('stellar');
	
	/********************************
		Backstretch
	********************************/
	wp_register_script('backstretch', get_template_directory_uri() . '/assets/js/vendor/jquery.backstretch.min.js', array(), '2.0.4', false);
	wp_enqueue_script('backstretch');
	
	/********************************
		Animations
	********************************/
	wp_register_style('themo_animations', get_template_directory_uri() . '/assets/css/themo_animations.css', array(), '1');
	wp_enqueue_style('themo_animations');
	
	/********************************
		Main JS
		In the future if we want to include specific JS plugins for Twitter bootstrap then we would do that here. For now we include
		everything in on bootstrap.js file.
	********************************/  
  	wp_register_script('roots_main', get_template_directory_uri() . '/assets/js/main.js', array(), '1', true);
	wp_enqueue_script('roots_main');
 
 	/********************************
		Shortcodes
		// Commented out to replace with unminified for DEBUG wp_register_script('bootstrap_shortcode', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', false, null, true);
		// TODO Replace with minified version before going live
	********************************/
	wp_register_script('bootstrap_shortcode', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js',  array(), '3.1.1', true);
	wp_register_script('bootstrap_shortcode_app', get_template_directory_uri() . '/assets/js/vendor/application.js', array(), '1', true); 
   	wp_enqueue_script('bootstrap_shortcode');
	wp_enqueue_script('bootstrap_shortcode_app');

	/********************************
		Bootstrap
	********************************/  
	wp_register_style('roots_bootstrap',  get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.1.1');
	wp_enqueue_style('roots_bootstrap');
	
	/********************************
		Lightbox
	********************************/
	wp_register_style('bootstrap_lighbox', get_template_directory_uri() . '/assets/css/ekko-lightbox.min.css', array(), '1');
	wp_enqueue_style('bootstrap_lighbox');
	
	wp_register_style('bootstrap_lighbox_theme', get_template_directory_uri() . '/assets/css/ekko-dark.css', array(), '1');
	wp_enqueue_style('bootstrap_lighbox_theme');
	
	wp_register_script('bootstrap_lighbox', get_template_directory_uri() . '/assets/js/vendor/ekko-lightbox.min.js', array(), '1', true);
  	wp_enqueue_script('bootstrap_lighbox');
	
	/********************************
		Flexslider
	********************************/
	wp_register_style('flexslider', get_template_directory_uri() . '/assets/css/flexslider.css', array(), '2.2.0');
	wp_enqueue_style('flexslider');
	
	wp_register_script('flexslider', get_template_directory_uri() . '/assets/js/vendor/jquery.flexslider-min.js', array(), '2.2.2', true);
  	wp_enqueue_script('flexslider');
	
	/********************************
		Masonry
	********************************/
	wp_register_script('masonry', get_template_directory_uri() . '/assets/js/vendor/masonry.pkgd.min.js', array(), '3.1.5', true);
  	wp_enqueue_script('masonry');
	
	/********************************
		ScrollUp
	********************************/
	wp_register_script('scrollup', get_template_directory_uri() . '/assets/js/vendor/jquery.scrollUp.min.js', array(), '2.4.0', true);
  	wp_enqueue_script('scrollup');
	
	/********************************
		SmoothScroll w/ Back Button Support
	********************************/
	wp_register_script('smoothccroll', get_template_directory_uri() . '/assets/js/vendor/jquery.smooth-scroll.min.js', array(), '1.5.3', true);
  	wp_enqueue_script('smoothccroll');
	
	wp_register_script('backbutton', get_template_directory_uri() . '/assets/js/vendor/jquery.ba-bbq.js', array(), '1.2.1s', true);
  	wp_enqueue_script('backbutton');

	/********************************
		WayPoint
	********************************/
	wp_register_script('waypoints', get_template_directory_uri() . '/assets/js/vendor/waypoints.min.js', array(), '2.0.5', true);
  	wp_enqueue_script('waypoints');
	
	
	/********************************
		Headhesive
	********************************/
	if ( function_exists( 'ot_get_option' ) ) {
		$sticky_header = ot_get_option( 'themo_sticky_header', "on" );
		if ($sticky_header == 'on'){ 			
			wp_register_script('headhesive', get_template_directory_uri() . '/assets/js/vendor/headhesive.min.js', array(), '1.1.1', true);
			wp_enqueue_script('headhesive');	
		}
	}
	

	/********************************
		NiceScroll
	********************************/
	if ( function_exists( 'ot_get_option' ) ) {
		$smooth_scroll = ot_get_option( 'themo_smooth_scroll', "on" );
		if ($smooth_scroll == 'on'){ 			
			wp_register_script('nicescroll', get_template_directory_uri() . '/assets/js/vendor/jquery.nicescroll.min.js', array(), '3.5.4', true);
  	wp_enqueue_script('nicescroll');
		}
	}
	
	
	

	
	/********************************
		Retina
	********************************/
	wp_register_script('retina', get_template_directory_uri() . '/assets/js/vendor/retina.min.js', array(), '1.3.0', true);
  	wp_enqueue_script('retina');
	
	/********************************
		Main Stylesheet
	********************************/  
	wp_register_style('roots_app',  get_template_directory_uri() . '/assets/css/app.css', array(), '1');
	wp_enqueue_style('roots_app');
	
	/********************************
		Header Stylesheet
	********************************/  
	wp_register_style('header',  get_template_directory_uri() . '/assets/css/header.css', array(), '1');
	wp_enqueue_style('header');
	
	/********************************
		Responsive @media CSS
	********************************/  
	/*if ( function_exists( 'ot_get_option' ) ) {
		$responsive_layout = ot_get_option( 'themo_responsive_layout' ); // Responsive on / off?
		if($responsive_layout == 'on'){
			wp_register_style('responsive_css',  get_template_directory_uri() . '/assets/css/responsive.css', array(), '1');
			wp_enqueue_style('responsive_css');
		}
	}*/
	wp_register_style('responsive_css',  get_template_directory_uri() . '/assets/css/responsive.css', array(), '1');
	wp_enqueue_style('responsive_css');
		
	/********************************
		Child Theme
	********************************/
	if (is_child_theme()) {
		wp_register_style('roots_child', get_stylesheet_uri());
		wp_enqueue_style('roots_child');
	}
  
}
add_action('wp_enqueue_scripts', 'roots_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function roots_jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.11.0.min.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', 'roots_jquery_local_fallback');

