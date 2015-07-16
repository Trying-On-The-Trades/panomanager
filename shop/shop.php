<?php
	require('db.php');

    $ordered = false;
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item'])){
        $ordered = true;

        $purchased = process_purchase($_POST['item']);

	}

	if(isset($_GET['id'])){
		$item = get_item($_GET['id']);
		$symbol = get_points_symbol();
		$plural = get_points_name_plural();
		$path = '../../../';
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Shop</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="./shop.css" />
	</head>
	<body>
		<?php if($ordered): ?>

            <div id="content">
                <?php if($purchased === true): ?>
									  <img src="./success.png" alt="success">
                    <p class="success">You just purchased an item!</p>
										<input type="hidden" name="shop_message" id="shop_message" value="You spent <?= $item->price ?> <?= $plural ?>!" />
                <?php else: ?>
									  <img src="./error.png" alt="error">
                    <p class="error">You don't have enough <?= $plural ?> to purchase this item.</p>
										<input type="hidden" name="shop_message" id="shop_message" value="" />
                <?php endif; ?>
            </div>

		<?php else : ?>

            <div id="content">
                <img src="<?= $path . $item->image ?>" alt="Image">
                <h4><?= $item->name ?></h4>
                <p><?= $item->description ?></p>
                <p><?= $symbol . $item->price ?></p>
                <form method="post">
                    <input type="hidden" name="item" value="<?= $item->id ?> "/>
                    <button id="submit" type="submit">Buy it</button>
                </form>
            </div>

		<?php endif; ?>
	</body>
</html>
