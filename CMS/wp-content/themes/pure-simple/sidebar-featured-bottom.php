<?php
/**
 * Featured Bottom sidebar group 
 * @package Pure_and_Simple
 * @since 1.0.0
 */


if (   ! is_active_sidebar( 'featuredbottom1'  )
	&& ! is_active_sidebar( 'featuredbottom2' )
	&& ! is_active_sidebar( 'featuredbottom3'  )
	&& ! is_active_sidebar( 'featuredbottom4'  )		
		
	)

		return;
	// If we get this far, we have widgets. Let do this.
?>

<div id="featured-bottom-group" style="background-color: <?php echo get_theme_mod( 'content_bg', '#ffffff' ); ?>;">
    <aside class="widget-area" role="complementary">
        <div class="container">
            <div class="row">
                
    			<?php if ( is_active_sidebar( 'featuredbottom1' ) ) : ?>
                    <div id="featuredbottom1" <?php puresimple_featuredbottomgroup(); ?> role="complementary">
                        <?php dynamic_sidebar( 'featuredbottom1' ); ?>
                    </div><!-- #top1 -->
           		<?php endif; ?>   

    			<?php if ( is_active_sidebar( 'featuredbottom2' ) ) : ?>                            
                    <div id="featuredbottom2" <?php puresimple_featuredbottomgroup(); ?> role="complementary">
                        <?php dynamic_sidebar( 'featuredbottom2' ); ?>
                    </div><!-- #top2 -->          
           		<?php endif; ?>
                 
     			<?php if ( is_active_sidebar( 'featuredbottom3' ) ) : ?>               
                    <div id="featuredbottom3" <?php puresimple_featuredbottomgroup(); ?> role="complementary">
                        <?php dynamic_sidebar( 'featuredbottom3' ); ?>
                    </div><!-- #top3 -->
           		<?php endif; ?>
                
    			<?php if ( is_active_sidebar( 'featuredbottom4' ) ) : ?>             
                    <div id="featuredbottom4" <?php puresimple_featuredbottomgroup(); ?> role="complementary">
                        <?php dynamic_sidebar( 'featuredbottom4' ); ?>
                    </div><!-- #top4 -->
            	<?php endif; ?>
                               
             </div>
        </div>
   </aside>	
</div>
