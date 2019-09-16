<?php
/**
 * Single content 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php puresimple_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
    
    
    
	<?php if( get_theme_mod( 'hide_featured' ) == '') { ?>
        <?php // do not show featured image if post is paged
        $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : false;
           if ( $paged === false ):     
              
            if ( has_post_thumbnail() ) {
				echo '<div class="featured-image-single">';
                the_post_thumbnail();
				echo '</div>';
            } 
      
        endif; ?>
    <?php } ?>    
    
       
		<?php the_content(); ?>
		<?php puresimple_multi_pages(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer single-footer">
    <h2 class="article-info"><?php _e( 'Article Information', 'pure-simple' ); ?></h2>
		
		<?php 
			if (get_the_modified_time() != get_the_time()) : 
		 		_e( 'Last Modified on ', 'pure-simple' );  the_modified_date() ; echo '<br>';		      
       		 endif; 
        
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'pure-simple' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'pure-simple' ) );
			
			$parent_title = get_the_title( $post->post_parent );

			if ( ! puresimple_categorized_blog() ) {
				
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged with %2$s <br />this article <a href="%3$s" rel="bookmark">', 'pure-simple') .  $parent_title . '</a><br />';
				} else {
					$meta_text = __( 'this article <a href="%3$s" rel="bookmark">', 'pure-simple' ) . $parent_title . '</a><br />';
				}

			} else {
				
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s <br />Tagged with %2$s <br />Bookmark this article <a href="%3$s" rel="bookmark">', 'pure-simple' ) . $parent_title . '</a><br />';
				} else {
					$meta_text = __( 'This entry was posted in %1$s <br />Bookmark this article <a href="%3$s" rel="bookmark">', 'pure-simple' ) . $parent_title . '</a><br />';
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

        <?php if( get_theme_mod( 'hide_edit' ) == '') { ?>
			<?php edit_post_link( __( 'Edit This Post', 'pure-simple' ), '<span class="edit-link">', '</span>' ); ?>
        <?php } ?>
		
	</footer><!-- .entry-footer -->
    
</article><!-- #post-## -->
