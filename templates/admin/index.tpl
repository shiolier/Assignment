<div>
	<a href="new_article.php">新規作成</a>
</div>
<div>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>タイトル</th>
			<th>内容</th>
			<th>公開日時</th>
			<th>操作</th>
		</tr>
		{foreach from=$articles item=article}
			<tr>
				<td>
					{$article.id}
				</td>
				<td>
					{$article.title|escape:'html'}
				</td>
				<td>
					{$article.content|escape:'html'}
				</td>
				<td>
					{$article.publication_datetime}
				</td>
				<td>
					<a href="edit_article.php?id={$article.id}">編集</a>
					<a href="delete_article.php?id={$article.id}">削除</a>
				</td>
			</tr>
		{/foreach}
	</table>
</div>