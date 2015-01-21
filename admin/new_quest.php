<?php

// Build the settings page
function new_quest_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $panos = get_panos();
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
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_quest" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="quest_name">Quest Name</label>
	    		<input name="quest_name" id="name" placeholder="Fun Quest" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="quest_description">Quest Description</label>
	        <textarea name="quest_description" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="pano_id">Select a Pano</label>
	        <select name="pano_id">
                 <?php foreach($panos as $pano): ?>
                     <option value="<?php echo $pano->id ?>"><?php echo $pano->name ?></option>
                 <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <!-- <div class="ui form">
	      <div class="field">
	        <label for="zip_file">Choose a zip file to upload: </label>
	    	<input id="file_input" type="file" name="pano_zip" />
	      </div>
	    </div> -->
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }