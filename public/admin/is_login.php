<?php

// ログインしていない場合はログインページへ
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
	header('HTTP/1.1 303 See Other');
	header('Location: login.php');
	exit();
}
