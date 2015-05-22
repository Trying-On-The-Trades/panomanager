<?php
  $oppia = '';

  if(isset($_GET['oppia'])){
    $oppia = $_GET['oppia'];
  }else{
    $oppia = '4';
  }

  if(isset($_GET['base_points'])){
    $base_points = $_GET['base_points'];
  }else{
    $base_points = 0;
  }

  if(isset($_GET['bonus_points'])){
    $bonus_points = $_GET['bonus_points'];
  }else{
    $bonus_points = 0;
  }

  $worth = $base_points + $bonus_points;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <script src="oppia-player.min.js"></script>
    <script type="text/javascript">
      window.OPPIA_PLAYER.onExplorationCompletedPostHook =
      function(iframeNode){
        var worth = document.getElementById('worth').getAttribute('value');
        var points = document.getElementById('points');
        points.setAttribute('value', worth);
      };
    </script>
    <title>Oppia test</title>
  </head>
  <body>
    <div>
      <oppia oppia-id="<?= $oppia ?>" src="https://www.oppia.org"></oppia>
    </div>
    <input id="points" type="hidden" value="0" />
    <input id="worth" type="hidden" value="<?= $worth ?>" />
  </body>
</html>
