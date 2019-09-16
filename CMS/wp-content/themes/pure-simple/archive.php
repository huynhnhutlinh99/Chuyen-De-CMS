<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * @package Pure_and_Simple
 * @since 1.0.0
 */

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

        <header class="page-header">
            <h1 class="page-title">
                <?php
                    if ( is_category() ) :
                        single_cat_title();

                    elseif ( is_tag() ) :
                        single_tag_title();

                    elseif ( is_author() ) :
                        printf( __( 'Author: %s', 'pure-simple' ), '<span class="vcard">' . get_the_author() . '</span>' );

                    elseif ( is_day() ) :
                        printf( __( 'Day: %s', 'pure-simple' ), '<span>' . get_the_date() . '</span>' );

                    elseif ( is_month() ) :
                        printf( __( 'Month: %s', 'pure-simple' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'pure-simple' ) ) . '</span>' );

                    elseif ( is_year() ) :
                        printf( __( 'Year: %s', 'pure-simple' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'pure-simple' ) ) . '</span>' );

                    elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                        _e( 'Asides', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
                        _e( 'Galleries', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
                        _e( 'Images', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
                        _e( 'Videos', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
                        _e( 'Quotes', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
                        _e( 'Links', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
                        _e( 'Statuses', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
                        _e( 'Audios', 'pure-simple' );

                    elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
                        _e( 'Chats', 'pure-simple' );

                    else :
                        _e( 'Archives', 'pure-simple' );

                    endif;
                ?>
            </h1>
            <?php
                // Show an optional term description.
                $term_description = term_description();
                if ( ! empty( $term_description ) ) :
                    printf( '<div class="taxonomy-description">%s</div>', $term_description );
                endif;
            ?>
        </header><!-- .page-header -->

        </div>
    </div>
</div>
              
<?php $bloglayout = get_theme_mod( 'blog_layout', 'blogright' );
        
	switch ($bloglayout) {
		// Right sidebar
		case "blogright" :
			echo '<div class="container"><div class="row"><div class="col-md-9">';
					get_template_part( 'loop', 'archive' );
			echo '</div><div id="secondary" class="col-md-3 widget-area" role="complementary">';
				get_sidebar( 'right' );
			echo '</div></div></div>';						
		break;		
						
		// Left sidebar
		case "blogleft" :
			echo '<div class="container"><div class="row"><div id="secondary" class="col-md-3 widget-area" role="complementary">';
				get_sidebar( 'left' );
			echo '</div>';	
			echo '<div class="col-md-9">';
					get_template_part( 'loop', 'archive' );
			echo '</div></div></div>';					  
		break;
						
		// Full width no sidebars
		case "blogwide" :
			echo '<div class="container"><div class="row"><div class="col-md-12">';
					get_template_part( 'loop', 'archive' );
			echo '</div></div></div>';							  
		break;				
		
	}
?>

<?php get_footer(); ?>