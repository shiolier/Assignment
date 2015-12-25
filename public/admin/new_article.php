<?php

require_once('is_login.php');

// Smarty読み込み&準備
require_once('../../setup.php');
$smarty = new Smarty_Assignment('Assignment | 新規作成');
$smarty->assign('is_new', true);
$smarty->assign('error_message', '');
$smarty->assign('error_title', '');
$smarty->assign('error_content', '');
$smarty->assign('error_publication_date', '');
$smarty->assign('error_publication_time', '');
$smarty->assign('article_title', '');
$smarty->assign('article_content', '');
$smarty->assign('publication_date', date('Y/m/d'));
$smarty->assign('publication_time', date('H:i'));

// HTTPメソッドがPOST以外の場合は投稿画面表示
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$smarty->displayBase('admin/edit_article.tpl');
	exit();
}

// パラーメーターをチェックして、不備があればエラーメッセージを表示
$is_exist_error = false;
if (!isset($_POST['title']) || $_POST['title'] === '') {
	$is_exist_error = true;
	$smarty->assign('error_title', '入力されていません');
} else {
	$smarty->assign('article_title', $_POST['title']);
}
if (!isset($_POST['content']) || $_POST['content'] === '') {
	$is_exist_error = true;
	$smarty->assign('error_content', '入力されていません');
} else {
	$smarty->assign('article_content', $_POST['content']);
}
if (!isset($_POST['publication_date']) || $_POST['publication_date'] === '') {
	$is_exist_error = true;
	$smarty->assign('error_publication_date', '入力されていません');
} else {
	$smarty->assign('publication_date', $_POST['publication_date']);
	if (preg_match('/^([1-9][0-9]{3})\/(0[1-9]{1}|1[0-2]{1})\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/', $_POST['publication_date']) !== 1) {
		$is_exist_error = true;
		$smarty->assign('error_publication_date', '無効なフォーマットです');
	}
}
if (!isset($_POST['publication_time']) || $_POST['publication_time'] === '') {
	$is_exist_error = true;
	$smarty->assign('error_publication_time', '入力されていません');
} else {
	$smarty->assign('publication_time', $_POST['publication_time']);
	if (preg_match('/^(0[0-9]{1}|1[0-9]{1}|2[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $_POST['publication_time']) !== 1) {
		$is_exist_error = true;
		$smarty->assign('error_publication_time', '無効なフォーマットです');
	}
}
if ($is_exist_error === true) {
	$smarty->displayBase('admin/edit_article.tpl');
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

// 公開日時のパラメーターをPostgresのdatetime用に加工
$datetime_unixtimestamp = strtotime($_POST['publication_date'] . ' ' . $_POST['publication_time']);
$datetime_for_postgres = date('Y-m-d H:i:s', $datetime_unixtimestamp);

// 新規作成が成功した場合は管理者トップページへ
if ($db->insert_new_article($_POST['title'], $_POST['content'], $datetime_for_postgres)) {
	header('HTTP/1.1 303 See Other');
	header('Location: ./');
	exit();
} else {
	$smarty->assign('error_message', '新規作成に失敗しました');
	$smarty->displayBase('admin/edit_article.tpl');
	exit();
}
