<ul>
	{foreach from=$articles item=article}
		<li>
			<div>
				{$article.title|escape:'htmlall'}
			</div>
			<div>
				{$article.content|escape:'htmlall'}
			</div>
			<div>
				<a href="detail_article.php?id={$article.id}">詳細を見る</a>
			</div>
		</li>
	{/foreach}
</ul>