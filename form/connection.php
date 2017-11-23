<form method="post" action="connectionAction">
	Identifiant <input type="text" name="login"><br/>
	Mot de passe <input type="password" name="password"><br/>
	<input type="checkbox" name="souvenir" id="souvenir"> <label for="souvenir">Se souvenir de moi</label><br/>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
