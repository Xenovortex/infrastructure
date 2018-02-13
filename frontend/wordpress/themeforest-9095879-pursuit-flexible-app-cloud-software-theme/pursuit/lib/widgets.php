<?php
//======================================================================
// Register sidebars and widgets
//======================================================================

//-----------------------------------------------------
// roots_widgets_init
//-----------------------------------------------------
function roots_widgets_init() {
	// Sidebars
	register_sidebar(array(
		'name'          => __('Primary', THEMO_TEXT_DOMAIN),
		'id'            => 'sidebar-primary',
		'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	//$i = $themo_footer_columns;
	/* Themovation Theme Options */
	if ( function_exists( 'ot_get_option' ) ) {	
		/* Footer  Columns */
		
		$themo_footer_show = ot_get_option( 'themo_footer_widget_switch', 'off' );
		
		if($themo_footer_show == 'on'){
			$themo_footer_columns = ot_get_option( 'themo_footer_columns', 2 );
	
			for ($i = 1; $i <= $themo_footer_columns; $i++) {
				register_sidebar(array(
					'name'          => __("Footer Column $i", THEMO_TEXT_DOMAIN),
					'id'            => "sidebar-footer-$i",
					'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
					'after_widget'  => '</div></section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				));
			}
		}
	}

  // Widgets
  register_widget('WP_Widget_Themo_Social_Icons');
}
add_action('widgets_init', 'roots_widgets_init');



//-----------------------------------------------------
// Social Media Icon Widget
//-----------------------------------------------------
class WP_Widget_Themo_Social_Icons extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_themo_social_icons', 'description' => __( "Social Icons", THEMO_TEXT_DOMAIN) );
		parent::__construct('themo-social-icons', __('Social Icons', THEMO_TEXT_DOMAIN), $widget_ops);
		$this->alt_option_name = 'widget_themo_social_icons';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_themo_social_icons', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base); ?>
        
		<?php echo $before_widget; ?>
        <?php // GET SOCIAL ICONS ?>
		<section class="widget widget-social">
    		<div class="widget-inner">
        		<?php if ( $title ) {?>
                <h3 class="widget-title"><?php echo $title; ?></h3>
                <?php } ?>
        			<div class="soc-widget">
        			<?php echo themo_return_social_icons(); ?>
           			</div>
    			</div>
		</section>
		<?php echo $after_widget; ?>
        
		<?php
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_themo_social_icons', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_themo_social_icons']) )
			delete_option('widget_themo_social_icons');
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_themo_social_icons', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEMO_TEXT_DOMAIN); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
	}
}
