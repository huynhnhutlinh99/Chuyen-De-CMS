<?php
/**
 * puresimple functions and definitions
 * @package Pure_and_Simple
 * @since 1.0.0
 */


/**
 * Set the content width based on the theme's design and stylesheet.
 */
	if ( ! isset( $content_width ) ) {
		$content_width = 1140; /* pixels */
	}
	
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */	
if ( ! function_exists( 'puresimple_setup' ) ) :

function puresimple_setup() {



	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Pure & Simple, use a find and replace
	 * to change 'pure-simple' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pure-simple', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This feature enables post-thumbnail support for a theme.
	 * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	/**
	 * This feature enables woocommerce support for a theme.
	 * @see http://www.woothemes.com/2013/02/last-call-for-testing-woocommerce-2-0-coming-march-4th/
	 */
	add_theme_support( 'woocommerce' );
		
	/**
	 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
	 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
	 */
	add_editor_style();
	add_theme_support( 'title-tag' );
	
	/**
	 * Add support for shortcodes in text widget
	 * @see http://codex.wordpress.org/Function_Reference/do_shortcode
	 */	
	add_filter('widget_text', 'do_shortcode');	
	
	
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'pure-simple' ),
		'footer' => __( 'Footer Menu', 'pure-simple' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'puresimple_custom_background_args', array(
		'default-color' => '3d4147',
		'default-image' => get_template_directory_uri() . '/images/page-bg.jpg',
	) ) );


	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

 	// Load default block styles.
	add_theme_support( 'wp-block-styles' );


}
endif; // puresimple_setup
add_action( 'after_setup_theme', 'puresimple_setup' );



/**
 * Enqueue scripts and styles.
 */
function puresimple_scripts() {
	
	wp_enqueue_style( 'puresimple-responsive', get_template_directory_uri() . '/css/responsive.min.css', array( ), '3.1.1' );
	wp_enqueue_style( 'puresimple-fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.2.0' );
    wp_enqueue_style( 'puresimple-opensans', get_template_directory_uri() . '/css/font-opensans.css', array(), '1.0.2' );
	wp_enqueue_style( 'puresimple-style', get_stylesheet_uri() );

	wp_enqueue_script( 'puresimple-global', get_template_directory_uri() . '/js/global.min.js', array( 'jquery' ), '20141001', true );
	wp_enqueue_script( 'puresimple-extras', get_template_directory_uri() . '/js/puresimple-extras.js', array( 'jquery' ), '20150918', true );
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'puresimple_scripts' );

/**
 * Enqueue admin scripts and styles.
 */
function puresimple_admin_scripts() {

	wp_enqueue_media();  
	//enqueue media uploader js
	wp_enqueue_script( 'puresimple-media-uploader', get_template_directory_uri() . '/js/media-uploader.js', array(), '20151215', true );
}
add_action( 'admin_enqueue_scripts', 'puresimple_admin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Get inline CSS.
 * If you need to edit this file, open the unminified version of the inline-css.php file.
 */
require get_template_directory() . '/inc/inline-css.min.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Jetpack compatibility file.
 */
 require get_template_directory() . '/inc/content-widgets.php';

/**
 * Load class for upsells links
 */

require get_template_directory(). '/puresimple-upsells/puresimple-pro-btn/class-customize.php';

/*@package pure simple
*@since  version 2.0.0
*@description add move to top featured
*/
if ( ! function_exists( 'puresimple_lr_move_to_top_fnc' ) ) :
function puresimple_lr_move_to_top_fnc() {
  $move_to_top_check = get_theme_mod('movetotop');
    if ($move_to_top_check == 1) { ?>
      <div class="puresimple_move_to_top"> 
        <i class="fa fa-arrow-up"></i>
      </div>  
    <?php }
}
add_action('lr_move_to_top', 'puresimple_lr_move_to_top_fnc');
endif;


/**
 * @author StyledThemes 
 * @show widget field
 * @version 3.0.0
 * @return widget fields, with adding image capability
*/
function puresimple_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {

	extract( $widget_field );
	switch( $puresimple_widgets_field_type ) {

	    // Standard text field
	    case 'upload' :

	        $output = '';
	        $id = $instance->get_field_id($puresimple_widgets_name);
	        $class = '';
	        $int = '';
	        $value = $athm_field_value;
	        $name = $instance->get_field_name($puresimple_widgets_name);


	        if ($value) {
	            $class = ' has-file';
	        }
	        $output .= '<div class="sub-option widget-upload">';
	        $output .= '<label for="' . $instance->get_field_id($puresimple_widgets_name) . '">' . $puresimple_widgets_title . '</label><br/>';
	        $output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __('No file chosen', 'pure-simple' ) . '" />' . "\n";
	        if (function_exists('wp_enqueue_media')) {
	                $output .= '<input id="upload-' . $id . '" class="upload-button button" type="button" value="' . __('Upload', 'pure-simple') . '" />' . "\n";
	        } else {
	            $output .= '<p><i>' . __('Upgrade your version of WordPress for full media support.', 'pure-simple') . '</i></p>';
	        }

	        $output .= '<div class="screenshot team-thumb" id="' . $id . '-image">' . "\n";

	        if ($value != '') {
	            $remove = '<a class="remove-image remove-screenshot">Remove</a>';
	            $attachment_id = attachment_url_to_postid($value);

	            $image_array = wp_get_attachment_image_src($attachment_id,'full',true);
	            $image = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value);
	            if ($image) {
	                $output .= '<img src="' . $image_array[0] . '" alt="" width="100%" />' . $remove;
	            } else {
	                $parts = explode("/", $value);
	                for ($i = 0; $i < sizeof($parts); ++$i) {
	                    $title = $parts[$i];
	                }

	                // No output preview if it's not an image.
	                $output .= '';

	                // Standard generic output if it's not an image.
	                $title = __('View File', 'pure-simple');
	                $output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">' . $title . '</a></span></div>';
	            }
	        }
	        $output .= '</div></div>' . "\n";
	        echo $output;
	        break; 
	}
}

// display custom admin notice
function puresimple_custom_admin_notice() {
	$mor_th_info = wp_get_theme(); 
	$currentversion = str_replace('.','',(esc_html( $mor_th_info->get('Version') )));
	$isitdismissed = 'puresimple_notice_dismissed'.$currentversion;
	if ( !get_user_meta( get_current_user_id() , $isitdismissed ) ) { ?>
	<div class="notice notice-success is-dismissible puresimple_notice" data-dismissible="disable-done-notice-forever">
		<div>
			<p>	
			<?php _e('Thank you for using the free version of ','pure-simple'); ?>
			<?php echo esc_html( $mor_th_info->get('Name') );?> - 
			<?php echo esc_html( $mor_th_info->get('Version') );
			 ?>
			<?php _e('theme. Want more features? Check out the', 'pure-simple'); ?>
			<a href="<?php echo esc_url( 'https://www.styledthemes.com/themes/pure-simple-pro/?utm_source=FreeThemes&utm_medium=UpdateMsg&utm_campaign=PureSimple');?>" target="_blank" aria-label="Dismiss the welcome panel">
				<strong><?php _e('PRO version','pure-simple');?></strong>
			</a>
			<?php _e('for more options and professional support!', 'pure-simple'); ?>
			<a href="?puresimple-notice-dismissed<?php echo $currentversion;?>">Dismiss this message</a>
			</p>
		</div>
		
	</div>
	
<?php
	}
 }
add_action('admin_notices', 'puresimple_custom_admin_notice');

function puresimple_notice_dismissed() {
	$mor_th_info = wp_get_theme(); 
	$currentversion = str_replace('.','',(esc_html( $mor_th_info->get('Version') )));
	$dismissurl = 'puresimple_notice_dismissed'.$currentversion;
	$isitdismissed = 'puresimple_notice_dismissed'.$currentversion;
    $user_id = get_current_user_id();
    if ( isset( $_GET[$dismissurl] ) )
        add_user_meta( $user_id, $isitdismissed, 'true', true );
}
add_action( 'admin_init', 'puresimple_notice_dismissed' );
