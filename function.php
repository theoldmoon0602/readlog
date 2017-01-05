<?php

function raw($content) {
	print($content);
}

function escape($content) {
	$double_encoding = false;
	$o = htmlspecialchars($content, ENT_QUOTES, "UTF-8", $double_encoding);
	return htmlspecialchars($content);
}

function error($msg) {
	print("<span style='color: red;'>$msg</span>");
}

function out($content) {
	print(escape($content));
}

function connect() {
	$pdo = new PDO('sqlite:database.db');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
}

function login($userinfo=NULL) {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if ($userinfo) {
		$db = connect();
		$stmt = $db->prepare('SELECT password_hash from users where username = ?');
		$stmt->execute([$userinfo['username']]);
		$result = $stmt->fetch();

		if (isset($result['password_hash']) &&
			password_verify($userinfo['password'], $result['password_hash'])) {

			$_SESSION['login'] = $userinfo['username'];
		}
		else {
			return FALSE;
		}
	}

	if (isset($_SESSION['login'])) {
		return $_SESSION['login'];
	}
	return false;
}

function draw($dirname, $config=[]) {
	$defaults = [
		'template' => 'template.php',
		'index' => 'index.php',
		'404page' => '404.php',
	];
	$config = array_merge($defaults, $config);

	$url = $_SERVER['REQUEST_URI'];
	$url = substr($url, strlen($dirname));
	while (strlen($url) > 0 && $url[0] == '/') {
		$url = substr($url, 1);
	}

	if (strlen($url) == 0) {
		$url = $config['index'];
	}

	if (file_exists($url)) {
		ob_start();
		include_once($url);
		$content = ob_get_contents();
		ob_clean();
		ob_flush();
		include_once($config['template']);
		return;
	}

	if (file_exists($config['404page'])) {
		include_once($config['404page']);
		$content = ob_get_contents();
		ob_clean();
		ob_flush();
		include_once($config['template']);
		return;
	}

	header("HTTP/1.1 404 not found");
}

function logout() {
	unset($_SESSION['login']);
}

function readbooknum() {
	$db = connect();
	$stmt = $db->prepare('select count(*) from books');
	$stmt->execute();

	return $stmt->fetch()['count(*)'];
}

function recentbooks ($rows, $user=NULL) {
	$db = connect();
	if ($user) {
		$stmt = $db->prepare('select * from books where user=? order by created_at desc limit ?');
		$stmt->execute([$user, $rows]);
		return $stmt->fetchAll();
	}
	$stmt = $db->prepare('select * from books order by created_at desc');
	$stmt->execute();
	return $stmt->fetchAll();
}

function sqlitedatetime() {
	return date('Y-m-d H:i:s');
}

function addbook($values, $user) {
	$db = connect();
	$stmt = $db->prepare('insert into books(title, author, price, username, created_at) values (?, ?, ?, ?, ?);');
	return $stmt->execute([$values['title'], $values['author'], $values['price'], $user, sqlitedatetime()]);
}
