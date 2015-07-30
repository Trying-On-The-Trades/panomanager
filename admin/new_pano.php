<?php
// Build the settings page
function new_pano_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>

<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Create a new pano!</h2>
<hr>
<style type="text/css">
  .new_pano_form{
    width:85%;
    margin: 0px auto;
  }
</style>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form id="pano_form" method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
  <!-- pano processing hook -->
  <input type="hidden" name="action" value="create_new_pano" />
  <div class="ui form segment new_pano_form">
    <div class="ui form">
      <div class="field">
        <div class="ui left labeled icon input">
          <label for="pano_name">Pano Name</label>
          <input type="text" name="pano_name" id="pano_name" />
        </div>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label for="pano_title">Pano Title</label>
        <input type="text" name="pano_title" id="pano_title" />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Pano Info</label>
        <textarea name="pano_description" required ></textarea>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Pano XML</label>
        <textarea name="pano_xml" id="pano_xml" required ></textarea>
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <label>Autopan - speed</label>
        <input type="number" name="autopan" id="autopan" placeholder="0" required />
      </div>
    </div>
    <div class="ui form">
      <div class="field">
        <input type="checkbox" id="pano_onload" name="pano_onload"/>
        <label style="display: inline-block;" for="pano_onload">Show the pano info everytime the user loads it</label>
      </div>
    </div>
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
