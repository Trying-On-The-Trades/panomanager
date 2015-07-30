<?php
// Build the settings page
function edit_pano_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $upload_zip_url  = admin_url() . "admin.php?page=upload_zip_setting";
  $prereqs_url     = admin_url() . "admin.php?page=prereq_edit_setting";
  $pano = null;

if (isset($_GET['id']) && is_numeric( $_GET['id']) ) {
  $pano = build_pano($_GET['id']);
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Edit Pano</h2>
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

<?php if ( isset( $_GET[ 'prereq-settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Pano updated successfully.</p></div>
<?php elseif ( isset( $_GET[ 'error' ] ) ): ?>
<div class="error"><p>Error updating pano.</p></div>
<?php endif; ?>

<form method="post" id="pano_form" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
  <!-- pano processing hook -->
  <input type="hidden" name="action" value="edit_pano" />
  <input type="hidden" name="pano_id" value="<?php echo $pano->get_id(); ?>" />
  <div class="ui form segment new_pano_form">
    <div class="ui form">
      <div class="field">
        <div class="ui left labeled icon input">
          <label for="pano_title">Pano Name</label>
          <input type="text" name="pano_name" id="pano_name" value="<?php echo $pano->get_name(); ?>"/>
          <input type="hidden" name="pano_title" id="pano_title" required value="<?php echo $pano->get_title(); ?>"/>
        </div>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Pano Info</label>
        <textarea name="pano_description" required ><?php echo $pano->get_description(); ?></textarea>
      </div>
    </div>
    <textarea style="display: none;" name="pano_xml" id="pano_xml" required ><?php echo $pano->get_xml(); ?></textarea>
    <div class="ui form">
      <div class="field">
        <label>Change autopan speed to</label>
        <input type="number" name="autopan" id="autopan" placeholder="0" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <input type="checkbox" id="pano_onload" name="pano_onload" checked="<?= ($pano->get_show_desc_onload() == "0") ? false : true ?>"/>
        <label style="display: inline-block;" for="pano_onload">Show the pano info everytime the user loads it</label>
      </div>
    </div>
    <a class="ui blue icon button" href="<?php echo $upload_zip_url ?>&id=<?php echo $pano->get_id() ?>" style="padding: 7px">Upload Zip File</a>
    <a class="ui blue icon button" href="<?php echo $prereqs_url ?>&pano_id=<?php echo $pano->get_id() ?>" style="padding: 7px">Manage Prereqs</a>
    <?php submit_button(); ?>
  </div>
</form>
<script type="text/javascript">
jQuery('#pano_form').submit(function(e){
  change_XML();
});

function change_XML(){
  var xml_string     = jQuery('#pano_xml').val();
  var xmlDoc         = jQuery.parseXML(xml_string);
  var pano_name      = jQuery('#pano_name').val();
  var auto_pan_value = jQuery('#autopan').val();
  var old_element    = null;
  var parent         = null;
  var name           = "";
  var old_auto_pano  = null;
  var auto_pan_xml = xmlDoc.createElement("autorotate");
  auto_pan_xml.setAttribute("enabled","true");
  auto_pan_xml.setAttribute("horizon","13.247107");
  auto_pan_xml.setAttribute("tofov","74.380165");
  auto_pan_xml.setAttribute("waittime","1");
  auto_pan_xml.setAttribute("speed",auto_pan_value);
  var sceneElements = xmlDoc.getElementsByTagName("scene");

  for(var i = 0; i < sceneElements.length; i++){
    name = sceneElements[i].getAttribute("name");
    if(name == pano_name){
      old_element = sceneElements[i];
      old_auto_pano = sceneElements[i].getElementsByTagName("autorotate");
      parent = sceneElements[i].parentNode;
      if(old_auto_pano.length > 0){
        var pan_parent = old_auto_pano[0].parentNode;
        pan_parent.replaceChild(auto_pan_xml, old_auto_pano[0]);
      }else{
        sceneElements[i].appendChild(auto_pan_xml);
      }
      parent.replaceChild(sceneElements[i], old_element);
    }
  }
  xml_string = (new XMLSerializer()).serializeToString(xmlDoc);
  jQuery('#pano_xml').val(xml_string);
}
</script>

<?php }
