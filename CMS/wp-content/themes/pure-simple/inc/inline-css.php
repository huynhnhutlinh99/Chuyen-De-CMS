<?php
/**
 * Custom template tags for this theme.
 *
 * Adds customizable styles to your <head>
 * @package Pure_and_Simple
 * @since 1.0.0
 */
function puresimple_theme_customize_css() {
?>
<style type="text/css">
html {font-size: <?php echo get_theme_mod( 'base_bodytext', '100' ); ?>%;}

a, a:visited {color:<?php echo get_theme_mod( 'content_links', '#c69f63' ); ?>;}
a:focus, a:hover {color:<?php echo get_theme_mod( 'content_linkshover', '#767676' ); ?>;}
.more-link a {background-color: <?php echo get_theme_mod( 'read_more', '#789993' ); ?>;	color: <?php echo get_theme_mod( 'read_moretext', '#ffffff' ); ?>;}
.more-link a:hover {background-color: <?php echo get_theme_mod( 'read_morehover', '#a48a61' ); ?>; color: <?php echo get_theme_mod( 'read_morehover_text', '#ffffff' ); ?>;}
#footer-menu a {color: <?php echo get_theme_mod( 'footer_links', '#b2b2b2' ); ?>;}
#footer-menu a:hover {color: <?php echo get_theme_mod( 'footer_linkshover', '#767676' ); ?>;}
#bottom-wrapper a,#bottom-wrapper .tagcloud a {color: <?php echo get_theme_mod( 'bottom_links', '#ffffff' ); ?>;}
#bottom-wrapper a:hover {color: <?php echo get_theme_mod( 'bottom_linkshover', '#cadad7' ); ?>;}
#bottom-wrapper .tagcloud a {border-color: <?php echo get_theme_mod( 'bottom_linkshover', '#cadad7' ); ?>;}
#socialbar .socialicon {background-color: <?php echo get_theme_mod( 'social_bg', '#42474d' ); ?>;}
#socialbar a {color: <?php echo get_theme_mod( 'social_colour', '#767676' ); ?>;}
#socialbar a:hover {color: <?php echo get_theme_mod( 'social_hover', '#9c9c9c' ); ?>;}

.entry-title {font-size: <?php echo get_theme_mod( 'entry_title', '1.625rem' ); ?>;}
.widget-title {font-size: <?php echo get_theme_mod( 'widget_title', '1.313rem' ); ?>;}
#content {font-size: <?php echo get_theme_mod( 'paragraph', '0.813rem' ); ?>;}
#bottom-wrapper {font-size: <?php echo get_theme_mod( 'bottom_textsize', '0.75rem' ); ?>;}
.site-tagline:before {background-color: <?php echo get_theme_mod( 'tagline_colour', '#b9b9b9' ); ?>;}
#cta {background-color:<?php echo get_theme_mod( 'cta_bg', '#ffffff' ); ?>;}

h1 {font-size: <?php echo get_theme_mod( 'h1_size', '1.75rem' ); ?>;}
h2 {font-size: <?php echo get_theme_mod( 'h2_size', '1.625rem' ); ?>;}
h3 {font-size: <?php echo get_theme_mod( 'h3_size', '1.438rem' ); ?>;}
h4 {font-size: <?php echo get_theme_mod( 'h4_size', '1.125rem' ); ?>;}
h5 {font-size: <?php echo get_theme_mod( 'h5_size', '1rem' ); ?>;}
h6 {font-size: <?php echo get_theme_mod( 'h6_size', '0.875rem' ); ?>;}
#cta-heading {color:<?php echo get_theme_mod( 'cta_heading', '#4c4c4c' ); ?>;}
.entry-title, .entry-title a {color:<?php echo get_theme_mod( 'post_title', '#4c4c4c' ); ?>;}
 .entry-title a:hover {color:<?php echo get_theme_mod( 'post_title_on_hover', '#a48a61' ); ?>;}
.widgetx_titles {color:<?php echo get_theme_mod( 'widget_titles', '#4c4c4c' ); ?>;}
#bottom-wrapper .widget-title {color:<?php echo get_theme_mod( 'bottom_hd', '#cadad7' ); ?>;}
#footer-heading {color:<?php echo get_theme_mod( 'footertext', '#767676' ); ?>;}
#bottom-wrapper {background-color:<?php echo get_theme_mod( 'bottomwidgets_bg', '#566965' ); ?>;}

	
@media screen and (min-width: 783px) {
.site-navigation ul {font-size: <?php echo get_theme_mod( 'menu_size', '1rem' ); ?>;}
.primary-navigation li li > a {font-size: <?php echo get_theme_mod( 'submenu_size', '0.813rem' ); ?>;}

.primary-navigation li li > a {color:<?php echo get_theme_mod( 'submenu_link', '#b6b6b6' ); ?>; border-color:<?php echo get_theme_mod( 'submenu_borders', '#363535' ); ?>;}
	
.primary-navigation li a,
.site-navigation a:hover,
.site-navigation .current-menu-item > a,
.site-navigation .current-menu-item > a,
.site-navigation .current-menu-ancestor > a {color:<?php echo get_theme_mod( 'menu_link', '#ffffff' ); ?>;}

.primary-navigation ul ul,
.primary-navigation li a:hover,
.primary-navigation li li:hover > a,
.primary-navigation li li.focus > a,
.primary-navigation ul ul a:hover,
.primary-navigation ul ul li.focus > a {background-color:<?php echo get_theme_mod( 'menu_hoverbg', '#080d07' ); ?>;}

.site-navigation .current-menu-item > a,
.site-navigation .current-menu-ancestor > a {background-color: <?php echo get_theme_mod( 'menu_activebg', '#080d07' ); ?>;}	
.home.current-menu-item a {background: none;}
}
</style>
<?php
}
add_action( 'wp_head', 'puresimple_theme_customize_css');

