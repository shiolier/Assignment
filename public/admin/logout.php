<?php

session_start();
// セッション変数を削除
$_SESSION = array();
// CookieのセッションIDを削除
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time() - 42000, '/');
}
// セッションのデータを破棄
session_destroy();

// ログインページへ
header('HTTP/1.1 303 See Other');
header('Location: login.php');
