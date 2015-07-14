<?php

// Build the settings page
function view_panos_settings_page() {
    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $pano_editor = WP_PLUGIN_URL . '../pano_editor/';
    $game_id = $_POST['game_id'];
    $panos = get_pano_title();

    ?>
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<h2>Choose a Pano</h2>
<hr>

<form id="form" method="post" enctype="multipart/form-data" action="<?php echo get_admin_url() . 'admin-post.php' ?>">
    <input type="hidden" name="action" value="create_new_spotgame" />
    <div class="ui form segment new_word_form">

       <div class="ui form">
        <div class="field">
            <label>Choose a deck:</label>
            <select name="panos" id="pano_id">
				 <option value="NA">Select a Pano</option>

                 <?php foreach($panos as $pano):  ?>

                        <option value="<?= $pano->id ?>"><?= $pano['title']  ?></option>

                <?php endforeach; ?>
            </select>
        </div>
       </div>

	    <p class="error" id="pano_not_selected">* Select one Pano</p>

	    <a class="ui blue icon button" onclick="go_to_panorama()" style="padding: 7px">Create Hotspot</a>
	</div>
</form>
</div>

<script>
    function go_to_panorama(){
        var selected = document.getElementById("pano_id").value;

        if(user_selected_one_pano(selected)){
            document.getElementById("pano_not_selected").style.display = "none";
            var game_id = "<?php echo $game_id ?>";
            if(game_id == "" || game_id == null){
                window.location.href = "<?php echo $pano_editor ?>" + "/?pano_id=" + selected;
            }else{
                window.location.href = "<?php echo $pano_editor ?>" + "/?game_id=<?php echo $game_id ?>&pano_id=" + selected;
            }

        }else{
            document.getElementById("pano_not_selected").style.display = "block";
        }
    }

    function user_selected_one_pano(selected){
        if(selected == "NA"){
            return false;
        }else{
            return true;
        }
    }

</script>
<?php }