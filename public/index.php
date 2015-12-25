<?php

// Smarty読み込み&準備
require_once('../setup.php');
$smarty = new Smarty_Assignment('Assignment');

require_once('../db.php');
$db = null;
try {
	$db = new Assigment_DB();
} catch (PDOException $e) {
	// echo 'PDOException: ' . $e->getMessage();
	header("HTTP/1.1 500 Internal Server Error");
	$smarty->displayBase('server_error.tpl');
	exit();
}

// 記事一覧取得
$articles = $db->get_all_article_for_admin();

$smarty->assign('articles', $articles);
$smarty->displayBase('index.tpl');
