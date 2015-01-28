<?php

// Build the settings page
function new_mission_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
	$panos    = get_panos();
	$trades   = get_trades();
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
    <input type="hidden" name="quest_id" id="quest_id" value="<?php echo $panos[0]->quest_id ?>" />
    <div class="ui form segment new_mission_form">
	    <div class="ui form">
	      <div class="field">
	        <label for="pano_id">Select a Pano</label>
	        <select id="pano_id" name="pano_id">
                 <?php foreach($panos as $pano): ?>
					<option value="<?php echo $pano->id ?>" data-quest-id="<?php echo $pano->quest_id ?>"><?php echo $pano->name ?></option>
				 <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="trade_id">Select a Trade</label>
	        <select name="trade_id">
				 <option value="NA">...</option>
                 <?php foreach($trades as $trade): ?>
					<option value="<?php echo $trade->id ?>"><?php echo $trade->name ?></option>
				 <?php endforeach; ?>
			</select>
	      </div>
	    </div>
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
	      	<div class="ui left labeled icon input">
	        	<label for="mission_points">Assign Points</label>
	    		<input type="number" name="mission_points" id="mission_points" placeholder="100" required />
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