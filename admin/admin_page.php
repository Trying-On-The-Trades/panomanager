<?php

// Build the settings page
function pano_settings_page() {
  
    $panos = get_panos();

    // Create urls
    $semantic      = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_pano_url  = admin_url() . "admin.php?page=new_pano_settings";
    $edit_pano_url = admin_url() . "admin.php?page=edit_pano_settings";
?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Welcome to pano manager!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<form method="post" action="admin-post.php">

    <!-- pano processing hook -->
    <input type="hidden" name="action" value="admin_post_pano" />

    <h2>Panos</h2>
    <table class="ui table segment">
      <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Edit</th>
      </tr>
      <?php foreach ($panos as $pano): ?>
        
        <tr>
            <td><?php echo $pano->name ?></td>
            <td><?php echo $pano->description ?></td>
            <td><a class="ui blue icon button" href="<?php echo $edit_pano_url ?>&id=<?php echo $pano->id ?>" style="padding: 7px">Edit</a></td>
        </tr>

      <?php endforeach; ?>
    </table>
    <a class="ui blue icon button" href="<?php echo $new_pano_url ?>" style="padding: 7px">New Pano</a>

</form>
</div>

<?php }
