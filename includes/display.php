<?php



/*
 * DISPLAY POST CALL TO ACTION BOX SINGLE POSTS
 *
 */

/* ----- insert CTA box below content ----- */

function rum_post_cta_box( $content ) {

	// checks to make sure code executes only on singles pages and inside of the main Loop
// TODO - make sure we are using the post_type = 'post' in the ID statement below
	if( is_singular() && is_main_query() ) {

// TODO - only proceed if there is data in the meta field for storing the CTA data from the metabox
		$rum_post_cta_box = '/includes/display-functions.php' ;
		$content .= $rum_post_cta_box;

	}
	return $content;
}

add_filter( ' the_content', 'rum_post_cta_box' );
