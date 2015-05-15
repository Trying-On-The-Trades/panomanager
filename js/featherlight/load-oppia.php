<?php
  $oppia = '';
  if(isset($_GET['oppia'])){
    $oppia = $_GET['oppia'];
  }
  else{
    $oppia = '4';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <script src="oppia-player.min.js"></script>
    <title>Oppia test</title>
  </head>
  <body>
    <div>
      <oppia oppia-id="<?= $oppia ?>" src="https://www.oppia.org"></oppia>
    </div>
  </body>
</html>
