<?php

require_once('../../session.php');

require_once('is_login.php');

require_once('../../setup.php');
$smarty = new Smarty_Assignment('Assignment | コメント');

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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	if (!isset($_GET['id'])) {
		header('HTTP/1.1 303 See Other');
		header('Location ./');
		exit();
	}
	$comments = $db->get_comments_by_article_id($_GET['id']);
	$tmp_comments = array();
	foreach ($comments as $comment) {
		$created_at_unixtimestamp = strtotime($comment['created_at']);
		$comment['created_at_date'] = date('Y/m/d', $created_at_unixtimestamp);
		$comment['created_at_time'] = date('H:i:s', $created_at_unixtimestamp);
		$tmp_comments[] = $comment;
	}
	$smarty->assign('comments', $tmp_comments);
	$smarty->displayBase('admin/delete_comment.tpl');
	exit();
}

if (isset($_POST['comment_id']) && $_POST['comment_id'] != '') {
	$db->delete_comment($_POST['comment_id']);
}
header('HTTP/1.1 303 See Other');
header('Location: ./delete_comment.php?id=' . $_GET['id']);
