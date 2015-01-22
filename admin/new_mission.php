<?php

// Build the settings page
function new_mission_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $quests = get_quests();
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
    <input type="hidden" name="action" value="create_new_mission" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="mission_name">Mission Name</label>
	    		<input type="text" name="mission_name" id="name" placeholder="Fun Mission" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_description">Mission Description</label>
	        <textarea name="mission_description" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_xml">Mission XML</label>
	        <textarea name="mission_xml" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="quest_id">Select a Quest</label>
	        <select name="quest_id">
                 <?php foreach($quests as $quest): ?>
                    <option value="<?php echo $quest->quest_id ?>"><?php echo $quest->name ?></option>
                <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="mission_points">Assign Points</label>
	    		<input type="number" name="mission_points" id="mission_points" placeholder="100" required />
     	 	</div>
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