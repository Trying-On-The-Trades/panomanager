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
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php if(!empty($purchases)): ?>
          <tr>
            <td></td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
