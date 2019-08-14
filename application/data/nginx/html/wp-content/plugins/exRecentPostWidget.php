<?php

/**
Plugin Name: ex Recent Post with Thumbnail Widget
Plugin URI: http://dev.ontheroad.jp/
Description: 最近の投稿にサムネイルを追加する
Author: （ひ）
Version: 0.1
Author URI: http://dev.ontheroad.jp/
*/

class WP_widget_ex_recent_posts extends WP_Widget {
//class WP_Widget_ex_Recent_Posts extends WP_widget_recent_posts {


	function __construct() {
		$widget_ops = array('classname' => 'widget_ex_recent_entries', 'description' => __( "The most recent posts with Thumbnail !!") );
		parent::__construct('ex_recent-posts', __('ex_Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_ex_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_ex_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_ex_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_ex_widget_cache') );
	}

	function widget($args, $instance) {

	if( !is_home() ) {
		$cache = wp_cache_get('widget_ex_recent_posts', 'widget');

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

		$title = apply_filters('widget_title', empty($instance['ex_title']) ? __('ex_Recent Posts') : $instance['ex_title'], $instance, $this->id_base);
		if ( empty( $instance['ex_number'] ) || ! $ex_number = absint( $instance['ex_number'] ) )
 			$ex_number = 10;

		$r = new WP_Query(array('posts_per_page' => $ex_number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>

		<li>
			<div class="thumbnail">
        		<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php get_thumbnail($post->ID, array(80,80), 'alt="' . $post->post_title . '"'); ?></a>
      		</div>

			<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
				<?php if ( get_the_title() ) the_title(); else the_ID(); ?>
			</a><br>
			<div style="margin:5px 0;"><?php the_time('Y年m月d日') ?></div>

			<div class="clear"></div>

		</li>

		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_ex_recent_posts', $cache, 'widget');

	} // end if( !is_home() )
	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['ex_title'] = strip_tags($new_instance['ex_title']);
		$instance['ex_number'] = (int) $new_instance['ex_number'];
		$this->flush_ex_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_ex_recent_entries']) )
			delete_option('widget_ex_recent_entries');

		return $instance;
	}

	function flush_ex_widget_cache() {
		wp_cache_delete('widget_ex_recent_posts', 'widget');
	}

	function form( $instance ) {
		$ex_title = isset($instance['ex_title']) ? esc_attr($instance['ex_title']) : '';
		$ex_number = isset($instance['ex_number']) ? absint($instance['ex_number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('ex_title'); ?>"><?php _e('ex_title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('ex_title'); ?>" name="<?php echo $this->get_field_name('ex_title'); ?>" type="text" value="<?php echo $ex_title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('ex_number'); ?>"><?php _e('ex_number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('ex_number'); ?>" name="<?php echo $this->get_field_name('ex_number'); ?>" type="text" value="<?php echo $ex_number; ?>" size="3" /></p>
<?php
	}
}

function WP_widget_ex_recent_postsInit() {
	register_widget('WP_widget_ex_recent_posts');
}
add_action('widgets_init', 'WP_widget_ex_recent_postsInit');

?>