<?php

$loggedin = login() ? "HELLO" . login() : "pls login";
$title = 'ReadLog';

echo $loggedin;
