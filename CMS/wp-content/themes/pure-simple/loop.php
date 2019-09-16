<?php
/**
 * content Loop
 * Get the loop for the appropriate blog location 
 * @package Pure_and_Simple
 * @since 1.0.0
 */

// Begin the loops

if ( is_home() ) : // Display posts for blog. 
		
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		get_template_part( 'content', get_post_format() );
	endwhile;
		puresimple_paging_nav();
	else :
		get_template_part( 'content', 'none' );
	endif;
        
elseif (is_single() ) :  // Display the full post.      
         
	while ( have_posts() ) : the_post();	
		get_template_part( 'content', 'single' );		
		puresimple_post_nav();					
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	endwhile; // end of the loop.
	
elseif (is_category() ) : // Display category posts.

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
		endwhile;
			puresimple_paging_nav();
		else :
			get_template_part( 'content', 'none' );
		endif;	
	
elseif (is_archive() || is_search() ) : // Display archived posts.

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'content', 'archive' );
		endwhile;
			puresimple_paging_nav();
		else :
			get_template_part( 'content', 'none' );
		endif;
		
// Close the loops        
endif; ?>        