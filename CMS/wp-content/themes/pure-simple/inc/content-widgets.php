<?php
/**
 * This file is  is used to create custom content widgets which allows us to use fontawesome icon or direclty image from media gallery
 * @package puresimple
 * @since versioni 1.0
 */
class puresimple_custom_content extends WP_Widget {

	/**
	 * Specifies the widget name, description, class name and instatiates it
	 */
	public function __construct() {
		/**
		 * Specifies the widget name, description, class name and instatiates it
		 */
		parent::__construct( 
			'puresimple_custom_content',
			__( 'Puresimple: Featured Content', 'pure-simple' ),
			array(
				'classname'   => 'puresimple_custom_content',
				'description' => __( 'This is custom widgets that shows recent post which includes featured image of particulat post', 'pure-simple' )
			) 
		);
	}

	private function widget_fields() {

	    $fields = array(

	        'image_title' => array(

	            'puresimple_widgets_name' => 'image_title',

	            'puresimple_widgets_title' => __('Title', 'pure-simple'),

	            'puresimple_widgets_field_type' => 'text',
	        ),
	        
	        'preview_image' => array(

	            'puresimple_widgets_name' => 'preview_image',

	            'puresimple_widgets_title' => __('Upload Image', 'pure-simple'),

	            'puresimple_widgets_field_type' => 'upload',
	        ),
	     );  
    return $fields;            
   
    }       

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {

		extract($args);
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		
		$font_icons = isset( $instance['font_icons'] ) ? $instance['font_icons'] : '';
		$checked_media_uploader = isset( $instance['checked_media_uploader'] ) ? (bool) $instance['checked_media_uploader'] : false;
		$preview_image = isset( $instance['preview_image'] ) ? $instance['preview_image'] : '';
		$text_content = isset( $instance['text_content'] ) ? $instance['text_content'] : '';
		echo $args['before_widget'];
			echo '<div style="text-align:center;">';
				
			
				if( $checked_media_uploader )  { 

					if ( $preview_image != '' ) {
		                $img_arr = explode('wp-content',$preview_image);
		                $image = content_url().$img_arr[1];
		            } else {
		                $image = '';    
	          	   }

	          	   	$img_id = attachment_url_to_postid($image);

		            $img = wp_get_attachment_image_src($img_id,'thumbnail');

		            $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
		            if( ! empty($img_id)){
		                $image_link = $img[0];
		            } else {
		                $image_link = $img[0];
		            }   
		            echo '<div class="icon">
		            	<img src="'.$image_link.'" alt="'.$alt.'" title="'.$alt.' class="attachment-full size-full" />
		            </div>';

				} else {
					echo '<span class="icon-circle">';
						echo '<i class="fa '.$font_icons.'" aria-hidden="true"></i>';
					echo '</span>';
				}

				if( ! empty( $title )) { echo '<h3>'.$title.'</h3>'; }
				if( ! empty( $text_content )) { echo '<p >'.$text_content.'</p>'; }

			echo '</div>';	
		
		echo $args['after_widget']; 
		
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['font_icons'] = isset( $new_instance['font_icons'] ) ? $new_instance['font_icons'] : '';
		$instance['checked_media_uploader'] = isset( $new_instance['checked_media_uploader'] ) ? (bool) $new_instance['checked_media_uploader'] : false;
		$instance['preview_image'] = isset( $new_instance['preview_image'] ) ? $new_instance['preview_image'] : '';
		$instance['text_content'] = isset( $new_instance['text_content'] ) ? $new_instance['text_content'] : '';
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {

		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$font_icons    = isset( $instance['font_icons'] ) ? esc_attr( $instance['font_icons'] ) : '';
		$checked_media_uploader = isset( $instance['checked_media_uploader'] ) ? (bool) $instance['checked_media_uploader'] : false;
		//$image_upload_preview = isset($instance['image_upload_preview']) ? $instance['image_upload_preview'] : '';
		$image_upload = isset($instance['image_upload']) ? $instance['image_upload'] : '';
		$text_content = isset( $instance['text_content'] ) ? esc_attr( $instance['text_content'] ) : '';
		$readmore_link    = isset( $instance['readmore_link'] ) ? esc_attr( $instance['readmore_link'] ) : '';
		
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pure-simple' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'font_icons' ); ?>"><?php _e( 'Font Awesome Icons: Place Icons Class <a href="http://fontawesome.io/">Visit Here For More Icons</a>', 'pure-simple' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'font_icons' ); ?>" name="<?php echo $this->get_field_name( 'font_icons' ); ?>" type="text" value="<?php echo $font_icons; ?>" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $checked_media_uploader ); ?> id="<?php echo $this->get_field_id( 'checked_media_uploader' ); ?>" name="<?php echo $this->get_field_name( 'checked_media_uploader' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'checked_media_uploader' ); ?>"><?php _e( 'Checked this Checkbox to Display Media Image?', 'pure-simple' ); ?></label></p>

		<?php
		 $widget_fields = $this->widget_fields();
            // Loop through fields

            foreach( $widget_fields as $widget_field ) {

                // Make array elements available as variables 

                extract( $widget_field );

                $puresimple_widgets_field_value = isset( $instance[$puresimple_widgets_name] ) ? esc_attr( $instance[$puresimple_widgets_name] ) : '';

                puresimple_widgets_show_widget_field( $this, $widget_field, $puresimple_widgets_field_value );

            } ?>  

            <p><label for="<?php echo $this->get_field_id( 'text_content' ); ?>"><?php _e( 'Content:', 'pure-simple' ); ?></label>
			<textarea class="widefat" rows="5" cols="10" id="<?php echo $this->get_field_id('text_content'); ?>" name="<?php echo $this->get_field_name('text_content'); ?>"><?php echo $text_content; ?></textarea></p>

        <?php }
}

/**
*@DESCRIPTION This function register the widgets
* @package puresimple
* @return add featured image on recent post
*/
function puresimple_register_widgets() {
	//register puresimple recents post
	register_widget( 'puresimple_custom_content' );

}
add_action( 'widgets_init', 'puresimple_register_widgets' );



