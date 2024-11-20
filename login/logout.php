<?php
session_start();
unset ( $_SESSION['verify_key'] );
unset ( $_SESSION['user_id'] );

if (isset($_SERVER['HTTP_COOKIE'])) {
	$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	foreach($cookies as $cookie) {
		$parts = explode('=', $cookie);
		$name = trim($parts[0]);
		setcookie($name, '', time()-1000);
		setcookie($name, '', time()-1000, '/', $_SERVER['HTTP_HOST']);
	}
}
header ( 'Location: ../index.php' );