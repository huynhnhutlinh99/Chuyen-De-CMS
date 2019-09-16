<?php
/**
 * Post Format Image 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail()) :     
        echo '<div class="format-image-featured">';
          	the_post_thumbnail();
         echo '</div>';
		endif; 
	?>

	<header class="entry-header">
		<h1 class="entry-title">
			<span class="post-format">
				<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"><?php echo get_post_format_string( 'image' ); ?></a>
			</span>       
       		<a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>      
        </h1>
        
		<div class="entry-meta">		
			<?php puresimple_posted_on(); ?>
			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'pure-simple' ), __( '1 Comment', 'pure-simple' ), __( '% Comments', 'pure-simple' ) ); ?></span>
			<?php endif; ?>			
		</div>
	</header>

	<div class="entry-content">
		<?php
			the_content( __( 'See More...', 'pure-simple' ) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'pure-simple' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div>
</article>


<div class="article-separator"></div>