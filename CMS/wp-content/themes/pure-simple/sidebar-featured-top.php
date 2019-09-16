<?php
/**
 * Featured Top sidebar group 
 * @package Pure_and_Simple
 * @since 1.0.0
 */


if (   ! is_active_sidebar( 'featuredtop1'  )
	&& ! is_active_sidebar( 'featuredtop2' )
	&& ! is_active_sidebar( 'featuredtop3'  )
	&& ! is_active_sidebar( 'featuredtop4'  )		
		
	)

		return;
	// If we get this far, we have widgets. Let do this.
?>
<div id="featured-top-group" style="background-color: <?php echo get_theme_mod( 'content_bg', '#ffffff' ); ?>;">
    <aside class="widget-area" role="complementary">
        <div class="container">
            <div class="row">

					<?php if ( is_active_sidebar( 'featuredtop1' ) ) : ?>                
                        <div id="featuredtop1" <?php puresimple_featuredtopgroup(); ?> role="complementary">
                            <?php dynamic_sidebar( 'featuredtop1' ); ?>
                        </div><!-- #top1 -->
                    <?php endif; ?>
                                        
                    <?php if ( is_active_sidebar( 'featuredtop2' ) ) : ?>                             
                        <div id="featuredtop2" <?php puresimple_featuredtopgroup(); ?> role="complementary">
                            <?php dynamic_sidebar( 'featuredtop2' ); ?>
                        </div><!-- #top2 -->          
                    <?php endif; ?> 
     
                    <?php if ( is_active_sidebar( 'featuredtop3' ) ) : ?>               
                        <div id="featuredtop3" <?php puresimple_featuredtopgroup(); ?> role="complementary">
                            <?php dynamic_sidebar( 'featuredtop3' ); ?>
                        </div><!-- #top3 -->
                    <?php endif; ?>
    
                    <?php if ( is_active_sidebar( 'featuredtop4' ) ) : ?>             
                        <div id="featuredtop4" <?php puresimple_featuredtopgroup(); ?> role="complementary">
                            <?php dynamic_sidebar( 'featuredtop4' ); ?>
                        </div><!-- #top4 -->
                    <?php endif; ?>
                                   
                </div>
            </div>	
    </aside>
</div>