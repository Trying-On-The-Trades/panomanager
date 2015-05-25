<?php

// Build the settings page
function edit_mission_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    
    $words    = get_words();

	$trades   = get_trades();

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $words = build_words($_GET['id']);
    }

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit a word!</h2>
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
    <div class="updated"><p>Dictionary updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating dictionary.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="edit_words" />
	    <div class="ui form">
	      <div class="field">
	        <label for="prereq_trade_id">Select a Trade</label>
	        <select name="trade_id">
				 <option value="NA">...</option>
                 <?php foreach($trades as $trade): ?>
					<option value="<?php echo $trade->id ?>" <?php echo ($trade->id === $words->get_trade_id()) ? "selected" : "" ?>><?php echo $trade->name ?></option>
				 <?php endforeach; ?>
			</select>
	      </div>
	    </div>
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="words_name">Word Name</label>
	    		<input name="words_name" id="name" placeholder="Fun Mission" value="<?php echo $words->get_word() ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="words_hint">Hint</label>
	        <textarea name="words_hint" required ><?php echo $words->get_hint() ?></textarea>
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