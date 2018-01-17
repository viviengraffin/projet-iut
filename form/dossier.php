<form method="post" action="addDossierAction">
	<label>Nom</label> <input type="text" name="nom"><br/>
	<label>Prénom</label> <input type="text" name="prenom"><br/>
	<label>Âge</label> <input type="number" name="age"><br/>
	<label>E-Mail</label> <input type="email" name="mail"><br/>
	
	<br/>
	
	<label>Ancienneté dans le corps de conférence</label> <input type="number" name="ancConf"><br/>
	<label>Échelon</label> <input type="text" name="echelon"><br/>
	<label>Ancienneté dans l'échelon</label> <input type="number" name="ancEchelon"><br/>
	<label>Premier rapporteur</label> <input name="rapp1" type="text" list="rapporteurs"><br/>
	<label>Deuxième rapporteur</label> <input type="text" name="rapp2" list="rapporteurs"><br/><br/><br/><br/>
	<datalist id="rapporteurs">
		<?php
			foreach($rapporteurs as $rapporteur){
				?>
				<option value="<?= $rapporteur->getPrenom()." ".$rapporteur->getNom(). " (".$rapporteur->getLogin().")"; ?>">
				<?php
			}
		?>
	</datalist>
	
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
