<form method="post" action="connectionAction">
	Identifiant <input type="text" name="login"><br/>
	Mot de passe <input type="password" name="password"><br/>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
