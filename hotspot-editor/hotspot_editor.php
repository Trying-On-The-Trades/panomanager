<?php
require('db.php');

$db           = database_connection();
$pano_id      = $_GET['pano_id'];
$missions     = get_missions($db, $pano_id);
$domains      = get_domains($db);
$semantic     = "../wp-content/plugins/panomanager/css/semantic.css";
$point_x      = $_GET['point_x'];
$point_y      = $_GET['point_y'];
$deck_id      = $_GET['deck_id'];
$item_id      = $_GET['item_id'];
$mission_id   = $pano_id;
$hotspot_type = "";

if($deck_id){
  $game_type = get_deck_type($db, $deck_id);
  $hotspot_type = "game";
}else if($item_id) {
  $game_type = "item";
  $hotspot_type = "item";
}else{
  $game_type = "url";
  $hotspot_type = "url";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title style="display: none;">Hotspot Editor</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
    <style style="display: none;">
      h2, hr, p, span{
        color: #555;
      }
      form .ui label{
        display: block;
        cursor: pointer;
      }
    </style>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script style="display: none;" type="text/javascript">
      // Hiding oppia id on startup
      jQuery('#form').ready(function(){
        jQuery('#oppia_input').hide();
      });

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
    </script>
  </head>
  <body>
    <h2 class="title" >Create a new hotspot!</h2>
    <hr>
    <form id="form" method="post" enctype="multipart/form-data" action="../wp-content/plugins/panomanager/hotspot-editor/action.php">
      <!-- pano processing hook -->
      <input type="hidden" name="action" value="create_new_hotspot" />
      <input type="hidden" name="point_x" value="<?=$point_x?>" />
      <input type="hidden" name="point_y" value="<?=$point_y?>" />
      <input type="hidden" name="deck_id" value="<?=$deck_id?>" />
      <input type="hidden" name="game_type" value="<?=$game_type?>" />
      <input type="hidden" name="item_id" value="<?= $item_id ?>" />
      <input type="hidden" name="pano_id" value="<?=$pano_id?>" />
      <input type="hidden" name="mission_id" value="<?= $mission_id ?>" />
      <input type="hidden" name="hotspot_domain_id" value="NA" />
      <input type="hidden" id="hotspot_type" name="hotspot_type" value="<?= $hotspot_type ?>" />
      <input type="hidden" id="hotspot_size" name="hotspot_size" value="125" />
      <div class="ui form segment new_pano_form">
        <div class="ui form">
          <div class="field">
            <label for="hotspot_name">Hotspot Name</label>
            <input type="text" id="hotspot_name" name="hotspot_name" required />
          </div>
        </div>
        <div class="ui form">
          <div class="field">
            <label for="hotspot_info">Hotspot Info</label>
            <textarea rows="4" id="hotspot_info" name="hotspot_info" required ></textarea>
          </div>
        </div>
        <div class="ui form">
          <div class="field">
            <label for="hotspot_menu">
              <input type="checkbox" id="hotspot_menu" name="hotspot_menu" checked />
              <span>Show hotspot on the menu</span>
            </label>
          </div>
        </div>
        <div id="menu_name_input" class="ui form">
          <div class="field">
            <label for="hotspot_menu_name">Hotspot Menu Text</label>
            <input type="text" id="hotspot_menu_name" name="hotspot_menu_name" />
          </div>
        </div>

        <?php if($game_type == "url"): ?>
        <p>Type of URL</p>
        <div class="ui form">
          <div class="field">
            <label for="website">
              <input type="radio" class="url_type" name="url_type" id="website" value="website" />
              <span>Website</span>
            </label>
            <label for="image">
              <input type="radio" class="url_type" name="url_type" id="image" value="image" />
              <span>Image</span>
            </label>
            <label for="video">
              <input type="radio" class="url_type" name="url_type" id="video" value="video" />
              <span>Video</span>
            </label>
            <label for="oppia">
              <input type="radio" class="url_type" name="url_type" id="oppia" value="oppia" />
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
            <input type="text" id="hotspot_points" name="hotspot_points" required />
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
            <label for="hotspot_points">Maximun number of attempts (0 for unlimited)</label>
            <input type="text" id="max_attempts" name="max_attempts" value="0" required />
          </div>
        </div>
        <div class="ui form">
          <div class="field">
            <input type="submit"  value="Save Changes" class="ui blue icon button" />
          </div>
        </div>
      </div>
    </form>
  </body>
</html>
