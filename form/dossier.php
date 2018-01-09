<form method="post" action="addDossierAction">
	<label>Nom</label> <input type="text" name="nom"><br/>
	<label>Prénom</label> <input type="text" name="prenom"><br/>
	<label>Âge</label> <input type="number" name="age" min="0"><br/>
	<label>E-Mail</label> <input type="email" name="mail"><br/>
	<label>Adresse</label> <input type="text" name="adresse"><br/>
	<label>Adresse Suite</label> <input type="text" name="suite"><br/>
	<label>Ville</label> <input type="text" name="ville"><br/>
	<label>Code Postal</label> <input type="number" name="cp" size="5"><br/>
	<label>Ancienneté dans le corps de conférence</label> <input type="number" name="ancEnseign"><br/>
	<label>Échelon</label> <input type="text" name="tachesAdmin"><br/>
	<label>Ancienneté dans l'échelon</label> <input type="number" name="ancEchelon" min="0"><br/>
	<label>Premier rapporteur</label> <input name="rapp1" type="text" list="rapporteurs"><br/>
	<label>Deuxième rapporteur</label> <input type="text" name="rapp2" list="rapporteurs"><br/>
	<datalist id="rapporteurs">
		<?php
			foreach($rapporteurs as $rapporteur){
				?>
				<option value="<?= $rapporteur->getPrenom()." ".$rapporteur->getNom(). " (".$rapporteur->getLogin().")"; ?>">
				<?php
			}
		?>
	</datalist>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
