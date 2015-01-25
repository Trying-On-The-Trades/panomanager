<?php

// Build the settings page
function new_hotspot_type_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
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
    <input type="hidden" name="action" value="create_new_hotspot_type" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_type_name">Hotspot Type</label>
            <input type="text" name="hotspot_type_name" id="name" placeholder="Fun Hotspot Type" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_type_description">Hotspot Type Description</label>
	        <textarea name="hotspot_type_description" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_type_xml">Hotspot Type XML</label>
	        <textarea name="hotspot_type_xml" required ></textarea>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_type_js_function">Hotspot Type JS Function</label>
	        <input type="text" name="hotspot_type_js_function" id="hotspot_type_js_function" placeholder="launchImage" value="" required />
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }