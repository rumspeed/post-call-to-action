<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php echo __( 'Post Call to Action' ); ?></h2>
	<p><?php echo __( 'Create a relationship from a blog post to another post type for displaying a call-to-action at the bottom
	of each post. Pick a post type to use an a metabox will appear in the post editor with available posts.
	Use for services, portfolios, and even standard pages. Below are the style and option settings related to
	this feature.' ); ?></p>

	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					<form method="post" action="options.php">
					
						<h3><span><?php echo __( 'Options' ); ?></span></h3>
						<div class="inside">
							<table class="form-table">
								<tr valign="top">
									<td scope="row"><label for="activate_post_call_to_action"><?php echo __( 'Activate "Post Call-to-Action"' ); ?></label></td>
									<td><fieldset>
										<legend class="screen-reader-text"><span><?php echo __( 'Activate "Post Call-to-Action"' ); ?></span></legend>
										<label for="users_can_register">
											<input name="users_can_register" type="checkbox" id="users_can_register" value="1"  />
										</label>
									</fieldset></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="post_type_for_cta_association"><?php echo __( 'Post Type for CTA Association' ); ?></label></td>
									<td><select name="post_cta_post_type" id="post-cta-post-type">
										<option selected="selected" value=""><?php echo __( 'Make a selection...' ); ?></option>
										<option value="">Posts</option>
										<option value="">Pages</option>
										<option value="">Services</option>
										<option value="">Products</option>
										<option value="">Portfolio</option>
										<option value="">Staff</option>
									</select></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="display_featured_image"><?php echo __( 'Display Featured Image' ); ?></label></td>
									<td><fieldset>
										<legend class="screen-reader-text"><span><?php echo __( 'Display Featured Image' ); ?></span></legend>
										<label for="users_can_register">
											<input name="users_can_register" type="checkbox" id="users_can_register" value="1"  />
										</label>
									</fieldset></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="background_color"><?php echo __( 'Background Color' ); ?></label></td>
									<td class="post-cta-color-field"><input type="text" name="post_cta_background_color" id="post-cta-background-color" class="color-picker" /></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="text_color"><?php echo __( 'Text Color' ); ?></label></td>
									<td class="post-cta-color-field"><input type="text" name="post-cta-text-color" id="post-cta-text-color" class="color-picker" /></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="button_style"><?php echo __( 'Button Style' ); ?></label></td>
									<td><select name="post_cta_button_style" id="post-cta-button-style">
										<option selected="selected" value=""><?php echo __( 'Make a selection...' ); ?></option>
										<option value="">Default</option>
										<option value="">Primary</option>
										<option value="">Success</option>
										<option value="">Info</option>
										<option value="">Warning</option>
										<option value="">Danger</option>
										<option value="">Link</option>
									</select></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="button_text"><?php echo __( 'Button Text' ); ?></label></td>
									<td><input name="post_cta_button_text" id="post-cta-button-text" type="text" value="<?php echo __( 'Learn more...' ); ?>" class="button-text" /></td>
								</tr>
							</table>
						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				
				<div class="meta-box-sortables">
					
					<div class="postbox">
					
						<h3><span><?php echo __( 'About This Plugin' ); ?></span></h3>
						<div class="inside">
							<p><?php echo __( 'This plugin is brought to you by ' ); ?><a href="http://rumspeed.com/">Rumspeed</a>.</p>
							<p><?php echo __( 'Create a relationship from a blog post to another post type for displaying a call-to-action at the bottom
							of each post. Pick a post type to use an a metabox will appear in the post editor with available posts.
							Use for services, portfolios, and even standard pages. Below are the style and option settings related to
							this feature.' ); ?></p>
						</div> <!-- .inside -->
						
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">

			<?php settings_fields('plugin_options'); ?>
			<?php do_settings_sections('plugin'); ?>

			<?php submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
		</form>
	</div> <!-- #poststuff -->
	
</div> <!-- .wrap -->