<h3>{$article.title}</h3>
<div>
	{$article.publication_date} {$article.publication_time}
</div>
<div>
	{$article.content}
</div>
<ul>
	{foreach from=$comments item=comment}
		<li>
			<div>
				{$comment.name|escape:'html'}
			</div>
			<div>
				{$comment.created_at_date} {$comment.created_at_time}
			</div>
			<div>
				{$comment.content|escape:'html'}
			</div>
		</li>
	{/foreach}
</ul>

<form action="post_comment.php" method="POST">
	コメント投稿<br>
	ハンドルネーム:<input type="text" name="name" placeholder="名無しさん"><br>
	内容:<textarea name="content"></textarea><br>
	<input type="hidden" name="article_id" value="{$article.id}">
	<input type="submit" value="投稿">
</form>
