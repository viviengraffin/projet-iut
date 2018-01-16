<form method="post" action="connectionAction">
	<label>Identifiant</label> <input type="text" name="login"><br/>
	<label>Mot de passe</label> <input type="password" name="password"><br/>
	<div style="text-align:center;">
		<input type="checkbox" name="souvenir" id="souvenir"> <label for="souvenir">Se souvenir de moi</label><br/>
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
