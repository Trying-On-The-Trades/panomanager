<?php

// Build the settings page
function edit_quest_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';

    $panos  = get_panos();
	$trades = get_trades();
    $quest  = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $quest = build_quest($_GET['id']);
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
    <div class="updated"><p>Quest updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating quest.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="edit_quest" />
    <input type="hidden" name="quest_id" value="<?php echo $quest->get_id() ?>" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="quest_name">Quest Name</label>
	    		<input name="quest_name" id="name" placeholder="Fun Quest" value="<?php echo $quest->get_name() ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="quest_description">Quest Description</label>
	        <textarea name="quest_description" required ><?php echo $quest->get_description() ?></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="pano_id">Select a Pano</label>
	        <select name="pano_id">
                 <?php foreach($panos as $pano): ?>
                    <option value="<?php echo $pano->id ?>" <?php echo ($pano->id === $quest->get_pano_id()) ? "selected" : "" ?>><?php echo $pano->name ?></option>
                <?php endforeach; ?>
            </select>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="prereq_trade_id">Select a Trade</label>
	        <select name="prereq_trade_id">
                 <?php foreach($trades as $trade): ?>
					 <option value="<?php echo $trade->id ?>" <?php echo ($trade->id === $quest->get_trade_id()) ? "selected" : "" ?>><?php echo $trade->name ?></option>
				 <?php endforeach; ?>
			</select>
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }