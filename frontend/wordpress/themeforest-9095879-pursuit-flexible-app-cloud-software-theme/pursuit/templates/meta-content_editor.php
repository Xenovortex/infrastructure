<?php
/*****************************
	Content Editor
*****************************/
?>
<?php 
$show = "on"; // Default to ON
$show = get_post_meta($post->ID, $key.'_sortorder_show', true); 
?>
<?php if(isset($show) && $show != 'off' && !empty( $post->post_content) ) { ?>
<section class="content-editor">
<?php echo $inner_container_open;?>
	<div class="row">
        <div class="col-xs-12">
       		<?php
			while (have_posts()) : the_post(); 
			the_content();
			endwhile;
        	?>
        </div>
	</div><!-- /.row -->
<?php echo $inner_container_close;?>
</section>
<?php } // end if