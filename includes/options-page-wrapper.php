<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2>Post Call to Action</h2>
	<p>Create a relationship from a blog post to another post type for displaying a call-to-action at the bottom
	of each post. Pick a post type to use an a metabox will appear in the post editor with available posts.
	Use for services, portfolios, and even standard pages. Below are the style and option settings related to
	this feature.</p>

	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-2">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">
					
					<div class="postbox">
					
						<h3><span>Options</span></h3>
						<div class="inside">
							<table class="form-table">
								<tr valign="top">
									<td scope="row"><label for="tablecell">Activate "Post Call-to-Action"</label></td>
									<td><fieldset>
										<legend class="screen-reader-text"><span>Activate "Post Call-to-Action"</span></legend>
										<label for="users_can_register">
											<input name="users_can_register" type="checkbox" id="users_can_register" value="1"  />
										</label>
									</fieldset></td>
								</tr>
								<tr valign="top" class="alternate">
									<td scope="row"><label for="tablecell">Post Type for CTA Association</label></td>
									<td><select name="" id="">
										<option selected="selected" value="">Make a selection...</option>
										<option value="">Posts</option>
										<option value="">Pages</option>
										<option value="">Services</option>
										<option value="">Products</option>
										<option value="">Portfolio</option>
										<option value="">Staff</option>
									</select></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="tablecell">Display Featured Image</label></td>
									<td><fieldset>
										<legend class="screen-reader-text"><span>Display Featured Image</span></legend>
										<label for="users_can_register">
											<input name="users_can_register" type="checkbox" id="users_can_register" value="1"  />
										</label>
									</fieldset></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="tablecell">Background Color</label></td>
									<td class="color-field"><input type="text" value="#bada55" class="my-color-field" data-default-color="#effeff"/></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="tablecell">Text Color</label></td>
									<td class="color-field"><input type="text" value="#bada55" class="my-color-field" data-default-color="#effeff" /></td>
								</tr>
								<tr valign="top">
									<td scope="row"><label for="tablecell">Button Style</label></td>
									<td><select name="" id="">
										<option selected="selected" value="">Make a selection...</option>
										<option value="">Default</option>
										<option value="">Primary</option>
										<option value="">Success</option>
										<option value="">Info</option>
										<option value="">Warning</option>
										<option value="">Danger</option>
										<option value="">Link</option>
									</select></td>
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
					
						<h3><span>About This Plugin</span></h3>
						<div class="inside">
							<p>This plugin is brought to you by <a href="http://rumspeed.com/">Rumspeed</a>.</p>
							<p>Create a relationship from a blog post to another post type for displaying a call-to-action at the bottom
							of each post. Pick a post type to use an a metabox will appear in the post editor with available posts.
							Use for services, portfolios, and even standard pages. Below are the style and option settings related to
							this feature.</p>
						</div> <!-- .inside -->
						
					</div> <!-- .postbox -->
					
				</div> <!-- .meta-box-sortables -->
				
			</div> <!-- #postbox-container-1 .postbox-container -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">

		<form action="options.php" method="post">
			<?php settings_fields('plugin_options'); ?>
			<?php do_settings_sections('plugin'); ?>

			<input class="button" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</form>
	</div> <!-- #poststuff -->
	
</div> <!-- .wrap -->