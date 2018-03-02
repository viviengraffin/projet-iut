<form method="post" action="resetPassword">
	<label>Mot de passe</label> <input type="password" name="pass1"><br/>
	<label>Retapez votre mot de passe</label> <input type="password" name="pass2"><br/>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
