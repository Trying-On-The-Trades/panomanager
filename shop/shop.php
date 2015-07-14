<?php
	require('db.php');

    $ordered = false;
	if(isset($_POST['item']) && isset($_POST['price'])){
        $ordered = true;

        $purchased = process_purchase($_POST['item'], $_POST['price']);

	}

	if(isset($_GET['id'])){
		$item = get_item($_GET['id']);
		$symbol = get_points_symbol();
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
                <?php else: ?>
									  <img src="./error.png" alt="error">
                    <p class="error">You don't have enough <?= get_points_name_plural()?> to purchase this item.</p>
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
                    <input type="hidden" name="price" value="<?= $item->price ?>" />
                    <button id="submit" type="submit">Buy it</button>
                </form>
            </div>

		<?php endif; ?>
	</body>
</html>
