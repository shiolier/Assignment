<div class="article_detail">
	<div class="title">
		{$article.title}
	</div>
	<div class="publication_datetime">
		{$article.publication_date} {$article.publication_time}
	</div>
	<div class="content">
		{$article.content}
	</div>
</div>
<div class="comment_list">
	<ul>
		{foreach from=$comments item=comment}
			<li>
				<div class="name">
					{$comment.name|escape:'html'}
				</div>
				<div class="created_at">
					{$comment.created_at_date} {$comment.created_at_time}
				</div>
				<div class="content">
					{$comment.content|escape:'html'}
				</div>
			</li>
		{/foreach}
	</ul>
</div>
<form class="post_comment_form" action="post_comment.php" method="POST">
	<input type="hidden" name="article_id" value="{$article.id}">
	<table>
		<caption>コメント投稿</caption>
		<tr>
			<td>ハンドルネーム:</td>
			<td><input type="text" name="name" placeholder="名無しさん"></td>
		</tr>
		<tr>
			<td>内容:</td>
			<td><textarea name="content"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" class="submit"><input class="submit_button" type="submit" value="投稿"></td>
		</tr>
	</table>
</form>
