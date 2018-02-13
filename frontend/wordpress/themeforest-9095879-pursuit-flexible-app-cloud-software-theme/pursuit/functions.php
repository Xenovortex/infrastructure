<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/custom.php');          // Custom functions

// THEMOVATION CUSTOMIZATION
require_once locate_template('/lib/class-tgm-plugin-activation.php');          // Bundled Plugins

// Activate Option Tree in the theme rather than as a plugin
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_show_pages', '__return_false' );
//add_filter( 'ot_show_pages', '__return_true' );

include_once('option-tree/ot-loader.php');
include_once('option-tree/theme-options.php' ); // LOAD THEME SETTINGS
include_once('option-tree/theme-options-defaults.php'); // LOAD OT DEFAULTS
include_once('option-tree/meta-boxes.php' ); // LOAD META BOXES

// END Option Tree