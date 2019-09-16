<?php
/**
 * This is the archive summary 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 


         <header class="entry-header">
            <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
                <?php if ( 'post' == get_post_type() ) : ?>
            <?php endif; ?>
            <div class="entry-meta">
              <?php puresimple_posted_on(); ?>
            </div> 
          </header> 
          <div class="entry-content">
          
            <?php the_excerpt(); ?>
            <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'pure-simple' ),
                        'after'  => '</div>',
                    ) );
                ?>
          </div>  
        
          <footer class="entry-footer">
            <?php edit_post_link( __( 'Edit', 'pure-simple' ), '<span class="edit-link">', '</span>' ); ?>
          </footer>  

 
</article>
<!-- #post-## -->