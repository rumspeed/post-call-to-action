<?php
/*
 * DISPLAY POST CALL TO ACTION BOX SINGLE POSTS
 *
 */



/* ----- insert CTA box below content ----- */
function rum_post_cta_box( $content ) {

	global $post;

    // get activation status
    $activated = rum_post_cta_activation_check();

    if ( $activated ) {

		// checks to make sure code executes only on single 'post' pages and inside of the main Loop
		if( is_singular('post') && is_main_query() ) {

		    // retrieve the custom meta box value
		    $post_cta_id = get_post_meta( $post->ID, 'rum_post_cta_id', true );


			// only proceed if there is data in the meta field for storing the CTA data from the metabox
			if ( $post_cta_id != '' ) {
				$rum_post_cta_box = rum_cta_box_html( $post_cta_id );
				$content .= $rum_post_cta_box;	
			}
		}
	}
	return $content;
}
add_filter( 'the_content', 'rum_post_cta_box' );




function rum_cta_box_html( $post_cta_id ) {

	// initialize variables
	$cta_html      = '';
	$featured_image = '';
	$title			= '';
	$button_text    = '';
	$cta_url		= '';

	// get plugin option array and store in a variable
	$plugin_option_array            = get_option( 'rum_post_cta_plugin_options' );


	$featured_image = rum_cta_featured_image( $post_cta_id );
	$title			= get_the_title( $post_cta_id );;
	$button_text    = $plugin_option_array[ 'button_text' ];
	$cta_url		= get_permalink( $post_cta_id );


	// display the featured image from the embedded post/page/etc.
	if ( $featured_image != '' ) {
	
		$cta_html .= '	<div class="rum-post-cta-image">';
		$cta_html .= $featured_image;
		$cta_html .= '	</div>';	
	}

	// display the cta text
	$cta_html .= '  <div class="rum-post-cta-text">';
	$cta_html .= '		<h2>' . $title . '</h2>';
	$cta_html .= '    </div>';

	// display the cta button
	$cta_html .= '	<div class="rum-post-cta-button">';
	$cta_html .= '		<a href="' . $cta_url . '">' . $button_text . '</a>';
	$cta_html .= '	</div>';


	// CTA box div wrapper
	$cta_html = '<div class="rum-post-cta-box">' . $cta_html . '</div>';

	return $cta_html;
}




function rum_cta_featured_image( $post_cta_id ) {

	// initialize variables
	$featured_image     = '';
	$size               = '';


	// get plugin option array and store in a variable
	$plugin_option_array            = get_option( 'rum_post_cta_plugin_options' );


	// fetch individual values from the plugin option variable array
    $featured_image     = $plugin_option_array[ 'featured_image' ];


	// if the featured image field is enabled, set the output string
	if ( $featured_image == 1 ) {

		//$size = array(75,75);
		$size = 'thumbnail';
		$featured_image = get_the_post_thumbnail( $post_cta_id, $size, $attr );;
	}



	return $featured_image;
}


