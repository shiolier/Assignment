<?php

require_once('../session.php');

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

if (isset($_POST['article_id']) && $_POST['article_id'] != '' &&
		isset($_POST['content']) && $_POST['content'] != '' &&
		$db->is_exist_article($_POST['article_id'], true)) {

	$name = '名無しさん';
	if (isset($_POST['name']) && $_POST['name'] != '') {
		$name = $_POST['name'];
	}

	$db->insert_comment($_POST['article_id'], $name, $_POST['content']);
}

header('HTTP/1.1 303 See Other');
header('Location: ' . (isset($_POST['article_id']) ? 'detail_article.php?id=' . $_POST['article_id'] : './'));
