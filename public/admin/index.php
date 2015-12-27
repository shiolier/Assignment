<?php

require_once('../../session.php');

require_once('is_login.php');

// Smarty読み込み&準備
require_once('../../setup.php');
$smarty = new Smarty_Assignment('Assignment | 管理者ページ');

require_once('../../db.php');
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
$tmp_articles = array();
foreach ($articles as $article) {
	$article['content'] = strip_tags($article['content']);
	$publication_unixtimestamp = strtotime($article['publication_datetime']);
	$article['publication_date'] = date('Y/m/d', $publication_unixtimestamp);
	$article['publication_time'] = date('H:i', $publication_unixtimestamp);
	$tmp_articles[] = $article;
}

$smarty->assign('articles', $tmp_articles);
$smarty->displayBase('admin/index.tpl');
