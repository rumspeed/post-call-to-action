<?php
/*
Plugin Name: Post Call to Action
Description: Every page should do something. Display a call to action bar below each blog post.
Version: 0.2.0
Author: Scot Rumery
Author URI: http://rumspeed.com/scot-rumery/
*/

define( 'RUM_POST_CTA_PLUGIN_VERSION', '0.1.0' );
define( 'RUM_POST_CTA_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'RUM_POST_CTA_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

// include files - these are simply to organize functions into logical areas
//include_once( 'includes/settings.php' );
//include_once( 'includes/display-functions.php' );

/* ----- add a link to the plugin in the admin menu under 'Settings > Post CTA' ----- */

function rum_post_cta_menu() {
	/*
	 * use the add_options_page function
	 * add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function )
	 *
	 */
	
	add_options_page(
		'Post Call to Action',
		'Post CTA',
		'manage_options',
		'rum-post-cta',
		'rum_post_cta_options_page'
	);

}

add_action( 'admin_menu', 'rum_post_cta_menu' );


function rum_post_cta_options_page() {

	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not sufficient permission to access this page.' );
	}

	require( 'includes/options-page-wrapper.php' );

}

/* ----- load admin functions if in the backend ----- */
	
	// if ( is_admin() ) {
	
	// }

/* ----- insert CTA box below content ----- */

function rum_post_cta_box( $content ) {
	/*
	 * Checks to make sure code executes only on
	 * singles pages and inside of the main Loop
	 *
	 */

	 if( is_singular() && is_main_query() ) {

	 	$post_cta_box = 'Insert the CTA box here';
	 	$content .= $new_content;

	 }
	 return $content;
}

add_filter( ' the_content', 'rum_post_cta_box' );

/* ----- add color picker ----- */

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( ) {

         // Add the color picker css file
         wp_enqueue_style( 'wp-color-picker' );

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script(
	        'wp-color-picker-script',
	        plugins_url( 'js/jquery.custom.js', __FILE__ ),
	        array( 'wp-color-picker' ),
	        false,
	        true
        );
		// Include the Iris color picker
	    wp_enqueue_script(
		    'iris',
		    admin_url( 'js/iris.min.js' ),
		    array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
		    false,
		    1
	    );
    }

