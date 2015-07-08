<?php
    function item_page_settings(){
        $items = get_items();
        $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
        $new_item_url = admin_url() . 'admin.php?page=new_item_settings' ;
        $edit_item_url = admin_url() . 'admin.php?page=edit_item_settings';
?>

<link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
<p>Manage your items!</p>
<hr>
<?php if(isset($_GET['settings-saved'])): ?>
    <div class="updated"><p>Settings saved successfully.</p></div>
<?php endif; ?>

<h2>Items</h2>
    <table class="ui table segment">
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th>Item Type</th>
        </tr>
        <?php foreach($items as $item): ?>
            <tr>
                <td><?= $item->name ?></td>
                <td><?= $item->description ?></td>
                <td><?= $item->image ?></td>
                <td><?= $item->price ?></td>
                <td><?= $item->item_type ?></td>
                <td><a class="ui blue icon button" href="<?= $edit_item_url ?>&id=<?= $item->id ?>" style="...">Edit</a> </td>
                <td>
                    <form method="post" action="admin-post.php" id="delete_item_form<?= $item->id ?>">
                        <input type="hidden" name="action" value="delete_item"/>
                        <input type="hidden" name="item_id" value="<?= $item->id ?>"/>
                        <input type="submit" class="ui blue icon button" value="Delete" style="..."/>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a class="ui blue icon button" href="<?= $new_item_url ?>" style="...">New Item</a>
    </div>
<?php    }