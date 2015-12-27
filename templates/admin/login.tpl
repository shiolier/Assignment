<form class="login_form" method='POST'>
	<table class="login_form_table">
		<caption>ログイン</caption>
		<tr>
			<td colspan="2" class="error_message">{$error_message}</td>
		</tr>
		<tr>
			<td>ユーザーID:</td>
			<td><input name='user_id' type='text'></td>
		</tr>
		<tr>
			<td>パスワード:</td>
			<td><input name='password' type='password'></td>
		</tr>
		<tr>
			<td colspan="2" class="submit"><input type='submit' class="submit_button" value='ログイン'></td>
		</tr>
	</table>
</form>