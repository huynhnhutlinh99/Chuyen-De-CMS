<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 * @package Pure_and_Simple
 * @since 1.0.0
 */


/**
* Modification of wp_link_pages to enclose page links in an unordered list.
*
* Special thanks to http://wpbungee.webstractions.com/bungee-development/pagination-hybrid-core-theme-templates-twitter-bootstrap/
*
*/
function puresimple_multi_pages($args = '') {
	$defaults = array(
	'before' => '<div class="pagination-wrapper clearfix"><label>' . __( 'Pages: ', 'pure-simple' ) . '</label><ul class="pagination">',
	'after'             => '</ul></div>',
	'link_before'       => '<li>', 
	'link_after'        => '</li>',
	'next_or_number'    => 'number', 
	'nextpagelink'      => __('Next page', 'pure-simple'),
	'previouspagelink'  => __('Previous page', 'pure-simple'), 
	'pagelink'          => '%',
	'echo'              => 1
);
 
$r = wp_parse_args( $args, $defaults );
$r = apply_filters( 'puresimple_multi_pages_args', $r );
extract( $r, EXTR_SKIP );
 
global $page, $numpages, $multipage, $more, $pagenow;
 
$output = '';
if ( $multipage ) {
if ( 'number' == $next_or_number ) {
    $output .= $before;
    for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
        $j = str_replace('%',$i,$pagelink);
        if ( ($i != $page) || ((!$more) && ($page==1)) ) {
            $output .= ' ' . str_replace('%','normal',$link_before);
            $output .= _wp_link_page($i);
            $output .= $j;
            $output .= '</a>';
        }
        else {
            $output .= ' ' . str_replace('%','disabled',$link_before);
            $output .= '<span class="active">' . $j . '</span>';
        }
        $output .=  $link_after;
    }
    $output .= $after;
} else {
    if ( $more ) {
        $output .= $before;
        $i = $page - 1;
        if ( $i && $more ) {
            $output .= $link_before;
            $output .= _wp_link_page($i);
            $output .= $previouspagelink . '</a>';
            $output .= $link_after;
        }
        $i = $page + 1;
        if ( $i <= $numpages && $more ) {
            $output .= $link_before;
            $output .= _wp_link_page($i);
            $output .= $nextpagelink . '</a>';
            $output .= $link_after;
        }
        $output .= $after;
    }
}
}
 
if ( $echo )
echo $output;
 
return $output;
}





if ( ! function_exists( 'puresimple_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function puresimple_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'pure-simple' ); ?></h1>
		<div class="nav-links">
			<h2 class="article-info"><?php _e( 'More Articles', 'pure-simple' ); ?></h2>
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><i class="fa fa-hand-o-left"></i> <?php next_posts_link( __( 'Older posts', 'pure-simple' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><i class="fa fa-hand-o-right"></i> <?php previous_posts_link( __( 'Newer posts', 'pure-simple' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'puresimple_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function puresimple_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'pure-simple' ); ?></h1>
		<div class="nav-links">
        <h2 class="article-info"><?php _e( 'More Articles', 'pure-simple' ); ?></h2>
        
        
			<?php
				previous_post_link( '<div class="nav-previous"><i class="fa fa-hand-o-left"></i> %link</div>', '<span class="meta-nav">%title</span>', 'Previous post link', 'pure-simple' );
				next_post_link( '<div class="nav-next"><i class="fa fa-hand-o-right"></i> %link</div>', '<span class="meta-nav">%title</span>', 'Next post link', 'pure-simple' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Display navigation to next/previous Images when on the attachment page
 *
 */
if ( ! function_exists( 'puresimple_attachment_nav' ) ) :

function puresimple_attachment_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	
		<h1 class="screen-reader-text"><?php _e( 'Photo Navigation', 'pure-simple' ); ?></h1>
		<div class="nav-links clearfix">
			<?php
			previous_image_link( false, '<span class="previous-image"><i class="fa fa-arrow-circle-left"></i></span>' );
			next_image_link( false, '<span class="next-image"><i class="fa fa-arrow-circle-right"></i></span>' );
			?>
		</div>
	
	<?php
}
endif;

if ( ! function_exists( 'puresimple_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function puresimple_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		__( 'Published on %s', 'pure-simple' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'pure-simple' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
    //displaying author and category in home page
    if(is_home()){ echo '<span class="category-name">';
    	          echo '&nbsp'.__('Category:','pure-simple').'<span class="">'.'&nbsp'.get_the_category_list( __( ', ', 'pure-simple' ) ).' </span>';}
    }
endif;


/**
 * Print the attached image with a link to the next attached image.
 *
 */
if ( ! function_exists( 'puresimple_the_attached_image' ) ) :

function puresimple_the_attached_image() {
	$post                = get_post();

	$attachment_size     = apply_filters( 'puresimple_attachment_size', array( 1140, 1140 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 */
function puresimple_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function puresimple_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'puresimple_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'puresimple_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so puresimple_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so puresimple_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in puresimple_categorized_blog.
 */
function puresimple_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'puresimple_categories' );
}
add_action( 'edit_category', 'puresimple_category_transient_flusher' );
add_action( 'save_post',     'puresimple_category_transient_flusher' );
