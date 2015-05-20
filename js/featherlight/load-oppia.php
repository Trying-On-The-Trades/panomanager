<?php
  $oppia = '';
  $worth = '';
  if(isset($_GET['oppia'])){
    $oppia = $_GET['oppia'];
  }
  else{
    $oppia = '4';
  }
  if(isset($_GET['worth'])){
    $worth = $_GET['worth'];
  }
  else{
    $worth = '50';
  }
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
