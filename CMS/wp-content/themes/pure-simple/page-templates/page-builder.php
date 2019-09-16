<?php
/**
 * Template Name: Page Builder
 * This template is for the use of a page builder plugin of your choice 
 * @package Pure_and_Simple
 * @since 1.0.0
 */

get_header(); ?>

      
<?php
	// Start the Loop.
	while ( have_posts() ) : the_post();

		// Include the page content template.
		get_template_part( 'content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
?>

<?php
get_footer();
