<?php

// Build the settings page
function edit_pano_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new pano!</h2>
<hr>
<style type="text/css">
	#wpfooter{
		display: none;
	}

	#file_input {
	    border: 1px solid #cccccc;
	    padding: 5px;
	}

	.new_pano_form{
		width:85%;
		margin: 0px auto;
	}
</style>
<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>
<form method="post" enctype="multipart/form-data" action="admin-post.php">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_pano" />  
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="pano_name">Pano Name</label>
	    		<input name="pano_name" id="name" placeholder="Cool Pano" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label>Pano Description</label>
	        <textarea name="pano_description" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label>Pano XML</label>
	        <textarea name="pano_xml" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="zip_file">Choose a zip file to upload: </label>
	    	<input id="file_input" type="file" name="pano_zip" required />
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }