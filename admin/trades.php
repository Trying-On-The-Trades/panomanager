<?php

// Build the settings page
function pano_trade_settings_page() {
    $trades = get_trades();

    $semantic       = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
    $new_trade_url  = admin_url() . "admin.php?page=new_trade_settings";
    $edit_trade_url = admin_url() . "admin.php?page=edit_trade_settings";
    ?>

<!-- style sheet so our admin page looks nice -->
<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<p>Manage your missions!</p>
<hr>

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
    <div class="updated"><p>Settings updated successfully.</p></div>
<?php endif ?>

<h2>Trades</h2>
<table class="ui table segment">
  <tr>
    <th>Trade</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach ($trades as $trade): ?>

    <tr>
        <td><?php echo $trade->name ?></td>
        <td><a class="ui blue icon button" href="<?php echo $edit_trade_url ?>&id=<?php echo $trade->id ?>" style="padding: 7px">Edit</a></td>
        <td>
            <form method="post" action="admin-post.php" id="delete_trade_form<?php echo $trade->id ?>">
                <!-- pano processing hook -->
                <input type="hidden" name="action" value="delete_trade" />
                <input type="hidden" name="trade_id" value="<?php echo $trade->id ?>" />

                <input type="submit" class="ui blue icon button" value="Delete" style="padding: 7px" >
            </form>
        </td>
    </tr>

<?php endforeach; ?>
</table>
<a class="ui blue icon button" href="<?php echo $new_trade_url ?>" style="padding: 7px">New Trade</a>
</div>

<?php }