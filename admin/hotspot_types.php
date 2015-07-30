<?php

// Build the settings page
function pano_hotspot_type_settings_page() {

    $semantic              = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $hotspot_types         = get_types();
    $new_hotspot_type_url  = admin_url() . "admin.php?page=new_hotspot_type_settings";
    $edit_hotspot_type_url = admin_url() . "admin.php?page=edit_hotspot_type_settings";
    ?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your missions!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>

<div>
    <h2>Hotspot Types</h2>
</div>
<table class="ui table segment">
  <tr>
    <th>Type</th>
    <th>Info</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($hotspot_types as $hotspot_type): ?>

    <tr>
        <td><?php echo $hotspot_type->name ?></td>
        <td><?php echo $hotspot_type->description ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_hotspot_type_url ?>&id=<?php echo $hotspot_type->id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_hotspot_type_form<?php echo $hotspot_type->id ?>">
                <!-- pano processing hook -->
                <input type="hidden" name="action" value="delete_hotspot_type" />
                <input type="hidden" name="hotspot_type_id" value="<?php echo $hotspot_type->id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

<?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_hotspot_type_url ?>" style="padding: 7px">New Hotspot Type</a>
</div>

<?php }
