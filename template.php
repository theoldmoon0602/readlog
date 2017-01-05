<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title><?php out($title); ?></title>
</head>
<body>
<div id="container">
<header><?php include_once("header.php"); ?></header>
<main><?php raw($content); ?></main>
<footer></footer>
</div>
</body>
</html>
