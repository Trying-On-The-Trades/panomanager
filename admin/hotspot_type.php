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

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="admin_post_pano" />

    <div>
        <h2>Hotspot Types</h2>
    </div>
    <table class="ui table segment">
      <tr>
        <th>Hotspot Type</th>
        <th>Description</th>
        <th>JS Function</th>
        <th>Edit</th>
      </tr>
      <?php foreach ($hotspot_types as $hotspot_type): ?>

        <tr>
            <td><?php echo $hotspot_type->name ?></td>
            <td><?php echo $hotspot_type->description ?></td>
            <td><?php echo $hotspot_type->js_function ?></td>
            <td><a class="ui blue icon button" href="<?php echo $edit_hotspot_type_url ?>&id=<?php echo $hotspot_type->id ?>" style="padding: 7px">Edit</a></td>
        </tr>

    <?php endforeach; ?>
    </table>
    <a class="ui blue icon button" href="<?php echo $new_hotspot_type_url ?>" style="padding: 7px">New Hotspot Type</a>
</form>
</div>

<?php }