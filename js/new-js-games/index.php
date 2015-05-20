<?php 
    $log;
    $word;
    $description;
    if(isset($_GET['word']))
    {
        $word_id = $_GET['word'];
        if(is_numeric($word_id))
        {
            $log = $word_id;
            $row = database_call();
            $word = $row->word;
            $description = $row->description;
        }
    }

    define('DB_HOST','localhost');
    define('DB_USER','wordpress');
    define('DB_PASS','wordpress');
    define('DB_NAME','wordpress');

    function database_call()
    {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $result = $db->query($query);
        $query = "SELECT word, description FROM wp_pano_dictionary WHERE id = {$word_id}";
        $row = $result->fetch_object(); 
        return $row;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript">
            var log = <?= $log ?>;
            var word = "my test being made";
            //var word = <?= $word ?>;
            var hint = "This is a test! Why hints?";
            //var hint = <?= $description ?>;
        </script>
        <script src="hatpla.js"></script>
        <link rel="stylesheet" href="style-2.css">
        <title>Hat Pla</title>
    </head>
<div class="wrapper">
    <h2>Can you earn your Stylist's Hat?</h2>
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