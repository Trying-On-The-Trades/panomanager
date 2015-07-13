<?php 
	require('db.php');

	if(isset($_POST[''])){
		//create a purchase
	}

	if(isset($_GET['id'])){
		//search for an item
		$item;
		$symbol;
		$path = '../../../';
	}
?>
<!DOCTYPE HTML>
<html>
	<head></head>
	<body>
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
	</body>
</html>