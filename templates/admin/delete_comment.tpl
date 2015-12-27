<table class="comment_list_table" border="1">
	<tr>
		{*<th>ID</th>*}
		<th>ハンドルネーム</th>
		<th>内容</th>
		<th>投稿日時</th>
		<th>削除</th>
	</tr>
	{foreach from=$comments item=comment}
		<tr>
			{*
			<td>
				{$comment.id}
			</td>
			*}
			<td>
				{$comment.name|escape:'html'}
			</td>
			<td>
				{$comment.content|escape:'html'}
			</td>
			<td>
				{$comment.created_at_date} {$comment.created_at_time}
			</td>
			<td>
				<form method="POST">
					<input type="hidden" name="comment_id" value="{$comment.id}">
					<input type="submit" class="submit_button" value="削除">
				</form>
			</td>
		</tr>
	{/foreach}
</table>
