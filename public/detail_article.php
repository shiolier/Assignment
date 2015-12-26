<?php

// Smarty読み込み&準備
require_once('../setup.php');
$smarty = new Smarty_Assignment('Assignment');

if (!isset($_GET['id']) || $_GET['id'] == '') {
	header('HTTP/1.1 303 See Other');
	header('Location: ./');
	exit();
}

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

$article = $db->get_one_article($_GET['id']);
$publication_unixtimestamp = strtotime($article['publication_datetime']);
$article['publication_date'] = date('Y/m/d', $publication_unixtimestamp);
$article['publication_time'] = date('H:i', $publication_unixtimestamp);
$smarty->assign('article', $article);
$smarty->assign('title', 'Assignment | ' . $article['title']);

$comments = $db->get_comments_by_article_id($_GET['id']);
$tmp_comments = array();
foreach ($comments as $comment) {
	$created_at_unixtimestamp = strtotime($comment['created_at']);
	$comment['created_at_date'] = date('Y/m/d', $created_at_unixtimestamp);
	$comment['created_at_time'] = date('H:i:s', $created_at_unixtimestamp);
	$tmp_comments[] = $comment;
}
$smarty->assign('comments', $tmp_comments);

$smarty->displayBase('detail_article.tpl');
