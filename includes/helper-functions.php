<?php
/*
 * HELPER FUNCTIONS
 *
 */



// set the activation flag for use in metabox.php and display.php
function rum_post_cta_activation_check() {

    // initialize variables
    $status             = FALSE;
    $activate_flag      = '';
    $post_type          = '';


    // get plugin option array and store in a variable
    $plugin_option_array = get_option( 'rum_post_cta_plugin_options' );


    // fetch values from the plugin option variable array
    if ( isset( $plugin_option_array[ 'activate' ] ) ) {
        $activate_flag      = $plugin_option_array[ 'activate' ];
    }
    if ( isset( $plugin_option_array[ 'post_type' ] ) ) {
        $post_type          = $plugin_option_array[ 'post_type' ];
    }


    // set the flag for use in metabox.php and display.php
    if( $activate_flag != '' && $post_type != '' ) {
        $status = TRUE;
    } else {
        $status = FALSE;
    }

    return $status;
}




// validate a hex color
function rum_post_cta_validate_color( $color ) {

    // initialize variables
    $valid_color = '';

    // must start with '#' and have 6 characters including a-f and 0-9
    if(preg_match('/^#[a-f0-9]{6}$/i', $color) ) { //hex color is valid 

        // data is a valid color
        $valid_color = $color;
    } else {

        // fallback color
        $valid_color = '#ffffff';
    }

    return $valid_color;
}
