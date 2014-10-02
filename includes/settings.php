<?php



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




/* ----- output a list of all registered post types http://codex.wordpress.org/Function_Reference/get_post_types ----- */
function rum_post_cta_association () {

// TODO - get the stored value for this settings option


	// set arguments for get_post_types()
	$args = array(
	   'public'   => true,
        '_builtin' => false
	);

	// get required post types and set into an array
    $post_types = get_post_types( $args, 'names' );

    // include page to the array because it was excluded in the arguments with "_builtin"
    $post_types[page] = 'page';

    foreach ( $post_types as $post_type ) {

// TODO - compare the value stored with the list and add "selected" to the <option> that matches
        $options .= '<option value="' . $post_type . '">' . $post_type . '</option>';
    }

    return $options;
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




/* ----- add color picker that can be used on the Settings screen ----- */
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
add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );




/*
 * POST CALL TO ACTION SETTINGS PAGE
 *
 */
// Display and fill the form fields for the plugin admin page
function rum_post_cta_options_page() {

	// check permissions and add the screen with the Post Call-to-Action settings
	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not sufficient permission to access this page.' );
	}



	// get plugin option array and store in a variable
	$plugin_option_array            = get_option( 'rum_post_cta_plugin_options' );


// DISPLAY ARRAY FOR DEVELOPMENT PURPOSES 
print_r($plugin_option_array);


	// fetch individual values from the plugin option variable array
	$activate_flag      = $plugin_option_array[ 'activate' ];
	$post_type			= $plugin_option_array[ 'post_type' ];


// REMAINING FIELD VALUES FROM ARRAY
//		'featured_image'    => '0',
//		'bg_color'          => '#FFFFFF',
//		'text_color'        => '#A0244E',
//		'button_style'      => '',
//		'button_text'       => 'Learn more...'


	// if activate is checked, set the value for the form field 
	if ( $activate_flag == 1 ) {
		$activate = ' checked';
	}


?>


	<div class="wrap">
		
		<div id="icon-options-general" class="icon32"></div>
	    <!-- Message box -->
	        <div id="message" class="updated">
	            <p><strong><?php _e('Settings saved.') ?></strong></p>
	        </div>
		<h2><?php echo __( 'Post Call to Action', 'rum-post-cta-textdomain' ); ?></h2>

	    <!-- Plugin description -->
		<p><?php echo __( 'Create a relationship from a blog post to another post type for displaying a call-to-action at the bottom
		of each post. Pick a post type to use an a metabox will appear in the post editor with available posts.
		Use for services, portfolios, and even standard pages. Below are the style and option settings related to
		this feature.', 'rum-post-cta-textdomain' ); ?></p>

		<div id="poststuff">
		
			<div id="post-body" class="metabox-holder columns-2">
			
				<!-- main content -->
				<div id="post-body-content">
					
					<div class="meta-box-sortables ui-sortable">
						
						<div class="postbox">

							<h3><span><?php echo __( 'Options', 'rum-post-cta-textdomain' ); ?></span></h3>
							<div class="inside">

							<form name="rum_post_cta_options_form" method="post" action="">
	                        <input type="hidden" name="rum_post_cta_options_form_submitted" value="Y">

							<?php settings_fields( 'rum_post_cta_options' ); ?>
							<?php $rum_post_cta_options = get_option( 'rum_post_cta_options_arr' ); ?>

								<table class="form-table">
									<tr valign="top">
										<td scope="row"><label for="activate_post_call_to_action"><?php echo __( 'Activate "Post Call-to-Action"', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><fieldset>
											<legend class="screen-reader-text"><span><?php echo __( 'Activate "Post Call-to-Action"', 'rum-post-cta-textdomain' ); ?></span></legend>
											<label for="rum_post_cta_active">
												<input name="rum_post_cta_options_arr[rum_post_cta_active]" type="checkbox" id="rum_post_cta_active" value="<?php echo esc_attr( $rum_post_cta_options_arr['rum_post_cta_active'] ); ?>" <?php echo $activate ?>  />
											</label>
										</fieldset></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_type"><?php echo __( 'Post Type for CTA Association', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><select name="rum_post_cta_type" id="rum_post-cta-type">
											<option selected=""><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ) ?></option>
											<?php echo rum_post_cta_association() ?>
										</select></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_image_image"><?php echo __( 'Display Featured Image', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><fieldset>
											<legend class="screen-reader-text"><span><?php echo __( 'Display Featured Image', 'rum-post-cta-textdomain' ); ?></span></legend>
											<label for="rum_post_cta_active_image">
												<input name="rum_post_cta_options_arr[rum_post_active_image]" type="checkbox" id="rum_post_cta_active_image" value="<?php echo esc_attr( $rum_post_cta_options_arr['rum_post_cta_active'] ); ?>"  />
											</label>
										</fieldset></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="background_color"><?php echo __( 'Background Color', 'rum-post-cta-textdomain' ); ?></label></td>
										<td class="post-cta-color-field"><input type="text" name="post_cta_background_color" id="post-cta-background-color" class="color-picker" /></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="text_color"><?php echo __( 'Text Color', 'rum-post-cta-textdomain' ); ?></label></td>
										<td class="post-cta-color-field"><input type="text" name="post-cta-text-color" id="post-cta-text-color" class="color-picker" value="<?php if ( isset ( $rum_post_cta_stored_meta[ 'meta-color'] ) ) echo $rum_post_cta_stored_meta['meta-color'][0]; ?>" /></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="button_style"><?php echo __( 'Button Style', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><select name="post_cta_button_style" id="post-cta-button-style">
											<option selected="selected" value=""><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ); ?></option>
	                                            <?php echo rum_post_cta_button_types() ?>
										</select></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="button_text"><?php echo __( 'Button Text', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><input name="post_cta_button_text" id="post-cta-button-text" type="text" value="<?php echo __( '', 'rum-post-cta-textdomain' ); ?>" class="button-text" /></td>
									</tr>
								</table>

	                            <p class="submit">
	                                <input type="submit" class="button-primary" value="<?php echo __( 'Save Settings', 'rum-post-cta-textdomain' ); ?>" >
	                            </p>

							</form>
							</div> <!-- .inside -->
						
						</div> <!-- .postbox -->
						
					</div> <!-- .meta-box-sortables .ui-sortable -->
					
				</div> <!-- post-body-content -->
				
				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">
					
					<div class="meta-box-sortables">
						
						<div class="postbox">
						
							<h3><span><?php echo __( 'About This Plugin', 'rum-post-cta-textdomain' ); ?></span></h3>
							<div class="inside">
								<p><?php echo __( 'Post Call to Action brought to you by ', 'rum-post-cta-textdomain' ); ?><a href="http://rumspeed.com/">Rumspeed</a>.</p>
								<p><?php echo __( 'Because every page should DO something.', 'rum-post-cta-textdomain' ); ?></p>
							</div> <!-- .inside -->
							
						</div> <!-- .postbox -->
						
					</div> <!-- .meta-box-sortables -->
					
				</div> <!-- #postbox-container-1 .postbox-container -->
				
			</div> <!-- #post-body .metabox-holder .columns-2 -->
			
			<br class="clear">

		</div> <!-- #poststuff -->
		
	</div> <!-- .wrap -->

<?php
}




/* ----- show message at top of Post Call-to-Action Settings screen when settings are saved ----- */
// TODO - this function name may need to be prefixed
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


