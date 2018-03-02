<form method="post" action="changePasswordAction">
	<label>Mot de passe actuel</label> <input type="password" name="actPassword"><br/>
	<label>Nouveau mot de passe</label> <input type="password" name="newPassword1"><br/>
	<label>Confirmez le nouveau mot de passe</label> <input type="password" name="newPassword2"><br/>
	<div style="text-align:center;">
		<input type="submit" value="Confirmer">
	</div>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
