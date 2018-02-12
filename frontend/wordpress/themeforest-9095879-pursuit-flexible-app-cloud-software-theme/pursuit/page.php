<?php global $post;  ?>
<?php include( locate_template( 'templates/page-layout.php' ) ); ?>

<div class="inner-container">
	<?php include( locate_template( 'templates/meta-slider-flex.php' ) ); ?>
    <?php include( locate_template( 'templates/meta-slider_master.php' ) ); ?>
	<?php include( locate_template( 'templates/page-header.php' ) ); // Page Header Template ?>
    
	<?php echo $outer_container_open . $outer_row_open; // Outer Tag Open ?>
	
    <?php
	//$old_meta = array('themo_service_split_1_sortorder_show');
	//themo_remove_old_meta($old_meta, $post->ID);
	?>
    <?php 
    /* OPEN MAIN CLASS */
    echo $main_class_open; // support for sidebar ?>
    
    <?php
    /* META BOX CONTENT */
    $custom_field_keys = get_post_custom($post->ID); // GET META DATA
  	//print_r($custom_field_keys);
	$meta_key_array = themo_sort_meta_array($custom_field_keys); // Filter an Sort ASC
    //echo "<BR><BR>"; print_r($meta_key_array);
	$page_template = basename( get_page_template() ); // Get Template Name
    
	
    foreach ( $meta_key_array as $key => $value ) { // Loop through custom array
     	//echo $key;
		themo_print_template_part($key,$page_template,$inner_container_open,$inner_container_close,$page_layout); // Custom Function that Prints template parts
    } ?>
    
    <?php // check if sidebar and remove container, else leave it. ?>
    <!-- Comment form for pages -->
	<?php echo $inner_container_open; ?>
        <div class="row">
			<div class="col-md-12">
	        <?php comments_template('/templates/comments.php'); ?>
            </div>
        </div>
    <?php echo $inner_container_close; ?>
    <!-- End Comment form for pages -->
    
    <?php 
    /* CLOSE MAIN CLASS */
    echo $main_class_close; ?>
    
    <?php
    /* SIDEBAR */
    include themo_sidebar_path(); ?>              
    
    <?php 
    echo $outer_container_close . $outer_row_close; // Outer Tag Close ?>
</div><!-- /.inner-container -->