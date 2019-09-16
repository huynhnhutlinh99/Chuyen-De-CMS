<?php
/**
 * Post Format Aside 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="entry-content">
	<div class="row">   
		<?php if ( has_post_thumbnail()) : ?>
            <div class="col-md-3">  
               <div class="format-aside-featured">
                   <?php the_post_thumbnail(); ?>
               </div>      
            </div>
            <div class="col-md-9">
        <?php else : ?>
            <div class="col-md-12">
        <?php endif; ?>
    
	<?php if ( is_single() ) : 
		the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header>' ); 
		endif;	?>   
 
	<?php the_content( __( 'Read More...', 'pure-simple' ) ); ?>
       
    <footer>
    	<div class="entry-meta">
      		<span class="post-format">
				<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'aside' ) ); ?>"><?php echo get_post_format_string( 'aside' ); ?></a>
			</span><?php puresimple_posted_on(); ?>
            
			<?php if( get_theme_mod( 'hide_edit' ) == '') { ?>
                <?php edit_post_link( __( 'Edit this post', 'pure-simple' ), '<span class="edit-link">', '</span>' ); ?>
            <?php } ?> 
                   
    	</div>
 	  
    </footer>       
    </div>
    
  </div>
</div>
			
	
</article>

<div class="article-separator"></div>