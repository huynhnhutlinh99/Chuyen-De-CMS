<?php
/**
 * Blog summary content
 * Get the content layout for each post summary 
 * @package Pure_and_Simple
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
	<?php get_template_part( 'partials/blog-style' ); ?>
 
</article>

<div class="article-separator"></div>