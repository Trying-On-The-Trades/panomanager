<?php
require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/wp-db.php');
require_once('../../../../wp-includes/pluggable.php');

$semantic = WP_PLUGIN_URL . '/panomanager/css/semantic.css';


$pano_id = $_GET['pano_id'];

$prereq = get_pano_prereq($pano_id);

$currency = get_points_symbol();

$items = get_prereq_items($prereq->id);

$user_id = get_current_user_id();

$items_size = sizeof($items);

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
<p><?php echo $prereq->prereq_pts . " " . $currency . " and the following items:"?></p>

<div class="ui form">
    <div class="field">
        <ul>
            <?php if($items_size > 0): ?>
                <?php foreach($items as $item): ?>
                    <li class="games_form">
                        <?php if(check_if_user_has_item($user_id, $item->item_id)): ?>
                            <input id="1" class="cat0" type="checkbox" value="1" name="words[]" checked disabled></input>
                        <?php else: ?>
                            <input id="1" class="cat0" type="checkbox" value="1" name="words[]" disabled></input>
                        <?php endif;?>

                        <label class="cat0" for="1">

                            <?php echo get_item($item->item_id)->name?>

                        </label>

                    </li>
                <?php endforeach; ?>

                <li class="games_form">
                    <p>
                        <div class="square_blue"></div>Got already
                    </p>
                    <p>
                        <div class="square_grey"></div>Have to get
                    </p>

                </li>
            <?php else: ?>
                <p>No items required</p>
            <?php endif;?>
        </ul>
    </div>
</div>

</body>
</html>