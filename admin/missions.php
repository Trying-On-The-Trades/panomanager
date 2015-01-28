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
<table id="missionTable" class="ui table segment tablesorter">
    <thead>
      <tr>
        <th>Mission</th>
        <th>Description</th>
        <th>Language Code</th>
        <th>Pano</th>
        <th>Trade</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>

    <tbody>
        <?php foreach ($missions as $mission): ?>
            <?php $current_mission = build_mission($mission->mission_id); ?>
            <tr>
                <td><?php echo $current_mission->get_name() ?></td>
                <td><?php echo $current_mission->get_description() ?></td>
                <td><?php echo $current_mission->get_language() ?></td>
                <td><?php echo $mission->pano_name ?></td>
                <td><?php echo $current_mission->get_trade_name() ?></td>
                <td><a class="ui blue icon button" href="<?php echo $edit_missoin_url ?>&id=<?php echo $current_mission->get_id() ?>" style="padding: 7px">Edit</a></td>
                <td>
                    <form method="post" action="admin-post.php" id="delete_mission_form<?php echo $current_mission->get_id() ?>">
                        <!-- pano processing hook -->
                        <input type="hidden" name="action" value="delete_mission" />
                        <input type="hidden" name="mission_id" value="<?php echo $current_mission->get_id() ?>" />

                        <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a class="ui blue icon button" href="<?php echo $new_mission_url ?>" style="padding: 7px">New Mission</a>
</div>

<script>
    jQuery(document).ready(function(){
        jQuery("#missionTable").tablesorter();
    })
</script>

<?php }