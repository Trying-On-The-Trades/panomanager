<?php

//Build the points page
function edit_points_info_settings_page(){
  $semantic =  WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
  <h2>Edit the name of your points!</h2>
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
      <div class="updated"><p>Points info updated successfully.</p></div>
  <?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
      <div class="error"><p>Error updating points info.</p></div>
  <?php endif; ?>
  <p>
    'Points' is a dull word. You can change it to be whatever you want! What about earning dollars?
  </p>
  <p>
    You can assign a currency symbol, a name to be displayed in the singular and plural forms, for example:
  </p>
  <ul>
    <li>
      Symbol: $
    </li>
    <li>
      Name (singular): dollar
    </li>
    <li>
      Name (plural): dollars
    </li>
  </ul>
  <form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <input type="hidden" name="action" value="update_points_info" />
    <div class="ui form">
      <div class="field">
        <label for="symbol">Symbol: </label>
        <input name="symbol" id="symbol" placeholder="Edit the symbol of your currency (optional)" value="<?= get_points_symbol() ?>" />
      </div>
      <div class="field">
        <label for="singular">Name (singular): </label>
        <input name="singular" id="singular" placeholder="Edit the singular name of your currency" value="<?= get_points_name_singular() ?>" />
      </div>
      <div class="field">
        <label for="plural">Name (plural): </label>
        <input name="plural" id="plural" placeholder="Edit the plural name of your currency" value="<?= get_points_name_plural() ?>" />
      </div>
    </div>
    <?php submit_button(); ?>
  </form>
<?php }
