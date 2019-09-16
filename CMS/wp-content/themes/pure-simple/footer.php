<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 * You can change the copyright from the theme option settings
 *
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>


    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar( 'featured-bottom' ); ?>

<div id="bottom-wrapper" style="color:<?php echo get_theme_mod( 'bottomtext', '#cadad7' ); ?>;">
    <?php get_sidebar( 'bottom' ); ?>
</div>

    <footer id="site-footer" style="background-color:<?php echo get_theme_mod( 'footer_bg', '#000000' ); ?>; color:<?php echo get_theme_mod( 'footertext', '#767676' ); ?>;" role="contentinfo">
    
        <?php get_sidebar( 'footer' ); ?>        
        
        <div id="social-wrapper">
            <?php get_template_part( 'partials/social-bar' ); ?>
        </div>
        

        
        <nav id="footer-nav" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'fallback_cb' => false, 'depth' => 1,'container' => false, 'menu_id' => 'footer-menu' ) ); ?>
        </nav>
            <?php esc_attr_e('Copyright &copy;', 'pure-simple'); 
            $date_pas = date('Y'); ?> 
            <?php printf(__('%s', 'pure-simple'), $date_pas); ?> <?php echo get_theme_mod( 'copyright', 'Your Name' ); ?>.&nbsp;<?php esc_attr_e('All rights reserved.', 'pure-simple'); ?>
            
    </footer>
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
