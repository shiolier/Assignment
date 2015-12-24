<?php

require_once("vendor/autoload.php");

class Smarty_Assignment extends Smarty {

	/**
	 * コンストラクタ
	 * @param $title HTMLのtitleタグに挿入するタイトル
	 */
	function __construct($title = 'Assignment') {
		parent::__construct();

		// Smartyが使用するディレクトリの設定
		$setup_conf = require('setup_conf.php');
		$this->template_dir = $setup_conf['template_dir'];
		$this->compile_dir = $setup_conf['compile_dir'];
		$this->config_dir = $setup_conf['config_dir'];
		$this->cache_dir = $setup_conf['cache_dir'];

		$this->assign('site_name', 'Assignment');
		$this->assign('title', $title);
	}

	/**
	 * ベーステンプレートにコンテンツテンプレートを挿入したものを表示
	 * @param $content_tpl_name コンテンツのテンプレート名
	 */
	function displayBase($content_tpl_name) {
		$this->assign('content_tpl', $content_tpl_name);
		$this->display('base.tpl');
	}
}
