<?php
/**
 * The header for this theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">   
    <?php wp_head(); ?>
</head>
    
<body <?php body_class(); ?>>
<!-- add move to top feture -->
<?php do_action( 'lr_move_to_top', 'pure-simple'); ?>

<?php $pagewidth = get_theme_mod( 'page_width', 'boxwide' ); ?>
<div id="page" class="<?php echo $pagewidth; ?> hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pure-simple' ); ?></a>

    <?php get_template_part( 'partials/logo-group' ); ?>	
    
<div class="navigation clearfix" style="background-color: <?php echo get_theme_mod( 'menu_bg', '#789993' ); ?>;">
  	<div class="container">
      	<div class="row">
          <div class="col-md-12">
             <div id="navbar" class="navbar">
				<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<div class="toggle-container visible-xs visible-sm hidden-md hidden-lg" style="background-color: <?php echo get_theme_mod( 'menu_bg', '#789993' ); ?>;">
                <button class="menu-toggle"><?php _e( 'Menu', 'pure-simple' ); ?></button></div>
               
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'pure-simple' ); ?></a>
             	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu' ) ); ?>
         
			</nav>
			</div>
            
			</div>
		</div>      
	</div>
</div><!-- .navigation -->
    
<?php get_sidebar( 'banner' ); ?>

<?php 
	$breadcrumbstyle = get_theme_mod( 'breadcrumb_bg', '#e6e6e6' );
	$breadcrumbcolour = get_theme_mod( 'breadcrumb_text', '#9e9e9e' );
	if(! is_front_page() && !is_attachment() ) : 
		if(function_exists('bcn_display')) {
			echo '<div id="breadcrumb-wrapper" style="background-color:' . $breadcrumbstyle . '; color: ' . $breadcrumbcolour . ';" role="nav"><div class="container"><div class="row"><div class="col-md-12"><i class="fa fa-home"></i> ';
				bcn_display();
			echo '</div></div></div></div>';
		}
	 endif; 
?>

<?php get_sidebar( 'cta' ); ?>

    <?php get_sidebar( 'featured-top' ); ?>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" style="background-color: <?php echo get_theme_mod( 'content_bg', '#ffffff' ); ?>; color:<?php echo get_theme_mod( 'contenttext', '#767676' ); ?>;" role="main">