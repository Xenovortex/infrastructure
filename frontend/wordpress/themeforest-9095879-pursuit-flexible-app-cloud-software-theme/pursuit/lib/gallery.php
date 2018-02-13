<?php
/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from Bootstrap
 * The number of columns must be a factor of 12.
 *
 * @link http://getbootstrap.com/components/#thumbnails
 */
function roots_gallery($attr) {
  $post = get_post();

  static $instance = 0;
  $instance++;

  if (!empty($attr['ids'])) {
    if (empty($attr['orderby'])) {
      $attr['orderby'] = 'post__in';
    }
    $attr['include'] = $attr['ids'];
  }

  $output = apply_filters('post_gallery', '', $attr);

  if ($output != '') {
    return $output;
  }

  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby']) {
      unset($attr['orderby']);
    }
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'itemtag'    => '',
    'icontag'    => '',
    'captiontag' => '',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => '',
    'link'       => ''
  ), $attr));
  
	

  $id = intval($id);
  $columns = (12 % $columns == 0) ? $columns: 4;

  $grid = sprintf('col-sm-%1$s col-lg-%1$s', 12/$columns);

  if ($order === 'RAND') {
    $orderby = 'none';
  }

  if (!empty($include)) {
    $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

    $attachments = array();
    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif (!empty($exclude)) {
    $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
  } else {
    $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
  }

	if (empty($attachments)) {
		return '';
	}

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}
		return $output;
	}

	$unique = (get_query_var('page')) ? $instance . '-p' . get_query_var('page'): $instance;
	$output = '<div class="gallery gallery-' . $id . '-' . $unique . '">';

	$size = return_gallery_thumb_size($columns);
	
	$i = 0;
	foreach ($attachments as $id => $attachment) {
	
	$img_attr = array(
		'class'	=> "thumbnail img-thumbnail test",
	);
	
	switch($link) {
		case 'file':
			$image = wp_get_attachment_link($id, $size, false, false);
			break;
		case 'none':
			$image = wp_get_attachment_image($id, $size, false, $img_attr);
			break;
		default:
			$image = wp_get_attachment_link($id, $size, true, false);
			break;
	}
    $output .= ($i % $columns == 0) ? '<div class="row gallery-row">': '';
    $output .= '<div class="' . $grid .'">' . $image;
    
	$gallery_text_div_open = "";
	$gallery_text_div_close = "";
	
	if(trim($attachment->post_title) || trim($attachment->post_excerpt)){
		$gallery_text_div_open = '<div class="gallery-text">';
		$gallery_text_div_close = "</div>";
	}
	
    $output .= $gallery_text_div_open;
	
	if (trim($attachment->post_title)) {
      $output .= '<div class="image-title">' . wptexturize($attachment->post_title) . '</div>';
    }
	
	if (trim($attachment->post_excerpt)) {
      $output .= '<div class="caption">' . wptexturize($attachment->post_excerpt) . '</div>';
    }
	
    $output .= $gallery_text_div_close;
	
    $output .= '</div>';
    $i++;
    $output .= ($i % $columns == 0) ? '</div>' : '';
  }
  
  $output .= ($i % $columns != 0 ) ? '</div>' : '';
  $output .= '</div>';

  return $output;
}
if (current_theme_supports('bootstrap-gallery')) {
  remove_shortcode('gallery');
  add_shortcode('gallery', 'roots_gallery');
  add_filter('use_default_gallery_style', '__return_null');
}

function return_gallery_thumb_size($columns){
	switch($columns) {
		case 1:
			$gallery_thumb_size = 'themo_full_width';
			break;
		case 2:
			$gallery_thumb_size = 'themo_featured';
			break;
		case 3:
			$gallery_thumb_size = 'themo_blog_masonry';
			break;			
		default:
			$gallery_thumb_size = 'themo_blog_masonry';
			break;
		}
	return $gallery_thumb_size;
}


/**
 * Add class="thumbnail img-thumbnail" to attachment items
 */
function roots_attachment_link_class($html) {
	
	$postid = get_the_ID();
	$html = str_replace('<a', '<a class="thumbnail img-thumbnail"', $html);

	$doc = new DOMDocument();
	$doc->preserveWhiteSpace = FALSE;
	$doc->loadHTML($html);
	
	$tags = $doc->getElementsByTagName('img');
	
	foreach ($tags as $tag) {
		   $title = $tag->getAttribute('alt');
	}
	
	$content = preg_replace("/<a/","<a data-toggle=\"lightbox\" data-gallery=\"multiimages\" data-title=\"$title\" data-footer=\"BOO\"",$html,1);
	return $html;
	

}
//add_filter('wp_get_attachment_link', 'roots_attachment_link_class', 10, 1);
