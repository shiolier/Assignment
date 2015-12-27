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

<form method="POST">
	{if $is_new == false}
		<input type="hidden" name="id" value="{$article_id}">
	{/if}
	<table class="edit_article_form_table">
		<caption>記事</caption>
		<tr>
			<td colspan="2" class="error_message">{$error_message}</td>
		</tr>
		<tr>
			<td colspan="2" class="error_message">{$error_title}</td>
		</tr>
		<tr>
			<td>タイトル:</td>
			<td><input class="title_form" type="text" name="title" value="{$article_title|escape:'html'}"></td>
		</tr>
		<tr>
			<td colspan="2" class="error_message">{$error_content}</td>
		</tr>
		<tr>
			<td>内容:</td>
			<td><textarea name="content" width="500px" height="300px">{$article_content|escape:'html'}</textarea></td>
		</tr>
		<tr>
			<td colspan="2" class="error_message">{$error_publication_date}</td>
		</tr>
		<tr>
			<td>表示開始日:</td>
			<td><input type="text" name="publication_date" id="publication_date" value="{$publication_date}"></td>
		</tr>
		<tr>
			<td colspan="2" class="error_message">{$error_publication_time}</td>
		</tr>
		<tr>
			<td>表示開始時刻:</td>
			<td><input type="text" name="publication_time" id="publication_time" value="{$publication_time}"></td>
		</tr>
		<tr>
			<td colspan="2" class="submit"><input type="submit" class="submit_button" value="保存"></td>
		</tr>
	</table>
</form>