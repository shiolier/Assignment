<?php

class Assigment_DB {
	private $dbh;

	function __construct() {
		$dsn = 'pgsql:host=localhost;port=5432;dbname=assignment';
		$db_conf = require('db_conf.php');

		try {
			$this->dbh = new PDO($dsn, $db_conf['user_name'], $db_conf['password']);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	function __destruct() {
		$this->dbh = null;
	}
}
