<?php

// Build the settings page
function pano_mission_settings_page() {
    $missions = get_missions();

    $semantic         = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_mission_url  = admin_url() . "admin.php?page=new_mission_settings";
    $edit_missoin_url = admin_url() . "admin.php?page=edit_mission_settings";
    ?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your missions!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
    <div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<h2>Missions</h2>
<table class="ui table segment">
  <tr>
    <th>Mission</th>
    <th>Description</th>
    <th>Language Code</th>
    <th>Quest</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($missions as $mission): ?>

    <tr>
        <td><?php echo $mission->name ?></td>
        <td><?php echo $mission->description ?></td>
        <td><?php echo $mission->language_code ?></td>
        <td><?php echo $mission->quest_name ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_missoin_url ?>&id=<?php echo $mission->mission_id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_mission_form<?php echo $mission->id ?>">
                <!-- pano processing hook -->
                <input type="hidden" name="action" value="delete_mission" />
                <input type="hidden" name="mission_id" value="<?php echo $mission->id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

<?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_mission_url ?>" style="padding: 7px">New Mission</a>
</div>

<?php }