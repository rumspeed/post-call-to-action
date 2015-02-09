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


		    // enqueue registered stylesheet
			wp_enqueue_style( 'rum-post-cta-styles' );


			// only proceed if there is data in the meta field for storing the CTA data from the metabox
			if ( $post_cta_id != '' && $post_cta_id != '0' ) {
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
	$cta_html       = '';
	$featured_image = '';
	$title			= '';
	$button_text    = '';
	$cta_url		= '';
	$box_style		= '';
    $bg_color       = '';
    $text_color     = '';
    $button_style   = '';


	// get plugin option array and store in a variable
	$plugin_option_array  = get_option( 'rum_post_cta_plugin_options' );


	$featured_image       = rum_cta_featured_image( $post_cta_id );
	$title			      = get_the_title( $post_cta_id );;
	$button_text          = $plugin_option_array[ 'button_text' ];
	$cta_url		      = get_permalink( $post_cta_id );
    $bg_color             = $plugin_option_array[ 'bg_color' ];
    $text_color           = $plugin_option_array[ 'text_color' ];
    $button_style         = $plugin_option_array[ 'button_style' ];


    // format style for CTA box
	$box_style .= 'background:' . $bg_color . ';';
	$box_style .= 'color:' . $text_color . ';';
	$box_style .= 'border: 1px solid ' . $text_color . ';';


	// format button style
	$button_style = 'class="cta-btn cta-btn-' . esc_attr( $button_style ) . '"'; // optional size value: 'btn-lg'

	// display the featured image from the embedded post/page/etc.
	if ( $featured_image != '' ) {
	
		$cta_html .= '	<div class="rum-post-cta-image">';
		$cta_html .= $featured_image;
		$cta_html .= '	</div>';	
	}


	// wrap rum-post-cta-text and rum-post-cta-button
	$cta_html .= '<div class="rum-post-cta-meta">';


	// display the cta text
	$cta_html .= '  <div class="rum-post-cta-text">';
	$cta_html .= '		<h2>' . $title . '</h2>';
	$cta_html .= '    </div>';


	// display the cta button
	$cta_html .= '	<div class="rum-post-cta-button">';
	$cta_html .= '		<a href="' . esc_url( $cta_url ) . '"' . $button_style . '>' . $button_text . '</a>';
	$cta_html .= '	</div>';


	// close the wrapper for rum-post-cta-text and rum-post-cta-button
	$cta_html .= '</div>';



	// CTA box div wrapper
	$cta_html = '<div id="rum-post-cta-box" style="' . esc_attr( $box_style ) . '">' . $cta_html . '</div>';


	// clear the float of the main container
	$cta_html .= '<div class="rum-post-cta-clearfix"></div>';


	return $cta_html;
}




function rum_cta_featured_image( $post_cta_id ) {

	// initialize variables
	$featured_image     = '';
	$size               = '';


	// get plugin option array and store in a variable
	$plugin_option_array = get_option( 'rum_post_cta_plugin_options' );


	// fetch individual values from the plugin option variable array
    $featured_image      = $plugin_option_array[ 'featured_image' ];


	// if the featured image field is enabled, set the output string
	if ( $featured_image == 1 ) {

		$size = 'medium';
		$featured_image = get_the_post_thumbnail( $post_cta_id, $size );
	}

	return $featured_image;
}




function rum_post_cta_enqueue_styles() {

	wp_register_style( 'rum-post-cta-styles', RUM_POST_CTA_PLUGIN_URI . '/css/rum-post-cta.css', array(), RUM_POST_CTA_PLUGIN_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'rum_post_cta_enqueue_styles' );
