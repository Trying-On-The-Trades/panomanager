<?php
  // Build the settings page
  function edit_hotspot_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $missions = get_missions();
  $types	  = get_types();
  $domains	  = get_domains();
  $hotspot  = null;

  if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
    $hotspot = build_hotspot($_GET['id']);
  }

  $hotspot_menu = $hotspot->is_menu_item();
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
  <input type="hidden" name="mission_id" value="<?= $hotspot->get_mission_id() ?>"/>
  <input type="hidden" name="type_id" value="<?= $hotspot->get_type_id() ?>"/>
  <input type="hidden" name="hotspot_domain_id" value="<?= $hotspot->get_domain_id() ?>"/>
  <input type="hidden" name="hotspot_modal_url" id="hotspot_modal_url" value="<?php echo $hotspot->get_modal_url(); ?>" />
  <textarea style="display:none;" name="hotspot_description" > <?php echo $hotspot->get_description() ?> </textarea>
  <textarea style="display:none;" name="hotspot_xml" > <?php echo $hotspot->get_xml() ?> </textarea>
  <textarea style="display:none;" name="hotspot_action_xml" > <?php echo $hotspot->get_action_xml() ?></textarea>
  <div class="ui form segment new_pano_form">
    <div class="ui form">
      <div class="field">
        <label for="hotspot_name">Hotspot Name</label>
        <input type="text" name="hotspot_name" id="name" value="<?php echo $hotspot->get_name() ?>" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_info">Hotspot Info</label>
        <textarea name="hotspot_info" required > <?php echo $hotspot->get_hotspot_info() ?> </textarea>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_menu">
          <input type="checkbox" id="hotspot_menu" name="hotspot_menu" <?= ($hotspot_menu)? 'checked' : '' ?> />
          <span>Show hotspot on the menu</span>
        </label>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_menu_name">Hotspot Menu Text</label>
        <input type="text" name="hotspot_menu_name" id="name" value="<?php echo $hotspot->get_menu_name() ?>" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_points">Hotspot Points</label>
        <input type="number" name="hotspot_points" id="hotspot_points" value="<?php echo $hotspot->get_points() ?>" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_attempts">Maximum number of attempts (0 for unlimited): </label>
        <input type="number" name="hotspot_attempts" id="hotspot_attempts" value="<?php echo $hotspot->get_attempts() ?>" required />
      </div>
    </div>
    <?php submit_button(); ?>
  </div>
</form>

<?php }
