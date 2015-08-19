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

      // Get string xml and convert
      var xml_hotspot_string    = jQuery('#hotspot_xml').val();
      var xml_hotspot_Doc       = jQuery.parseXML(xml_hotspot_string);

      var xml_action_string    = jQuery('#hotspot_action_xml').val();
      var xml_action_Doc       = jQuery.parseXML(xml_action_string);

      // Get action tag
      var hotspot       = xml_hotspot_Doc.getElementsByTagName("hotspot")[0];
      var hotspot_zoom  = hotspot.getAttribute("zoom");

      hotspot_zoom = (hotspot_zoom == "false" ? false : true);

      $("#hotspot_zoom").prop('checked', hotspot_zoom);

      var hotspot_x     = hotspot.getAttribute("ath");
      $("#hotspot_x").val(hotspot_x);

      var hotspot_y     = hotspot.getAttribute("atv");
      $("#hotspot_y").val(hotspot_y);

      var hotspot_size  = hotspot.getAttribute("width");

      if(hotspot_size == null || hotspot_size == ""){
          hotspot_size = 125;
      }

      jQuery('#hotspot_size').val(hotspot_size);
      jQuery('#hotspot_front_size').val(hotspot_size);

      var action       = xml_action_Doc.getElementsByTagName("action")[0];

      // Get action tag content
      var action_cotent = action.innerHTML;

      // Get url
      var url = action_cotent.substr(3);
      url     = url.substr(url.indexOf("(") + 1);
      url     = url.substr(url.indexOf(",") + 1);
      url     = url.substr(0, url.indexOf(')'));

      var reg       = new RegExp('"', 'g');
      var reg_space = new RegExp(' ', 'g');

      url = url.replace(reg, '');
      url = url.replace(reg_space, '');

      $("#hotspot_url").val(url);


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
        jQuery('#hotspot_size').val(125);
        jQuery('#hotspot_front_size').val(125);
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
    jQuery('#hotspot_front_size').on('input', function(){
      jQuery('#size_value').val(jQuery(this).val());
      jQuery('#hotspot_size').val(jQuery(this).val());
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
    <input type="hidden" name="hotspot_x" id="hotspot_x" value="" />
    <input type="hidden" name="hotspot_y" id="hotspot_y" value="" />
  <input type="hidden" name="hotspot_id" value="<?php echo $hotspot->get_id() ?>" />
  <input type="hidden" name="mission_id" value="<?= $hotspot->get_mission_id() ?>"/>
  <input type="hidden" name="hotspot_domain_id" value="<?= $hotspot->get_domain_id() ?>"/>
  <input type="hidden" id="hotspot_type" name="hotspot_type" value="<?= $hotspot_type ?>" />
  <input type="hidden" id="hotspot_size" name="hotspot_size" value="125" />
  <textarea style="display:none;" name="hotspot_xml" id="hotspot_xml" > <?php echo $hotspot->get_xml() ?> </textarea>
  <textarea style="display:none;" name="hotspot_action_xml" id="hotspot_action_xml"> <?php echo $hotspot->get_action_xml() ?></textarea>
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
        <input type="text" name="hotspot_menu_name" id="name" value="<?php echo $hotspot->get_menu_name() ?>" />
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
        <label for="hotspot_front_size">
          <span>Hotspot size</span>
          <input type="range" id="hotspot_front_size" name="hotspot_front_size" min="1" max="500" step="1" value="125" />
          <output for="hotspot_front_size" id="size_value">125</output>
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
