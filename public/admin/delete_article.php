<?php

require_once('../../session.php');

require_once('is_login.php');

if (isset($_GET['id']) && $_GET['id'] != '') {
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

	$db->delete_article($_GET['id']);
}

header('HTTP/1.1 303 See Other');
header('Location: ./');