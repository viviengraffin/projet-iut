<form method="post" action="changePasswordAction">
	Mot de passe actuel <input type="password" name="actPassword"><br/>
	Nouveau mot de passe <input type="password" name="newPassword1"><br/>
	Confirmez le nouveau mot de passe <input type="password" name="newPassword2"><br/>
	<input type="submit" value="Confirmer">
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
