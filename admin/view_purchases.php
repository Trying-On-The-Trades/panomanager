<?php

function purchases_settings_page(){
  $purchases = get_purchases();
  $view_purchase_url = admin_url() . 'admin.php?page=view_purchase_settings';
  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
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
<table class="ui table segment">
  <tr>
    <th>User</th>
    <th>Date</th>
    <th>View</th>
  </tr>
  <?php foreach($purchases as $purchase): ?>
    <tr>
      <td><?= $purchase->user_id ?></td>
      <td><?= $purchase->date ?></td>
      <td><a class="ui blue icon button" style="padding: 7px" href="<?= $view_purchase_url ?>&id=<?= $purchase->id ?>">View</a></td>
    </tr>
  <?php endforeach; ?>
</table>

<?php }
