<?php

function pano_purchases_settings_page(){
  $purchases = get_purchases();

  $semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';
?>

<link rel="stylesheet" type="text/css" href="<?= $semantic ?>"/>
<p>View your purchases</p>
<hr>

<h2>Purchases</h2>
<table class="ui table segment">
  <tr>
    <th>User</th>
    <th>Date</th>
  </tr>
  <?php foreach($purchases as $purchase): ?>
    <tr>
      <td><?= $purchase->user_id ?></td>
      <td><?= $purchase->date ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<?php }
