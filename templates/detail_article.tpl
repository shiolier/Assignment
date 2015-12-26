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
