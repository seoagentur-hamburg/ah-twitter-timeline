<?php
/*
Plugin Name: AH Twitter Timeline Widget
Plugin URI:  https://wordpress.org/plugins/evolution-twitter-timeline/
Description: Creates a new and simple to use widget that outputs the new awesome Twitter Embedded Timeline from your Twitter account. Looks nice in Sidebar and Footer.
Version:     1.0.5
Author:      Andreas Hecht
Author URI:  https://andreas-hecht.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: evolution_twitter
Domain Path: /languages
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


class Evolution_Twitter_Timeline_Widget extends WP_Widget {

/**
 * Register widget with WordPress.
 */
    public function __construct() {
		parent::__construct(
	 		'evolution_twitter_timeline', // Base ID
			'AH Twitter Timeline Widget', // Name
			array( 'description' => __( 'Mit diesem Widget erstellst Du eine coole Twitter-Timeline von Deinem Twitter-Account.', 'evolution_twitter' ), ) // Args
		);

		// Registers Script with WordPress ( to wp_footer(); )
		wp_register_script( 'widgets', '//platform.twitter.com/widgets.js','','', true );

		// Adding the javascript only if widget in use
			if ( is_active_widget( false, false, $this->id_base, true ) ) {

			wp_enqueue_script('widgets');

			}
	}	

    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    public function widget($args, $instance) {  	
    	
    	//global $app_id;
        extract( $args );
        
		$title 		                    = apply_filters('widget_title', $instance['title']);
		$width		                 = $instance['width'];
		$height		                 = $instance['height'];
		$twitter_name	      = $instance['twitter_name'];
		$link_color	               = $instance['link_color'];
		$theme_color	       = $instance['theme_color'];
		
		echo $before_widget;
        if ( $title )
       echo $before_title . $title . $after_title;

 		echo '<a class="twitter-timeline" href="https://twitter.com/'.$twitter_name.'" data-width="'.$width.'" data-height="'.$height.'" data-theme="'.$theme_color.'" data-link-color="'.$link_color.'" >Tweets von @"'.$twitter_name.'"</a>' ;
      
 		echo $after_widget;

} 


    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] 		             = strip_tags( $new_instance['title'] );
		$instance['width'] 		          = strip_tags( $new_instance['width'] );
		$instance['height'] 		      = strip_tags($new_instance['height'] );
		$instance['twitter_name']  = strip_tags($new_instance['twitter_name'] );
		$instance['link_color']		    = strip_tags($new_instance['link_color'] );
		$instance['theme_color']	= strip_tags($new_instance['theme_color'] );

		return $instance;

	}


    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    public function form($instance) {

    	/**
    	 * Set Default Value for widget form
    	 */   	
    	$default_value	=	array("title"=> "Follow me on Twitter", "width" => "340", "height" => "400", "twitter_name" => "AndreasHecht_HH",  "link_color" => "#f96e5b", "theme_color" => "light" );
    	$instance		=	wp_parse_args((array)$instance,$default_value);
        
    		$title		              = esc_attr($instance['title']);
        	$width		           = esc_attr($instance['width']);
        	$height		           = esc_attr($instance['height']);
        	$twitter_name	= esc_attr($instance['twitter_name']);
        	$link_color	         = esc_attr($instance['link_color']);
        	$theme_color	 = esc_attr($instance['theme_color']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:', 'evolution_twitter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		
        <p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Wähle die Breite der Timeline:', 'evolution_twitter' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
		
		 <p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'wähle die Höhe der Timeline:', 'evolution_twitter' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id('twitter_name'); ?>"><?php _e('Dein Twitter Name:', 'evolution_twitter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_name'); ?>" name="<?php echo $this->get_field_name('twitter_name'); ?>" type="text" value="<?php echo $twitter_name; ?>" />
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('link_color'); ?>"><?php _e('Linkfarbe:', 'evolution_twitter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link_color'); ?>" name="<?php echo $this->get_field_name('link_color'); ?>" type="text" value="<?php echo $link_color; ?>" />
        </p> 
        
        <p>
			<label for="<?php echo $this->get_field_id('theme_color'); ?>"><?php _e('Wähle eine Themefarbe (Hell oder Dunkel):', 'evolution_twitter'); ?></label>
			<select name="<?php echo $this->get_field_name('theme_color'); ?>" id="<?php echo $this->get_field_id('theme_color'); ?>" class="widefat">
				<option value="light"<?php selected( $instance['theme_color'], 'light' ); ?>><?php _e('Hell'); ?></option>
				<option value="dark"<?php selected( $instance['theme_color'], 'dark' ); ?>><?php _e('Dunkel'); ?></option>
			</select>
        </p> 
		
       <?php
    }

}


/**
 * Loads the Textdomain for the english translation
 */
function evolution_twitter_timeline_load_plugin_textdomain() {
    load_plugin_textdomain( 'evolution_twitter', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'evolution_twitter_timeline_load_plugin_textdomain' );



/**
 * Registers our Widget.
 */
add_action( 'widgets_init', function(){
	register_widget( 'Evolution_Twitter_Timeline_Widget' );
});