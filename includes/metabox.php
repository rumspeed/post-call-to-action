<?php



/*
 * POST CALL TO ACTION META BOX ON POST EDIT SCREEN
 *
 * /

/* ----- add a Post Call-to-Action meta box to New Post and Edit Post sidebars ----- */
function rum_post_cta_meta_box_init() {

    // get plugin option array and store in a variable
    $plugin_option_array            = get_option( 'rum_post_cta_plugin_options' );


    // fetch individual values from the plugin option variable array
    $activate_flag      = $plugin_option_array[ 'activate' ];
    $post_type          = $plugin_option_array[ 'post_type' ];


    if( $activate_flag != '' && $post_type != '' ) {

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
}
add_action( 'add_meta_boxes', 'rum_post_cta_meta_box_init' );




function rum_post_cta_meta_box_list() {
// https://wordpress.org/support/topic/drop-down-menu-in-posts-metabox-populated-with-values-from-custom-post-type

// TODO - pass through the selected rum_post_cta_association post type ----- */


//    $option = get_option( ‘option_name’ );
//    $option_i_want = $option[‘array_key’};

    $option = get_option( 'rum_post_cta_type' );
//    $rum_post_cta_associated = $option['rum_post_cta_type'];

    var_dump( $option );

    //$rum_post_cta_type = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->options" );

//    $rum_post_cta_options_arr = $wpdb->get_row("SELECT * FROM $wpdb->options WHERE option_name = 'rum_post_cta_options'", ARRAY_A);
//    echo $rum_post_cta_options_arr['option_value'];
    echo '<p>Selected post type is ' . $option . '</p>';

    // The Query
    $the_query = new WP_Query( $rum_post_cta_associated );


    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
// TODO - list the titles of all the posts of that type ----- */
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
        select an available * %s * from the drop down menu.</p>', 'rum-post-cta-text-domain' ), $rum_post_cta_associated );
    // save the selection

};

/* ----- TODO -- save the meta box selection ----- */

