<?php

function purchases_settings_page(){
    if(isset($_POST['item']) && is_numeric($_POST['item'])){
        $purchases = get_purchases_by_item($_POST['item']);
    } elseif(isset($_POST['user']) && is_numeric($_POST['user'])){
        $purchases = get_purchases_by_user($_POST['user']);;
    } else {
        $purchases = get_purchases();
    }

  $view_purchase_url = admin_url() . 'admin.php?page=view_purchase_settings';
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
  $users = get_users();
  $items = get_items();
?>

<link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
<style>
#wpfooter{
  display: none;
}
</style>
<p>View your purchases</p>
<hr>

<h2>Purchases</h2>
    <p>Filter the purchases by: </p>
    <form method="POST">
      <label>User: </label>
      <select name="user">
          <option value="">Select a value</option>
          <?php foreach($users as $user): ?>
            <option value="<?= $user->ID ?>"><?= $user->user_nicename ?></option>
          <?php endforeach; ?>
      </select>
      <label>Item: </label>
      <select name="item">
          <option value="">Select a value</option>
          <?php foreach($items as $item): ?>
              <option value="<?= $item->id ?>"><?= $item->name ?></option>
          <?php endforeach; ?>
      </select>
      <input class="ui blue icon button" style="padding: 7px;" type="submit" value="Search"/>
    </form>
<table class="ui table segment">
  <tr>
    <th>User</th>
    <th>Date</th>
    <th>View</th>
  </tr>
  <?php foreach($purchases as $purchase): ?>
    <tr>
      <td><?= get_userdata( $purchase->user_id )->user_nicename ?></td>
      <td><?= date( 'm/d/Y', strtotime( $purchase->date )) ?></td>
      <td><a class="ui blue icon button" style="padding: 7px" href="<?= $view_purchase_url ?>&id=<?= $purchase->id ?>">View</a></td>
    </tr>
  <?php endforeach; ?>
</table>

<?php }
