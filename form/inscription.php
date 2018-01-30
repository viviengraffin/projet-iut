<form action="inscriptionAction" method="post">
	
	<h3>Informations personnels</h3><br/><br/>
	
	<label>Identifiant  * :</label><input type="texte" name="login" id="id"><br><br>

	<label>Mot de passe *: </label><input type="password" name="password1" id="mdp"><br><br>
	
	<label>Confirmer *:</label> <input type="password" name="password2" id="confirmer"><br><br><br>
	
	<h3>Informations professionnels</h2><br/><br/>

	<label>Prénom *:</label> <input type="texte" name="prenom" id="prénom"><br><br>

	<label>Nom *:</label> <input type="texte" name="nom" id="nom"><br><br>

	<label>Adresse mail * :</label> <input type="texte" name="mail" id="adresse" ><br><br><br>

	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
	
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
</form>
