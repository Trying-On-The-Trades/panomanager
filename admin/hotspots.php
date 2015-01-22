<?php

// Build the settings page
function pano_hotspot_settings_page() {
    $hotspots = get_hotspots();

    $semantic         = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_hotspot_url  = admin_url() . "admin.php?page=new_hotspot_settings";
    $edit_hotspot_url = admin_url() . "admin.php?page=edit_hotspot_settings";
    ?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your missions!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="admin_post_pano" />

    <h2>Quests</h2>
    <table class="ui table segment">
      <tr>
        <th>Hotspot</th>
        <th>Menu Name</th>
        <th>Description</th>
        <th>Points</th>
        <th>Attempts</th>
        <th>Mission</th>
        <th>Edit</th>
      </tr>
      <?php foreach ($hotspots as $hotspot): ?>

        <tr>
            <td><?php echo $hotspot->name ?></td>
            <td><?php echo $hotspot->menu_name ?></td>
            <td><?php echo $hotspot->description ?></td>
            <td><?php echo $hotspot->points ?></td>
            <td><?php echo $hotspot->attempts ?></td>
            <td><?php echo $hotspot->mission_name ?></td>
            <td><a class="ui blue icon button" href="<?php echo $edit_hotspot_url ?>&id=<?php echo $hotspot->id ?>" style="padding: 7px">Edit</a></td>
        </tr>

    <?php endforeach; ?>
    </table>
    <a class="ui blue icon button" href="<?php echo $new_hotspot_url ?>" style="padding: 7px">New Mission</a>
</form>
</div>

<?php }