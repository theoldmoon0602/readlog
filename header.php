<div class="header-bar">
	<h1><a href="index.php">ReadLog</a></h1>
	<h2><?php out($title); ?></h2>

	<?php if(!login()) { ?>
	<form action="login.php" method="post">
		<input type="text" name="username">
		<input type="password" name="password">
		<input type="submit" value="login">
	</form>
	<?php } else { ?>
	<a href="logout.php">logout</a>
	<?php } ?>

<div>
