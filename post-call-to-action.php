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


/* POST CALL TO ACTION SETTINGS PAGE */

/* ----- add a link to the plugin in the admin menu under 'Settings > Post CTA' ----- */

function rum_post_cta_menu() {
	/*
	 * add Post CTA to the Settings menu
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

/* ----- add the page with the Post Call to Action settings ----- */

function rum_post_cta_options_page() {

	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not sufficient permission to access this page.' );
	}

	require( 'includes/settings.php' );

}

/* ----- add the options that will be created/saved from the Settings page ---- */

$rum_post_cta_options_arr = array(
	'rum_post_cta_active' => 'yes/no',
	'rum_post_cta_type' => 'post type for cta association',
	'rum_post_cta_active_image' => 'yes/no',
	'rum_post_cta_background_color' => 'color from color picker',
	'rum_post_cta_text_color' => 'color from color picker',
	'rum_post_cta_button_style' => 'button style from Bootstrap',
	'rum_post_cta_button_text' => 'text to appear on button'
);

update_option( 'rum_post_cta_options', $rum_post_cta_options_arr );

/* ----- add color picker that can be used on the Settings screen ----- */

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
		array(
			'jquery-ui-draggable',
			'jquery-ui-slider',
			'jquery-touch-punch'
		),
		false,
		1
	);
}


/* POST CALL TO ACTION META BOX ON POST EDIT SCREEN */

/* ----- add the meta box to post sidebars ----- */

add_action( 'add_meta_boxes', 'post_cta_meta_box_init' );

function post_cta_meta_box_init() {

	$args = array(
		'public'   => true,
		'_builtin' => false
	);

	$post_types = get_post_types( $args, 'names' );

		foreach ( $post_types as $post_type ) {
			echo '<p>' . $post_type . '</p>';
		}

	/*
	 * add a Post Call To Action meta box to New Post and Edit Post screens
	 * use the add_meta_box function
	 * add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args )
	 *
	 */

	add_meta_box(
		'post-cta-meta-box',
		__( 'Post Call to Action', 'post_cta_textdomain'),
		'post_cta_meta_box_init',
		'post',
		'side',
		'high',
		array(
			'post' => $post_types
		)
	);

}


/* DISPLAY POST CALL TO ACTION BOX SINGLE POSTS */

/* ----- insert CTA box below content ----- */

function rum_post_cta_box( $content ) {
	/*
	 * Checks to make sure code executes only on
	 * singles pages and inside of the main Loop
	 *
	 */

	if( is_singular() && is_main_query() ) {

		$rum_post_cta_box = '/includes/display-functions.php' ;
		$content .= $rum_post_cta_box;

	}
	return $content;
}

add_filter( ' the_content', 'rum_post_cta_box' );
