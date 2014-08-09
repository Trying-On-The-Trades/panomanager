<?php

// Build the settings page
function pano_settings_page() {
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $panos = get_panos();

  // New pano url
  $new_pano_url = WP_PLUGIN_URL . "/panomanager/admin/new_pano.php";
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

    <table>
      <th>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
      </th>
      <?php foreach ($panos as $pano): ?>
        
        <tr>
            <td><?php echo $pano->id ?></td>
            <th><?php echo $pano->name ?></th>
            <th><?php echo $pano->description ?></th>
        </tr>

      <?php endforeach; ?>
    </table>

</form>
</div>

<?php }
