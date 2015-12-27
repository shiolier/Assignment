<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<title>{$title}</title>

		<link rel="stylesheet" type="text/css" href="/css/style.css">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<p class="site_name">{$site_name}</p>
			</div>
			<div id="content">
				{* コンテントのテンプレートを挿入 *}
				{include file="$content_tpl"}
			</div>
			<div id="sidebar">
				<ul>
					<li><a href="/">Top</a></li>
					{if $login}
						<li><a href="/admin/">管理者ページ</a></li>
						<li><a href="/admin/logout.php">ログアウト</a></li>
					{else}
						<li><a href="/admin/login.php">ログイン</a></li>
					{/if}
				</ul>
			</div>
			<div class="clear"></div>
			<div id="footer">
				<p class="copyright">
					Copyright &copy; 2015 assignment All Rights Reserved.
				</p>
			</div>
		</div>
	</body>
</html>