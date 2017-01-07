<?php
if (!login()) {
	include_once('index.php');
}
else {
	$title = 'Add New Book';
	
	if (isset($_POST['title']) && isset($_POST['author']) && isset($_POST['price'])) {
		$e = addbook($_POST, login());
		if (!$e) {
			error($e);
		}
	}
?>

<form action="add.php" method="post">
	<dl>
		<dt>Title</dt><dd><input type="text" name="title" required></dd>
		<dt>Author</dt><dd><input type="text" name="author" required></dd>
		<dt>Price</dt><dd><input type="number" name="price" required>Yen</dd>
		<dd><input type="submit" value="ADD"></dd>
	</dl>
</form>
<?php } ?>
