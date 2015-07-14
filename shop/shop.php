<?php 
	require('db.php');

	if(isset($_POST['item'])){
		
	}

	if(isset($_GET['id'])){
		//search for an item
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
	</head>
	<body>
		<?php if(isset($_POST['item'])): ?>

			<div class="content">
				
			</div>

		<?php else : ?>
		
			<div class="content">
				<img src="<?= $path . $item['image'] ?>" alt="Image">
				<h4><?= $item['name'] ?></h4>
				<p><?= $item['description'] ?></p>
				<p><?= $symbol . $item['price'] ?></p>
				<form method="post">
					<input type="hidden" name="item" value="<?= $item['id'] ?> "/>
					<input type="hidden" name="price" value="<?= $item['price'] ?>" />
					<button type="submit">Buy it</button>
				</form>
			</div>

		<?php endif; ?>
	</body>
</html>