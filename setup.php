<?php

require_once("vendor/autoload.php");

class Smarty_Assignment extends Smarty {
	function __construct() {
		parent::__construct();

		// Smartyが使用するディレクトリの設定
		$setup_conf = require('setup_conf.php');
		$this->template_dir = $setup_conf['template_dir'];
		$this->compile_dir = $setup_conf['compile_dir'];
		$this->config_dir = $setup_conf['config_dir'];
		$this->cache_dir = $setup_conf['cache_dir'];
	}
}
