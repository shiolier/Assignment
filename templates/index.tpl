<ul class="article_list">
	{foreach from=$articles item=article}
		<li>
			<div class="title no_line_break">
				{$article.title|escape:'html'}
			</div>
			<div class="content">
				{$article.content|escape:'html'}
			</div>
			<div class="show_detail">
				<a href="detail_article.php?id={$article.id}">詳細を見る</a>
			</div>
		</li>
	{/foreach}
</ul>