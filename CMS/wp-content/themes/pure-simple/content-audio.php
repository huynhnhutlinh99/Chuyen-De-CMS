<?php
/**
 * Post Format audio 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   

   
	<header class="entry-header">
		<h1 class="entry-title">
			<span class="post-format">
				<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'audio' ) ); ?>"><?php echo get_post_format_string( 'audio' ); ?></a>
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
 	<?php if ( has_post_thumbnail()) :     
        echo '<div class="format-audio-featured">';
          	the_post_thumbnail();
         echo '</div>';
		endif; 
	?>   
		<?php the_content(); ?>
	</div><!-- .entry-content -->
    
	<footer class="entry-meta"></footer>
    
</article><!-- #post-## -->

<div class="article-separator"></div>