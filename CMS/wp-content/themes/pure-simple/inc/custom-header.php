<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 * @package Pure_and_Simple
 * @since 1.0.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses puresimple_header_style()
 * @uses puresimple_admin_header_style()
 * @uses puresimple_admin_header_image()
 */


	$args = array(
		'width'         => 2560,
		'flex-width'    => true,
		'height'        => 260,
		'flex-height'    => true,
		'uploads'       => true,
		'header-text'  	=> false
		
	);
	add_theme_support( 'custom-header', $args );
