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




// Use Settings API to whitelist options
function rum_post_cta_settings_api_init() {

	register_setting( 'rum_post_cta_option_group', 'rum_post_cta_plugin_options', 'rum_post_cta_sanitize_options' );
}
add_action( 'admin_init', 'rum_post_cta_settings_api_init');




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

	// initialize variables
	$options                   = '';


	// get plugin option array and store in a variable
	$plugin_option_array       = get_option( 'rum_post_cta_plugin_options' );


	// fetch individual values from the plugin option variable array
	$cta_post_type             = $plugin_option_array[ 'post_type' ];


	// escape data
	$cta_post_type             = esc_attr( $cta_post_type );


	// set arguments for get_post_types()
	$args = array(
	   'public'   => true,
        '_builtin' => false
	);

	// get required post types and set into an array
    $post_types = get_post_types( $args, 'names' );

    // include page to the array because it was excluded in the arguments with "_builtin"
    $post_types['page'] = 'page';

    foreach ( $post_types as $post_type ) {

        $options .= '<option value="' . esc_attr( $post_type ) . '" ' . selected( $cta_post_type, $post_type ) .'>' . $post_type . '</option>';
    }

    return $options;
}




/* ----- populate the button style drop down with Bootstrap button styles ----- */
function rum_post_cta_button_types() {

	// initialize variables
	$buttons                   = '';


	// get plugin option array and store in a variable
    $plugin_option_array    = get_option( 'rum_post_cta_plugin_options' );


	// fetch individual values from the plugin option variable array
    $cta_button_types       = $plugin_option_array[ 'button_style' ];


	// escape data
	$cta_button_types       = esc_attr( $cta_button_types );


    $button_types = array(
        'default',
        'primary',
        'success',
        'info',
        'warning',
        'danger',
        'link'
    );

    foreach ( $button_types as $button_type ) {
        $buttons .= '<option value"' . esc_attr( $button_type ) . '" ' . selected( $cta_button_types, $button_type ) . '>' . $button_type . '</option>';
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
		RUM_POST_CTA_PLUGIN_URI . '/js/jquery.custom.js',
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


	// fetch individual values from the plugin option variable array
	$activate_flag      = $plugin_option_array[ 'activate' ];
	$post_type			= $plugin_option_array[ 'post_type' ];
    $featured_image     = $plugin_option_array[ 'featured_image' ];
    $bg_color           = $plugin_option_array[ 'bg_color' ];
    $text_color         = $plugin_option_array[ 'text_color' ];
    $button_style       = $plugin_option_array[ 'button_style' ];
    $button_text        = $plugin_option_array[ 'button_text' ];


	// if activate is checked, set the value for the form field 
	if ( $activate_flag == 1 ) {
		$activate = ' checked';
	}

?>

	<div class="wrap">
		
		<div id="icon-options-general" class="icon32"></div>
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
							<form name="rum_post_cta_options_form" method="post" action="options.php">
<?php 
settings_fields( 'rum_post_cta_option_group' );
do_settings_sections( 'rum-post-cta' );
?>								
								<table class="form-table">
									<tr valign="top">
										<td scope="row"><label for="activate_post_call_to_action"><?php echo __( 'Activate "Post Call-to-Action"', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><fieldset>
											<legend class="screen-reader-text"><span><?php echo __( 'Activate "Post Call-to-Action"', 'rum-post-cta-textdomain' ); ?></span></legend>
											<label for="rum_post_cta_active">
												<input name="rum_post_cta_plugin_options[activate]" type="checkbox" value="1" <?php checked( '1', $activate_flag ); ?> />
											</label>
										</fieldset></td>
									</tr>
									<tr valign="top">
										<td colspan="2"><hr></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_type"><?php echo __( 'Post Type for CTA Association', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><select name="rum_post_cta_plugin_options[post_type]">
												<option value=""><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ) ?></option>
												<?php echo rum_post_cta_association() ?>
										</select></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_image"><?php echo __( 'Display Featured Image', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><fieldset>
											<legend class="screen-reader-text"><span><?php echo __( 'Display Featured Image', 'rum-post-cta-textdomain' ); ?></span></legend>
											<label for="rum_post_cta_featured_image">
												<input name="rum_post_cta_plugin_options[featured_image]" type="checkbox" value="1" <?php checked( '1', $featured_image ); ?> />
											</label>
										</fieldset></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_background_color"><?php echo __( 'Background Color', 'rum-post-cta-textdomain' ); ?></label></td>
										<td class="post-cta-color-field"><input type="text" name="rum_post_cta_plugin_options[bg_color]" class="color-picker" value="<?php echo esc_attr( $bg_color ); ?>" /></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_text_color"><?php echo __( 'Text Color', 'rum-post-cta-textdomain' ); ?></label></td>
										<td class="post-cta-color-field"><input type="text" name="rum_post_cta_plugin_options[text_color]" class="color-picker" value="<?php echo esc_attr( $text_color ); ?>" /></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="rum_post_cta_button_types"><?php echo __( 'Button Style', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><select name="rum_post_cta_plugin_options[button_style]">
												<option value=""><?php echo __( 'Make a selection...', 'rum-post-cta-textdomain' ); ?></option>
                                                <?php echo rum_post_cta_button_types() ?>
										</select></td>
									</tr>
									<tr valign="top">
										<td scope="row"><label for="button_text"><?php echo __( 'Button Text', 'rum-post-cta-textdomain' ); ?></label></td>
										<td><input type="text" name="rum_post_cta_plugin_options[button_text]" class="button-text" value="<?php echo esc_attr( $button_text ); ?>" /></td>
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


function rum_post_cta_sanitize_options( $input ) {

	// start with clear array
	$valid = array();


	// validation/sanitize
	$valid['activate']          = $input['activate'];
	$valid['post_type']         = $input['post_type'];
	$valid['featured_image']    = $input['featured_image'];
	$valid['bg_color']          = rum_post_cta_validate_color( $input['bg_color'] );
	$valid['text_color']        = rum_post_cta_validate_color( $input['text_color'] );
	$valid['button_style']      = $input['button_style'];
	$valid['button_text']       = sanitize_text_field( $input['button_text'] );


	// return array
	return $valid;
}
