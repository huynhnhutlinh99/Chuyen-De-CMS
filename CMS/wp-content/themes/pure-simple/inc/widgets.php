<?php 

/**
 * Theme Widget positions
 * @package Pure_and_Simple
 * @since 1.0.0 
 */

 
/**
 * Registers our main widget area and the front page widget areas.
 */
 
function puresimple_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Blog Right Sidebar', 'pure-simple' ),
		'id' => 'blogright',
		'description' => __( 'This is the right sidebar column that appears on the blog but not the pages.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Blog Left Sidebar', 'pure-simple' ),
		'id' => 'blogleft',
		'description' => __( 'This is the left sidebar column that appears on the blog but not the pages.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Page Right Sidebar', 'pure-simple' ),
		'id' => 'pageright',
		'description' => __( 'This is the right sidebar column that appears on pages, but not part of the blog', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Page Left Sidebar', 'pure-simple' ),
		'id' => 'pageleft',
		'description' => __( 'This is the left sidebar column that appears on pages, but not part of the blog', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Banner', 'pure-simple' ),
		'id' => 'banner',
		'description' => __( 'This is a full width showcase banner for images or media sliders that can display on your pages.', 'pure-simple' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	) );		

	register_sidebar( array(
		'name' => __( 'Featured Top 1', 'pure-simple' ),
		'id' => 'featuredtop1',
		'description' => __( 'This is the first featured top widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Top 2', 'pure-simple' ),
		'id' => 'featuredtop2',
		'description' => __( 'This is the second featured top widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Top 3', 'pure-simple' ),
		'id' => 'featuredtop3',
		'description' => __( 'This is the third featured top widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Top 4', 'pure-simple' ),
		'id' => 'featuredtop4',
		'description' => __( 'This is the fourth featured top widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
				
	register_sidebar( array(
		'name' => __( 'Featured Bottom 1', 'pure-simple' ),
		'id' => 'featuredbottom1',
		'description' => __( 'This is the first featured bottom widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Bottom 2', 'pure-simple' ),
		'id' => 'featuredbottom2',
		'description' => __( 'This is the second featured bottom widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Bottom 3', 'pure-simple' ),
		'id' => 'featuredbottom3',
		'description' => __( 'This is the third featured bottom widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Featured Bottom 4', 'pure-simple' ),
		'id' => 'featuredbottom4',
		'description' => __( 'This is the fourth featured bottom widget position located just below the main content.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	register_sidebar( array(
		'name' => __( 'Bottom 1', 'pure-simple' ),
		'id' => 'bottom1',
		'description' => __( 'This is the first bottom widget position located in a coloured background area just above the footer.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Bottom 2', 'pure-simple' ),
		'id' => 'bottom2',
		'description' => __( 'This is the second bottom widget position located in a coloured background area just above the footer.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Bottom 3', 'pure-simple' ),
		'id' => 'bottom3',
		'description' => __( 'This is the third bottom widget position located in a coloured background area just above the footer.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => __( 'Bottom 4', 'pure-simple' ),
		'id' => 'bottom4',
		'description' => __( 'This is the fourth bottom widget position located in a coloured background area just above the footer.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Call to Action', 'pure-simple' ),
		'id' => 'cta',
		'description' => __( 'This is a call to action which is normally used to make a message stand out just above the main content.', 'pure-simple' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1 id="cta-heading">',
		'after_title' => '</h1>',
	) );		
	register_sidebar( array(
		'name' => __( 'Footer', 'pure-simple' ),
		'id' => 'footer',
		'description' => __( 'This is a footer widget position at the very bottom of the page and outside the content container.', 'pure-simple' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 id="footer-heading">',
		'after_title' => '</h4>',
	) );	

}
add_action( 'widgets_init', 'puresimple_widgets_init' );

/**
 * Count the number of widgets to enable resizable widgets
 */

// lets setup the featured top group 
function puresimple_featuredtopgroup() {
	$count = 0;
	if ( is_active_sidebar( 'featuredtop1' ) )
		$count++;
	if ( is_active_sidebar( 'featuredtop2' ) )
		$count++;
	if ( is_active_sidebar( 'featuredtop3' ) )
		$count++;		
	if ( is_active_sidebar( 'featuredtop4' ) )
		$count++;
	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'col-md-12';
			break;
		case '2':
			$class = 'col-md-6';
			break;
		case '3':
			$class = 'col-md-4';
			break;
		case '4':
			$class = 'col-md-3';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}

// lets setup the featured bottom group 
function puresimple_featuredbottomgroup() {
	$count = 0;
	if ( is_active_sidebar( 'featuredbottom1' ) )
		$count++;
	if ( is_active_sidebar( 'featuredbottom2' ) )
		$count++;
	if ( is_active_sidebar( 'featuredbottom3' ) )
		$count++;		
	if ( is_active_sidebar( 'featuredbottom4' ) )
		$count++;
	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'col-md-12';
			break;
		case '2':
			$class = 'col-md-6';
			break;
		case '3':
			$class = 'col-md-4';
			break;
		case '4':
			$class = 'col-md-3';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}

// lets setup the bottom group 
function puresimple_bottomgroup() {
	$count = 0;
	if ( is_active_sidebar( 'bottom1' ) )
		$count++;
	if ( is_active_sidebar( 'bottom2' ) )
		$count++;
	if ( is_active_sidebar( 'bottom3' ) )
		$count++;		
	if ( is_active_sidebar( 'bottom4' ) )
		$count++;
	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'col-md-12';
			break;
		case '2':
			$class = 'col-md-6';
			break;
		case '3':
			$class = 'col-md-4';
			break;
		case '4':
			$class = 'col-md-3';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}