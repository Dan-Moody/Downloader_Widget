<?php

/*

Plugin Name: Downloader Widget

Plugin URI: https://github.com/Dan-Moody/Downloader_Widget.git

Description: Lets you add download links to the widget space

Version: 1.0

Author: Daniel Moody

Author URI: https://github.com/Dan-Moody

License: GPL2

*/

// Register and load the widget
function downloader_load_widget() {
    register_widget( 'downloader_widget' );
}
add_action( 'widgets_init', 'downloader_load_widget' );

// Creating the widget 
class downloader_widget extends WP_Widget {
  
    function __construct() {
        // Add Widget scripts
        add_action('admin_enqueue_scripts', array($this, 'scripts'));
        
        parent::__construct(
        // Base ID of your widget
        'downloader_widget', 
        
        // Widget name will appear in UI
        __('Downloader Widget', 'downloader_widget_domain'), 
        
        // Widget description
        array( 'description' => __( 'For downloading files in widget space', 'downloader_widget_domain' ), ) 
        );
    }
      
    // Creating widget front-end
      
    public function widget( $args, $instance ) {
        // Our variables from the widget settings
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Default title', 'text_domain' ) : $instance['title'] );
        $file = ! empty( $instance['file'] ) ? $instance['file'] : '';
        
        ob_start();
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        
        <?php if($file): ?>
            <img src="<?php echo esc_url($file); ?>" alt="">
        <?php endif; ?>
        
        <?php
        echo $args['after_widget'];
        ob_end_flush();
    }
              
    // Widget Backend 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        $file = ! empty( $instance['file'] ) ? $instance['file'] : '';
        ?>
        <p>
           <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
           <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
           <label for="<?php echo $this->get_field_id( 'file' ); ?>"><?php _e( 'file:' ); ?></label>
           <input class="widefat" id="<?php echo $this->get_field_id( 'file' ); ?>" name="<?php echo $this->get_field_name( 'file' ); ?>" type="text" value="<?php echo esc_url( $file ); ?>" />
           <button class="upload_image_button button button-primary">Select or Upload File</button>
        </p>
        <?php
     }
          
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['file'] = ( ! empty( $new_instance['file'] ) ) ? $new_instance['file'] : '';
      
        return $instance;
    }
     
    public function scripts() {
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();
        wp_enqueue_script('our_admin', '/wp-content/plugins/downloader_widget/our_admin.js', array('jquery'));
    }
    // Class wpb_widget ends here 
} 
     
     
    