<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-includes/wp-db.php');
require_once('../../../../../wp-includes/pluggable.php');

function get_this_pano_id(){
  $url = $_SERVER['HTTP_REFERER'];
  $parts = explode('?pano_id=', $url);
  $pano_id = $parts[1];

  if ($pano_id == NULL){
      $pano_id = 1;
  }

  return $pano_id;
}

$pano_id = get_this_pano_id();
$pano_info = get_pano_info($pano_id);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="./pano_info.css">
  </head>
  <body>
    <div id="wrapper">
      <?php if(!empty($pano_info)): ?>
      <h1>Pano Information</h1>
      <p><?= $pano_info ?></p>
      <?php endif; ?>
    </div>
  </body>
</html>
