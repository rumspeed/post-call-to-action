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

function rum_post_cta_register_settings() {
	/*
	 * register the Post CTA Settings to be saved to the database
	 * use the register_setting function
	 * register_setting( $option_group, $option_name, $sanitize_callback )
	 *
	 */
	register_setting(
		'rum-post-cta-options',
		'rum_post_cta_section',
		'rum_post_cta_sanitize_options'
	);


	add_settings_section(
		'rum_post_cta_section',
		'Options',
		'rum_post_cta_section',
		'settings'
	);

// add_settings_field( $id, $title, $callback, $page, $section, $args );

	add_settings_field(
		'rum_post_cta_active',              // $id - used in CSS
		'Activate Post Call to Action',     // $title - displayed on settings page
		'rum_post_cta_setting_active',      // $callback - URL slug
		'settings'                          // $page -
	);

	add_settings_field(
		'rum_post_cta_type',
		'Post Type for CTA Association',
		'rum_post_cta_setting_type',
		'settings'
	);

	add_settings_field(
		'rum_post_cta_active_image',
		'Display Featured Image',
		'rum_post_cta_setting_active_image',
		'settings'
	);

	add_settings_field(
		'rum_post_cta_background_color',
		'Background Color',
		'rum_post_cta_background_color',
		'settings'
	);

	add_settings_field(
		'rum_post_cta_text_color',
		'Text Color',
		'rum_post_cta_text_color',
		'settings'
	);

	add_settings_field(
		'rum_post_cta_button_style',
		'Button Style',
		'rum_post_cta_button_style',
		'settings'
	);

	add_settings_field(
		'rum_post_cta_button_text',
		'Button Text',
		'rum_post_cta_button_text',
		'settings'
	);

}
//$rum_post_cta_options_arr = array(
//	'rum_post_cta_active' => 'yes/no',
//	'rum_post_cta_type' => 'post type for cta association',
//	'rum_post_cta_active_image' => 'yes/no',
//	'rum_post_cta_background_color' => 'color from color picker',
//	'rum_post_cta_text_color' => 'color from color picker',
//	'rum_post_cta_button_style' => 'button style from Bootstrap',
//	'rum_post_cta_button_text' => 'text to appear on button'
//);

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

add_action( 'add_meta_boxes', 'rum_post_cta_meta_box_init' );

function rum_post_cta_meta_box_init() {

//	$args = array(
//		'public'   => true,
//		'_builtin' => false
//	);
//
//	$post_types = get_post_types( $args, 'names' );
//
//		foreach ( $post_types as $post_type ) {
//			echo '<p>' . $post_type . '</p>';
//		}
//
//    $rum_post_cta_meta_box_message = __('<p>If you would like to display a call-to-action bar at the bottom
//			of your post, select an available <strong>post_type</strong> post from the dropdown menu.</p>', 'meta_box_message');

	/*
	 * add a Post Call To Action meta box to New Post and Edit Post screens
	 * use the add_meta_box function
	 * add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args )
	 *
	 */

	add_meta_box(
		'rum_post-cta-meta-box',                                    // $id
		__( 'Post Call to Action', 'rum_post_cta_textdomain'),      // $title
        'rum_post_cta_meta_box_callback',                           // $callback
		'post',                                                     // $page
		'side',                                                     // $context
		'high'                                                      // $priority
//		'rum_post_cta_meta_box_callbac_argsk'                       // $callback_args
	);

    /* ----- outputs the content of the meta box ----- */
    function rum_post_cta_meta_box_callback( $post ){
        echo '<?php get_post_type(); ?>';
        echo '<p>If you would like to display a call-to-action bar at the bottom of your post,
            select an available post_type from the dropdown menu.</p>';
    };

// https://wordpress.org/support/topic/drop-down-menu-in-posts-metabox-populated-with-values-from-custom-post-type

//    $args = array(
//        'post_type' => 'post_type_you_want_there',
//        'nopaging' => true
//    );
//
//    $query = new WP_Query( $args );
//
//    echo 'select name="posttype';
//
//    while ( $the_query -> have_posts() ) : $the_query -> the_post();
//        echo '<option value="'.$post -> ID.'">';
//        the_title();
//        echo '</option>';
//    endwhile;
//
//    echo '</select>';
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
