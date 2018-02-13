<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="input-group">
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field form-control" placeholder="<?php _e('Search', THEMO_TEXT_DOMAIN); ?> <?php bloginfo('name'); ?>">
    <label class="hide"><?php _e('Search for:', THEMO_TEXT_DOMAIN); ?></label>
    <span class="input-group-btn">
      <button type="submit" class="search-submit btn btn-default"><?php _e('Search', THEMO_TEXT_DOMAIN); ?></button>
    </span>
  </div>
</form>