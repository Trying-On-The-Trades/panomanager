<?php


function item_type_settings_page(){
    $item_types = get_item_types();

    $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_item_type_url = admin_url() . 'admin.php?page=new_item_type_settings';
    $edit_item_type_url = admin_url() . 'admin.php?page=edit_item_type_settings';
    ?>

<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your item types!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
        <div class="updated"><p>Settings updated successfully.</p></div>
    <?php endif ?>

<h2>Item Types</h2>
<table class="ui table segment">
  <tr>
    <th>Item Type</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($item_types as $item_type): ?>

    <tr>
        <td><?php echo $item_type->name ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_item_type_url ?>&id=<?php echo $item_type->id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_item_type_form<?php echo $item_type->id ?>">

                <input type="hidden" name="action" value="delete_item_type" />
                <input type="hidden" name="item_type_id" value="<?php echo $item_type->id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

    <?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_item_type_url ?>" style="padding: 7px">New Item Type</a>
</div>

<?php }