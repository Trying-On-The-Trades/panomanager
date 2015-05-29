<?php
  $oppia = '';
  $base_points = 0;
  $bonus_points = 0;
  $enable_bonus = false;

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

  if(isset($_GET['time_limit'])){
    $time_limit = $_GET['time_limit'];
  }else{
    $time_limit = 0;
  }

  $worth = $base_points + $bonus_points;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <style rel="stylesheet" type="text/css">
      body{
        overflow-x: hidden;
        overflow-y: hidden;
      }
    </style>
    <script src="oppia-player.min.js"></script>
    <script type="text/javascript">
      var beginTime = 0;
      var endTime = 0;
      window.OPPIA_PLAYER.onExplorationLoadedPostHook =
      function(iframeNode){
        beginTime = Date.now();
      };
      window.OPPIA_PLAYER.onExplorationCompletedPostHook =
      function(iframeNode){
        endTime = Date.now();
        var base = document.getElementById('base');
        var bonus = document.getElementById('bonus');
        var limit = document.getElementById('limit');
        var limitTime = (parseInt(limit.getAttribute('value')) * 1000);
        var totalTime = endTime - beginTime;
        totalTime = parseInt(totalTime);
        var total = 0;
        if((limitTime > 0) && (totalTime < limitTime)){
          total = parseInt(base.getAttribute('value')) + parseInt(bonus.getAttribute('value'));
        }else{
          total = parseInt(base.getAttribute('value'));
        }
        var points = document.getElementById('points');
        points.setAttribute('value', total);
      };
    </script>
    <title>Oppia test</title>
  </head>
  <body>
    <div>
      <oppia oppia-id="<?= $oppia ?>" src="https://www.oppia.org"></oppia>
    </div>
    <input id="points" type="hidden" value="0" />
    <input id="base" type="hidden" value="<?= $base_points ?>" />
    <input id="bonus" type="hidden" value="<?= $bonus_points ?>" />
    <input id="limit" type="hidden" value="<?= $time_limit ?>" />
  </body>
</html>
