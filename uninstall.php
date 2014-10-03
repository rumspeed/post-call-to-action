<?php

	// If uninstall not called from WordPress exit

	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	
		exit();
	
	}
	
	// Delete settings page options from options table
	delete_option( 'rum_post_cta_plugin_options' );


// TODO - remove the meta_key 'rum_post_cta_id' that is stored on EACH blog post from the custom metabox

