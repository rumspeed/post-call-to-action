<?php



/*
 * DISPLAY POST CALL TO ACTION BOX SINGLE POSTS
 *
 */



/* ----- insert CTA box below content ----- */
function rum_post_cta_box( $content ) {

	// checks to make sure code executes only on singles pages and inside of the main Loop
// TODO - make sure we are using the post_type = 'post' in the ID statement below
	if( is_singular('post') && is_main_query() ) {

// TODO - only proceed if there is data in the meta field for storing the CTA data from the metabox
		$rum_post_cta_box = rum_cta_box_html();
		$content .= $rum_post_cta_box;

	}
	return $content;
}
add_filter( 'the_content', 'rum_post_cta_box' );




function rum_cta_box_html() {

	// initialize variables
	$cta_html      = '';

// TODO - get the post metabox metafield that stores the post we are linking to

	// display the featured image from the embedded post/page/etc.
	$cta_html .= '	<div class="rum-post-cta-image">';
	$cta_html .= '     Image goes here';
	$cta_html .= '	</div>';


	// display the cta text
	$cta_html .= '  <div class="rum-post-cta-text">';
	$cta_html .= '		<h2>Post Title Goes Here</h2>';
	$cta_html .= '    </div>';

	// display the cta button
	$cta_html .= '	<div class="rum-post-cta-button">';
	$cta_html .= '		CTA Button';
	$cta_html .= '	</div>';


	// CTA box div wrapper
	$cta_html .= '<div class="rum-post-cta-box">' . $cta_html . '</div>';

	return $cta_html;
}

