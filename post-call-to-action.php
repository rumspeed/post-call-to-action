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
include_once( 'includes/settings.php' );
include_once( 'includes/metabox.php' );
include_once( 'includes/display.php' );






// Hook will fire upon activation - we are using it to set default option values
register_activation_hook( __FILE__, 'rum_post_cta_activate_plugin' );

// Add options and populate default values on first load
function rum_post_cta_activate_plugin() {

	// populate plugin options array
	$rum_post_cta_plugin_options = array(

		'activate'          => '0',
		'post_type'         => '',
		'featured_image'    => '0',
		'bg_color'          => '#FFFFFF',
		'text_color'        => '#A0244E',
		'button_style'      => '',
		'button_text'       => 'Learn more...'
		);

	// create field in WP_options to store all plugin data in one field
	add_option( 'rum_post_cta_plugin_options', $rum_post_cta_plugin_options );

}




///* ----- register the Post CTA options that will be saved to the database from the Settings page ---- */
//
//function rum_post_cta_register_settings() {
//
//    // register_setting( $option_group, $option_name, $sanitize_callback )
//	register_setting(
//		'rum-post-cta-options',
//		'rum_post_cta_section',
//		'rum_post_cta_sanitize_options'
//	);
//
//    // add_settings_section( $id, $title, $callback, $page )
//	add_settings_section(
//		'rum_post_cta_section',
//		'Options',
//		'rum_post_cta_section',
//		'settings'
//	);
//
//    // add_settings_field( $id, $title, $callback, $page, $section, $args )
//	add_settings_field(
//		'rum_post_cta_active',              // $id - used in CSS
//		'Activate Post Call to Action',     // $title - displayed on settings page
//		'rum_post_cta_setting_active',      // $callback - URL slug
//		'settings'                          // $page - the page to display the field on
//	);
//
//	add_settings_field(
//		'rum_post_cta_type',
//		'Post Type for CTA Association',
//		'rum_post_cta_setting_type',
//		'settings'
//	);
//
//	add_settings_field(
//		'rum_post_cta_active_image',
//		'Display Featured Image',
//		'rum_post_cta_setting_active_image',
//		'settings'
//	);
//
//	add_settings_field(
//		'rum_post_cta_background_color',
//		'Background Color',
//		'rum_post_cta_background_color',
//		'settings'
//	);
//
//	add_settings_field(
//		'rum_post_cta_text_color',
//		'Text Color',
//		'rum_post_cta_text_color',
//		'settings'
//	);
//
//	add_settings_field(
//		'rum_post_cta_button_style',
//		'Button Style',
//		'rum_post_cta_button_style',
//		'settings'
//	);
//
//	add_settings_field(
//		'rum_post_cta_button_text',
//		'Button Text',
//		'rum_post_cta_button_text',
//		'settings'
//	);
//
//}

//// define setting options array for storage in the options database table
//$rum_post_cta_options_arr = array(
//
//    $rum_post_cta_options_arr['rum_post_cta_active']            = $rum_post_cta_active,
//    $rum_post_cta_options_arr['rum_post_cta_type']              = $rum_post_cta_type,
//    $rum_post_cta_options_arr['rum_post_cta_active_image']      = $rum_post_cta_active_image,
//    $rum_post_cta_options_arr['rum_post_cta_background_color']  = $rum_post_cta_background_color,
//    $rum_post_cta_options_arr['rum_post_cta_text_color']        = $rum_post_cta_text_color,
//    $rum_post_cta_options_arr['rum_post_cta_button_style']      = $rum_post_cta_button_style,
//    $rum_post_cta_options_arr['rum_post_cta_button_text']       = $rum_post_cta_button_text
//
//);
//
//update_option( 'rum_post_cta_options', $rum_post_cta_options_arr );

//// if there are options stored in the database, retrieve the options from the array ( use get_option() )
//$rum_post_cta_options_arr = get_option( 'rum_post_cta_options_arr' );
//
//    if( $rum_post_cta_options_arr != "" ) {
//
//        $rum_post_cta_active            = $rum_post_cta_options_arr['rum_post_cta_active'];
//        $rum_post_cta_type              = $rum_post_cta_options_arr['rum_post_cta_type'];
//        $rum_post_cta_active_image      = $rum_post_cta_options_arr['rum_post_cta_active_image'];
//        $rum_post_cta_background_color  = $rum_post_cta_options_arr['rum_post_cta_background_color'];
//        $rum_post_cta_text_color        = $rum_post_cta_options_arr['rum_post_cta_text_color'];
//        $rum_post_cta_button_style      = $rum_post_cta_options_arr['rum_post_cta_button_style'];
//        $rum_post_cta_button_text       = $rum_post_cta_options_arr['rum_post_cta_button_text'];
//
//    }

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

//var_dump( $rum_post_cta_options_arr );



