<form action="inscriptionAction" method="post">
	
	<h3 style="color:black;text-align:left;">Informations personnels</h2><br/><br/>
	
	<label for="id">Identifiant  * :</label><input type="texte" name="login" id="id"><br><br>

	<label for="mdp">Mot de passe *: </label><input type="password" name="password1" id="mdp"><br><br>
	
	<label for="confirmer">Confirmer *:</label> <input type="password" name="password2" id="confirmer"><br><br><br>
	
	<h3 style="color:black;text-align:left;">Informations professionnels</h2><br/><br/>

	<label for="prénom">Prénom *:</label> <input type="texte" name="prenom" id="prénom"><br><br>

	<label for="nom">Nom *:</label> <input type="texte" name="nom" id="nom"><br><br>

	<label for="adresse">Adresse mail * :</label> <input type="texte" name="mail" id="adresse" ><br><br><br>

	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
	
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
</form>
