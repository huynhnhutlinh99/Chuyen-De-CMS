<?php
/**
 * Post Format Quote 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	

<div class="entry-content">
<div class="row">
	  <?php if ( has_post_thumbnail()) : ?>
      <div class="col-md-3">
        <div class="quote-thumbnail">
          <?php the_post_thumbnail(); ?>
          </div>
         </div>
         <div class="col-md-9">
       <?php else : ?>
     <div class="col-md-12">
        <?php endif; ?>
 
     
      <header class="entry-header">
        <h1 class="entry-title"><span class="post-format">
				<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'quote' ) ); ?>"><?php echo get_post_format_string( 'quote' ); ?></a>
			</span><a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        </header>
      <?php the_content( __( 'Read Full Quote...', 'pure-simple' ) ); ?>
      
</div>  
  </div>
</div>

</article>
<div class="article-separator"></div>