<?php
/**
 * Blog Summary styles 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<?php $bloglayout = get_theme_mod( 'blog_style', 'blogstyle1' );
		
	switch ($bloglayout) {
		// blog style 1
		case "blogstyle1" :
			echo '<header class="entry-header">';
										
				//the_title( sprintf( '<h1 class="entry-title">	<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );						
				echo '<h1 class="entry-title">'; if ( is_sticky() && is_home() && ! is_paged() ) : echo '<span class="featured-post">'; _e( 'Featured', 'pure-simple' );
				echo '</span>'; endif;
				echo '<a href="' .esc_url( get_permalink() ) .'" title="'; the_title(); 
				echo '">'; if(the_title( '', '', false ) !='') the_title(); else _e('Untitled', 'pure-simple'); 
				echo '</a></h1>';												
				
			echo '<div class="entry-meta">';
				puresimple_posted_on();
			echo '</div></header><div class="entry-content">';
				if ( has_post_thumbnail() ) { 			
					echo '<div class="featured-image-style1 clearfix"><a href="' . get_permalink() . '">';
						the_post_thumbnail();				        
					echo '</a></div>';	
				}
				$excon = get_theme_mod( 'excerpt_content', 'content' );
				$excerpt = get_theme_mod( 'excerpt_limit', '50' );
					 switch ($excon) {
						case "content" :
							the_content(__('Read More', 'pure-simple'));
						break;
						case "excerpt" : 
							echo '<p>' . puresimple_excerpt($excerpt) . '</p>' ;
							echo '<p class="more-link"><a href="' . get_permalink() . '">' . __('Read More', 'pure-simple') . '</a>' ;
						break;
				}
				
			echo '</div><footer class="entry-footer">';
				puresimple_multi_pages();
				if( get_theme_mod( 'hide_edit' ) == '') {
					edit_post_link( __( 'Edit this Post', 'pure-simple' ), '<span class="edit-link">', '</span>' );
				}						
			echo '</footer>';		 						
		break;		
						
		// blog style 2
		case "blogstyle2" :
			echo '<div class="row">';
				if ( has_post_thumbnail() ) { 			
					echo '<div class="col-md-4 featured-image-style2 clearfix"><a href="' . get_permalink() . '">';
						the_post_thumbnail();				        
					echo '</a></div><div class="col-md-8">';
				} else {
					echo '<div class="col-md-12">';						 
				}
			echo '<header class="entry-header">';
				echo '<h1 class="entry-title">'; if ( is_sticky() && is_home() && ! is_paged() ) : echo '<span class="featured-post">'; _e( 'Featured', 'pure-simple' );
				echo '</span>'; endif;
				echo '<a href="' .esc_url( get_permalink() ) .'" title="'; the_title(); 
				echo '">'; if(the_title( '', '', false ) !='') the_title(); else _e('Untitled', 'pure-simple'); 
				echo '</a></h1>';	
			echo '<div class="entry-meta">';
				puresimple_posted_on();
			echo '</div></header><div class="entry-content">';
				$excon = get_theme_mod( 'excerpt_content', 'content' );
				$excerpt = get_theme_mod( 'excerpt_limit', '50' );
					 switch ($excon) {
						case "content" :
							the_content(__('Read More', 'pure-simple'));
						break;
						case "excerpt" : 
							echo '<p>' . puresimple_excerpt($excerpt) . '</p>' ;
							echo '<p class="more-link"><a href="' . get_permalink() . '">' . __('Read More', 'pure-simple') . '</a>' ;
						break;
				}						
			echo '</div><footer class="entry-footer">';	
				puresimple_multi_pages();
				if( get_theme_mod( 'hide_edit' ) == '') {
					edit_post_link( __( 'Edit this Post', 'pure-simple' ), '<span class="edit-link">', '</span>' );
				}
			echo '</footer>';							  
		break;
						
		// blog style 3
		case "blogstyle3" :
			if ( has_post_thumbnail() ) { 			
				echo '<div class="featured-image-style3 clearfix"><a href="' . get_permalink() . '">';
					the_post_thumbnail();				        
				echo '</a></div>';			 
			}				
			echo '<header class="entry-header">';
				echo '<h1 class="entry-title">'; if ( is_sticky() && is_home() && ! is_paged() ) : echo '<span class="featured-post">'; _e( 'Featured', 'pure-simple' );
				echo '</span>'; endif;
				echo '<a href="' .esc_url( get_permalink() ) .'" title="'; the_title(); 
				echo '">'; if(the_title( '', '', false ) !='') the_title(); else _e('Untitled', 'pure-simple'); 
				echo '</a></h1>';
			echo '<div class="entry-meta">';
				puresimple_posted_on();
			echo '</div></header><div class="entry-content">';	
				$excon = get_theme_mod( 'excerpt_content', 'content' );
				$excerpt = get_theme_mod( 'excerpt_limit', '50' );
					 switch ($excon) {
						case "content" :
							the_content(__('Read More', 'pure-simple'));
						break;
						case "excerpt" : 
							echo '<p>' . puresimple_excerpt($excerpt) . '</p>' ;
							echo '<p class="more-link"><a href="' . get_permalink() . '">' . __('Read More', 'pure-simple') . '</a>' ;
						break;
				}

					
			echo '</div><footer class="entry-footer">';
				puresimple_multi_pages();	
				if( get_theme_mod( 'hide_edit' ) == '') {
					edit_post_link( __( 'Edit this Post', 'pure-simple' ), '<span class="edit-link">', '</span>' );
				}	
			echo '</footer>';			  
		break;				
						
		// blog style 4
		case "blogstyle4" :
			echo '<div class="blog-style-centered">';
			if ( has_post_thumbnail() ) { 			
				echo '<div class="featured-image-style4 clearfix"><a href="' . get_permalink() . '">';
					the_post_thumbnail();				        
				echo '</a></div>';			 
			}				
			echo '<header class="entry-header">';
				echo '<h1 class="entry-title">'; if ( is_sticky() && is_home() && ! is_paged() ) : echo '<span class="featured-post">'; _e( 'Featured', 'pure-simple' );
				echo '</span>'; endif;
				echo '<a href="' .esc_url( get_permalink() ) .'" title="'; the_title(); 
				echo '">'; if(the_title( '', '', false ) !='') the_title(); else _e('Untitled', 'pure-simple'); 
				echo '</a></h1>';
			echo '<div class="entry-meta">';
				puresimple_posted_on();
			echo '</div></header><div class="entry-content">';	
				$excon = get_theme_mod( 'excerpt_content', 'content' );
				$excerpt = get_theme_mod( 'excerpt_limit', '50' );
					 switch ($excon) {
						case "content" :
							the_content(__('Read More', 'pure-simple'));
						break;
						case "excerpt" : 
							echo '<p>' . puresimple_excerpt($excerpt) . '</p>' ;
							echo '<p class="more-link"><a href="' . get_permalink() . '">' . __('Read More', 'pure-simple') . '</a>' ;
						break;
				}

				puresimple_multi_pages();
			echo '</div><footer class="entry-footer">';	
				if( get_theme_mod( 'hide_edit' ) == '') {
					edit_post_link( __( 'Edit this Post', 'pure-simple' ), '<span class="edit-link">', '</span>' );
				}
			echo '</footer></div>';							  
		break;
					
						
	}
?>
      