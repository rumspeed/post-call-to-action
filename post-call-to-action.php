<?php
/*
Plugin Name: Post Call to Action
Description: Every page should do something. Display a call to action bar below each blog post.
Version: 0.3.4
Author: Scot Rumery
Author URI: http://rumspeed.com/scot-rumery/
License: GPLv2
*/

/*  Copyright 2015  Scot Rumery (email : scot@rumspeed.com)

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

define( 'RUM_POST_CTA_PLUGIN_VERSION', '0.3.4' );
define( 'RUM_POST_CTA_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'RUM_POST_CTA_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

// include files - these are simply to organize functions into logical areas
include_once( 'includes/helper-functions.php' );
include_once( 'includes/settings.php' );
include_once( 'includes/metabox.php' );
include_once( 'includes/display.php' );






// Hook will fire upon activation - we are using it to set default option values
register_activation_hook( __FILE__, 'rum_post_cta_activate_plugin' );


