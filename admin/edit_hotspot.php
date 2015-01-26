<?php

// Build the settings page
function edit_hotspot_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';

    $missions = get_missions();
	$types	  = get_types();
    $hotspot  = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $hotspot = build_hotspot($_GET['id']);
    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit a Hotspot!</h2>
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
    <div class="updated"><p>Hotspot updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating hotspot.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="edit_hotspot" />
    <input type="hidden" name="hotspot_id" value="<?php echo $hotspot->get_id() ?>" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_id">Select a Mission</label>
	        <select name="mission_id">
                 <?php foreach($missions as $mission): ?>
                     <option value="<?php echo $mission->mission_id ?>" <?php echo ($mission->mission_id === $hotspot->get_mission_id()) ? "selected" : "" ?>><?php echo $mission->name ?></option>
                 <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_name">Hotspot Name</label>
            <input type="text" name="hotspot_name" id="name" placeholder="Fun Hotspot" value="<?php echo $hotspot->get_name() ?>" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_menu_name">Hotspot Menu Name</label>
            <input type="text" name="hotspot_menu_name" id="name" placeholder="Find Hotspot" value="<?php echo $hotspot->get_menu_name() ?>" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_description">Hotspot Description</label>
	        <textarea name="hotspot_description" required > <?php echo $hotspot->get_description() ?> </textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_xml">Hotspot XML</label>
	        <textarea name="hotspot_xml" required > <?php echo $hotspot->get_xml() ?> </textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_action_xml">Hotspot Action XMl</label>
	        <textarea name="hotspot_action_xml" required > <?php echo $hotspot->get_action_xml() ?></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_points">Points</label>
            <input type="number" name="hotspot_points" id="hotspot_points" placeholder="10" value="<?php echo $hotspot->get_points() ?>" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_attempts">Attempts</label>
            <input type="number" name="hotspot_attempts" id="hotspot_attempts" placeholder="1" value="<?php echo $hotspot->get_attempts() ?>" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="type_id">Select a Type</label>
	        <select name="type_id">
                 <?php foreach($types as $type): ?>
					 <option value="<?php echo $type->id ?>" <?php echo ($type->id === $hotspot->get_type_id()) ? "selected" : "" ?>><?php echo $type->name ?></option>
				 <?php endforeach; ?>
			</select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_modal_url">Hotspot Modal Url</label>
	        <input type="text" name="hotspot_modal_url" id="hotspot_modal_url" placeholder="" value="<?php echo $hotspot->get_modal_url(); ?>" required />
	      </div>
	    </div>
		<?php submit_button(); ?>
	</div>
</form>
</div>
<?php }