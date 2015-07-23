<?php

// Build the settings page
function edit_mission_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';

	$panos    = get_panos();
	$domains   = get_domains();
    $mission = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $mission = build_mission($_GET['id']);
    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit a quest!</h2>
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
    <div class="updated"><p>Mission updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating mission.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="edit_mission" />
    <input type="hidden" name="mission_id" value="<?php echo $mission->get_id() ?>" />
    <input type="hidden" name="quest_id" id="quest_id" value="<?php echo $mission->get_quest_id() ?>" />
	    <div class="ui form">
	      <div class="field">
	        <label for="pano_id">Select a Pano</label>
	        <select name="pano_id" id="pano_id">
                 <?php foreach($panos as $pano): ?>
					<option value="<?php echo $pano->id ?>" data-quest-id="<?php echo $pano->quest_id ?>" <?php echo ($pano->id === $mission->get_pano_id()) ? "selected" : "" ?>><?php echo $pano->name ?></option>
				 <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="prereq_domain_id">Select a domain</label>
	        <select name="domain_id">
				 <option value="NA">...</option>
                 <?php foreach($domains as $domain): ?>
					<option value="<?php echo $domain->id ?>" <?php echo ($domain->id === $mission->get_domain_id()) ? "selected" : "" ?>><?php echo $domain->name ?></option>
				 <?php endforeach; ?>
			</select>
	      </div>
	    </div>
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="misison_name">Mission Name</label>
	    		<input name="mission_name" id="name" placeholder="Fun Mission" value="<?php echo $mission->get_name() ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="misison_description">Mission Info</label>
	        <textarea name="mission_description" required ><?php echo $mission->get_description() ?></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_xml">Mission XML</label>
	        <textarea name="mission_xml" required ><?php echo $mission->get_xml() ?></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="mission_points">Assign Points</label>
	    		<input type="number" name="mission_points" id="mission_points" placeholder="100" value="<?php echo $mission->get_points() ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>

<script>
	jQuery(document).ready(function(){
		jQuery("#pano_id").change(function(){
			var quest_id = jQuery("option:selected", this).attr("data-quest-id");
			jQuery("#quest_id").val(quest_id);
		});
	});
</script>
<?php }