<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-includes/wp-db.php');
require_once('../../../../../wp-includes/pluggable.php');

$user_id = wp_get_current_user()->ID;
$purchases = get_purchases_by_user($user_id);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <div id="content">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
         <?php if(!empty($purchases)): ?>
           <?php foreach($purchases as $purchase): ?>
             <?php $items = get_purchase_items($purchase->id); ?>
             <?php foreach($items as $key => $item): ?>
             <tr>
               <th>Date here</th>
               <th><?= $item->name ?></th>
               <th><?= $item->price ?></th>
             </tr>
             <?php endforeach; ?>
           <?php endforeach; ?>
         <?php endif; ?>
        </tbody>
      </table>
    </div>
  </body>
</html>