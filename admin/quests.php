<?php

// Build the settings page
function pano_quest_settings_page() {
    $quests = get_quests();

    $semantic       = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_quest_url  = admin_url() . "admin.php?page=new_quest_settings";
    $edit_quest_url = admin_url() . "admin.php?page=edit_quest_settings";
?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your quests!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<h2>Quests</h2>
<table class="ui table segment">
  <tr>
    <th>Quest</th>
    <th>Description</th>
    <th>Language Code</th>
    <th>Pano</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($quests as $quest): ?>

    <tr>
        <td><?php echo $quest->name ?></td>
        <td><?php echo $quest->description ?></td>
        <td><?php echo $quest->language_code ?></td>
        <td><?php echo $quest->pano_name ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_quest_url ?>&id=<?php echo $quest->quest_id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_quest_form<?php echo $quest->quest_id ?>">
                <!-- pano processing hook -->
                <input type="hidden" name="action" value="delete_quest" />
                <input type="hidden" name="quest_id" value="<?php echo $quest->quest_id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

  <?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_quest_url ?>" style="padding: 7px">New Quest</a>

</div>

<?php }