<?php

class Output {
}

function out($content) {
	if ($content instanceof Output) {
		print($content->specialchars());
		return;
	}
	$double_encoding = false;
	$o = htmlspecialchars($content, ENT_QUOTES, "UTF-8", $double_encoding);
	print( htmlspecialchars($content) );
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
		'404' => '404.php',
		'template' => 'template.php',
		'index' => 'index.php'
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

	if (file_exists($config['404'])) {
		include_once($url);
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
