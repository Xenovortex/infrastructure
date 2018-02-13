<?php
/*****************************
	Shortcode Slider
*****************************/
$themo_slider_shortcode = get_post_meta($post->ID, 'themo_slider_shortcode', true );
?>
<?php if($themo_slider_shortcode > ""){ ?>
	<?php echo $inner_container_open;?>
		<div class="row">
			<?php echo do_shortcode($themo_slider_shortcode);?>
		</div><!--/row-->
<?php echo $inner_container_close;?>
<?php } ?>
