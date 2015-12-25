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

	/**
	 * ログイン
	 * @param $user_id ユーザーID
	 * @param $password パスワード
	 * @return boolean ログイン成功かどうか
	 */
	function login($user_id = '', $password = '') {
		if ($user_id === '' || $password === '') {
			return false;
		}

		// パスワードをハッシュ
		$password_hash = password_hash($password, PASSWORD_BCRYPT, array('salt' => sha1('hashsalt')));

		// ユーザーIDとパスワードが一致する行数を取得
		$sql = "SELECT COUNT(*) FROM users WHERE user_id = :user_id AND password = :password;";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
		$stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
		$stmt->execute();

		// 最初のカラム COUNT(*) を取得して、1だったらログイン成功
		return $stmt->fetchColumn() == 1;
	}

	/**
	 * 全記事取得(管理者用)
	 * @return array 記事
	 */
	function get_all_article_for_admin() {
		// 全行取得
		$sql =  "SELECT id, title, LEFT(content, 100) AS content, publication_datetime FROM articles;";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();

		$articles = array();
		while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$articles[] = $article;
		}
		return $articles;
	}

	/**
	 * 記事の挿入(新規作成)
	 * @param $title 記事のタイトル
	 * @param $content 記事の内容
	 * @param publication_datetime 記事の公開日時
	 * @return boolean 新規作成が成功したかどうか
	 */
	function insert_new_article($title, $content, $publication_datetime) {
		// 挿入
		$sql = "INSERT INTO articles(title, content, publication_datetime) VALUES (:title, :content, :publication_datetime);";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->bindValue(':publication_datetime', $publication_datetime);
		$stmt->execute();

		// 1件挿入できてたら成功
		return $stmt->rowCount() === 1;
	}
}
