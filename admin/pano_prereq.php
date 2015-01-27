<?php

// Build the settings page
function edit_pano_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $upload_zip_url  = admin_url() . "admin.php?page=upload_zip_setting";
    $pano = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $pano = build_pano($_GET['id']);
    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit Pano</h2>
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
        <div class="updated"><p>Pano updated successfully.</p></div>
    <?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
        <div class="error"><p>Error updating pano.</p></div>
    <?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="edit_pano" />
    <input type="hidden" name="pano_id" value="<?php echo $pano->get_id(); ?>" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="pano_name">Pano Name</label>
	    		<input name="pano_name" id="name" placeholder="Cool Pano" required value="<?php echo $pano->get_name(); ?>"/>
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label>Pano Description</label>
	        <textarea name="pano_description" required ><?php echo $pano->get_description(); ?></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label>Pano XML</label>
	        <textarea name="pano_xml" required ><?php echo $pano->get_xml(); ?></textarea>
	      </div>
	    </div>
	    <a class="ui blue icon button" href="<?php echo $upload_zip_url ?>&id=<?php echo $pano->get_id() ?>" style="padding: 7px">Upload Zip File</a>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }