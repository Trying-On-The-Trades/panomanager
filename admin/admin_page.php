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

<h2>Panos</h2>
<table id="panoTable" class="ui table segment tablesorter">
    <thead>
      <tr>
          <th>Title</th>
          <th>Pano Info</th>
          <th>Prereq Points</th>
          <th>Edit</th>
          <th>Delete</th>
      </tr>
    </thead>

    <tbody>
        <?php foreach ($panos as $pano): ?>
            <?php $prereq = get_pano_prereq($pano->id); ?>
            <tr>
                <td><?php echo $pano->title ?></td>
                <td><?php echo $pano->description ?></td>
                <td>
                    <?php echo $prereq->prereq_pts; ?>
                </td>
                <td><a class="ui blue icon button" href="<?php echo $edit_pano_url ?>&id=<?php echo $pano->pano_id ?>" style="padding: 7px">Edit</a></td>
                <td>
                    <form method="post" action="admin-post.php" id="delete_pano_form<?php echo $pano->pano_id ?>">
                        <!-- pano processing hook -->
                        <input type="hidden" name="action" value="delete_pano" />
                        <input type="hidden" name="pano_id" value="<?php echo $pano->pano_id ?>" />

                        <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<a class="ui blue icon button" href="<?php echo $new_pano_url ?>" style="padding: 7px">New Pano</a>
</div>

<script>
    jQuery(document).ready(function(){
        jQuery("#panoTable").tablesorter();
    })
</script>
<?php }
