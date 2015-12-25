<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../css/jquery.ui.timepicker.css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.timepicker.js"></script>
<script>
	$(function(){
		$("#publication_date").datepicker();
		$('#publication_time').timepicker();
	});
</script>

<h3>記事</h3>
<form method="POST">
	<p>
		{$error_message}
	</p>
	{$error_title}<br>
	タイトル:<input type="text" name="title" value="{$article_title|escape:'html'}"><br>
	{$error_content}<br>
	内容:<textarea name="content" width="500px" height="300px">{$article_content|escape:'html'}</textarea><br>
	{$error_publication_date}<br>
	表示開始日:<input type="text" name="publication_date" id="publication_date" value="{$publication_date}"><br>
	{$error_publication_time}<br>
	表示開始時刻:<input type="text" name="publication_time" id="publication_time" value="{$publication_time}"><br>
	{if $is_new == false}
		<input type="hidden" name="id" value="{$article_id}">
	{/if}
	<input type="submit" value="保存">
</form>