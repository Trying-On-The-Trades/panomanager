<?php
require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once('../../../../wp-includes/pluggable.php');

$semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';


$pano_id = $_GET['pano_id'];

$prereq = get_pano_prereq($pano_id);

$currency = get_points_symbol();

//$items = get_prereq_items($prereq[0]->prereq_id);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
</head>
<body>
<h1>Pano Requirements</h1>
<p><?php echo "To access this pano you need:"?></p>
<p><?php echo $prereq[0]->prereq_pts . " points and the following items:"?></p>

<div class="ui form">
    <div class="field">
        <ul>
            <li class="games_form">

                <input id="1" class="cat0" type="checkbox" value="1" name="words[]" checked disabled></input>

                <label class="cat0" for="1">

                    Hammer

                </label>

            </li>
            <li class="games_form">

                <input id="1" class="cat0" type="checkbox" value="1" name="words[]" disabled></input>

                <label class="cat0" for="1">

                    Helmet

                </label>

            </li>
            <li class="games_form">

                <input id="1" class="cat0" type="checkbox" value="1" name="words[]" checked disabled></input>

                <label class="cat0" for="1">

                    Boots

                </label>

            </li>
            <li class="games_form">

                <input id="1" class="cat0" type="checkbox" value="1" name="words[]" disabled></input>

                <label class="cat0" for="1">

                    Goggles

                </label>

            </li>
            <li class="games_form">

                <input id="1" class="cat0" type="checkbox" value="1" name="words[]" disabled></input>

                <label class="cat0" for="1">

                    Gloves

                </label>

            </li>
            <li class="games_form">
                <p>
                <div class="square_blue"></div>Got already

                </p>
                <p>
                <div class="square_grey"></div>Have to get

                </p>

            </li>
        </ul>
    </div>
</div>

</body>
</html>