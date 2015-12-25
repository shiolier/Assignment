<?php

// 管理者ページへのリダイレクト関数
function redirect_admin_page() {
	header('HTTP/1.1 303 See Other');
	header('Location: ./');
	exit();
}

session_start();

// ログイン済みの場合は管理者ページへ
if (isset($_SESSION['login']) && $_SESSION['login']) {
	redirect_admin_page();
}

// Smarty読み込み&準備
require_once('../../setup.php');
$smarty = new Smarty_Assignment('Assignment | ログイン');
$smarty->assign('error_message', '');

// HTTPメソッドがGETの場合や、パラメーターが不足している場合は、ログイン画面を表示
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['user_id']) || !isset($_POST['password'])) {
	$smarty->displayBase('admin/login.tpl');
	exit();
}

require_once('../../db.php');
$db = null;
try {
	$db = new Assigment_DB();
} catch (PDOException $e) {
	// echo 'PDOException: ' . $e->getMessage();
	header ("HTTP/1.1 500 Internal Server Error");
	$smarty->displayBase('server_error.tpl');
	exit();
}

// ログインに成功した場合は管理者ページへ
if ($db->login($_POST['user_id'], $_POST['password'])) {
	$_SESSION['login'] = true;
	// セッションIDを再生成
	session_regenerate_id();
	redirect_admin_page();
} else {
	// ログインに失敗した場合はエラーメッセージを表示
	$smarty->assign('error_message', 'ユーザーIDやパスワードが間違っています');
	$smarty->displayBase('admin/login.tpl');
	exit();
}
