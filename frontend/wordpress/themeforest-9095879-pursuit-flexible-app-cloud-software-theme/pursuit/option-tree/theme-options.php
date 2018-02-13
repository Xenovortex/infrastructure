<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'themo_general',
        'title'       => __( 'General', THEMO_TEXT_DOMAIN ),
      ),
	  array(
        'id'          => 'themo_color',
        'title'       => __( 'Colors', THEMO_TEXT_DOMAIN ),
      ),
      array(
        'id'          => 'themo_typography',
        'title'       => __( 'Typography', THEMO_TEXT_DOMAIN ),
      ),
      array(
        'id'          => 'themo_social',
        'title'       => __( 'Social', THEMO_TEXT_DOMAIN ),
      ),
      array(
        'id'          => 'themo_style_layout',
        'title'       => __( 'Site Layout', THEMO_TEXT_DOMAIN ),
      ),
      array(
        'id'          => 'themo_footer',
        'title'       => __( 'Footer', THEMO_TEXT_DOMAIN ),
      ),
      array(
        'id'          => 'themo_slider_config',
        'title'       => 'Slider'
      ),
      array(
        'id'          => 'blog__amp__posts_settings',
        'title'       => __( 'Header &amp; Sidebar', THEMO_TEXT_DOMAIN ),
      ),
      /*array(
        'id'          => 'meta_stuff',
        'title'       => __( 'Page Templates', THEMO_TEXT_DOMAIN ),
      )*/
    ),
    'settings'        => array( 
      array(
        'id'          => 'themo_favicon',
        'label'       => 'Favicon',
        'desc'        => __( 'A favicon (short for "favorites icon") is an icon associated with a website or webpage intended to be used when you bookmark the web page. Web browsers use them in the URL bar, on tabs, and elsewhere to help identify a website visually. It\'s typically a graphic 16 x 16 pixels square and is saved as favicon.ico', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_logo_height',
        'label'       => __( 'Logo Height', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'The theme will automatically re-size logos to a maximum 100px high. If you would like a specific height, please enter it here. <strong>Please \'Save Changes\' before uploading your logo. This effects the retina support.</strong>', THEMO_TEXT_DOMAIN ),'',
        'std'         => '100',
        'type'        => 'numeric-slider',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '10,300',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_logo',
        'label'       => __( 'Logo with Retina Support', THEMO_TEXT_DOMAIN ),
        'desc'        => '<p>' . __( 'For Retina Support to work, upload a logo that is at least x2 the size of your non-retina logo.', THEMO_TEXT_DOMAIN ) . '</p><p>'. __( 'E.G.: If you want a 200 x 60 logo, you need to upload it at 400 x 120 for retina support. If you DON\'T want retina support, upload the logo at whatever size you wish.', THEMO_TEXT_DOMAIN ) .'</p>',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'themo_general',
      ),
	  array(
        'id'          => 'themo_logo_transparent_header_enable',
        'label'       => __( 'Enable Transparent Header Logo', THEMO_TEXT_DOMAIN ),
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'themo_general',
		'desc' 		  => 'This will be used when the header is transparent before the user scrolls. (If nothing is uploaded, the default logo will be used)'
      ),
	  array(
        'id'          => 'themo_logo_transparent_header',
        'label'       => __( 'Upload Logo for Transparent Header (Retina Support Automatically Included)', THEMO_TEXT_DOMAIN ),
        'desc'        => '<p>' . __( 'For Retina Support to work, upload a logo that is at least x2 the size of your non-retina logo.', THEMO_TEXT_DOMAIN ) . '</p><p>'. __( 'E.G.: If you want a 200 x 60 logo, you need to upload it at 400 x 120 for retina support. If you DON\'T want retina support, upload the logo at whatever size you wish.', THEMO_TEXT_DOMAIN ) .'</p>',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'themo_general',
		'condition'   => "themo_logo_transparent_header_enable:is(on)",
      ),
	  array(
        'id'          => 'themo_nav_top_margin',
        'label'       => __( 'Navigation Top Margin', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Set top margin value for the navigation bar', THEMO_TEXT_DOMAIN ),'',
        'std'         => '19',
        'type'        => 'numeric-slider',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '0,300',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_custom_css',
        'label'       => __( 'Custom CSS', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Add custom CSS to your website.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'css',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_google_analytics_tracking_code',
        'label'       => __( 'Google Analytics Tracking Code', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Enterprise-class web analytics by Google. Sign up for an account (www.google.ca/analytics/) and get your tracking code.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'themo_general',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	   array(
        'id'          => 'themo_meta_box_builder_meta_box_manual_sort_order',
        'label'       => __( 'Enable Manual Meta Box Sort Order', THEMO_TEXT_DOMAIN ),
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	   array(
        'id'          => 'themo_meta_box_builder_meta_box_max_quantity',
        'label'       => __( 'Set the maximum times you can use a metabox on a single page', THEMO_TEXT_DOMAIN ),
        'std'         => '5',
        'type'        => 'numeric-slider',
        'section'     => 'themo_general',
   		'min_max_step'=> '1,20,1',
      ),
	  array(
        'id'          => 'themo_automatic_post_excerpts',
        'label'       => __( 'Enable Automatic Post Excerpts', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_general',
		'description' => 'This will create automatic excerpts for your posts, placing a read more link after.',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	   array(
        'id'          => 'themo_smooth_scroll',
        'label'       => __( 'Smooth Scroll', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
            'id'          => 'themo_google_map_api_key',
            'label'       => esc_html__( 'Google Map API key', THEMO_TEXT_DOMAIN ),
            'desc'        => esc_html__( 'Get your free API key here: ', THEMO_TEXT_DOMAIN ) . '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Key/Authentication</a>. ' . esc_html__( 'Leave it blank and use our key but we do not guarantee that it will work as it has a daily use limit.', THEMO_TEXT_DOMAIN ),
            'type'        => 'text',
            'section'     => 'themo_general',
            'operator'    => 'and'
        ),
	  array(
        'id'          => 'themo_color_primary',
        'label'       => __( 'Primary Color', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Change this color to alter the primary color globally.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'themo_color',
      ),
	  array(
        'id'          => 'themo_color_accent',
        'label'       => __( 'Accent Color', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Change this color to alter the accent color globally.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'themo_color',
      ),
      array(
        'id'          => 'themo_body_font',
        'label'       => __( 'Body Font', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Options for Body Font', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'themo_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_menu_font',
        'label'       => __( 'Menu Font', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Menu / Navigation Font Options', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'themo_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_headings_font',
        'label'       => __( 'Headings Font', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Headings Font Options', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'themo_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'themo_google_fonts',
        'label'       => __( 'Google Fonts', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Add or remove Google Fonts', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'themo_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'themo_google_font_family',
            'label'       => __( 'Google Font Name / Font Family', THEMO_TEXT_DOMAIN ),
            'desc'        => '<p>'.__( 'Add or remove Google Fonts. In the "Font Name / Font Family" field add the name of the font or a font family where the fonts are separated with commas.', THEMO_TEXT_DOMAIN ).'</p><p>'.__( 'Example values:', THEMO_TEXT_DOMAIN ). '\'Open Sans\', sans-serif. <a href="http://www.google.com/fonts" target="_blank">Google Fonts Online</a></p>',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_google_font_url',
            'label'       => __( 'Google Font URL', THEMO_TEXT_DOMAIN ),
            'desc'        => '<p>'. __( 'Insert the URL of the font file.', THEMO_TEXT_DOMAIN ). '</p><p>'. __( 'Example values: ', THEMO_TEXT_DOMAIN ). 'http://fonts.googleapis.com/css?family=Open+Sans:400,600</P>'. __( 'Find the URL here: ', THEMO_TEXT_DOMAIN ) . '<a href="http://www.google.com/fonts" target="_blank">Google Fonts Online</a>',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      ),
      array(
        'id'          => 'themo_social_media_accounts',
        'label'       => __( 'Social Media Accounts', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Add your social media account here', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'themo_social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'themo_social_font_icon',
            'label'       => __( 'Social Icon', THEMO_TEXT_DOMAIN ),
            'desc'        => __( 'Use any', THEMO_TEXT_DOMAIN ). ' <a href="http://glyphicons.com/" target="_blank">SOCIAL</a> icon(e.g.: twitter). <a href="http://glyphicons.com/" target="_blank">'.__( 'Full List Here', THEMO_TEXT_DOMAIN ).'</a>',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_social_url',
            'label'       => __( 'Social URL', THEMO_TEXT_DOMAIN ),
            'desc'        => __( 'URL to your social media profile', THEMO_TEXT_DOMAIN ),
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      ),
      array(
        'id'          => 'themo_sticky_header',
        'label'       => __( 'Sticky Header', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'themo_transparent_header',
        'label'       => __( 'Transparent Header When Applicable', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
		'desc' 		  => 'Enable transparent header before the user scrolls. Works with Page Headers and Sliders.',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'themo_wide_layout',
        'label'       => __( 'Full Width Layout', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Full Width vs Boxed Layout.', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	   
	  array(
        'id'          => 'themo_boxed_layout_background',
        'label'       => __( 'Boxed Layout Background', THEMO_TEXT_DOMAIN ),
        'desc'        => 	sprintf(__('%1$s %3$sFor a Full Width Background%4$s : Upload your image and "Save Changes". (Color and custom background settings are optional). %2$s', THEMO_TEXT_DOMAIN), '<p>','</p>', '<strong>','</strong>') .
							sprintf(__('%1$s %3$sFor a Tiled / Pattern Background%4$s :  Upload your tile, select "Repeat All" from the "background-repeat" select list, "Save Changes". %2$s', THEMO_TEXT_DOMAIN), '<p>','</p>', '<strong>','</strong>').
							sprintf(__('%1$s %3$sFor a Solid Background Color%4$s :  Select your colour from the color picker, "Save Changes".%2$s', THEMO_TEXT_DOMAIN), '<p>','</p>', '<strong>','</strong>').
							sprintf(__('%1$s %3$sFor Custom CSS%4$s : Use the CSS options to custom your background (optional), "Save Changes". You may also wish to also "Disable Backstretch JS"%2$s', THEMO_TEXT_DOMAIN), '<p>','</p>', '<strong>','</strong>'),
        'type'        => 'background',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'ot-upload-attachment-id-removed',
        'condition'   => 'themo_wide_layout:is(off)',
        'operator'    => 'and'
      ),
	  array(
        'id'          => 'themo_backstretch',
        'label'       => __( 'Backstretch JS', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Required for Full Width Images. Turn this off ONLY if you know what you are doing with the custom CSS opitons under the "Boxed Layout Background" area.', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'themo_wide_layout:is(off)',
        'operator'    => 'and'
      ),
      /*array(
        'id'          => 'themo_responsive_layout',
        'label'       => __( 'Responsive Layout', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Enable or disable responsive layout', THEMO_TEXT_DOMAIN ),
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),*/
	  array(
        'id'          => 'themo_retina_support',
        'label'       => __( 'Automatically Create Retina Images', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Enable or disable the feature to automatically create retina images.', THEMO_TEXT_DOMAIN ),
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'themo_style_layout',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_footer_copyright',
        'label'       => __( 'Footer Copyright', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Your copyright statement', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'themo_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_footer_credit',
        'label'       => __( 'Footer Credit', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Your footer credit. \'website by...\'', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'themo_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_footer_widget_switch',
        'label'       => __( 'Footer Widget', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Enable / disable footer widget area.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_footer_columns',
        'label'       => __( 'Footer Columns', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Select the number of columns you would like in your footer.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'themo_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'themo_footer_widget_switch:is(on)',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => '2',
            'label'       => '2 ' . __( 'Columns', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/themo_footer_2_columns.png'
          ),
          array(
            'value'       => '3',
            'label'       => '3 ' . __( 'Columns', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/themo_footer_3_columns.png'
          ),
          array(
            'value'       => '4',
            'label'       => '4 ' . __( 'Columns', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/themo_footer_4_columns.png'
          )
        )
      ),
      array(
        'id'          => 'themo_flex_animation',
        'label'       => __( 'Animation', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Controls the animation type, "fade" or "slide".', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'fade',
            'label'       => __( 'Fade', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          ),
          array(
            'value'       => 'slide',
            'label'       => __( 'Slide', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          )
        )
      ),
      array(
        'id'          => 'themo_flex_easing',
        'label'       => __( 'Easing', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Determines the easing method used in jQuery transitions.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'swing',
            'label'       => __( 'Swing', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          ),
          array(
            'value'       => 'linear',
            'label'       => __( 'Linear', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          )
        )
      ),
      /*array(
        'id'          => 'themo_flex_direction',
        'label'       => __( 'Direction', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Controls the animation direction, "horizontal" or "vertical"', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'horizontal',
            'label'       => __( 'Horizontal', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          ),
          array(
            'value'       => 'vertical',
            'label'       => __( 'Vertical', THEMO_TEXT_DOMAIN ),
            'src'         => ''
          )
        )
      ),*/
      /*array(
        'id'          => 'themo_flex_reverse',
        'label'       => __( 'Reverse', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Reverse the animation direction.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),*/
      array(
        'id'          => 'themo_flex_animationloop',
        'label'       => __( 'Animation Loop', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Gives the slider a seamless infinite loop.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_smoothheight',
        'label'       => __( 'Smooth Height', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Animate the height of the slider smoothly for slides of varying height.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_slideshowspeed',
        'label'       => __( 'Slideshow Speed', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Set the speed of the slideshow cycling, in milliseconds', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'numeric-slider',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '0,15000,100',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_animationspeed',
        'label'       => __( 'Animation Speed', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Set the speed of animations, in milliseconds', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'numeric-slider',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '0,1200,50',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_randomize',
        'label'       => __( 'Randomize', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Randomize slide order, on load', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_pauseonhover',
        'label'       => __( 'Pause On Hover', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_touch',
        'label'       => __( 'Touch', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Allow touch swipe navigation of the slider on enabled devices', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'themo_flex_directionnav',
        'label'       => __( 'Direction Nav', THEMO_TEXT_DOMAIN ),
        'desc'        => __( 'Create previous/next arrow navigation.', THEMO_TEXT_DOMAIN ),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'themo_slider_config',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      
		
		//-----------------------------------------------------
		// Blog Homepage
		//-----------------------------------------------------
		
	  	/* Tab */
		return_tab_option('themo_blog_index_layout','blog__amp__posts_settings','Blog homepage'),
		
		
		/* Header */
		list($show_header,$header_float) = return_header_options('themo_blog_index_layout','blog__amp__posts_settings'),
		$show_header,$header_float,
		
		/* Sidebar */
		return_sidebar_options('themo_blog_index_layout','blog__amp__posts_settings'),
		


		
		//-----------------------------------------------------
		// Single Post
		//-----------------------------------------------------
		
		/* Tab */
		return_tab_option('themo_single_post_layout','blog__amp__posts_settings','Single Post'),
		
		
		/* Header */
		list($show_header,$header_float) = return_header_options('themo_single_post_layout','blog__amp__posts_settings'),
		$show_header,$header_float,
	   
		/* Sidebar */
		return_sidebar_options('themo_single_post_layout','blog__amp__posts_settings'),
		
		//-----------------------------------------------------
		// Search, 404, Archive
		//-----------------------------------------------------
		
		/* Tab */
		return_tab_option('themo_default_layout','blog__amp__posts_settings','Search, Archives, 404, etc..'),
		
		/* Header */
		list($show_header,$header_float) = return_header_options('themo_default_layout','blog__amp__posts_settings'),
		$show_header,$header_float,
	   
		/* Sidebar */
		return_sidebar_options('themo_default_layout','blog__amp__posts_settings'),

        array(
            'id'          => 'themo_blog_index_layout_masonry',
            'label'       => __( 'Category Masonry Style', THEMO_TEXT_DOMAIN ),
            //'desc'        => __( 'Masonry vs Standard.', THEMO_TEXT_DOMAIN ),
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'blog__amp__posts_settings',
        ),
      
      /*array(
        'id'          => 'themo_custom_template',
        'label'       => __( 'Custom Templates', THEMO_TEXT_DOMAIN ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'meta_stuff',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'meta_boxes',
            'label'       => __( 'Meta Boxes', THEMO_TEXT_DOMAIN ),
            'desc'        => '',
            'std'         => 'page_header',
            'type'        => 'checkbox',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and',
            'choices'     => array( 
              array(
                'value'       => 'accordion',
                'label'       => 'Accordion',
              ),
              array(
                'value'       => 'brands',
                'label'       => 'Brands',
              ),
              array(
                'value'       => 'call_to_action',
                'label'       => 'Call to Action',
                'src'         => ''
              ),
              array(
                'value'       => 'conversion_form',
                'label'       => 'Conversion Form',
                'src'         => ''
              ),
              array(
                'value'       => 'faq',
                'label'       => 'FAQ',
                'src'         => ''
              ),
              array(
                'value'       => 'featured',
                'label'       => 'Featured',
                'src'         => ''
              ),
              array(
                'value'       => 'html',
                'label'       => 'HTML',
                'src'         => ''
              ),
              array(
                'value'       => 'map',
                'label'       => 'Map',
                'src'         => ''
              ),
              array(
                'value'       => 'pricing_plans',
                'label'       => 'Pricing Plans',
                'src'         => ''
              ),
              array(
                'value'       => 'service_block',
                'label'       => 'Service Block',
                'src'         => ''
              ),
              array(
                'value'       => 'service_block_split',
                'label'       => 'Service Block Split',
                'src'         => ''
              ),
              array(
                'value'       => 'showcase',
                'label'       => 'Showcase',
                'src'         => ''
              ),
              array(
                'value'       => 'slider',
                'label'       => 'Slider',
                'src'         => ''
              ),
              array(
                'value'       => 'team',
                'label'       => 'Team',
                'src'         => ''
              ),
              array(
                'value'       => 'testimonials',
                'label'       => 'Testimonials',
                'src'         => ''
              ),
              array(
                'value'       => 'thumbnail_slider',
                'label'       => 'Thumbnail Slider',
                'src'         => ''
              ),
              array(
                'value'       => 'tour',
                'label'       => 'Tour',
                'src'         => ''
              )
            )
          ),
          array(
            'id'          => 'themo_meta_box_quantity',
            'label'       => __( 'Meta Box Quantity', THEMO_TEXT_DOMAIN ),
            'desc'        => __( 'Use the slider to add multiple meta boxes to any template.', THEMO_TEXT_DOMAIN ),
            'std'         => '',
            'type'        => 'textblock-titled',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_accordion',
            'label'       => 'Accordion',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_brands',
            'label'       => 'Brands',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_call_to_action',
            'label'       => 'Call to Action',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_conversion_form',
            'label'       => 'Conversion Form',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_faq',
            'label'       => 'FAQ',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_featured',
            'label'       => 'Featured',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_html',
            'label'       => 'HTML',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_map',
            'label'       => 'Map',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_pricing_plans',
            'label'       => 'Pricing Plans',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_service_block',
            'label'       => 'Service Block',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_service_block_split',
            'label'       => 'Service Block Split',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_showcase',
            'label'       => 'Showcase',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_team',
            'label'       => 'Team',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_testimonials',
            'label'       => 'Testimonials',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'themo_meta_box_quantity_thumbnail_slider',
            'label'       => 'Thumbnail Slider',
            'desc'        => '',
            'std'         => '',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,3,1',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      )*/
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}


//-----------------------------------------------------
// Tab
//-----------------------------------------------------
function return_tab_option($key,$section,$name){

$tab = array(
        'id'          => $key.'_tab',
        'label'       => $name,
        'desc'        => '',
        'std'         => '',
        'type'        => 'tab',
        'section'     => $section,
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      );
return $tab;
}

//-----------------------------------------------------
// Header Options
//-----------------------------------------------------
function return_header_options($key,$section ){

$show_header = array(
				'id'          => $key.'_show_header',
				'label'       => __( 'Header', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => $section,
			  );
/*$header 	= array(
				'id'          => $key."_".$i."_header",
				'label'       => __( 'Heading', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'class'       => 'meta-child',
				'condition'   => $key."_".$i."_show_header:is(on)",
				'section'     => $section,				
				);
$subtext 	= array(
				'id'          => $key."_".$i.'_subtext',
				'label'       => __( 'Subtext', THEMO_TEXT_DOMAIN ),
				'type'        => 'textarea-simple',
				'rows'        => '4',
				'class'       => 'meta-child',
				'condition'   => $key."_".$i."_show_header:is(on)",
				'section'     => $section,				
				);*/
$header_float = array(
				'id'          => $key."_header_float",
				'label'       => __( 'Align Header', THEMO_TEXT_DOMAIN ),
				'std'         => 'left',
				'type'        => 'radio-image',
				'class'       => 'meta-child',
				'condition'   => $key."_show_header:is(on)",
				'section'     => $section,	
				'choices'     => array( 
					  array(
						'value'       => 'left',
						'label'       => __( 'Left', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/header_left.png'
					  ),
					  array(
						'value'       => 'centered',
						'label'       => __( 'Center', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/header_center.png'
					  ),
					  array(
						'value'       => 'right',
						'label'       => __( 'Right', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/header_right.png'
					  )
					)
				);
return array($show_header,$header_float);
}

//-----------------------------------------------------
// Sidebar Options
//-----------------------------------------------------
function return_sidebar_options($key,$section ){

$sidebar_options = array(
        'id'          => $key.'_sidebar',
        'label'       => __( 'Sidebar Layout', THEMO_TEXT_DOMAIN ),
        'desc'        => '',
        'std'         => 'right',
        'type'        => 'radio-image',
        'section'     => $section,
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'left',
            'label'       => __( 'Left Sidebar', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/side_bar_left.png'
          ),
          array(
            'value'       => 'full',
            'label'       => __( 'Full Width', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/side_bar_none.png'
          ),
          array(
            'value'       => 'right',
            'label'       => __( 'Right Sidebar', THEMO_TEXT_DOMAIN ),
            'src'         => 'OT_THEME_URL/assets/images/side_bar_right.png'
          )
        )
      );
return $sidebar_options;
}