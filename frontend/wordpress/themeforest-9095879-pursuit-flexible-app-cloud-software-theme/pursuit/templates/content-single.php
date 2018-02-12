<?php while (have_posts()) : the_post(); ?>
<article <?php post_class(); ?>>
    <header>
		<?php if ( has_post_thumbnail() ) { ?>                        
        <div class="blog-post-image">
            <a title="<?php printf(__('Permanent Link to %s', THEMO_TEXT_DOMAIN), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(''); ?>
            </a>
        </div>    
        <?php } ?>    
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
	    <?php the_content(); ?>
    </div>
    <footer>
	    <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', THEMO_TEXT_DOMAIN), 'after' => '</p></nav>')); ?>
    </footer>
</article>
<?php comments_template('/templates/comments.php'); ?>
<?php endwhile; ?>
