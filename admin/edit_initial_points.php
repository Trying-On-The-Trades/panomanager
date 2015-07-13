<?php

function edit_initial_points_settings_page(){
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
  <h2>Edit the initial amount of points</h2>
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
    <div class="updated"><p>Initial points updated successfully.</p></div>
  <?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
    <div class="error"><p>Error updating initial points.</p></div>
  <?php endif; ?>
  <p>
    Choose the quantity of starting points for each user.
  </p>
  <form method="POST" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <input type="hidden" name="action" value="update_initial_points" />
    <div class="ui form">
      <div class="field">
        <div class="ui left labeled icon input">
          <label for="quantity">Initial Points Quantity: </label>
          <input name="quantity" id="quantity" placeholder="Edit the initial quantity of points" value="<?= get_points_initial_bonus() ?>"/>
        </div>
      </div>
    </div>
    <?php submit_button(); ?>
  </form>
<?php }
