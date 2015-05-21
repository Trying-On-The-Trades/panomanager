<?php 
    require('db.php');
    $db = database_connection();
    $word;
    $hint;
    $word_id;
    $profession = "";
    if(isset($_GET['word']))
    {
        $word_id = $_GET['word'];
        if(is_numeric($word_id))
        {
            $term = select_word($db, $word_id);
            $word = $term->word;
            $hint = $term->hint;
            $trade = select_trade($db, $word_id);
            $profession = $trade->profession;
            $winner = $trade->image;
        }
    }

    

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript">
            var word = "<?= $word ?>";
            var hint = "<?= $hint ?>";
            var winner_image = "<?= $winner ?>";
        </script>
        <script src="hatpla.js"></script>
        <link rel="stylesheet" href="style-2.css">
        <title>Hat Pla</title>
    </head>
<div class="wrapper">
    <h2>Can you earn your <?= $profession ?>'s Hat?</h2>
</div>
<div class="content">
    <div id="buttons">
    </div>
    <div id="inf">
        <p id="categoryName"></p>
        <div id="hold">
        </div>
        <p id="mylives"></p>
        <p id="clue"></p>
    </div>
    <div id="smileImage">
    </div>
</div>
    <div class="container">
      <button id="hint">Hint</button>
      <button id="reset">Play again</button>
      <input id="points" type="hidden" value="0"/>
    </div>

</html>