<?php

// Build the settings page
function edit_hotspot_type_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';

    $hotspot_type  = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $hotspot_type = build_hotspot_type($_GET['id']);
    }
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
    <input type="hidden" name="action" value="edit_hotspot_type" />
    <input type="hidden" name="hotspot_type_id" value="<?php echo $hotspot_type->get_id(); ?>" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
            <label for="hotspot_type_name">Hotspot Type</label>
            <input type="text" name="hotspot_type_name" id="name" placeholder="Fun Hotspot Type" value="<?php echo $hotspot_type->get_name(); ?>" required />
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_type_description">Hotspot Type Info</label>
	        <textarea name="hotspot_type_description" required ><?php echo $hotspot_type->get_description(); ?></textarea>
	      </div>
	    </div>
      <textarea style="display: none;" name="hotspot_type_xml" ><?php echo $hotspot_type->get_xml(); ?></textarea>
      <input style="display: none;" type="text" name="hotspot_type_js_function" id="hotspot_type_js_function" placeholder="launchImage" value="<?php echo $hotspot_type->get_type_js_function(); ?>" />
	    <?php submit_button(); ?>
	</div>
</form>

<?php }
