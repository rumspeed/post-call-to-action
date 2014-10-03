<?php
/*
 * POST CALL TO ACTION META BOX ON POST EDIT SCREEN
 *
 * /




/* ----- add a Post Call-to-Action meta box to New Post and Edit Post sidebars ----- */
function rum_post_cta_meta_box_init() {

    // get activation status
    $activated = rum_post_cta_activation_check();

    if ( $activated ) {

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




/* ----- output the content of the meta box ----- */
function rum_post_cta_meta_box_callback( $post, $box) {

    // retrieve the custom meta box value
    $post_cta_id = get_post_meta( $post->ID, 'rum_post_cta_id', true );

    // nonce for security
    wp_nonce_field( plugin_basename( __FILE__ ), 'rum_post_cta_meta_box_save' );

    // display a dropdown list
    ?>
    <select name="rum_post_cta_id" id="rum_post_cta_id">
        <option><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ) ?></option>
        <?php echo rum_post_cta_meta_box_list() ?>
    </select>
    <?php

    // display text message
    $plugin_option_array = get_option( 'rum_post_cta_plugin_options' );
    $post_cta_post_type  = $plugin_option_array[ 'post_type' ];
    printf( __( '<p>If you would like to display a call-to-action bar at the bottom of your post,
        select an available %s from the drop down menu.</p>', 'rum-post-cta-text-domain' ), $post_cta_post_type );

/* ----- TODO -- save the meta box selection ----- */
    // save the selection

}



// save our metabox data when the post is saved
function rum_post_cta_meta_box_save( $post_id ) {

    if ( isset( $_POST['rum_post_cta_id'] ) ) {

        $post_CTA_id = $_POST['rum_post_cta_id'];

        // if auto saving skip saving our meta box data
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // check nonce for security
        check_admin_referer( plugin_basename( __FILE__ ), 'rum_post_cta_meta_box_save' );

        // save the meta box data as post meta using the post ID as a unique prefix
        update_post_meta( $post_id, 'rum_post_cta_id', $post_CTA_id );
    }
}
add_action( 'save_post', 'rum_post_cta_meta_box_save' );




function rum_post_cta_meta_box_list() {
// https://wordpress.org/support/topic/drop-down-menu-in-posts-metabox-populated-with-values-from-custom-post-type

    global $post;

    // initialize variables
    $options             = '';


    // get plugin option array and store in a variable
    $plugin_option_array = get_option( 'rum_post_cta_plugin_options' );


    // fetch values from the plugin option variable array
    $post_cta_post_type  = $plugin_option_array[ 'post_type' ];


    // set query arguments
    $args = array(
        'post_type' => $post_cta_post_type,
        'nopaging'  => true
    );


    // execute the query
    $cta_post_query = new WP_Query( $args );


    // retrieve the custom meta box value
    $post_cta_id = get_post_meta( $post->ID, 'rum_post_cta_id', true );


    // The Loop
    while ( $cta_post_query->have_posts() ) {
        $cta_post_query->the_post();
        $post_title = get_the_title();
        $post_ID    = get_the_id();
        $options .= '<option value="' . $post_ID . '" ' . selected( $post_cta_id, $post_ID ) .'>' . $post_title . '</option>';
    }


    // restore the global $post variable of the main query loop 
    wp_reset_postdata();


    return $options;
}


