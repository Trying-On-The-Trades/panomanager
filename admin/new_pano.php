<?php

// Build the settings page
function new_pano_settings_page() {
	$semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new pano!</h2>
<hr>
<style type="text/css">
	.new_pano_form{
		width:85%;
		margin: 0px auto;
	}
</style>
<script type="text/javascript">


</script>
<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>
<form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
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
	        <label>Autopan - speed</label>
	        <input type="number" name="autopan" placeholder="0" required />
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>

<?php }