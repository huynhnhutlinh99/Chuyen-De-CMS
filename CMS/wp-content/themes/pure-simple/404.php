<?php
/**
 * The template for displaying 404 pages (not found). 
 * @package Pure_and_Simple
 * @since 1.0.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="container">
            <div class="row">    
                <div class="col-md-12">
                
                    <section id="cir-content-area" role="main">
      
                        <div class="error-content">
                
                            <header class="page-header">
                                <h1 style="font-weight:bold;"><?php _e( 'Page Not Found', 'pure-simple' ); ?></h1><br/>
                                <h2 style="font-weight:bold;"><?php _e( 'Well this does not look good.<br />It appears this page is missing or was removed.', 'pure-simple' ); ?></h2>                     
                            </header>
                            <br/>
                            <br/>
            
                        <h4><?php _e( 'If what you were looking for is not found, you may want to try searching with keywords relevant to what you were looking for.', 'pure-simple' ); ?></h4><br/>
                        
                        <div class="input-group-box">
                            <?php get_search_form(); ?>
                        </div>
                </div><!-- .page-content -->
                                
            </div>
        </div><!-- #main -->
    </div><!-- #primary -->
</section>          

                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
