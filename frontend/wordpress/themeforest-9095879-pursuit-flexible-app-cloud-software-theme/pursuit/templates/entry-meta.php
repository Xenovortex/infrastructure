<?php 
$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
$write_comments = "";

if ( comments_open() ) {
	if ( $num_comments == 0 ) {
		$comments = __('No Comments', THEMO_TEXT_DOMAIN);
	} elseif ( $num_comments > 1 ) {
		$comments = $num_comments . __(' Comments', THEMO_TEXT_DOMAIN);
	} else {
		$comments = __('1 Comment', THEMO_TEXT_DOMAIN);
	}
	$write_comments = '| <a href="' . get_comments_link() .'">'. $comments.'</a>';
} 
?>
<div class="post-meta"><span class="show-author"><?php echo __('Posted by', THEMO_TEXT_DOMAIN); ?> <?php echo the_author_posts_link(); ?></span> <span class="show-date"><span class="pre-date"><?php echo __('on', THEMO_TEXT_DOMAIN); ?></span> <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time></span> <span class="is-sticky">| <?php echo __('Featured', THEMO_TEXT_DOMAIN); ?></span> <span class="show-comments"><?php echo $write_comments; ?></span></div>
