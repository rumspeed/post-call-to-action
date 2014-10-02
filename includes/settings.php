<?php



// Display and fill the form fields for the plugin admin page
function rum_post_cta_options_page() {

	// check permissions and add the screen with the Post Call-to-Action settings
	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not sufficient permission to access this page.' );
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
												<input name="rum_post_cta_options_arr[rum_post_cta_active]" type="checkbox" id="rum_post_cta_active" value="<?php echo esc_attr( $rum_post_cta_options_arr['rum_post_cta_active'] ); ?>"  />
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
										<td><input name="post_cta_button_text" id="post-cta-button-text" type="text" value="<?php echo __( 'Learn more...', 'rum-post-cta-textdomain' ); ?>" class="button-text" /></td>
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