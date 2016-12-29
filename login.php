<?php

if (login()) {
	include_once('index.php');
}
else {
	login($_POST);
	include_once('index.php');
}
