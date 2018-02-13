<?php
/*
Template Name: Blog - Masonry
*/

$use_bittersweet_pagination = false;
if(is_front_page()) {
    $use_bittersweet_pagination=true;
}

?>
<?php global $post;  ?>
<?php include( locate_template( 'templates/page-layout.php' ) ); ?>
<div class="inner-container">
	<?php include( locate_template( 'templates/meta-slider-flex.php' ) ); ?>
	<?php include( locate_template( 'templates/page-header.php' ) ); // Page Header Template ?>
    
    <?php 
	//-----------------------------------------------------
	// OPEN | OUTER Container + Row
	//-----------------------------------------------------
	echo $outer_container_open . $outer_row_open; // Outer Tag Open ?>
    
    <?php 
	//-----------------------------------------------------
	// OPEN | Wrapper Class - Support for sidebar
	//-----------------------------------------------------
    echo $main_class_open;  ?>
    
    <?php
	//-----------------------------------------------------
	// OPEN | Section + INNER Container
	//----------------------------------------------------- ?>
    
    <?php
	// Set Image Size
	$image_size = 'themo_blog_masonry';
	
	$masonry_template_key = '-masonry';
	$masonry_section_class = 'masonry-blog';
	$masonry_row_class = 'mas-blog';
	if($has_sidebar){
		$masonry_div_class = 'mas-blog-post col-md-6';
	}else{
		$masonry_div_class = 'mas-blog-post col-lg-4 col-md-4 col-sm-6';
	}
	
	$automatic_post_excerpts = 'on';
	if ( function_exists( 'ot_get_option' ) ) {
		$automatic_post_excerpts = ot_get_option( 'themo_automatic_post_excerpts', 'on' );
	}
	
	?>

    <section id="<?php echo $key.'_content'; ?>" class="<?php echo $masonry_section_class; ?>">
	<?php echo $inner_container_open;?>

	<?php
    //-----------------------------------------------------
    // LOOP
    //----------------------------------------------------- ?>
    
    <?php

    if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
    elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
    else { $paged = 1; }

    // Metabox options to filter by category.
    $themo_blog_cat_array = get_post_meta($post->ID, 'themo_category_checkbox', true );

    $themo_cat_arg = false;
    if(isset($themo_blog_cat_array) && is_array($themo_blog_cat_array)){
        $themo_blog_categories = implode(',', $themo_blog_cat_array);
        $themo_cat_arg = "cat=".$themo_blog_categories."&";
    }

    query_posts($themo_cat_arg.'post_type=post&post_status=publish&paged='. $paged); ?>
    
    <div class="<?php echo $masonry_row_class; ?> row">
		<?php if (!have_posts()) : ?>
            <div class="alert">
            <?php _e('Sorry, no results were found.', THEMO_TEXT_DOMAIN); ?>
            </div>
            <?php get_search_form(); ?>
        <?php endif; ?>
            
		<?php while (have_posts()) : the_post(); ?>
		<?php
        $format = get_post_format();
        if ( false === $format ) {
        $format = 'standard';
        }
        ?>
            <div <?php post_class($masonry_div_class); ?> >
				<?php get_template_part('templates/content', $format); ?>
			</div><!-- /.col-md --> 
        <?php endwhile; ?>	
    </div><!-- /.row -->
    
    <div class="row">
		<?php if ($wp_query->max_num_pages > 1) : ?>
            <nav class="post-nav">
                <ul class="pager">
                    <?php if($use_bittersweet_pagination){
                        bittersweet_pagination();
                    }else{ ?>
                        <li class="previous"><?php next_posts_link(__('&larr; Older posts', THEMO_TEXT_DOMAIN)); ?></li>
                        <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', THEMO_TEXT_DOMAIN)); ?></li>
                    <?php } ?>
                </ul>
            </nav>
        <?php endif; ?>
	</div>
    
    <?php wp_reset_postdata(); ?>
    
	<?php
	//-----------------------------------------------------
	// CLOSE | Section + INNER Container
	//----------------------------------------------------- ?>
	<?php echo $inner_container_close;?>    
	</section>

	<?php 
    //-----------------------------------------------------
	// CLOSE | Main Class
	//-----------------------------------------------------
    echo $main_class_close; ?>
    
    <?php
    //-----------------------------------------------------
	// INCLUDE | Sidebar
	//-----------------------------------------------------
    include themo_sidebar_path(); ?>
    
    <?php
	//-----------------------------------------------------
	// CLOSE | OUTER Container + Row
	//----------------------------------------------------- 
    echo $outer_container_close . $outer_row_close; // Outer Tag Close ?>
</div><!-- /.inner-container -->