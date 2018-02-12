<?php
  if (post_password_required()) {
    return;
  }

 if (have_comments()) : ?>
  <section id="comments">
    <h3 class="comments-title"><?php printf(_n('One Comment', '%1$s Comments', get_comments_number(), THEMO_TEXT_DOMAIN), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

    <ol class="media-list">
      <?php wp_list_comments(array('walker' => new Roots_Walker_Comment)); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    <nav>
      <ul class="pager">
        <?php if (get_previous_comments_link()) : ?>
          <li class="previous"><?php previous_comments_link(__('&larr; Older comments', THEMO_TEXT_DOMAIN)); ?></li>
        <?php endif; ?>
        <?php if (get_next_comments_link()) : ?>
          <li class="next"><?php next_comments_link(__('Newer comments &rarr;', THEMO_TEXT_DOMAIN)); ?></li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="comments-closed">
      <?php _e('Comments are closed.', THEMO_TEXT_DOMAIN); ?>
    </div>
    <?php endif; ?>
  </section><!-- /#comments -->
<?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
  <section id="comments">
      <div class="comments-closed">
	      <?php _e('Comments are closed.', THEMO_TEXT_DOMAIN); ?>
      </div>
  </section><!-- /#comments -->
<?php endif; ?>

<?php
if (comments_open()) :
    $required_text = __( 'Required fields are marked *',THEMO_TEXT_DOMAIN );
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$args = array(
		'id_form'           => 'commentform',
		'id_submit'         => 'submit',
		'title_reply'       => __( 'Leave a Reply',THEMO_TEXT_DOMAIN ),
		'title_reply_to'    => __( 'Leave a Reply to %s',THEMO_TEXT_DOMAIN ),
		'cancel_reply_link' => __( 'Cancel Reply',THEMO_TEXT_DOMAIN ),
		'label_submit'      => __( 'Submit Comment',THEMO_TEXT_DOMAIN ),

	
		'comment_field' =>  '<div class="form-group"><label for="comment">' . _x( 'Comment' ,THEMO_TEXT_DOMAIN ) .
		'</label><textarea name="comment" id="comment" class="form-control" rows="8" aria-required="true">' .
		'</textarea></div>',
	
			'must_log_in' => '<p class="comment-info">' .
			sprintf(
			  __( 'You must be <a href="%s">logged in</a> to post a comment.',THEMO_TEXT_DOMAIN ),
			  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			) . '</p>',
	
			'logged_in_as' => '<p class="comment-info">' .
			sprintf(
			__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>',THEMO_TEXT_DOMAIN ),
			  admin_url( 'profile.php' ),
			  $user_identity,
			  wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			) . '</p>',
	
			'comment_notes_before' => '<p class="comment-info">' .
			__( 'Your email address will not be published. ',THEMO_TEXT_DOMAIN ) . ( $req ? $required_text : '' ) .
			'</p>',
	
			'comment_notes_after' => '<p class="form-allowed-tags">' .
			sprintf(
			  __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s',THEMO_TEXT_DOMAIN ),
			  ' <code>' . allowed_tags() . '</code>'
			) . '</p>',
	
			'fields' => apply_filters( 'comment_form_default_fields', array(
	
				'author' =>
				  '<div class="form-group">' .
				  '<label for="author">' . __( 'Name', THEMO_TEXT_DOMAIN ) . ( $req ? ' *' : '' ) . '</label> ' .
				  '<input type="text" class="form-control" name="author"  id="author" value="' . esc_attr( $commenter['comment_author'] ) .
				  '" size="22"' . $aria_req . ' /></div>',
		
				'email' =>
				   '<div class="form-group">' .
				  '<label for="email">' . __( 'Email', THEMO_TEXT_DOMAIN ) . ( $req ? ' *' : '' ) . '</label> ' .
				  '<input type="text" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				  '" size="22"' . $aria_req . ' /></div>',
		
				'url' =>
				  '<div class="form-group">'.
				  '<label for="url">' . __( 'Website', THEMO_TEXT_DOMAIN ) . '</label>' .
				  '<input type="text"  class="form-control" name="url" id="url"  value="' . esc_attr( $commenter['comment_author_url'] ) .
				  '" size="22" /></div>',
				)
			),
);
?>


    
<?php comment_form($args); ?>
  
<?php endif; ?>
