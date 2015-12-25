<ul>
	{foreach from=$articles item=article}
		<li>
			<div>
				{$article.title|escape:'html'}
			</div>
			<div>
				{$article.content|escape:'html'}
			</div>
			<div>
				<a href="detail_article.php?id={$article.id}">詳細を見る</a>
			</div>
		</li>
	{/foreach}
</ul>