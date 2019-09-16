<?php
/**
 * Call to Action Sidebar 
 * @package Pure_and_Simple
 * @since 1.0.0
 */

$default_content = get_theme_mod('hide_default_content', '0');
if ( ! is_active_sidebar( 'cta' ) && (!$default_content) && (is_front_page()) ) {?>
	
    <div id="cta" style="color:<?php echo get_theme_mod( 'cta_text', '#adadad' ); ?>;">
    <aside class="widget-area" role="complementary">        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 id="cta-heading"><?php echo __('WELCOME TO PURE & SIMPLE', 'pure-simple');?></h1>          
                    <div class="textwidget">
                    <p><?php echo __('Explore my new WordPress theme called Pure &amp; Simple...a theme built for professional bloggers with beautiful subtle features that gives you more when you are serious about your content! Unlimited colours, several blog styles, Jetpack ready with a gorgeous portfolio, mobile responsive...and much more!', 'pure-simple');?></p>
                    <p><a class="btn link" target="_blank" href="https://www.styledthemes.com/themes/pure-simple/">More Info</a></p>
                    </div>
                </div>
            </div>
        </div>      
    </aside>
</div>
<?php } else if(is_active_sidebar( 'cta' ) )  {
?>
<div id="cta" style="color:<?php echo get_theme_mod( 'cta_text', '#adadad' ); ?>;">
	<aside class="widget-area" role="complementary">		
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php dynamic_sidebar( 'cta' ); ?>
                </div>
            </div>
        </div>    	
	</aside>
</div>
<?php } ?>
