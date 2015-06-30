<?php

// Build the settings page
function new_item_type_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new item type!</h2>
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
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_item_type" />
    <div class="ui form segment new_item_type_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="item_type_name">Item Type Name</label>
	    		<input name="item_type_name" id="name" placeholder="Name" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="item_type_description">Item Type Description</label>
	    		<input name="item_type_description" id="description" placeholder="Description" required />
     	 	</div>
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }