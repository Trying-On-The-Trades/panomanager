<?php 

    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','root');
    define('DB_NAME','wordpress');
    // $log;
    $word = "";
    $description;
    $word_id;
    if(isset($_GET['word']))
    {
                    
        $word_id = $_GET['word'];
        if(is_numeric($word_id))
        {
            $row = database_call($word_id);
            $word = $row->word;
            $description = $row->hint;

        }
    }

    function database_call($id)
    {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $query = "SELECT word, hint FROM wp_pano_terms WHERE id = {$id}";
        $result = $db->query($query);
        $row = $result->fetch_object(); 
        return $row;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript">
            var word = "<?= $word ?>";
            var hint = "<?= $description ?>";
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
        <div id="smileImage">
        </div>
        <p id="clue"></p>
    </div>

</div>
    <div class="container">
      <button id="hint">Hint</button>
      <button id="reset">Play again</button>
      <input id="points" type="hidden" value="0"/>
    </div>

</html>