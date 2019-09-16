<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 * @package Pure_and_Simple
 * @since 1.0.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function puresimple_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'puresimple_jetpack_setup' );


add_action('init', 'puresimple_jetpack_portfolio_add_excerpt', 100);
function puresimple_jetpack_portfolio_add_excerpt()
{
	add_post_type_support('jetpack-portfolio', 'excerpt');
}