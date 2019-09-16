<?php
/**
 * Bottom sidebar group. 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
$hide_defaults = get_theme_mod('hide_default_content','0');

if (   ! is_active_sidebar( 'bottom1'  )
	&& ! is_active_sidebar( 'bottom2' )
	&& ! is_active_sidebar( 'bottom3'  )
	&& ! is_active_sidebar( 'bottom4'  )
    && (!$hide_defaults)
		
	): ?>
           <aside class="widget-area" role="complementary" id="puresimple-bottom-section" >
                <div class="container">
                    <div class="row">              
                        <div id="bottom1" class="col-md-3" role="complementary">
                            <h3><?php echo __('Bottom 1', 'pure-simple'); ?></h3>
                            <p><?php echo __('<p>Add the bottom Content here Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'pure-simple');?></p>
                        </div><!-- #top1 -->

                        <div id="bottom2" class="col-md-3" role="complementary">
                            <h3><?php echo __('Bottom 2', 'pure-simple'); ?></h3>
                            <p><?php echo __('Add the bottom Content here Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'pure-simple');?></p>
                        </div><!-- #top2 -->          

                        <div id="bottom3" class="col-md-3" role="complementary">
                            <h3><?php echo __('Bottom 3', 'pure-simple'); ?></h3>
                            <p><?php echo __('Add the bottom Content here Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'pure-simple');?></p>
                        </div><!-- #top3 -->

                        <div id="bottom4" class="col-md-3" role="complementary">
                            <h3><?php echo __('Bottom 4', 'pure-simple'); ?></h3>
                            <p><?php echo __('Add the bottom Content here Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'pure-simple');?></p>
                        </div><!-- #top4 -->

                    </div>
                </div>
            </aside>
        <?php elseif(is_active_sidebar( 'bottom1' )  ||  is_active_sidebar( 'bottom2' ) || is_active_sidebar( 'bottom3' ) ||  is_active_sidebar( 'bottom4' )):

    // If we get this far, we have widgets. Let do this.
?>
<aside class="widget-area" role="complementary" id="puresimple-bottom-section" >
    <div class="container">
        <div class="row">

			<?php if ( is_active_sidebar( 'bottom1' ) ) : ?>
                <div id="bottom1" <?php puresimple_bottomgroup(); ?> role="complementary">
                    <?php dynamic_sidebar( 'bottom1' ); ?>
                </div><!-- #top1 -->
            <?php endif; ?>
            
            <?php if ( is_active_sidebar( 'bottom2' ) ) : ?>      
                <div id="bottom2" <?php puresimple_bottomgroup(); ?> role="complementary">
                    <?php dynamic_sidebar( 'bottom2' ); ?>
                </div><!-- #top2 -->          
            <?php endif; ?>
            
            <?php if ( is_active_sidebar( 'bottom3' ) ) : ?>        
                <div id="bottom3" <?php puresimple_bottomgroup(); ?> role="complementary">
                    <?php dynamic_sidebar( 'bottom3' ); ?>
                </div><!-- #top3 -->
            <?php endif; ?>
            
            <?php if ( is_active_sidebar( 'bottom4' ) ) : ?>     
                <div id="bottom4" <?php puresimple_bottomgroup(); ?> role="complementary">
                    <?php dynamic_sidebar( 'bottom4' ); ?>
                </div><!-- #top4 -->
             <?php endif; ?>
            
        </div>
    </div>
</aside>
<?php else:
    return;
endif;
?>
