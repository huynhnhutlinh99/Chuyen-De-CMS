<?php
/**
 * Post Format Link 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
<div class="entry-content">
	<div class="row">
	  <?php if ( has_post_thumbnail()) : ?>
      <div class="col-md-3">
        <div class="status-thumbnail">
          <?php the_post_thumbnail(); ?>
          </div>
         </div>
         <div class="col-md-9">
       <?php else : ?>
     <div class="col-md-12">
        <?php endif; ?>
     
    <header class="entry-header">
        <h1 class="entry-title">
            <span class="post-format">
                <a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'link' ) ); ?>"><?php echo get_post_format_string( 'link' ); ?></a>
            </span>       
            	<a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>      
        </h1>
    </header>
      
    <div class="entry-content">
    	<?php the_content( __( 'Link Info', 'pure-simple' ) ); ?>
    <div> 
          
	</div>  
  </div>
</div>

</article><!-- #post-## -->

<div class="article-separator"></div>