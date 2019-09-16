<?php
/**
 * Sidebar for the banner area and the Header Caption option 
 * @package Pure_and_Simple
 * @since 1.0.0 
 */
 
$hide_defaults = get_theme_mod('hide_default_content','0');
if ( ! is_active_sidebar( 'banner' ) && (!$hide_defaults) && (is_front_page()) ): ?>
	<aside class="widget-area" role="complementary"><div id="page-banner" role="banner">
			<img src="<?php  echo esc_url( get_template_directory_uri() ); ?>/images/banner.jpg" alt="" />
		</div></aside>
	<?php 
elseif(is_active_sidebar( 'banner' ) ):
		
		echo '<aside class="widget-area" role="complementary"><div id="page-banner" role="banner">'; 
	dynamic_sidebar( 'banner' );
	echo '</div></aside>';
else:
	return;
endif;
?>

