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

		$db_conf = require('db_conf.php');
		// パスワードをハッシュ
		$password_hash = crypt($password, $db_conf['crypt_salt_prefix'] . $db_conf['hash_salt']);

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
	 * 全記事取得(一般ユーザー用)
	 * @return array 記事
	 */
	function get_all_article() {
		// 公開日時が現在より前の記事を取得
		$sql =  "SELECT id, title, LEFT(content, 100) AS content, publication_datetime FROM articles WHERE publication_datetime < CURRENT_TIMESTAMP ORDER BY publication_datetime DESC;";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();

		$articles = array();
		while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$articles[] = $article;
		}
		return $articles;
	}

	/**
	 * 全記事取得(管理者用)
	 * @return array 記事
	 */
	function get_all_article_for_admin() {
		// 全行取得
		$sql =  "SELECT id, title, LEFT(content, 100) AS content, publication_datetime FROM articles ORDER BY id DESC;";
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

	/**
	 * 1つの記事を取得
	 * @param $id 取得したい記事のID
	 * @return array 記事の連想配列
	 */
	function get_one_article($id = 0) {
		// IDが一致する行を取得
		$sql = "SELECT * FROM articles WHERE id = :id;";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * 記事を更新
	 * @param $title 記事のタイトル
	 * @param $content 記事の内容
	 * @param $publication_datetime 記事の公開日時
	 * @return boolean 更新が成功したかどうか
	 */
	function update_article($id = 0, $title, $content, $publication_datetime) {
		// IDが一致する行を更新
		$sql = "UPDATE articles SET title = :title, content = :content, publication_datetime = :publication_datetime WHERE id = :id;";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->bindValue(':publication_datetime', $publication_datetime);
		$stmt->execute();

		// 1件更新できてたら成功
		return $stmt->rowCount() === 1;
	}

	/**
	 * 記事を削除
	 * @param $id 削除したい記事のID
	 * @return boolean 削除が成功したかどうか
	 */
	function delete_article($id = 0) {
		// IDが一致する行を削除
		$sql = "DELETE FROM articles WHERE id = :id;";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		// 1件削除できてたら成功
		return $stmt->rowCount() === 1;
	}

	/**
	 * 記事が存在するかどうかを確認
	 * @param $id 確認したい記事のID
	 * @param $public 公開済みかどうかも確認。trueにした場合、記事自体が存在していても公開されていなければ存在しないものとする。
	 * @return boolean 記事が存在するかどうか
	 */
	function is_exist_article($id = 0, $public = false) {
		$sql = "SELECT COUNT(*) FROM articles WHERE id = :id";
		if ($public === true) {
			$sql .= " AND publication_datetime < CURRENT_TIMESTAMP";
		}
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		// 最初のカラム COUNT(*) を取得して、1だったらログイン成功
		return $stmt->fetchColumn() == 1;
	}

	/**
	 * 記事に投稿されたコメント一覧を取得
	 * @param $article_id コメント一覧を取得したい記事のID
	 * @return 指定した記事に投稿されたコメント一覧
	 */
	function get_comments_by_article_id($article_id = 0) {
		$sql = "SELECT * FROM comments WHERE article_id = :article_id;";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':article_id', $article_id, PDO::PARAM_INT);
		$stmt->execute();

		$comments = array();
		while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = $comment;
		}
		return $comments;
	}

	/**
	 * コメントを挿入
	 * @param $article_id コメントを投稿する記事のID
	 * @param $name ハンドルネーム
	 * @param $content コメントの内容
	 * @return boolean コメントの挿入に成功したかどうか
	 */
	function insert_comment($article_id = 0, $name, $content) {
		// 挿入
		$sql = "INSERT INTO comments(article_id, name, content, created_at) VALUES (:article_id, :name, :content, CURRENT_TIMESTAMP);";
		$stmt = $this->dbh->prepare($sql);

		$stmt->bindValue(':article_id', $article_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();

		// 1件挿入できてたら成功
		return $stmt->rowCount() === 1;
	}
}
