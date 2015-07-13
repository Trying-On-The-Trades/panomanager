<?php

// Build the settings page
function edit_item_type_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $item_type    = null;

    if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
        $item_type = build_item_type($_GET['id']);
    }
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit your item type!</h2>
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
    <div class="updated"><p>Item type updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating item type.</p></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">

    <input type="hidden" name="action" value="edit_item_type" />
    <input type="hidden" name="item_type_id" value="<?php echo $item_type->get_id(); ?>" />
    <div class="ui form segment new_item_type_form">
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="item_type_name">Item Type Name</label>
	    		<input name="item_type_name" id="name" placeholder="Name" value="<?php echo $item_type->get_name(); ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <div class="ui form">
	      <div class="field">
	      	<div class="ui left labeled icon input">
	        	<label for="item_type_description">Item Type Description</label>
	    		<input name="item_type_description" id="description" placeholder="Description" value="<?php echo $item_type->get_description(); ?>" required />
     	 	</div>
	      </div>
	    </div>
	    <?php submit_button(); ?>
	</div>
</form>
</div>
<?php }