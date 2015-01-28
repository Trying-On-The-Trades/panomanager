<?php

// Build the settings page
function pano_hotspot_settings_page() {
    $hotspots = get_hotspots();

    $semantic         = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $hotspot_types    = admin_url() . "admin.php?page=pano_hotspot_type_settings";
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

<div>
    <h2>Hotspots</h2>
</div>
<table id="hostpotTable" class="ui table segment tablesorter">
    <thead>
      <tr>
        <th>Hotspot</th>
        <th>Menu Name</th>
        <th>Description</th>
        <th>Points</th>
        <th>Attempts</th>
        <th>Type</th>
        <th>Mission</th>
        <th>Trade</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>

    <tbody>
        <?php foreach ($hotspots as $hotspot): ?>
            <?php $current_hotspot = build_hotspot($hotspot->id); ?>
            <tr>
                <td><?php echo $current_hotspot->get_name(); ?></td>
                <td><?php echo $current_hotspot->get_menu_name(); ?></td>
                <td><?php echo $current_hotspot->get_description(); ?></td>
                <td><?php echo $current_hotspot->get_points(); ?></td>
                <td><?php echo $current_hotspot->get_attempts(); ?></td>
                <td><?php echo $current_hotspot->get_type_name(); ?></td>
                <td><?php echo $current_hotspot->get_mission_name(); ?></td>
                <td><?php echo $current_hotspot->get_trade_name(); ?></td>
                <td><a class="ui blue icon button" href="<?php echo $edit_hotspot_url ?>&id=<?php echo $current_hotspot->get_id(); ?>" style="padding: 7px">Edit</a></td>
                <td>
                    <form method="post" action="admin-post.php" id="delete_hotspot_form<?php echo $current_hotspot->get_id(); ?>">
                        <!-- pano processing hook -->
                        <input type="hidden" name="action" value="delete_hotspot" />
                        <input type="hidden" name="hotspot_id" value="<?php echo $current_hotspot->get_id(); ?>" />

                        <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a class="ui blue icon button" href="<?php echo $new_hotspot_url ?>" style="padding: 7px">New Hotspot</a>
<a class="ui blue icon button" href="<?php echo $hotspot_types ?>" style="padding: 7px">Manage Hotspot Type</a>
</div>

<script>
    jQuery(document).ready(function(){
        jQuery("#hostpotTable").tablesorter();
    })
</script>


<?php }