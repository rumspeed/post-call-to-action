<?php
/*
Plugin Name: Post Call to Action
Description: Every page should do something. Display a call to action bar below each blog post.
Version: 0.2.0
Author: Scot Rumery
Author URI: http://rumspeed.com/scot-rumery/
License: GPLv2
*/

/*  Copyright 2014  Scot Rumery (email : scot@rumspeed.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'RUM_POST_CTA_PLUGIN_VERSION', '0.2.0' );
define( 'RUM_POST_CTA_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'RUM_POST_CTA_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

// include files - these are simply to organize functions into logical areas
// include_once( 'includes/settings.php' );
// include_once( 'includes/display-functions.php' );


/*
 * POST CALL TO ACTION SETTINGS PAGE
 *
 */

/* ----- add a link to the plugin in the admin menu under 'Settings > Post CTA' ----- */

function rum_post_cta_menu() {

	// add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function )
	add_options_page(
		'Post Call to Action',
		'Post CTA',
		'manage_options',
		'rum-post-cta',
		'rum_post_cta_options_page'
	);

}

add_action( 'admin_menu', 'rum_post_cta_menu' );

/* ----- check permissions and add the screen with the Post Call-to-Action settings ----- */

function rum_post_cta_options_page() {

	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not sufficient permission to access this page.' );
	}

	require( 'includes/settings.php' );

}

/* ----- register the Post CTA options that will be saved to the database from the Settings page ---- */

function rum_post_cta_register_settings() {

    // register_setting( $option_group, $option_name, $sanitize_callback )
	register_setting(
		'rum-post-cta-options',
		'rum_post_cta_section',
		'rum_post_cta_sanitize_options'
	);

    // add_settings_section( $id, $title, $callback, $page )
	add_settings_section(
		'rum_post_cta_section',
		'Options',
		'rum_post_cta_section',
		'settings'
	);

    // add_settings_field( $id, $title, $callback, $page, $section, $args )
	add_settings_field(
		'rum_post_cta_active',              // $id - used in CSS
		'Activate Post Call to Action',     // $title - displayed on settings page
		'rum_post_cta_setting_active',      // $callback - URL slug
		'settings'                          // $page - the page to display the field on
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

// define setting options array for storage in the options database table
$rum_post_cta_options_arr = array(

    $rum_post_cta_options_arr['rum_post_cta_active']            = $rum_post_cta_active,
    $rum_post_cta_options_arr['rum_post_cta_type']              = $rum_post_cta_type,
    $rum_post_cta_options_arr['rum_post_cta_active_image']      = $rum_post_cta_active_image,
    $rum_post_cta_options_arr['rum_post_cta_background_color']  = $rum_post_cta_background_color,
    $rum_post_cta_options_arr['rum_post_cta_text_color']        = $rum_post_cta_text_color,
    $rum_post_cta_options_arr['rum_post_cta_button_style']      = $rum_post_cta_button_style,
    $rum_post_cta_options_arr['rum_post_cta_button_text']       = $rum_post_cta_button_text

);

update_option( 'rum_post_cta_options', $rum_post_cta_options_arr );

// if there are options stored in the database, retrieve the options from the array ( use get_option() )
$rum_post_cta_options_arr = get_option( 'rum_post_options_arr' );

    if( $rum_post_cta_options_arr != "" ) {

        $rum_post_cta_active            = $rum_post_cta_options_arr['rum_post_cta_active'];
        $rum_post_cta_type              = $rum_post_cta_options_arr['rum_post_cta_type'];
        $rum_post_cta_active_image      = $rum_post_cta_options_arr['rum_post_cta_active_image'];
        $rum_post_cta_background_color  = $rum_post_cta_options_arr['rum_post_cta_background_color'];
        $rum_post_cta_text_color        = $rum_post_cta_options_arr['rum_post_cta_text_color'];
        $rum_post_cta_button_style      = $rum_post_cta_options_arr['rum_post_cta_button_style'];
        $rum_post_cta_button_text       = $rum_post_cta_options_arr['rum_post_cta_button_text'];

    }

// check to see if form already submitted
//if( isset( $_POST['rum_post_cta_options_form_submitted'] ) ) {
//
//    $hidden_field = esc_html( $_POST['rum_post_cta_options_form_submitted'] );
//
//    if( $hidden_field == 'Y' ) {
//
//        $rum_post_cta_active = $_POST['rum_post_cta_active'] ;
//        $rum_post_cta_type = $_POST['rum_post_cta_type'];
//        $rum_post_cta_active_image = $_POST['rum_post_cta_active_image'];
//        $rum_post_cta_background_color = $_POST['rum_post_cta_background_color'];
//        $rum_post_cta_text_color = $_POST['rum_post_cta_text_color'];
//        $rum_post_cta_button_style = $_POST['rum_post_cta_button_style'];
//        $rum_post_cta_button_text = esc_html( $_POST['rum_post_cta_button_text'] );
//
//        echo $rum_post_cta_active;
//        echo $rum_post_cta_type;
//        echo $rum_post_cta_active_image;
//        echo $rum_post_cta_background_color;
//        echo $rum_post_cta_text_color;
//        echo $rum_post_cta_button_style;
//        echo $rum_post_cta_button_text;
//
//    }
//
//}

/* ----- TODO - have activate checkbox control whether or not meta box appears on New Post and Edit Post pages ----- */

/* ----- output a list of all registered post types http://codex.wordpress.org/Function_Reference/get_post_types ----- */

function rum_post_cta_association () {

	// set arguments for get_post_types()
	$args = array(
	   'public'   => true,
        '_builtin' => false
	);

    $post_types = get_post_types( $args, 'names' );

    foreach ( $post_types as $post_type ) {

        $options .= '<option value="' . $post_type . '">' . $post_type . '</option>';
    }

    // include page as a post type because it was excluded in the arguments with "_builtin"
    $options .= '<option value="page">page</option>';

    return $options;
}

// TODO - get the stored value for this settings option
// TODO - compare the value stored with the list and add "selected" to the <option> that matches

/* ----- add color picker that can be used on the Settings screen ----- */

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );

function wp_enqueue_color_picker( ) {

	// add the color picker css file
	wp_enqueue_style( 'wp-color-picker' );

	// include the custom jQuery file with WordPress Color Picker dependency
	wp_enqueue_script(
		'wp-color-picker-script',
		plugins_url( 'js/jquery.custom.js', __FILE__ ),
		array( 'wp-color-picker' ),
		false,
		true
	);

	// include the Iris color picker
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

/* ----- populate the button style drop down with Bootstrap button styles ----- */

function rum_post_cta_button_types() {
    $button_types = array(
        'Default',
        'Primary',
        'Success',
        'Info',
        'Warning',
        'Danger',
        'Link'
    );

    foreach ( $button_types as $button_type ) {
        $buttons .= '<option value"' . $button_type . '">' . $button_type . '</option>';
    }

    return $buttons;
}

/* ----- show message at top of Post Call-to-Action Settings screen when settings are saved ----- */

function change( $data ) {

    $message = null;
    $type = null;

    if ( null != $data ) {

        if ( false === get_option( 'myOption' ) ) {

            add_option( 'myOption', $data );
            $type = 'updated';
            $message = __( 'Successfully saved', 'rum-post-cta-text-domain' );

        } else {

            update_option( 'myOption', $data );
            $type = 'updated';
            $message = __( 'Successfully updated', 'rum-post-cta-text-domain' );

        }

    } else {

        $type = 'error';
        $message = __( 'Data can not be empty', 'rum_post-cta-text-domain' );

    }

    add_settings_error(
        'rum_post_cta_settings_error',
        esc_attr( 'settings_updated' ),
        $message,
        $type
    );

}


/*
 * POST CALL TO ACTION META BOX ON POST EDIT SCREEN
 *
 * /

/* ----- add a Post Call-to-Action meta box to New Post and Edit Post sidebars ----- */

add_action( 'add_meta_boxes', 'rum_post_cta_meta_box_init' );

function rum_post_cta_meta_box_init() {

    // add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args )
    add_meta_box(
        'rum_post-cta-meta-box',                                    // $id
        __('Post Call to Action', 'rum-post-cta-textdomain'),       // $title
        'rum_post_cta_meta_box_callback',                           // $callback
        'post',                                                     // $page
        'side',                                                     // $context
        'high'                                                      // $priority
    //	'rum_post_cta_meta_box_callback_args'                       // $callback_args
    );
}


// https://wordpress.org/support/topic/drop-down-menu-in-posts-metabox-populated-with-values-from-custom-post-type

/* ----- TODO - pass through the selected rum_post_cta_association post type ----- */

/* ----- TODO - list the titles of all the posts of that type ----- */

function rum_post_cta_meta_box_list() {

    // The Query
    $the_query = new WP_Query( 'rum_post_cta_type' );

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul> in the loop.';
    } else {
        // no posts found
    }
    // restore original post data
    wp_reset_postdata();

}

add_action( 'register_sidebar_widget', 'rum_post_cta_meta_box_list' );

/* ----- output the content of the meta box ----- */

function rum_post_cta_meta_box_callback() {

    // display a dropdown list
    ?>
    <select name="rum_post_cta_selection" id="rum_post-cta-selection">
        <option selected=""><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ) ?></option>
        <?php echo rum_post_cta_meta_box_list() ?>
    </select>
    <?php

    // populate that list with items from the selected post type
    $rum_post_cta_options = get_option( 'rum_post_cta_options_arr' );
    // display text message
    printf( __( '<p>If you would like to display a call-to-action bar at the bottom of your post,
        select an available %s from the drop down menu.</p>', 'rum-post-cta-text-domain' ), $rum_post_cta_association );
    // save the selection

};

/* ----- TODO -- save the meta box selection ----- */


/*
 * DISPLAY POST CALL TO ACTION BOX SINGLE POSTS
 *
 */

/* ----- insert CTA box below content ----- */

function rum_post_cta_box( $content ) {

	// checks to make sure code executes only on singles pages and inside of the main Loop
	if( is_singular() && is_main_query() ) {

		$rum_post_cta_box = '/includes/display-functions.php' ;
		$content .= $rum_post_cta_box;

	}
	return $content;
}

add_filter( ' the_content', 'rum_post_cta_box' );
