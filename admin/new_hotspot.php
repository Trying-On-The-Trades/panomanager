<?php

// Build the settings page
function new_hotspot_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $missions = get_missions();
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new hotspot!</h2>
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
    <input type="hidden" name="action" value="create_new_hotspot" />
    <input type="hidden" name="type_id" value="1" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_id">Select a Mission</label>
	        <select name="mission_id">
                 <?php foreach($missions as $mission): ?>
                    <option value="<?php echo $mission->mission_id ?>"><?php echo $mission->name ?></option>
                 <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_name">Hotspot Name</label>
            <input type="text" name="hotspot_name" id="name" placeholder="Fun Hotspot" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_menu_name">Hotspot Menu Name</label>
            <input type="text" name="hotspot_menu_name" id="name" placeholder="Find Hotspot" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_description">Hotspot Description</label>
	        <textarea name="hotspot_description" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_xml">Hotspot XML</label>
	        <textarea name="hotspot_xml" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_action_xml">Hotspot Action XMl</label>
	        <textarea name="hotspot_action_xml" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_points">Points</label>
            <input type="number" name="hotspot_points" id="hotspot_points" placeholder="10" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_attempts">Attempts</label>
            <input type="number" name="hotspot_attempts" id="hotspot_attempts" placeholder="1" required />
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }