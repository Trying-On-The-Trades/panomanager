<?php
require('db.php');
    $db        = database_connection();
    $pano_id   = $_GET['pano_id'];
    $missions  = get_missions($db, $pano_id);
    $domains   = get_domains($db);
    $semantic  = "../wp-content/plugins/panomanager/css/semantic.css";
    $point_x   = $_GET['point_x'];
    $point_y   = $_GET['point_y'];
    $deck_id   = $_GET['deck_id'];

    if($deck_id){
        $game_type = get_deck_type($db, $deck_id);
    }else{
        $game_type = "url";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2 class="title" >Create a new hotspot!</h2>
<hr>
<!--<style type="text/css">-->
<!--	.new_pano_form{-->
<!--		width:85%;-->
<!--		margin: 0px auto;-->
<!--	}-->
<!--</style>-->
<body>
<form method="post" enctype="multipart/form-data" action="../wp-content/plugins/panomanager/hotspot-editor/action.php">
    <!-- pano processing hook -->
    <input type="hidden" name="action" value="create_new_hotspot" />
    <input type="hidden" name="point_x" value="<?=$point_x?>" />
    <input type="hidden" name="point_y" value="<?=$point_y?>" />
    <input type="hidden" name="deck_id" value="<?=$deck_id?>" />
    <input type="hidden" name="game_type" value="<?=$game_type?>" />
    <input type="hidden" name="pano_id" value="<?=$pano_id?>" />
    <div class="ui form segment new_pano_form">
	    <div class="ui form">
	      <div class="field">
	        <label for="mission_id">Select a Mission</label>
	        <select name="mission_id">
                <option value="NA">Select a mission</option>
                 <?php foreach($missions as $mission): ?>
                    <option value="<?php echo $mission['id'] ?>"><?php echo $mission['name']  ?></option>
                 <?php endforeach; ?>
            </select>
	      </div>
	    </div>

        <div class="ui form">
	      <div class="field">
	        <label for="hotspot_domain_id">Select a Domain</label>
	        <select name="hotspot_domain_id">
				 <option value="NA">Select a domain</option>
                 <?php foreach($domains as $domain): ?>
                    <option value="<?php echo $domain['id'] ?>"><?php echo $domain['name'] ?></option>
                <?php endforeach; ?>
			</select>
	      </div>
	    </div>

	    <div class="ui form">
	      <div class="field">
	        <label for="hotspot_description">Hotspot Description</label>
	        <textarea rows="4" name="hotspot_description" required ></textarea>
	      </div>
	    </div>

        <div class="ui form">
            <div class="field">
                <label for="hotspot_menu_name">Hotspot Menu Text</label>
                <input type="text" name="hotspot_menu_name" required />
            </div>
        </div>

        <?php if($game_type == "url"): ?>

            <div class="ui form">
                <div class="field">
                    <label for="hotspot_url">Hotspot Url</label>
                    <input type="text" name="hotspot_url" required />
                </div>
            </div>

            <div class="ui form">
                <div class="field">
                    <label for="url_type">Type of url</label>
                    <input type="radio" name="url_type" value="website">Website<br>
                    <input type="radio" name="url_type" value="image">Image
                </div>
            </div>

        <?php endif; ?>

        <div class="ui form">
            <div class="field">
                <label for="hotspot_points">Hotspot Points</label>
                <input type="text" name="hotspot_points" required />
            </div>
        </div>

        <div class="ui form">
          <div class="field">
            <input type="checkbox" name="hotspot_icon" checked="true" />Apply image to hotspot
          </div>
        </div>

        <div class="ui form">
            <div class="field">
                <input type="checkbox" name="hotspot_menu" checked="true" />Show hotspot on the menu
            </div>
        </div>

        <div class="ui form">
            <div class="field">
                <input type="submit"  value="Save Changes" class="ui blue icon button" />
            </div>
        </div>
</form>
</div>
</body>
</html>
