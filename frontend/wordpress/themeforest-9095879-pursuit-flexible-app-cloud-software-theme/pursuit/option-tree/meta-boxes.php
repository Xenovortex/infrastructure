<?php

$glyphicons_website = "http://glyphicons.com";

//======================================================================
// Meta Box HELPER Functions
//======================================================================

//-----------------------------------------------------
// Glyphioncs / Icons
//-----------------------------------------------------
function return_icons($key,$i){

global $glyphicons_website;

$glyphicons_icon_set = array(
				'id'          => $key."_".$i."_glyphicons_icon_set",
				'label'       => __( 'Custom Icon', THEMO_TEXT_DOMAIN ),
				'std'         => 'none',
				'type'        => 'radio-image',
				'choices'     => array( 
					  array(
						'value'       => 'none',
						'label'       => __( 'none', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/icons_none.png'
					  ),
					  array(
						'value'       => 'glyphicons',
						'label'       => __( 'glyphicon', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/icons_glyphicons.png'
					  ),
					    array(
						'value'       => 'halflings',
						'label'       => __( 'glyphicon', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/icons_halflings.png'
					  ),
					    array(
						'value'       => 'social',
						'label'       => __( 'glyphicon', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/icons_social.png'
					  ),
					    array(
						'value'       => 'filetype',
						'label'       => __( 'glyphicon', THEMO_TEXT_DOMAIN ),
						'src'         => 'OT_THEME_URL/assets/images/icons_filetypes.png'
					  ),
					)
				);

$glyphicons_icon = array(
				'id'          => $key."_".$i."_glyphicons-icon",
				'label'       => '',
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">Glyphicon</a> (e.g.: facebook). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
			  );
				
/*$show_glyphicons = array(
				'id'          =>  $key."_".$i."_show_glyphicons",
				'label'       => 'Glyphicon Icons',
				'std'         => 'off',
				'type'        => 'on-off',
				);
$glyphicons_icon = array(
				'id'          => $key."_".$i."_glyphicons-icon",
				'label'       => '',
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">Glyphicon</a> (e.g.: facebook). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
				'condition'   => $key."_".$i."_show_glyphicons:is(on)",
			  );
$spacer = array(
				'id'          => 'spacer',
				'label'       => '&nbsp;',
				'type'        => 'textblock',
			  );
$show_halflings = array(
				'id'          => $key."_".$i."_show_halflings",
				'label'       => 'Halflings Icons',
				'std'         => 'off',
				'type'        => 'on-off',
			  );
$halflings_icon = array(
				'id'          => 'halflings-icon',
				'label'       => '',
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">HALFLINGS</a> below (e.g.: home). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
				'condition'   =>  $key."_".$i."_show_halflings:is(on)",
			  );
					  
$show_social = array(
				'id'          =>  $key."_".$i."_show_social",
				'label'       => 'Social Icons',
				'std'         => 'off',
				'type'        => 'on-off',
			  );
$social_icon = array(
				'id'          => 'social-icon',
				'label'       => '',
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">SOCIAL</a> icon below (e.g.: twitter). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
				'condition'   =>  $key."_".$i."_show_social:is(on)",
			  );
					 
$show_filetype = array(
				'id'          =>  $key."_".$i."_show_filetype",
				'label'       => 'Filetype Icons',
				'std'         => 'off',
				'type'        => 'on-off',
			  );
$filetype_icon = array(
				'id'          => $key."_".$i."_filetype-icon",
				'label'       => 'Icon - FILETYPES',
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">FILETYPES</a> icon below (e.g.: html). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
				'condition'   =>  $key."_".$i."_show_filetype:is(on)",
			  );
			  
return array($show_glyphicons,$glyphicons_icon,$show_halflings,$halflings_icon,$show_social,$social_icon,$show_filetype, $filetype_icon, $spacer);*/

return array($glyphicons_icon_set,$glyphicons_icon);

}

//-----------------------------------------------------
// Sort Order
//-----------------------------------------------------
function return_sort_order($key,$i){
global $themo_meta_box_order, $post_id;

$meta_box_order = get_post_meta($post_id, $key."_".$i."_order", true);

// Check General Options to see if Manual Sort Order is Seleted.
if ( function_exists( 'ot_get_option' ) ) {
  $meta_box_manual_sort_order = ot_get_option( 'themo_meta_box_builder_meta_box_manual_sort_order', 'off' );
}

// If Manual Sort Order is set to ON, then add "meta-box-order" that will show the manual sort order text field.
$meta_box_class = "meta-box-order";
if(isset($meta_box_manual_sort_order) && $meta_box_manual_sort_order == 'on'){
	$meta_box_class = '';
}

//echo "Existing Order ". $meta_box_order."<br>";
if(isset($meta_box_order) && !$meta_box_order > 0){
	if(!isset($themo_meta_box_order)){
		$themo_meta_box_order = 10;
	}else{
		$themo_meta_box_order = $themo_meta_box_order + 10;
	}
}

//echo "Sort Order Function ".$key."_".$i."_order = ". $themo_meta_box_order."<br>";

$sortorder_tab = array(
					'id'          => $key."_".$i.'_sortorder_tab',
					'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				);
				
$sortorder_show	= array(
					'id'          => $key."_".$i."_sortorder_show",
					'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
					'std'         => 'on',
					'type'        => 'on-off'
				);
$order = array(
				'id'          => $key."_".$i."_order",
				'label'       => __( 'Order', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'class'       => $meta_box_class,
				'condition'   => $key."_".$i."_sortorder_show:is(on)",
				'std'         => $themo_meta_box_order,
				);

$anchor =	array(
				'id'          => $key."_".$i."_anchor",
				'label'       => __( 'Anchor', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'condition'   => $key."_".$i."_sortorder_show:is(on)",
				'class'       => 'anchor-input',
				);		
/*$sortorder_edit_lock	= array(
				'id'          => $key."_".$i."_sortorder_edit_enable",
				'label'       => __( 'Edit Mode', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Turning Edit Mode OFF, improves page load time and protects your meta box content.', THEMO_TEXT_DOMAIN ),
				'std'         => 'on',
				'class'         => 'themo_meta_box_edit_mode',
				'type'        => 'on-off'
			  );*/
			
//return array($sortorder_tab,$sortorder_show,$order,$sortorder_edit_lock);
return array($sortorder_tab,$sortorder_show,$order,$anchor);
}

//-----------------------------------------------------
// Header Options
//-----------------------------------------------------
function return_meta_header($key,$i){
$header_tab =	array(
				'id'          => $key."_".$i.'_header_tab',
				'label'       => __( 'Header', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);
$show_header = array(
				'id'          => $key."_".$i.'_show_header',
				'label'       => __( 'Header', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off'
			  );
				  
$header 	= array(
				'id'          => $key."_".$i."_header",
				'label'       => __( 'Heading', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'condition'   => $key."_".$i."_show_header:is(on)"
				);
$subtext 	= array(
				'id'          => $key."_".$i.'_subtext',
				'label'       => __( 'Subtext', THEMO_TEXT_DOMAIN ),
				'type'        => 'textarea-simple',
				'rows'        => '4',
				
				'condition'   => $key."_".$i."_show_header:is(on)",
				);
$header_float = array(
				'id'          => $key."_".$i."_header_float",
				'label'       => __( 'Align Header', THEMO_TEXT_DOMAIN ),
				'std'         => 'left',
				'type'        => 'radio-image',
				
				'condition'   => $key."_".$i."_show_header:is(on)",
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
return array($header_tab,$show_header,$header,$subtext,$header_float);
}

//-----------------------------------------------------
// Background
//-----------------------------------------------------
function return_background_options($key,$i){
$background_tab =	array(
				'id'          => $key."_".$i.'_background_tab',
				'label'       => __( 'Background', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);
$show_background = array(
				'id'          => $key."_".$i.'_show_background',
				'label'       => __( 'Background Styling', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Background styling is intended for full width pages, therefore they do not show when using sidebars.', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
			);
$parallax = array(
				'id'          => $key."_".$i.'_parallax',
				'label'       => __( 'Parallax', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
				
				'condition'   => $key."_".$i.'_show_background:is(on)',
			);
			
$background = array(
				'id'          => $key."_".$i.'_background',
				'label'       => __( 'Background', THEMO_TEXT_DOMAIN ),
				'type'        => 'background',
				
				'condition'   => $key."_".$i.'_show_background:is(on)',
				'class'       => 'ot-upload-attachment-id-removed',
			);
$background_video_MP4 =     array(
        'id'          => $key."_".$i."_background_video_mp4",
        'label'       => __( 'Video MP4 Upload', THEMO_TEXT_DOMAIN ),
        'type'        => 'upload',
        'condition'   => $key."_".$i.'_show_background:is(on)',
        'class'       => 'ot-upload-attachment-id-removed',
    );
$text_contrast = array(
				'id'          => $key."_".$i.'_text_contrast',
				'label'       => __( 'Text contrast', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'For darker colored backgrounds, use the light text option.', THEMO_TEXT_DOMAIN ),
				'std'         => 'dark',
				'type'        => 'radio-image',
				
				'condition'   => $key."_".$i.'_show_background:is(on)',
				'choices'     => array( 
									array(
									'value'       => 'dark',
									'label'       => __( 'Dark Text (Default)', THEMO_TEXT_DOMAIN ),
									'src'         => 'OT_THEME_URL/assets/images/text_dark.png'
									),
									array(
									'value'       => 'light',
									'label'       => __( 'Light Text', THEMO_TEXT_DOMAIN ),
									'src'         => 'OT_THEME_URL/assets/images/text_light.png'
									)
								)
			);

//return var_export($output,true);
return array($background_tab,$show_background,$parallax,$background,$text_contrast,$background_video_MP4);
}

//-----------------------------------------------------
// Borders
//-----------------------------------------------------
function return_border_options($key,$i){


$show_border_default = "off";
$border_default = "";
	
if($key == 'themo_page_header'){
	$show_border_default = "on";
	$border_default = "bottom";
}

$border_tab =	array(
				'id'          => $key."_".$i.'_border_tab',
				'label'       => __( 'Borders', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);
$show_border = array(
				'id'          => $key."_".$i.'_show_border',
				'label'       => __( 'Borders', THEMO_TEXT_DOMAIN ),
				'std'         => $show_border_default,
				'type'        => 'on-off',
				);
$border =	array(
				'id'          => $key."_".$i.'_border',
				'type'        => 'radio-image',
				'std'         => $border_default,
				'condition'   => $key."_".$i.'_show_border:is(on)',
				'choices'     => array( 
					array(
					'value'       => 'top',
					'label'       => __( 'Top', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/border_top.png'
					),
					array(
					'value'       => 'bottom',
					'label'       => __( 'Bottom', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/border_bottom.png'
					),
					array(
					'value'       => 'both',
					'label'       => __( 'Top & Bottom', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/border_both.png'
					)
				)
			);
$border_full_width = array(
				'id'          => $key."_".$i.'_border_full_width',
				'label'       => __( 'Full with borders', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
				'condition'   => $key."_".$i.'_show_border:is(on)',
				);			
return array($border_tab, $show_border, $border, $border_full_width);
}

//-----------------------------------------------------
// Padding
//-----------------------------------------------------
function return_padding_options($key,$i){
$padding_tab =	array(
				'id'          => $key."_".$i.'_padding_tab',
				'label'       => __( 'Padding', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);
$padding = 	array(
				'id'          => $key."_".$i.'_padding',
				'label'       => __( 'Padding', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off'
			  );
$top_padding = array(
				'id'          => $key."_".$i.'_top_padding',
				'label'       => __( 'Top Padding', THEMO_TEXT_DOMAIN ),
				'type'        => 'numeric-slider',
				'min_max_step'=> '0,300,5',
				
				'condition'   => $key."_".$i.'_padding:is(on)'
				);
$bottom_padding = array(
				'id'          => $key."_".$i.'_bottom_padding',
				'label'       => __( 'Bottom Padding', THEMO_TEXT_DOMAIN ),
				'type'        => 'numeric-slider',
				'min_max_step'=> '0,300,5',
				
				'condition'   => $key."_".$i.'_padding:is(on)',
				);
return array($padding_tab,$padding,$top_padding,$bottom_padding);				  
}

//-----------------------------------------------------
// Animation
//-----------------------------------------------------
function return_animation_options($key,$i){
$animation_tab =	array(
				'id'          => $key."_".$i.'_animation_tab',
				'label'       => __( 'Animation', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);
$animation = 	array(
				'id'          => $key."_".$i.'_animate',
				'label'       => __( 'Animate', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off'
			  );
$animation_style = 	array(
				'id'          => $key."_".$i.'_animate_style',
				'label'       => __( 'Animation Style', THEMO_TEXT_DOMAIN ),
				'std'         => 'slideUp',
				'type'        => 'select',
				'condition'   => $key."_".$i.'_animate:is(on)',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'slideUp',
					'label'       => 'Slide Up'
				  ),
				   array(
					'value'       => 'slideDown',
					'label'       => 'Slide Down'
				  ),
				   array(
					'value'       => 'slideLeft',
					'label'       => 'Slide Left'
				  ),
				   array(
					'value'       => 'slideRight',
					'label'       => 'Slide Right'
				  ),
				  array(
					'value'       => 'fadeIn',
					'label'       => 'Fade In'
				  )
				)
			  );
return array($animation_tab,$animation,$animation_style);				  
}

//-----------------------------------------------------
// Button
//-----------------------------------------------------
function return_button_options($key,$i){

/*$border_tab =	array(
				'id'          => $key."_".$i.'_border_tab',
				'label'       => __( 'Borders', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			);*/
$show_button = array(
				'id'          => $key."_".$i.'_show_button',
				'label'       => __( 'Button', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
				);
$button_text 	= array(
				'id'          => $key."_".$i."_button_text",
				'label'       => __( 'Button Text', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				
				'condition'   => $key."_".$i."_show_button:is(on)"
				);
$button_link 	= array(
				'id'          => $key."_".$i."_button_link",
				'label'       => __( 'Button Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				
				'condition'   => $key."_".$i."_show_button:is(on)"
				);
$button_link_target = 	array(
				'id'          => $key."_".$i.'_button_link_target',
				'label'       => __( 'Link Target', THEMO_TEXT_DOMAIN ),
				'type'        => 'checkbox',
				'condition'   => $key."_".$i."_show_button:is(on)",
				'choices'     => array( 
				  array(
					'value'       => '_blank',
					'label'       => 'Open link in a new window / tab',
				  ),
				)
			  );						
$button_style = 	array(
				'id'          => $key."_".$i.'_button_style',
				'label'       => __( 'Button Style', THEMO_TEXT_DOMAIN ),
				'std'         => 'standard',
				'type'        => 'select',
				'condition'   => $key."_".$i."_show_button:is(on)",
				'operator'    => 'and',
				'choices'     => array( 
				   array(
					'value'       => 'standard',
					'label'       => 'Standard'
				  ),
				  array(
					'value'       => 'ghost',
					'label'       => 'Ghost'
				  ),
				   array(
					'value'       => 'cta',
					'label'       => 'Call to Action'
				  ),
				/* array(
					'value'       => 'accent-light',
					'label'       => 'Accent Light'
				  ),*/
				  
				)
			  );				

return array($show_button,$button_text,$button_link,$button_style,$button_link_target);
}

//-----------------------------------------------------
// Link
//-----------------------------------------------------
function return_link($key,$i){
$show_link = array(
				'id'          => $key."_".$i.'_show_link',
				'label'       => __( 'Display Link', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
				);	
$link 	= array(
				'id'          => $key."_".$i."_link",
				'label'       => __( 'Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				
				'condition'   => $key."_".$i."_show_link:is(on)",
				);
$link_target = 	array(
				'id'          => $key."_".$i.'_link_target',
				'label'       => __( 'Link Target', THEMO_TEXT_DOMAIN ),
				'type'        => 'checkbox',
				'condition'   => $key."_".$i."_show_link:is(on)",
				'choices'     => array( 
				  array(
					'value'       => '_blank',
					'label'       => 'Open link in a new window / tab',
				  ),
				)
			  );
$link_text = array(
				'id'          => $key."_".$i."_link_text",
				'label'       => __( 'Link Text', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				
				'condition'   => $key."_".$i."_show_link:is(on)",
				);				


return array($show_link,$link,$link_target,$link_text);
}
				
//-----------------------------------------------------
// Print Header Action
//-----------------------------------------------------

function print_header_array($key,$i){
	$output = array(
				'id'          => $key."_".$i.'_header',
				'desc'        => __( 'This is some help', THEMO_TEXT_DOMAIN ),
				'label'       => __( 'Heading', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				
				'condition'   => $key."_".$i.'_show_header:is(on)',
			);
	return $output;
}

//-----------------------------------------------------
// Edit Lock Check
//-----------------------------------------------------
function edit_lock_check($key,$i,$locked_options = array(),$meta_box_array = array()){
	global $post_id;

	$edit_lock = 'on'; //get_post_meta($post_id, $key."_".$i."_sortorder_edit_enable", true);
	
	if(isset($edit_lock) && $edit_lock == 'off'){
		return $meta_box_array;
	}else{
		//echo "<pre>";
		foreach ($locked_options as &$value) {
			array_push($meta_box_array['fields'],$value);
		}
		return $meta_box_array;
	}
	
}


add_action( 'admin_init', '_themo_general_meta_boxes' );

add_action( 'admin_init', '_themo_specific_meta_boxes' );


//======================================================================
// General Meta Boxes
//======================================================================

function _themo_general_meta_boxes() {


//-----------------------------------------------------
// Blog Category Filter
//-----------------------------------------------------
    $themo_blog_category_meta_box = array(
        'id'          => 'themo_blog_category_meta_box',
        'title'       => __( 'Category Filter', THEMO_TEXT_DOMAIN ),
        'pages'       => array( 'page' ),
        'context'     => 'normal',
        'priority'    => 'default',
        'fields'      => array(
            // START PAGE LAYOUT META BOX
            array(
                'id'          => 'themo_category_checkbox',
                'std'         => '',
                'type'        => 'category-checkbox',
            ),
            // END PAGE LAYOUT META BOX
        )
    );
    ot_register_meta_box( $themo_blog_category_meta_box );

//-----------------------------------------------------
// Page Layout, Sidebar, Content Editor Sort Order
//-----------------------------------------------------
	$themo_page_layout_meta_box = array(
		'id'          => 'themo_page_layout_meta_box',
		'title'       => __( 'Page Layout', THEMO_TEXT_DOMAIN ),
		'pages'       => array( 'page' ),
		'context'     => 'side',
		'priority'    => 'default',
		'fields'      => array(	
			// START PAGE LAYOUT META BOX		
			array(
				'id'          => 'themo_page_layout',
				'label'       => '',
				'std'         => 'full',
				'type'        => 'radio-image',
				'section'     => 'themo_home_page_meta',
				'choices'     => array( 
					array(
					'value'       => 'left',
					'label'       => __( 'Left Sidebar', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/side_bar_left.png'
					),
					array(
					'value'       => 'right',
					'label'       => __( 'Right Sidebar', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/side_bar_right.png'
					),
					array(
					'value'       => 'full',
					'label'       => __( 'Ful Width', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/side_bar_none.png'
					)
				)
			),
			array(
				'id'          => 'themo_page_disable_nav_transparency',
				'label'       => 'Disable Nav Transparency',
				'desc'       => 'Force nav header to stay solid.',
				'std'         => 'off',
				'type'        => 'on-off',
			  ),
			// END PAGE LAYOUT META BOX					
		)
	);
	ot_register_meta_box( $themo_page_layout_meta_box );


//-----------------------------------------------------
// Page Header
//-----------------------------------------------------	
	//echo "Page Header";
	$key = 'themo_page_header';
	$name = 'Page Header';
	
	$i = 1;
				
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast,$background_video_MP4) = return_background_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);

	/* Get Button Options */
	list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);
	
	
	$themo_page_header_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name,
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START HEADER META BOX
			array(
				'id'          => $key."_".$i.'_pageheader_tab',
				'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			),
			array(
				'id'          => $key."_".$i."_show",
				'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
				'std'         => 'on',
				'type'        => 'on-off',  
			),
			array(
				'id'          => $key."_".$i."_anchor",
				'label'       => __( 'Anchor', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'condition'   => $key."_".$i."_show:is(on)",
				'class'       => 'anchor-input',
				),
			/* Header */
			$header_tab,
			$show_header,
			$header,
			$subtext,
			/* Button */
			$show_button,$button_text,$button_link,$button_style,$button_link_target,
			$header_float,
			
			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			
			/* Animation */
			$animation_tab,$animation,$animation_style,

			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,

			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
				
			// END HEADER BOX			
		)
	);
	ot_register_meta_box( $themo_page_header_meta );

	
//-----------------------------------------------------
// LINK POST Meta Box
//-----------------------------------------------------
	$key = 'themo_post_link';
	$name = 'Link Post';
	
	$themo_post_link_meta_box = array(
		'id'          => $key.'_meta_box',
		'title'       => $name,
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START PAGE LAYOUT META BOX		
			array(
				'id'          => $key.'_url',
				'label'       => $name.' URL',
				'desc'        => 'e.g. http://google.com',
				'type'        => 'text',
			),
			// END PAGE LAYOUT META BOX
		)
	);
	//ot_register_meta_box( $themo_post_link_meta_box ); // Register

//-----------------------------------------------------
// AUDIO POST Meta Box
//-----------------------------------------------------		
	$key = 'themo_post_audio';
	$name = 'Audio Post';
	
	$themo_post_audio_meta_box = array(
		'id'          => $key.'_meta_box',
		'title'       => $name,
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START AUDIO POST Options	
			array(
				'id'          => $key.'_file', 
				'label'       => __( 'File Upload', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Supported File Types:', THEMO_TEXT_DOMAIN ) . ' .mp3, .m4a, .ogg, .wav',
				'type'        => 'upload',
			),
			// END AUDIO POST Options
		)
	);
	//ot_register_meta_box( $themo_post_audio_meta_box ); // Register
	
//-----------------------------------------------------
// VIDEO POST Meta Box
//-----------------------------------------------------			
	$key = 'themo_post_video';
	$name = 'Video Post';
	
	$themo_post_video_meta_box = array(
		'id'          => $key.'_meta_box',
		'title'       => $name,
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START VIDEO POST Options	
			array(
				'id'          => $key.'_file',
				'label'       => __( 'File Upload', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Supported File Types:', THEMO_TEXT_DOMAIN ) . ' .mp4, .m4v (MPEG-4), .mov (QuickTime), .wmv (Windows Media Video), .avi, .mpg, .ogv (Ogg), .3gp (3GPP), .3g2 (3GPP2) ',
				'type'        => 'upload',
			),
			array(
				'id'          => $key.'_preview',
				'label'       => __( 'Preview Image', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Upload an image to show as placeholder before the media plays.', THEMO_TEXT_DOMAIN ),
				'type'        => 'upload',
			),
			array(
				'id'          => $key.'_embed_link',
				'label'       => __( 'Embed Video Link', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'If the video is embedded rather than self hosted, paste a link to the video here. e.g. http://my.movies.com/cool/movie/coolest.mov. See supported sites on ', THEMO_TEXT_DOMAIN ) . ' <a href="https://codex.wordpress.org/Embeds" target="_blank">WordPress.org</a>',
				'type'        => 'text',
			),
			array(
				'id'          => $key.'_embed',
				'label'       => __( 'Embed Code Advanced', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'If the video is embedded rather than self hosted, paste your embed code here.', THEMO_TEXT_DOMAIN ),
				'type'        => 'textarea-simple',
			),
			// END VIDEO POST Options
		)
	);
	//ot_register_meta_box( $themo_post_video_meta_box ); // Register
	
//-----------------------------------------------------
// QUOTE POST Meta Box
//-----------------------------------------------------
	$key = 'themo_post_quote';
	$name = 'Quote Post';
	
	$themo_post_quote_meta_box = array(
		'id'          => $key.'_meta_box',
		'title'       => $name,
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START QUOTE POST Options	
			array(
				'id'          => $key,
				'label'       => __( 'Quote', THEMO_TEXT_DOMAIN ),
				'type'        => 'textarea-simple',
			),
			array(
				'id'          => $key.'_cite_name',
				'label'       => __( 'Source', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'e.g. Mr. Labelle', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',	
			),
			array(
				'id'          => $key.'_cite_title',
				'label'       => __( 'Source Title', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'e.g. CEO', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',	
			),
			// END QUOTE POST Options
		)
	);
	//ot_register_meta_box( $themo_post_quote_meta_box ); // Register

//-----------------------------------------------------
// GALLERY POST Meta Box
//-----------------------------------------------------		
	$key = 'themo_post_gallery';
	$name = 'Gallery Post';
	
	$themo_post_gallery_meta_box = array(
		'id'          => $key.'_meta_box',
		'title'       => $name,
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START GALLERY POST Options	
			 array(
				'id'          => $key."_slider",
				'label'       => __( 'Display Gallery as a Slider', THEMO_TEXT_DOMAIN ),
				'std'         => 'on',
				'type'        => 'on-off',
			),
			// END GALLERY POST Options
		)
	);
	//ot_register_meta_box( $themo_post_gallery_meta_box ); // Register
	

//-----------------------------------------------------
// META BOX Prefs
//-----------------------------------------------------	

	$themo_meta_prefs = array(
		'id'        => '_themo_meta_prefs_meta_box',
		'title'     => 'Meta Box Prefs',
		'pages'     => array( 'page' ),
		'context'   => 'normal',
		'priority'  => 'low',
		'fields'    => array(
				array(
				'id'          => '_themo_meta_prefs',
				'label'       => 'themo_meta_prefs',
				'type'        => 'text',
				)
			)
		);
	//ot_register_meta_box( $themo_meta_prefs );
} 


//======================================================================
// Specific Meta Boxes
//======================================================================

function _themo_specific_meta_boxes() {	
	
	global $post_id;
	$post_id = (isset($_GET['post'])) ? $_GET['post'] : ((isset($_POST['post_ID'])) ? $_POST['post_ID'] : false);
	
	
	//-----------------------------------------------------
		// Meta Box Builder
		//-----------------------------------------------------	
		$key = 'themo_meta_box_builder';
		$name = 'Meta Box Builder';
		
		$i = 1;
		
		$themo_meta_box_builder_meta = array(
			'id'          => $key."_meta_box",
			'title'       => $name,
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				array(
					'id'          => $key."_meta_boxes_tab",
					'label'       => __( 'Selection', THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				array(
				'id'          => $key."_meta_boxes",
				'label'       => __( 'Meta Boxes', THEMO_TEXT_DOMAIN ),
				'type'        => 'checkbox',
				'class'		=> 'checkbox-inline',
				'choices'     => array( 
					array(
					'value'       => 'accordion',
					'label'       => 'Accordion',
					'src'         => ''
					),
					array(
					'value'       => 'brands',
					'label'       => 'Brands',
					'src'         => ''
					),
					array(
					'value'       => 'call_to_action',
					'label'       => 'Call to Action',
					'src'         => ''
					),
					array(
					'value'       => 'content_editor',
					'label'       => 'Content Editor',
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
                    'value'       => 'slider_master',
                    'label'       => 'Master Slider',
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
				// END HEADER BOX			
			)
		);
	
	if ($post_id){
		
		//-----------------------------------------------------
		// Helper to find label for key.
		//-----------------------------------------------------	
		function search_for_meta_value($value, $array) {
		   foreach ($array as $key => $val) {
			   if ($val['value'] === $value) {
				   return $val['label'];
			   }
		   }
		   return null;
		}
		
		//-----------------------------------------------------
		// Get Meta Box Selections for this post / page 
		// and add quantity sliders
		//-----------------------------------------------------	
		
		$themo_meta_box_builder_meta_boxes = get_post_meta($post_id, 'themo_meta_box_builder_meta_boxes', true);
		
		
		
		
		// If there are values, then add meta boxes to page / post.
		if ( isset($themo_meta_box_builder_meta_boxes) && is_array($themo_meta_box_builder_meta_boxes)) {
		
		// Check General Options to see the max quantity for meta boxes.
		if ( function_exists( 'ot_get_option' ) ) {
		  $meta_box_max_quantity = ot_get_option( 'themo_meta_box_builder_meta_box_max_quantity', '5' );
		}
			
			// Add Tab for Meta Box Quantity Sliders
			array_push($themo_meta_box_builder_meta['fields'],array('id'=> $key."_meta_boxe_quantity_tab",'label'=> __( 'Quantity', THEMO_TEXT_DOMAIN ),'type'=> 'tab'));
			
			foreach($themo_meta_box_builder_meta_boxes as $value => $meta_box_name){ // loop through each metabox and output metabox		
				
				if( $meta_box_name !== 'content_editor' && $meta_box_name !== 'slider' && $meta_box_name !== 'slider_master'){
			
					$label = search_for_meta_value($meta_box_name, $themo_meta_box_builder_meta['fields'][1]['choices']);
					
					$meta_box_quantity =  array(
							'id'          => 'themo_meta_box_quantity_'.$meta_box_name,
							'label'       => ucfirst($label),
							'desc'        => '',
							'std'         => '',
							'type'        => 'numeric-slider',
							'rows'        => '',
							'post_type'   => '',
							'taxonomy'    => '',
							'min_max_step'=> '1,'.$meta_box_max_quantity.',1',
							'operator'    => 'and'
						  );
					array_push($themo_meta_box_builder_meta['fields'],$meta_box_quantity);
				}
			}
			
			//-----------------------------------------------------
			// Sortable 
			//-----------------------------------------------------	
			
			// Add Sortable
			array_push($themo_meta_box_builder_meta['fields'],array('id'=> $key."_meta_boxes_tab_sortable",'label'=> __( 'Sort Order', THEMO_TEXT_DOMAIN ),'type'=> 'tab'));
			//array_push($themo_meta_box_builder_meta['fields'],array('id'=> $key."_meta_box_manual_sort_order",'label'=> __( 'Manual Sort Order', THEMO_TEXT_DOMAIN ),'type'=> 'on-off','std'=> 'off'));
			array_push($themo_meta_box_builder_meta['fields'],array('id'=> $key."_meta_box_sort_order",'label'=> __( 'Drag and drop to organize', THEMO_TEXT_DOMAIN ),'type'=> 'sortable'));
			
			// Keep track of where we are in the array.
			$fields_count = count($themo_meta_box_builder_meta['fields'])-1;

			$meta_box_sorted_list = array();

				//echo "<pre>";
				//print_r($themo_meta_box_builder_meta_boxes);
				//echo "</pre>";
			
			
			/*
			$meta_box_sortable = array(
				'value'       => $themo_meta_box_prefix."page_layout_content",
				'label'       => "Main Content Editor",
				'meta_name'       => $themo_meta_box_prefix."page_layout_content",
			);
			$choices = array($meta_box_sortable);
			$themo_meta_box_builder_meta['fields'][$fields_count]['choices']=$choices;
			*/
			
			//foreach( $meta_box_sorted_list as $value => $meta_box_name ) {
			foreach( $themo_meta_box_builder_meta_boxes as $value => $meta_box_name ) {
			
				if($meta_box_name !== 'slider' && $meta_box_name !== 'slider_master'){
					$label = search_for_meta_value($meta_box_name, $themo_meta_box_builder_meta['fields'][1]['choices']);
					
					// See if there are more than 1 copies of this meta box
					$themo_meta_box_builder_meta_box_quantity = get_post_meta($post_id, 'themo_meta_box_quantity_'.$meta_box_name, true);
					
					// If there is more than 1 copy of a meta box, save the value.
					if(isset($themo_meta_box_builder_meta_box_quantity) && $themo_meta_box_builder_meta_box_quantity > ""){
						$themo_meta_box_quantity = $themo_meta_box_builder_meta_box_quantity;
					}else{
						$themo_meta_box_quantity = 1;
					}
					
					$themo_meta_box_prefix = 'themo_';
	
					$x=1; // our counter
					
					// for each copy, add the meta box to the page.
					while($x<=$themo_meta_box_quantity) {
						$meta_box_sortable = array(
							'value'       => $themo_meta_box_prefix.$value."_".$x,
							'label'       => ucfirst($label).return_meta_box_number($x),
							'meta_name'       => $themo_meta_box_prefix.$meta_box_name."_".$x,
						);
						

						//echo "<pre>";
						//print_r($meta_box_sortable);
						//echo "</pre>";
						
						if(isset($themo_meta_box_builder_meta['fields'][$fields_count]['choices']) && $themo_meta_box_builder_meta['fields'][$fields_count]['choices'] > ""){
							array_push($themo_meta_box_builder_meta['fields'][$fields_count]['choices'],$meta_box_sortable);
						}else{
							$choices = array($meta_box_sortable);
							$themo_meta_box_builder_meta['fields'][$fields_count]['choices']=$choices;
						}
					
					  $x++;
					}
				}

				//$meta_box_order_count++;
			}
		}
	}
	ot_register_meta_box( $themo_meta_box_builder_meta );
	
	if ($post_id){
		
		//-----------------------------------------------------
		// Track Max Order Value for Sorting
		//-----------------------------------------------------	
		$custom_field_keys = get_post_custom($post_id); // GET ALL CUSTOM META DATA
		
		// For each Key, loop through and get the max order value.
		foreach ( $custom_field_keys as $key => $value ) {
		
			$pos_show = strpos($key, '_sortorder_show'); // Only interested in themo fields
			$meta_key = substr($key, 0, $pos_show); // Just the key prefix please.
		
			$sort_order_key = $meta_key . '_order'; // Add prefix to _order to snag order value.
		
			if (array_key_exists($sort_order_key, $custom_field_keys)) { // If a sort order value is set, grab it.
				$sort_order = $custom_field_keys[$sort_order_key][0]; 
				$sort_order_array[] = $sort_order; // Add to array so we can get max value later.
			}
		}
		// Now we have all Order Values in an Array, loop through and get the highest number.
		if(isset($sort_order_array)){
			$sort_order_max = max($sort_order_array); // Store Max Order Value, update Global variable.
			if($sort_order_max > 0){
				global $themo_meta_box_order;
				$themo_meta_box_order = $sort_order_max;
			}
		}
		
		//-----------------------------------------------------
		// Get Meta Box Selections for this post / page.
		//-----------------------------------------------------	
		$themo_meta_box_builder_meta_boxes = get_post_meta($post_id, 'themo_meta_box_builder_meta_boxes', true);
		
		// If there are values, then add meta boxes to page / post.
		if ( isset($themo_meta_box_builder_meta_boxes) && is_array($themo_meta_box_builder_meta_boxes)) {
			$i = 1;
			foreach($themo_meta_box_builder_meta_boxes as $value => $meta_box_name){ // loop through each metabox and output metabox	
				// How many meta boxes do we need to print?
				$meta_box_multiply = 1;
				$themo_meta_box_quantity = get_post_meta($post_id, "themo_meta_box_quantity_".$meta_box_name, true);
				
				if(isset($themo_meta_box_quantity) && $themo_meta_box_quantity > 1){
					$meta_box_multiply = $themo_meta_box_quantity;
				}
				register_meta_box($meta_box_name,$meta_box_multiply);
			}
		}
				
	}
}

function _themo_specific_meta_boxes_hold() {
	
	$themo_custom_template_meta_box = array(
		'id'          => 'themo_custom_template_meta_box',
		'title'       => __( 'Custom Page Templates', THEMO_TEXT_DOMAIN ),
		'pages'       => array( 'page' ),
		'context'     => 'side',
		'priority'    => 'high',
		'fields'      => array(	
			
			array(
				'id'          => 'themo_template_select_help',
				'label'       => __( 'Refresh Page', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'You will need to refresh this page in order for the new template setting to take effect.', THEMO_TEXT_DOMAIN ),
				'type'        => 'textblock',
				'operator'    => 'and'
			),
			array(
				'id'          => 'themo_template_selection',
				'label'       => '',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'default',
					'label'       => 'Default'
				  )
				)
			  ),
		)
	);
	
	
	if ( function_exists( 'ot_get_option' ) ) {
		/* get an array of page id's */
		$templates = ot_get_option( 'themo_custom_template', array() );
		if ( ! empty( $templates ) ){
			$i = 1;
			//array_pop($themo_custom_template_meta_box['fields'][1]['choices']);
			foreach( $templates as $template ) {
				$title = $template['title'];
				$title_slug =  sanitize_title($template['title']);
				array_push($themo_custom_template_meta_box['fields'][1]['choices'],array('value' => $title_slug,'label' => $title));
				$i++;
			}
		}
	}
	
	ot_register_meta_box( $themo_custom_template_meta_box );
	
	
	global $post_id;
	$post_id = (isset($_GET['post'])) ? $_GET['post'] : ((isset($_POST['post_ID'])) ? $_POST['post_ID'] : false);
	
	
	/* TO  DO 
		Find the template we are using and only create meta boxes for it.
		We'll need to put each metabox in it's own function.
	*/
	if ($post_id){
		/*
		TO DO - Find the highest Meta Box Order Value, and update Global Order Count.
		If user is adding new meta boxes, we want to make sure the new meta box has a proper order value.
		It should show at the bottom of the list.
		e.g. if the highest order value is 50, then we want to make the next order value 60.
		*/
		
		
		$custom_field_keys = get_post_custom($post_id); // GET ALL CUSTOM META DATA
		
		// For each Key, loop through and get the max order value.
		foreach ( $custom_field_keys as $key => $value ) {
		
			$pos_show = strpos($key, '_sortorder_show'); // Only interested in themo fields
			$meta_key = substr($key, 0, $pos_show); // Just the key prefix please.
		
			$sort_order_key = $meta_key . '_order'; // Add prefix to _order to snag order value.
		
			if (array_key_exists($sort_order_key, $custom_field_keys)) { // If a sort order value is set, grab it.
				$sort_order = $custom_field_keys[$sort_order_key][0]; 
				$sort_order_array[] = $sort_order; // Add to array so we can get max value later.
				//echo $sort_order_key." = ".$sort_order."<br>";
			}
		}
		
		if(isset($sort_order_array)){
			$sort_order_max = max($sort_order_array); // Store Max Order Value, update Global variable.
		
			//echo "MAX ". $sort_order_max."<br>";
			
			if($sort_order_max > 0){
				global $themo_meta_box_order;
				$themo_meta_box_order = $sort_order_max;
				//echo "themo_meta_box_order ". $themo_meta_box_order."<br>";
			}
		}

		$template_slug = get_post_meta($post_id, 'themo_template_selection', true);
		$template_slug  = str_replace("-","_",$template_slug ); 
		
		
		if ( function_exists( 'ot_get_option' ) ) {
			/* get an array of page id's */
			$templates = ot_get_option( 'themo_custom_template', array() );
			if ( ! empty( $templates ) ){
				$i = 1;
				foreach( $templates as $template ) {
					//$title = $template['title'];
					$title_slug =  sanitize_title($template['title']); // Match meta box title slug
					$title_slug = str_replace("-","_",$title_slug); 
					//echo "<pre>";
					//print_r($template);
					//echo "</pre>";
					//echo "Title Slug ".$title_slug . "<br>";
					if ($template_slug == $title_slug){
						foreach($template['meta_boxes'] as $value => $meta_box_name){ // loop through each metabox and output metabox
							
							// How many meta boxes do we need to print?
							//$meta_box_name_quantity_key = str_replace("-","_",$meta_box_name); 
							$meta_box_multiply = 1;
							//echo "themo_meta_box_quantity_".$meta_box_name;
							if(isset($template["themo_meta_box_quantity_".$meta_box_name]) && $template["themo_meta_box_quantity_".$meta_box_name] > 1){
								$meta_box_multiply = $template["themo_meta_box_quantity_".$meta_box_name];
							}
							register_meta_box($meta_box_name,$meta_box_multiply);
						}
					}
					$i++;
				}
			}
		}
				
	};
	
}


//======================================================================
// register_meta_box
// Register Specific Meta Box
//======================================================================
function register_meta_box($meta_box_name,$meta_box_multiply = 1){

global $glyphicons_website;
/*
echo "<pre>";
echo "<BR>META BOX ".$meta_box_name;
echo "<BR>META Count  ".$meta_box_multiply;
echo "</pre>";
*/
switch ($meta_box_name){

case "accordion":
//-----------------------------------------------------
// Accordion
//-----------------------------------------------------	
	$key = 'themo_accordion';
	$name = 'Accordion';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
		
		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
			
		/* Header */
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
		
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
		
		/* Icons 
		list($show_glyphicons,$glyphicons_icon,$show_halflings,$halflings_icon,$show_social,$social_icon,$show_filetype, $filetype_icon, $spacer) = return_icons($key,$i);*/	
		list($glyphicons_icon_set,$glyphicons_icon) = return_icons($key,$i);
		
		/* Get Button Options */
		list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);

		$themo_accordion_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START accordion
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
				

				// END accordion META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
			$header_tab, $show_header,
			$header,
			$subtext,
			$header_float,	
			
			/* Accordions */
			array(
				'id'          => $key."_".$i.'_tab',
				'label'       => __( $name, THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			),
			array(
				'id'          => $key."_".$i."_show",
				'label'       => $name,
				'std'         => 'off',
				'type'        => 'on-off',
			  ),
			array(
				'id'          => $key."_".$i,
				'label'       => __( 'Add new', THEMO_TEXT_DOMAIN ),
				'type'        => 'list-item',
				'condition'   => $key."_".$i."_show:is(on)",
				'settings'    => array( 
				  array(
					'id'          => $key."_".$i."_description",
					'label'       => __( 'Description', THEMO_TEXT_DOMAIN ),
					'type'        => 'textarea-simple',
					'rows'        => '3',
					'class'		=> 'themo_wp_editor',
				  ),
				 /* Icons 	
				$show_glyphicons,$glyphicons_icon,$spacer,
				$show_halflings,$halflings_icon,$spacer,
				$show_social,$social_icon,$spacer,
				$show_filetype,$filetype_icon,*/
				$glyphicons_icon_set,$glyphicons_icon,
				/* Button */
				$show_button,$button_text,$button_link,$button_style,$button_link_target,
				)
			),
			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_accordion_meta = edit_lock_check($key,$i,$locked_options,$themo_accordion_meta);
		
		ot_register_meta_box( $themo_accordion_meta );
	} // END accordion

break;
case "brands":
//-----------------------------------------------------
// BRANDS
//-----------------------------------------------------
	$key = 'themo_brands';
	$name = 'Brands';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
		
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Link Options */
	list($show_link,$link,$link_target,$link_text) = return_link($key,$i);
	
		$themo_homepage_logo_list_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START BRAND LIST META BOX
			
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
	
				
			// END LOGO LIST META BOX				
			)
		);
		
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
				/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	
			
			  /* Logo List */
				 array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				  array(
					'id'          => $key."_".$i."_show",
					'label'       => $name,
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  /*array(
					'id'          => $key."_".$i.'_before',
					'label'       => __( 'Before Copy / Text', THEMO_TEXT_DOMAIN ),
					'type'        => 'text',
					'condition'   => $key."_".$i."_show:is(on)",
				  ),*/
				  array(
					'id'          => $key."_".$i,
					'label'       => __( 'Add a ', THEMO_TEXT_DOMAIN ). $key,
					'type'        => 'list-item',
					'condition'   => $key."_".$i."_show:is(on)",
					'settings'    => array( 
					  array(
						'id'          => $key."_".$i.'_image',
						'label'       => __( 'Logo', THEMO_TEXT_DOMAIN ),
						'type'        => 'upload',
						'class'       => 'ot-upload-attachment-id-removed',
					  ),
					  
					/* Link */
					$show_link,$link,$link_target,$link_text,

					)
				  ),
				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Animation */
				$animation_tab,$animation,$animation_style,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_homepage_logo_list_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_logo_list_meta);
		
		ot_register_meta_box( $themo_homepage_logo_list_meta );
	} // END BRAND LIST LOOP
	
break;
case "call_to_action":
//-----------------------------------------------------
// CALL TO ACTION 
//-----------------------------------------------------
	$key = 'themo_call_to_action';
	$name = 'Call to action';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);

	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);

	/* Get Button Options */
	list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);
	
		$themo_homepage_call_to_action_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
		
		// START CALL TO ACTION META BOX
		
			 /* Sort Order */
			$sortorder_tab,$sortorder_show,$order,$anchor,
			  
			
				// END CALL TO ACTION META BOX				
			)
		);	
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
		
			array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
			  array(
				'id'          => $key."_".$i."_show",
				'label'       => $name,
				'std'         => 'off',
				'type'        => 'on-off',
			  ),
				 array(
					'id'          => $key."_".$i."_text",
					'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
					'type'        => 'text',
					'condition'   => $key.'_'.$i."_show:is(on)",
				  ),
				/* Button */
				$show_button,$button_text,$button_link,$button_style,$button_link_target,
				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Animation */
				$animation_tab,$animation,$animation_style,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_homepage_call_to_action_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_call_to_action_meta);

		ot_register_meta_box( $themo_homepage_call_to_action_meta );
	}
	
break;

case "content_editor":
//-----------------------------------------------------
// Content Editor
//-----------------------------------------------------
	$key = 'themo_content_editor';
	$name = 'Content Editor';
	
	$i = 1;	
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	$themo_content_editor_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name,
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START META BOX
			$sortorder_tab,$sortorder_show,$order,$anchor,		
			// END BOX			
		)
	);
	ot_register_meta_box( $themo_content_editor_meta );
break;


case "conversion_form":
//-----------------------------------------------------
// CONVERSION FORM
//-----------------------------------------------------	
	$key = 'themo_conversion_form';
	$name = 'Conversion Form';
	
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
		$themo_conversion_form_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
			// START CONVERSION FORM
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
				
				// END CONVERSION FORM				
			)
		);
	
		
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	
				
				/* Conversion Form */
				  array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				  array(
					'id'          => $key."_".$i."_show",
					'label'       => __( 'Form', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  array(
					'id'          => $key."_".$i.'_shortcode',
					'label'       => __( 'Form Shortcode', THEMO_TEXT_DOMAIN ),
					'type'        => 'text',
					'condition'   => $key."_".$i."_show:is(on)",
					
				),
				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_conversion_form_meta = edit_lock_check($key,$i,$locked_options,$themo_conversion_form_meta);

		ot_register_meta_box( $themo_conversion_form_meta );
	} // END CONVERSION LOOP
	
break;
case "faq":
//-----------------------------------------------------
// FAQs
//-----------------------------------------------------		
	$key = 'themo_faq';
	$name = 'FAQ';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP

		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
			
		/* Header */
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
		
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

		/* Animation */	
		list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
		$themo_float_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	

				// START FLOATING META BOX
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				

			) // END Fields.
				
		); // END FLOATING META BOX				
	
	// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
	$locked_options = array(
		/* Header */
		$header_tab, $show_header,
		$header,
		$subtext,
		$header_float,	
		
		/* FAQ */
		array(
			'id'          => $key."_".$i.'_tab',
			'label'       => __( $name, THEMO_TEXT_DOMAIN ),
			'type'        => 'tab'
		),
		array(
			'id'          => $key."_".$i."_show",
			'label'       => $name,
			'std'         => 'off',
			'type'        => 'on-off',
		  ),
		 array(
			'id'          => $key."_".$i,
			'label'       => __( 'Add ', THEMO_TEXT_DOMAIN ). $name,
			'type'        => 'list-item',
			'condition'   => $key."_".$i."_show:is(on)",
			'settings'    => array( 
			  array(
				'id'          => 'answer',
				'label'       => __( 'Answer', THEMO_TEXT_DOMAIN ),
				'class' 		=> 'themo_wp_editor',
				'rows'        => '3',
				'type'        => 'textarea-simple',
			  )
			)
		),
		  
		/* Background */
		$background_tab,$show_background,$parallax,$background,$text_contrast,
		/* Animation */
		$animation_tab,$animation,$animation_style,
		/* Borders */
		$border_tab, $show_border, $border, $border_full_width,
		/* Padding */
		$padding_tab,$padding,$top_padding,$bottom_padding
	);
	
	
	// Check for Edit Lock / hide locked meta box options of ON
	$themo_float_meta = edit_lock_check($key,$i,$locked_options,$themo_float_meta);

	ot_register_meta_box( $themo_float_meta );
	} // END FLOAT LOOP
	
break;
case "featured":
//-----------------------------------------------------
// FEATURED
//-----------------------------------------------------
	$key = 'themo_featured';
	$name = 'Featured';
	
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Link Options */
	list($show_link,$link,$link_target,$link_text) = return_link($key,$i);
	
	$themo_homepage_featured_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
		// START FEATURED META BOX
		  	/* Sort Order */
			$sortorder_tab,$sortorder_show,$order,$anchor,
			
			
			// END FEATURED META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
			$header_tab,$show_header,
			$header,
			$subtext,
			$header_float,
			 
			/* Featured Items */
			array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
			 array(
				'id'          => $key."_".$i."_show",
				'label'       => $name." Items",
				'std'         => 'off',
				'type'        => 'on-off',
				  ),
			  array(
				'id'          => $key."_".$i,
				'label'       => __( 'Add a Feature', THEMO_TEXT_DOMAIN ),
				'type'        => 'list-item',
				'condition'   => $key."_".$i."_show:is(on)",
				'settings'    => array( 
				  array(
					'id'          => $key."_".$i."_text",
					'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
					'type'        => 'textarea-simple',
					'rows'        => '3',
				  ),
				  array(
					'id'          => $key."_".$i."_image",
					'label'       => __( 'Image', THEMO_TEXT_DOMAIN ),
					'type'        => 'upload',
					'class'       => 'ot-upload-attachment-id-removed',
				  ),
					/* Link */
					$show_link,$link,$link_target,$link_text,
				)
			  ),
			 /* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Animation */
			$animation_tab,$animation,$animation_style,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_homepage_featured_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_featured_meta);

		ot_register_meta_box( $themo_homepage_featured_meta );
	} // END FEATURED LOOP
	
break;
case "html":
//-----------------------------------------------------
// HTML
//-----------------------------------------------------
	$key = 'themo_html';
	$name = 'HTML';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
	
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

		$themo_html_editor_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START HTML EDITOR META BOX
				
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
				
			// END HTML EDITOR META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,
				
				/* HTML EDITOR */
				
				array(
					'label'       => __( 'HTML Editor', THEMO_TEXT_DOMAIN ),
					'id'          => 'tab_html_editor',
					'type'        => 'tab'
				  ),
				array(
					'id'          => $key."_".$i."_show",
					'label'       => __( 'Content', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				array(
					'id'          => $key."_".$i."_content",
					'label'       => __( 'Add Content', THEMO_TEXT_DOMAIN ),
					'type'        => 'textarea-simple',
					'rows'        => '6',
					'condition'   => $key."_".$i."_show:is(on)",
					'class' => 'themo_wp_editor',
				),
				
				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_html_editor_meta = edit_lock_check($key,$i,$locked_options,$themo_html_editor_meta);
		
		ot_register_meta_box( $themo_html_editor_meta );
	} // END HTML
	
break;
case "map":
//-----------------------------------------------------
// MAP
//-----------------------------------------------------			
	$key = 'themo_map';
	$name = 'Map';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
		
		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
			
		/* Header */
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
		
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

		$themo_gmap_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
				// END GOOGLE MAP META BOX
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,
				
				/* Google Map */
				array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				array(
						'id'          => $key."_".$i."_show",
						'label'       => $name." Shortcode",
						'std'         => 'off',
						'type'        => 'on-off',
					  ),
					  array(
							'id'          => $key."_".$i."_shortcode",
							'label'       => __( 'Add a Shortocde', THEMO_TEXT_DOMAIN ),
							'desc' => __( 'Example:', THEMO_TEXT_DOMAIN ) . ' [google_map title="Our Location" location="Liberty Island, New York, NY 10004, United States" height="300" zoom="8" align="default"]',
							'type'        => 'text',
							'condition'   => $key."_".$i."_show:is(on)",
						  ),
					array(
						'id'          => $key."_".$i."_in_heder",
						'label'       => __( 'Replace Header with Map', THEMO_TEXT_DOMAIN ),
						'std'         => 'off',
						'type'        => 'on-off',
						'condition'   => $key."_".$i."_show:is(on)",
					  ),

				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_gmap_meta = edit_lock_check($key,$i,$locked_options,$themo_gmap_meta);
		
		ot_register_meta_box( $themo_gmap_meta );
	} // END GOOGLE MAP LOOP
	
break;


case "slider_master":
//-----------------------------------------------------
// Master Slider
//-----------------------------------------------------
        $key = 'themo_slider_master';
        $name = 'Master Slider';

        $i = 1;

        /* Sort Order */
        list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);

        $themo_master_slider_meta = array(
            'id'          => $key."_meta_box",
            'title'       => $name,
            'pages'       => array( 'page' ),
            'context'     => 'normal',
            'priority'    => 'high',
            'fields'      => array(
                // START META BOX
               // $sortorder_tab,$sortorder_show,$order,$anchor,
                // END BOX
            )
        );

        // Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
        $locked_options = array(

            /* Conversion Form */
            array(
                'id'          => $key.'_tab',
                'label'       => __( $name, THEMO_TEXT_DOMAIN ),
                'type'        => 'tab'
            ),
            array(
                'id'          => $key."_show",
                'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
                'std'         => 'off',
                'type'        => 'on-off',
            ),
            array(
                'id'          => $key.'_shortcode',
                'label'       => __( 'Slider Shortcode', THEMO_TEXT_DOMAIN ),
                'type'        => 'text',
                'condition'   => $key."_show:is(on)",

            ),
        );


        // Check for Edit Lock / hide locked meta box options of ON
        $themo_master_slider_meta = edit_lock_check($key,$i,$locked_options,$themo_master_slider_meta);


        ot_register_meta_box( $themo_master_slider_meta );
        break;

case "pricing_plans":
//-----------------------------------------------------
// PLANS
//-----------------------------------------------------		
	$key = 'themo_pricing_plans';
	$name = 'Pricing Plans';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);

	/* Get Button Options */
	list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);

		$themo_plans_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START PLANS META BOX
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
				
				// END PLANS META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	
				
				/* Service Plans */
				  array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				  array(
					'id'          => $key."_".$i."_show",
					'label'       => $name,
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  array(
					'id'          => $key."_".$i,
					'label'       => __( 'Add', THEMO_TEXT_DOMAIN ).$name.' Column (5 Max)',
					'type'        => 'list-item',
					'section'     => __( 'Jobs', THEMO_TEXT_DOMAIN ),
					
					'condition'   => $key."_".$i."_show:is(on)",
					'settings'    => array( 
					  array(
						'id'          => $key."_".$i."_price",
						'label'       => 'Price',
						'type'        => 'text',
					  ),
					  array(
						'id'          => $key."_".$i."_price_per",
						'label'       => __( 'Price per', THEMO_TEXT_DOMAIN ),
						'desc'        => __( 'Example: /month', THEMO_TEXT_DOMAIN ),
						'type'        => 'text',
					  ),
					  array(
						'id'          => $key."_".$i."_details",
						'label'       => $name. ' Details',
						'desc'        => __( 'List all details here.  Use a line break to force a new row.', THEMO_TEXT_DOMAIN ),
						'type'        => 'textarea-simple',
						'rows'        => '3',
					  ),
					  	/* Button */
						$show_button,$button_text,$button_link,$button_style,$button_link_target,
					  array(
						'id'          => $key."_".$i."_featured",
						'label'       => __( 'Most Popular / Featured.', THEMO_TEXT_DOMAIN ),
						'std'         => 'off',
						'type'        => 'on-off',
					  ),
					)
				  ),
				  array(
					'id'          => $key."_".$i."_footnote_show",
					'label'       => __( 'Footnote', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  array(
					'id'          => $key."_".$i."_footnote",
					'label'       => __( 'Footnote Copy', THEMO_TEXT_DOMAIN ),
					'type'        => 'textarea-simple',
					'rows'        => '3',
					
					'condition'   => $key."_".$i.'_footnote_show:is(on)',
				  ),
				/* Background */
				$background_tab,$show_background,$parallax,$background,$text_contrast,
				/* Animation */
				$animation_tab,$animation,$animation_style,
				/* Borders */
				$border_tab, $show_border, $border, $border_full_width,
				/* Padding */
				$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_plans_meta = edit_lock_check($key,$i,$locked_options,$themo_plans_meta);

		ot_register_meta_box( $themo_plans_meta );
	} // END PLANS

break;
case "service_block":
//-----------------------------------------------------
// SERVICE BLOCKS (Style 1 and 2)
//-----------------------------------------------------	
$key = 'themo_service_block';
$name = 'Service Block';	

for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP

	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

	/* Icons 
	list($show_glyphicons,$glyphicons_icon,$show_halflings,$halflings_icon,$show_social,$social_icon,$show_filetype, $filetype_icon, $spacer) = return_icons($key,$i);*/
	list($glyphicons_icon_set,$glyphicons_icon) = return_icons($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Link Options */
	list($show_link,$link,$link_target,$link_text) = return_link($key,$i);

	
	
	$themo_homepage_service_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START SERVICE META BOX
			/* Sort Order */
			$sortorder_tab,$sortorder_show,$order,$anchor,
			
			
			 
			// END SERVICE META BOX				
		)
	);
	
	
	// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
	$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	
				
			array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
			array(
				'id'          => $key."_".$i."_show",
				'label'       => $name,
				'std'         => 'off',
				'type'        => 'on-off',
			  ),
			/*array(
				'id'          => $key."_".$i."_style",
				'label'       => __( 'Style', THEMO_TEXT_DOMAIN ),
				'std'         => 'horizontal',
				'type'        => 'select',
				'condition'   => $key."_".$i."_show:is(on)",
				'choices'     => array( 
					array(
						'value'       => 'horizontal',
						'label'       => __( 'Horizontal', THEMO_TEXT_DOMAIN ),
					),
					array(
						'value'       => 'vertical',
						'label'       => __( 'Vertical', THEMO_TEXT_DOMAIN ),
					)
				)
			  ),*/
			array(
				'id'          => $key."_".$i."_style",
				'label'       => __( 'Layout', THEMO_TEXT_DOMAIN ),
				'std'         => 'horizontal',
				'type'        => 'radio-image',
				
				'choices'     => array( 
					array(
					'value'       => 'horizontal',
					'label'       => __( 'Horizontal', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/service_block_layout_horizontal.png'
					),
					array(
					'value'       => 'vertical',
					'label'       => __( 'Vertical', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/service_block_layout_vertical.png'
					)
				)
			),
			  
			array(
				'id'          => $key."_".$i."_icon_style",
				'label'       => __( 'Icon Style', THEMO_TEXT_DOMAIN ),
				'std'         => 'standard',
				'type'        => 'radio-image',
				
				'operator'    => 'and',
				'condition'   => $key."_".$i."_show:is(on),". $key."_".$i."_style:is(horizontal)",
				'choices'     => array( 
					array(
					'value'       => 'standard',
					'label'       => __( 'Standard', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/icon_style_standard.png'
					),
					array(
					'value'       => 'cirlce',
					'label'       => __( 'Cicled', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/icon_style_circle.png'
					)
				)
			),
			array(
				'id'          => $key."_".$i."_layout_columns",
				'label'       => __( '1 or 2 columns', THEMO_TEXT_DOMAIN ),
				'std'         => 1,
				'type'        => 'radio-image',
				
				'operator'    => 'and',
				'condition'   => $key."_".$i."_show:is(on),". $key."_".$i."_style:is(horizontal)",
				'choices'     => array( 
					array(
					'value'       => 1,
					'label'       => '1 ' . __( 'Column', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/1_column.png'
					),
					array(
					'value'       => 2,
					'label'       => '2  ' . __( 'Column', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/2_column.png'
					),
					array(
					'value'       => 3,
					'label'       => '3  ' . __( 'Columns with image', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/3_column.png'
					)
				)
			),

			  array(
				'id'          => $key."_".$i,
				'label'       => __( 'Add Block', THEMO_TEXT_DOMAIN ),
				'type'        => 'list-item',
				'condition'   => $key."_".$i."_show:is(on)",
				'settings'    => array( 
				  array(
					'id'          => $key."_".$i."_text",
					'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
					'class' => 'themo_wp_editor',
					'rows'        => '3',
					'type'        => 'textarea-simple',
				  ),
					/* Icon Options 
					$show_glyphicons,$glyphicons_icon,$spacer,
					$show_halflings,$halflings_icon,$spacer,
					$show_social,$social_icon,$spacer,
					$show_filetype,$filetype_icon,*/
					$glyphicons_icon_set,$glyphicons_icon,
				  
					/* Link */
					$show_link,$link,$link_target,$link_text,
				)
			  ),
			array(
				'id'          => $key."_".$i."_image",
				'label'       => __( 'Image', THEMO_TEXT_DOMAIN ),
				'type'        => 'upload',
				'class'       => 'ot-upload-attachment-id-removed',
			  ),

			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Animation */
			$animation_tab,$animation,$animation_style,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
	);
	
	
	// Check for Edit Lock / hide locked meta box options of ON
	$themo_homepage_service_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_service_meta);

	ot_register_meta_box( $themo_homepage_service_meta );
	
}// END SERVICE LOOP

break;
case "service_block_split":
//-----------------------------------------------------
// SERVICE BOXES SPLIT LOOP
//-----------------------------------------------------	
	$key = 'themo_service_block_split';
	$name = 'Service Block Split';
						  	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
		
		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
			
		/* Header */
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
		
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

		/* Icons 	
		list($show_glyphicons,$glyphicons_icon,$show_halflings,$halflings_icon,$show_social,$social_icon,$show_filetype, $filetype_icon, $spacer) = return_icons($key,$i);*/
		list($glyphicons_icon_set,$glyphicons_icon) = return_icons($key,$i);
		
		/* Animation */	
		list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
		
		$themo_homepage_service_split_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START SERVICE META BOX
				
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
					  
				// END SERVICE SPLIT META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	
				
				  array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				  array(
					'id'          => $key."_".$i."_show",
					'label'       => __( 'Service Block', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  array(
					'id'          => $key."_".$i,
					'label'       => __( 'Add Blocks', THEMO_TEXT_DOMAIN ),
					'type'        => 'list-item',
					'condition'   => $key."_".$i."_show:is(on)",

					'settings'    => array( 
					  array(
						'id'          => 'themo_service_text',
						'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),						
						'type'        => 'textarea-simple',
						'rows'        => '3',
					  ),
					  	/* Icons 	
						$show_glyphicons,$glyphicons_icon,$spacer,
						$show_halflings,$halflings_icon,$spacer,
						$show_social,$social_icon,$spacer,
						$show_filetype,$filetype_icon,*/
						$glyphicons_icon_set,$glyphicons_icon,
					)
				  ),
				 array(
					'id'          => $key."_".$i.'_show_content',
					'label'       => __( 'HTML', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				array(
					'id'          => $key."_".$i.'_content',
					'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
					'class' => 'themo_wp_editor',
					'rows'        => '3',
					'type'        => 'textarea-simple',
					'condition'   => $key."_".$i.'_show_content:is(on)',
				),
				 array(
					'id'          => $key."_".$i.'_reverse',
					'label'       => __( 'Reverse Alignment', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
					/* Background */
					$background_tab,$show_background,$parallax,$background,$text_contrast,
					/* Animation */
					$animation_tab,$animation,$animation_style,
					/* Borders */
					$border_tab, $show_border, $border, $border_full_width,
					/* Padding */
					$padding_tab,$padding,$top_padding,$bottom_padding	
		);
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_homepage_service_split_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_service_split_meta);

		ot_register_meta_box( $themo_homepage_service_split_meta );
		
	}// END SERVICE SPLIT LOOP
	
break;
case "showcase":
//-----------------------------------------------------
// SHOWCASE
//-----------------------------------------------------
	$key = 'themo_showcase';
	$name = 'Showcase';
						  	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
		
		
		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
			
		/* Header */
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
		
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
		
		/* Icons 
		list($show_glyphicons,$glyphicons_icon,$show_halflings,$halflings_icon,$show_social,$social_icon,$show_filetype, $filetype_icon, $spacer) = return_icons($key,$i);*/
		list($glyphicons_icon_set,$glyphicons_icon) = return_icons($key,$i);
		
		/* Animation */	
		list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
		
		/* Get Link Options */
		list($show_link,$link,$link_target,$link_text) = return_link($key,$i);

		$themo_showcase_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	
				// START SHOWCASE META BOX

				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
					
				// END TOUR META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
				/* Header */
				$header_tab, $show_header,
				$header,
				$subtext,
				$header_float,	

				/* Showcase Blocks */
				array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
				array(
					'id'          => $key."_".$i.'_show_floating_block',
					'label'       => $name,
					'std'         => 'off',
					'type'        => 'on-off',
				),
				array(
					'id'          => $key."_".$i.'_content_heading',
					'label'       => __( 'Title', THEMO_TEXT_DOMAIN ),
					'type'        => 'text',
					'condition'   => $key."_".$i.'_show_floating_block:is(on)',
				),
				array(
					'id'          => $key."_".$i.'_content',
					'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
					'class' => 'themo_wp_editor',
					'rows'        => '3',
					'type'        => 'textarea-simple',
					'condition'   => $key."_".$i.'_show_floating_block:is(on)',
				),
				array(
					'id'          => $key."_".$i.'_image',
					'label'       => $name . __( ' Image', THEMO_TEXT_DOMAIN ),
					'type'        => 'upload',
					'class'       => 'ot-upload-attachment-id-removed',
					'condition'   => $key."_".$i.'_show_floating_block:is(on)',
				),
				array(
					'id'          => $key."_".$i.'_image_float',
					'label'       => __( 'Align Image', THEMO_TEXT_DOMAIN ),
					'std'         => 'left',
					'type'        => 'radio-image',
					'condition'   => $key."_".$i.'_show_floating_block:is(on)',
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
				  ),
				  
				  array(
					'id'          => $key."_".$i."_show",
					'label'       => $name.__( ' Bullet Items', THEMO_TEXT_DOMAIN ),
					'std'         => 'off',
					'type'        => 'on-off',
				  ),
				  array(
					'id'          => $key."_".$i,
					'label'       => $name.__( 'Bullet Items', THEMO_TEXT_DOMAIN ),
					'type'        => 'list-item',
					'condition'   => $key."_".$i."_show:is(on)",
					'settings'    => array( 
					  array(
						'id'          => $key."_".$i."_text",
						'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
						'type'        => 'textarea-simple',
						'rows'        => '3',
					  ),
					  	/* Icons 	
						$show_glyphicons,$glyphicons_icon,$spacer,
						$show_halflings,$halflings_icon,$spacer,
						$show_social,$social_icon,$spacer,
						$show_filetype,$filetype_icon,*/
						$glyphicons_icon_set,$glyphicons_icon,
						
						/* Link */
						$show_link,$link,$link_target,$link_text,
					)
				  ),
					/* Background */
					$background_tab,$show_background,$parallax,$background,$text_contrast,
					/* Animation */
					$animation_tab,$animation,$animation_style,
					/* Borders */
					$border_tab, $show_border, $border, $border_full_width,
					/* Padding */
					$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_showcase_meta = edit_lock_check($key,$i,$locked_options,$themo_showcase_meta);

		ot_register_meta_box( $themo_showcase_meta );
		
	}// END SHOWCASE LOOP
	
break;
case "slider":
//-----------------------------------------------------
// Slider
//-----------------------------------------------------	
	$key = 'themo_slider';
	$name = 'Slider';
	
	/* Get Background Options */
	$i = '';
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Button Options */
	list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);
	
	/* Get Link Options */
	list($show_link,$link,$link_target,$link_text) = return_link($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
		
	$themo_slider_meta = array(
		'id'          => $key.'_meta_box',
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
			// START SLIDER META BOX
			
			array(
				'id'          => $key."_tab_display",
				'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
				),
			array(
				'id'          => $key."_sortorder_show",
				'label'       => __( 'Display', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => $key."_anchor",
				'label'       => __( 'Anchor', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
				'condition'   => $key."_sortorder_show:is(on)",
				'class'       => 'anchor-input',
				),
			/*array(
				'id'          => $key."_".$i."_sortorder_edit_enable",
				'label'       => __( 'Edit Mode', THEMO_TEXT_DOMAIN ),
				'desc'        => __( 'Turning Edit Mode OFF, improves page load time and protects your meta box content.', THEMO_TEXT_DOMAIN ),
				'std'         => 'on',
				'class'         => 'themo_meta_box_edit_mode',
				'type'        => 'on-off'
			  ),*/

			
			// END SLIDER META BOX					
		)
	);
	
	// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
	$locked_options = array(
			array(
				'id'          => $key."_tab",
				'label'       => __( $name, THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
				),
			array(
				'id'          => $key."_flex_show",
				'label'       => 'Flexslider',
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => $key."_flex",
				'label'       => __( 'Add', THEMO_TEXT_DOMAIN ). ' Slider',
				'type'        => 'list-item',
				'condition'   => $key."_flex_show:is(on)",
				'settings'    => array( 
					array(
						'id'          => $key."_subtitle",
						'label'       => __( 'Subtitle', THEMO_TEXT_DOMAIN ),
						'type'        => 'textarea-simple',
						'rows'        => '3',
					),
					array(
						'id'          => $key.'_large_styling',
						'label'       => __( 'Large Styling', THEMO_TEXT_DOMAIN ),
						'std'         => 'off',
						'type'        => 'on-off',
					),
					/* Button */
					$show_button,$button_text,$button_link,$button_style,$button_link_target,
					
					array(
						'id'          => $key."_image",
						'label'       => __( 'Image', THEMO_TEXT_DOMAIN ),
						'type'        => 'upload',
						'class'       => 'ot-upload-attachment-id-removed',
					),
					/* Link */
					$show_link,$link,$link_target,$link_text,
					
					/* Background */
					$show_background,$background,$text_contrast,
					
					/* Padding */
					$padding,$top_padding,$bottom_padding,
					
					array(
						'id'          => $key."_form_shortcode",
						'label'       => __( 'Shortcode', THEMO_TEXT_DOMAIN ),
						'type'        => 'text',
					)
				)
			),
			/* Animation */
			$animation_tab,$animation,$animation_style,
			array(
				'id'          => $key."_tab_global_form_shortcode",
				'label'       => __( 'Shortcode', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
				),
			array(
				'id'          => $key."_global_form_show",
				'label'       => __( 'Shortcode', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => $key."_form_global_shortcode",
				'type'        => 'text',
				'condition'   => $key."_global_form_show:is(on)",
			),
			/*array(
				'id'          => $key."_tab_slider_shortcode",
				'label'       => __( 'Alternative Slider', THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
				),
			array(
				'id'          => $key."_shortcode_show",
				'label'       => __( 'Slider Shortocde', THEMO_TEXT_DOMAIN ),
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => $key."_shortcode",
				'type'        => 'text',
				'condition'   => $key."_shortcode_show:is(on)",
			),*/
	);
	
	
	// Check for Edit Lock / hide locked meta box options of ON
	$themo_slider_meta = edit_lock_check($key,$i,$locked_options,$themo_slider_meta);

	ot_register_meta_box( $themo_slider_meta );

break;
case "team":	
//-----------------------------------------------------
// TEAM
//-----------------------------------------------------	
$key = 'themo_team';
$name = 'Team';

for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP

/* Sort Order */
list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
	
/* Header */
list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);

/* Get Background Options */
list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);

/* Get Border Options */
list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);

/* Get Padding Options */
list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);

/* Animation */	
list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);

$themo_team_meta = array(
	'id'          => $key."_".$i."_meta_box",
	'title'       => $name.return_meta_box_number($i),
	'pages'       => array( 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(	
	// START TEAM META BOX
		/* Sort Order */
		$sortorder_tab,$sortorder_show,$order,$anchor,
		
		
		  // END TEAM META BOX				
		)
	);
	
	// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
	$locked_options = array(
		/* Header */
		$header_tab,$show_header,
		$header,
		$subtext,
		$header_float,

		/* Meet the Team */
		  array(
			'id'          => $key."_".$i.'_tab',
			'label'       => __( $name, THEMO_TEXT_DOMAIN ),
			'type'        => 'tab'
			),
		  array(
			'id'          => $key."_".$i."_show",
			'label'       => __( 'Team Members', THEMO_TEXT_DOMAIN ),
			'std'         => 'off',
			'type'        => 'on-off',
		  ),
		  array(
			'id'          => $key."_".$i,
			'label'       => __( 'Add Team Member', THEMO_TEXT_DOMAIN ),
			'type'        => 'list-item',
			'condition'   => $key."_".$i."_show:is(on)",
			'settings'    => array( 
			  array(
				'id'          => $key."_".$i."_job_title",
				'label'       => __( 'Job Title', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_bio",
				'label'       => __( 'Bio', THEMO_TEXT_DOMAIN ),
				'class' => 'themo_wp_editor',
				'type'        => 'textarea-simple',
				'rows'        => '4',
			  ),
			  array(
				'id'          => $key."_".$i."_photo",
				'label'       => __( 'Photo', THEMO_TEXT_DOMAIN ),
				'type'        => 'upload',
				'class'       => 'ot-upload-attachment-id-removed',
			  ),
			  array(
				'id'          => $key."_".$i."_social_1_name",
				'label'       => __( 'Social 1 - Name', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_1_icon",
				'label'       => __( 'Social 1 - Icon', THEMO_TEXT_DOMAIN ),
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">SOCIAL</a> icon below (e.g.: twitter). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_1_link",
				'label'       => __( 'Social 1 - Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_2_name",
				'label'       => __( 'Social 2 - Name', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_2_icon",
				'label'       => __( 'Social 2 - Icon', THEMO_TEXT_DOMAIN ),
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">SOCIAL</a> icon below (e.g.: twitter). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_2_link",
				'label'       => __( 'Social 2 - Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',	
			  ),
			  array(
				'id'          => $key."_".$i."_social_3_name",
				'label'       => __( 'Social 3 - Name', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_3_icon",
				'label'       => __( 'Social 3 - Icon', THEMO_TEXT_DOMAIN ),
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">SOCIAL</a> icon below (e.g.: twitter). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_3_link",
				'label'       => __( 'Social 3 - Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_4_name",
				'label'       => __( 'Social 4 - Name', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),

			  array(
				'id'          => $key."_".$i."_social_4_icon",
				'label'       => __( 'Social 4 - Icon', THEMO_TEXT_DOMAIN ),
				'desc'        => 'Use any <a href="'.$glyphicons_website.'" target="_blank">SOCIAL</a> icon below (e.g.: twitter). <a href="'.$glyphicons_website.'" target="_blank">FULL LIST HERE</a>',
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_social_4_link",
				'label'       => __( 'Social 4 - Link', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ) 
			  
			)
		  ),
			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Animation */
			$animation_tab,$animation,$animation_style,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
	);
	
	// Check for Edit Lock / hide locked meta box options of ON
	$themo_team_meta = edit_lock_check($key,$i,$locked_options,$themo_team_meta);
	
	ot_register_meta_box( $themo_team_meta );
} // END TEAM LOOP

break;
case "testimonials":
//-----------------------------------------------------
// TESTIMONIALS 
//-----------------------------------------------------
	$key = 'themo_testimonials';
	$name = 'Testimonials';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);

		$themo_homepage_testimonials_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
		// START Testimonials META BOX
			/* Sort Order */
			$sortorder_tab,$sortorder_show,$order,$anchor,
			
			
			// END Testimonials META BOX				
			)
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
			/* Header */
			$header_tab,$show_header,
			$header,
			$subtext,
			$header_float,	
		
			/* Testimonials */
			array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
			array(
				'id'          => $key."_".$i."_show",
				'label'       => $name,
				'std'         => 'off',
				'type'        => 'on-off',
			),
			array(
				'id'          => $key."_".$i,
				'label'       => __( 'Add a Testimonial', THEMO_TEXT_DOMAIN ),
				'type'        => 'list-item',
				'condition'   => $key."_".$i."_show:is(on)",
				'settings'    => array( 
					array(
						'id'          => $key."_".$i."_position",
						'label'       => __( 'Job Title', THEMO_TEXT_DOMAIN ),
						'type'        => 'text',	
					),
					array(
						'id'          => $key."_".$i."_quote",
						'label'       => __( 'Quote', THEMO_TEXT_DOMAIN ),
						'type'        => 'textarea-simple',
						'rows'        => '3',
					),
					array(
						'id'          => $key."_".$i."_photo",
						'label'       => __( 'Photo', THEMO_TEXT_DOMAIN ),
						'type'        => 'upload',
						'class'       => 'ot-upload-attachment-id-removed',
					)
				)
			),
			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Animation */
			$animation_tab,$animation,$animation_style,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_homepage_testimonials_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_testimonials_meta);
		
		ot_register_meta_box( $themo_homepage_testimonials_meta );
	} // END TESTIMONIAL LOOP
	
break;
case "thumbnail_slider":

//-----------------------------------------------------
// Thumbnail Slider
//-----------------------------------------------------
	$key = 'themo_thumbnail_slider';
	$name = 'Thumbnail Slider';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP
	
	/* Sort Order */
	list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
	/* Header */
	list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);
	
	/* Get Background Options */
	list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
	
	/* Get Border Options */
	list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
	
	/* Get Padding Options */
	list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
	
	/* Animation */	
	list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
	
	/* Get Link Options */
	list($show_link,$link,$link_target,$link_text) = return_link($key,$i);

	$themo_homepage_thumbslide_meta = array(
		'id'          => $key."_".$i."_meta_box",
		'title'       => $name.return_meta_box_number($i),
		'pages'       => array( 'page' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(	
		// START THUMB SLIDER META BOX
		/* Sort Order */
		$sortorder_tab,$sortorder_show,$order,$anchor,
     
	  // END THUMB SLIDER META BOX	
	)
	);
	
	// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
	$locked_options = array(
		/* Header */
		$header_tab,$show_header,
		$header,
		$subtext,
		$header_float,
		
			/* Thumbs */
		  array(
				'id'          => $key."_".$i.'_tab',
				'label'       => __( $name, THEMO_TEXT_DOMAIN ),
				'type'        => 'tab'
			),
		  array(
			'id'          => $key."_".$i.'_show',
			'label'       => $name.' Items',
			'std'         => 'off',
			'type'        => 'on-off',
		  ),
		  
		  array(
				'id'          => $key."_".$i.'_image_orientation',
				'label'       => __( 'Image Orientation', THEMO_TEXT_DOMAIN ),
				'std'         => 'landscape',
				'type'        => 'radio-image',
				'condition'   => $key."_".$i.'_show:is(on)',
				'choices'     => array( 
					array(
					'value'       => 'landscape',
					'label'       => __( 'Landscape', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/image_orientation_landscape.png'
					),
					array(
					'value'       => 'portrait',
					'label'       => __( 'Portrait', THEMO_TEXT_DOMAIN ),
					'src'         => 'OT_THEME_URL/assets/images/image_orientation_potrait.png'
					)
				)
			),
		
		 array(
			'id'          => $key."_".$i.'_lightbox',
			'label'       => 'Enable Lightbox',
			'std'         => 'off',
			'type'        => 'on-off',
			'condition'   => $key."_".$i.'_show:is(on)',
		  ),
		  
		  array(
			'id'          => $key."_".$i,
			'label'       => __( 'Add', THEMO_TEXT_DOMAIN ).' '.$name,
			'type'        => 'list-item',
			'condition'   => $key."_".$i.'_show:is(on)',
			'settings'    => array( 
			  array(
				'id'          => $key."_".$i."_small_text",
				'label'       => __( 'Small Text', THEMO_TEXT_DOMAIN ),
				'type'        => 'text',
			  ),
			  array(
				'id'          => $key."_".$i."_image",
				'label'       => __( 'Image', THEMO_TEXT_DOMAIN ),
				'type'        => 'upload',
				'class'       => 'ot-upload-attachment-id-removed',
			  ),
				/* Link */
				$show_link,$link,$link_target,$link_text,
			  
			)
		  ),
			/* Background */
			$background_tab,$show_background,$parallax,$background,$text_contrast,
			/* Animation */
			$animation_tab,$animation,$animation_style,
			/* Borders */
			$border_tab, $show_border, $border, $border_full_width,
			/* Padding */
			$padding_tab,$padding,$top_padding,$bottom_padding
	);
	
	
	// Check for Edit Lock / hide locked meta box options of ON
	$themo_homepage_thumbslide_meta = edit_lock_check($key,$i,$locked_options,$themo_homepage_thumbslide_meta);

	ot_register_meta_box( $themo_homepage_thumbslide_meta );

} // END Thumbnail Slider

break;
case "tour":
//-----------------------------------------------------
// Tour
//-----------------------------------------------------		
	$key = 'themo_tour';
	$name = 'Tour';
	
	for ($i = 1;$i <= $meta_box_multiply;$i++) { // LOOP

		/* Sort Order */
		list($sortorder_tab,$sortorder_show,$order,$anchor) = return_sort_order($key,$i);
		
		/* Header 
		list($header_tab,$show_header,$header,$subtext,$header_float) = return_meta_header($key,$i);*/
			
		/* Get Background Options */
		list($background_tab,$show_background,$parallax,$background,$text_contrast) = return_background_options($key,$i);
		
		/* Get Border Options */
		list($border_tab, $show_border, $border, $border_full_width) = return_border_options($key,$i);
		
		/* Get Padding Options */
		list($padding_tab,$padding,$top_padding,$bottom_padding) = return_padding_options($key,$i);
		
		/* Animation */	
		list($animation_tab,$animation,$animation_style) = return_animation_options($key,$i);
		
		/* Get Button Options */
		list($show_button,$button_text,$button_link,$button_style,$button_link_target) = return_button_options($key,$i);

		$themo_float_meta = array(
			'id'          => $key."_".$i."_meta_box",
			'title'       => $name.return_meta_box_number($i),
			'pages'       => array( 'page' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(	

			// START FLOATING META BOX
				/* Sort Order */
				$sortorder_tab,$sortorder_show,$order,$anchor,
				
			) // END FLOATING META BOX				
		);
		
		// Meta Box Options. We separate meta box options into a unique array so we can include if edit lock is not on.
		$locked_options = array(
				/* Header 
				$header_tab,
				$show_header,
				$header,
				$subtext,
				$header_float,	*/
			  
			   /* Content with Floating Image */
			  array(
					'id'          => $key."_".$i.'_tab',
					'label'       => __( $name, THEMO_TEXT_DOMAIN ),
					'type'        => 'tab'
				),
			  array(
				'id'          => $key."_".$i."_show",
				'label'       => $name,
				'std'         => 'off',
				'type'        => 'on-off',
			  ),
			  array(
				'id'          => $key."_".$i,
				'label'       => __( 'Add Content', THEMO_TEXT_DOMAIN ),
				'type'        => 'list-item',
				'condition'   => $key."_".$i."_show:is(on)",
				'settings'    => array(
						  array(
							'id'          => $key."_".$i."_text",
							'label'       => __( 'Text', THEMO_TEXT_DOMAIN ),
							'class' => 'themo_wp_editor',
							'type'        => 'textarea-simple',
							'rows'        => '4',
						  ),
							/* Button */
							$show_button,$button_text,$button_link,$button_style,$button_link_target,	
							array(
								'id'          => $key."_".$i.'_large_styling',
								'label'       => __( 'Large Styling', THEMO_TEXT_DOMAIN ),
								'std'         => 'off',
								'type'        => 'on-off',
							),
						  array(
							'id'          => $key."_".$i."_photo",
							'label'       => __( 'Photo', THEMO_TEXT_DOMAIN ),
							'type'        => 'upload',
							'class'       => 'ot-upload-attachment-id-removed',
						  ),
						  array(
							'id'          => $key."_".$i."_photo_align",
							'label'       => __( 'Align Photo', THEMO_TEXT_DOMAIN ),
							'std'         => 'right',
							'type'        => 'radio-image',
							'choices'     => array( 
							  array(
								'value'       => 'left',
								'label'       => __( 'Left', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/align_left.png'
							  ),
							  array(
								'value'       => 'centered',
								'label'       => __( 'Center', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/align_center.png'
							  ),
							  array(
								'value'       => 'right',
								'label'       => __( 'Right', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/align_right.png'
							  )
							)
						  ),
						  array(
							'id'          => $key."_".$i."_photo_sticky",
							'label'       => __( 'Pin Photo', THEMO_TEXT_DOMAIN ),
							'std'         => 'none',
							'type'        => 'radio-image',
							'choices'     => array( 
							  array(
								'value'       => 'top',
								'label'       => __( 'Pin to Top', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/photo_sticky_top.png'
							  ),
							  array(
								'value'       => 'none',
								'label'       => __( 'No Pin', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/align_right.png'
							  ),
							  array(
								'value'       => 'bottom',
								'label'       => __( 'Pin to Bottom', THEMO_TEXT_DOMAIN ),
								'src'         => 'OT_THEME_URL/assets/images/photo_sticky_bottom.png'
							  )
							)
						  ),
						/* Background */
						$show_background,$parallax,$background,$text_contrast,
						/* Animation */
						$animation,$animation_style,
						/* Borders */
						$show_border, $border, $border_full_width,
						/* Padding */
						$padding,$top_padding,$bottom_padding
					)
				) // END LIST ITEM.
		);
		
		
		// Check for Edit Lock / hide locked meta box options of ON
		$themo_float_meta = edit_lock_check($key,$i,$locked_options,$themo_float_meta);

		ot_register_meta_box( $themo_float_meta );
	} // END FLOAT LOOP

break;

	}
	//-----------------------------------------------------
	// END SWITCH
	//-----------------------------------------------------	
}
?>