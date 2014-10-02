<?php
/*
 * HELPER FUNCTIONS
 *
 * /

/* ----- add a Post Call-to-Action meta box to New Post and Edit Post sidebars ----- */
function rum_post_cta_activation_check() {

    // initialize variables
    $status             = false;
    $activate_flag      = '';
    $post_type          = '';


    // get plugin option array and store in a variable
    $plugin_option_array            = get_option( 'rum_post_cta_plugin_options' );


    // fetch values from the plugin option variable array
    $activate_flag      = $plugin_option_array[ 'activate' ];
    $post_type          = $plugin_option_array[ 'post_type' ];


    if( $activate_flag != '' && $post_type != '' ) {
        $status = false;
    } else {
        $status = true;
    }

    return $status;
}
