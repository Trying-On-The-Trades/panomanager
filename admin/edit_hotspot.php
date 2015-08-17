<?php
  // Build the settings page
  function edit_hotspot_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $missions = get_missions();
  $types	  = get_types();
  $domains	  = get_domains();
  $hotspot  = null;
  $show_type_edit = false;

  if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
    $hotspot = build_hotspot($_GET['id']);
  }

  $hotspot_menu = $hotspot->is_menu_item();
  $hotspot_type_id = $hotspot->get_type_id();
  $hotspot_type_row = get_hotspot_type($hotspot_type_id);
  $hotspot_type = $hotspot_type_row->name;

  if(($hotspot_type == "website") || ($hotspot_type == "image") || ($hotspot_type == "video") || ($hotspot_type == "oppia")){
    $show_type_edit = true;
  }
?>

<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
<script type="text/javascript">
  jQuery('#form').ready(function(){
    // Hiding oppia id on startup
    jQuery('#oppia_input').hide();

    // Displaying oppia id or hotspot url input
    //  according to radio button selection
    jQuery('.url_type').change(function(){
      if(jQuery('#oppia').is(':checked')){
        jQuery('#hotspot_url').val('');
        jQuery('#website_input').hide();
        jQuery('#oppia_input').show();
        jQuery('#oppia_id').focus();
      } else {
        jQuery('#oppia_id').val('');
        jQuery('#oppia_input').hide();
        jQuery('#website_input').show();
        jQuery('#hotspot_url').focus();
      }
    });

    // Changing hotspot type value
    //  according to user selection
    jQuery('.url_type').change(function(){
      if(jQuery('#website').is(':checked')){
        jQuery('#hotspot_type').val('website');
      }
      else if(jQuery('#image').is(':checked')){
        jQuery('#hotspot_type').val('image');
      }
      else if(jQuery('#video').is(':checked')){
        jQuery('#hotspot_type').val('video');
      }
      else if(jQuery('#oppia').is(':checked')){
        jQuery('#hotspot_type').val('oppia');
      } else {
        jQuery('#hotspot_type').val('url');
      }
    });

    // Displaying hotspot zoom if user chooses
    //  visible hotspot
    jQuery('#hotspot_icon').change(function(){
      if(jQuery(this).is(':checked')){
        jQuery('#zoom_input').show();
        jQuery('#size_input').show();
      } else {
        jQuery('#hotspot_zoom').prop('checked', false);
        jQuery('#zoom_input').hide();
        jQuery('#size_value').val(125);
        jQuery('#size_input').hide();
      }
    });

    // Displaying hotspot menu name input
    //  if user chooses to be visible
    jQuery('#hotspot_menu').change(function(){
      if(jQuery(this).is(':checked')){
        jQuery('#menu_name_input').show();
      } else{
        jQuery('#hotspot_menu_name').val('');
        jQuery('#menu_name_input').hide();
      }
    });

    // Updating hotspot size value according to slide
    jQuery('#hotspot_size').on('input', function(){
      jQuery('#size_value').val(jQuery(this).val());
    });
  });
</script>
<h2>Edit a Hotspot!</h2>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Hotspot updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
<div class="error"><p>Error updating hotspot.</p></div>
<?php endif; ?>

<form id="form" method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
  <!-- pano processing hook -->
  <input type="hidden" name="action" value="edit_hotspot" />
  <input type="hidden" name="hotspot_id" value="<?php echo $hotspot->get_id() ?>" />
  <input type="hidden" name="mission_id" value="<?= $hotspot->get_mission_id() ?>"/>
  <input type="hidden" name="hotspot_domain_id" value="<?= $hotspot->get_domain_id() ?>"/>
  <input type="hidden" id="hotspot_type" name="hotspot_type" value="<?= $hotspot_type ?>" />
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

    <?php if($show_type_edit): ?>
    <p>Type of URL</p>
    <div class="ui form">
      <div class="field">
        <label for="website">
          <input type="radio" class="url_type" name="url_type" id="website" value="website" <?= ($hotspot_type == 'website')? 'checked' : '' ?> />
          <span>Website</span>
        </label>
        <label for="image">
          <input type="radio" class="url_type" name="url_type" id="image" value="image" <?= ($hotspot_type == 'image')? 'checked' : '' ?> />
          <span>Image</span>
        </label>
        <label for="video">
          <input type="radio" class="url_type" name="url_type" id="video" value="video" <?= ($hotspot_type == 'video')? 'checked' : '' ?> />
          <span>Video</span>
        </label>
        <label for="oppia">
          <input type="radio" class="url_type" name="url_type" id="oppia" value="oppia" <?= ($hotspot_type == 'oppia')? 'checked' : '' ?> />
          <span>Oppia</span>
        </label>
      </div>
    </div>
    <div id="website_input" class="ui form">
      <div class="field">
        <label for="hotspot_url">Hotspot URL</label>
        <input type="text" id="hotspot_url" name="hotspot_url" />
      </div>
    </div>
    <div id="oppia_input" class="ui form">
      <div class="field">
        <label for="oppia_id">Oppia ID</label>
        <input type="text" id="oppia_id" name="oppia_id" />
      </div>
    </div>
    <?php endif; ?>

    <div class="ui form">
      <div class="field">
        <label for="hotspot_points">Hotspot Points</label>
        <input type="number" name="hotspot_points" id="hotspot_points" value="<?php echo $hotspot->get_points() ?>" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="hotspot_icon">
          <input type="checkbox" id="hotspot_icon" name="hotspot_icon" checked />
          <span>Make hotspot icon visible</span>
        </label>
      </div>
    </div>
    <div id="size_input" class="ui form">
      <div class="field">
        <label for="hotspot_size">
          <span>Hotspot size</span>
          <input type="range" id="hotspot_size" name="hotspot_size" min="1" max="500" step="1" value="125" />
          <output for="hotspot_size" id="size_value">125</output>
          <span> px</span>
        </label>
      </div>
    </div>
    <div id="zoom_input" class="ui form">
      <div class="field">
        <label for="hotspot_zoom">
          <input type="checkbox" id="hotspot_zoom" name="hotspot_zoom" checked />
          <span>Hotspot icon zoom with panorama</span>
        </label>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="max_attempts">Maximum number of attempts (0 for unlimited)</label>
        <input type="number" name="max_attempts" id="max_attempts" value="<?php echo $hotspot->get_attempts() ?>" required />
      </div>
    </div>
    <?php submit_button(); ?>
  </div>
</form>

<?php }
