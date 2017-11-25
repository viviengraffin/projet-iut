<form method="post" action="addDossierAction">
	Nom <input type="text" name="nom"><br/>
	Prénom <input type="text" name="prenom"><br/>
	Âge <input type="number" name="age"><br/>
	E-Mail <input type="email" name="mail"><br/>
	Adresse <input type="text" name="adresse"><br/>
	Adresse Suite <input type="text" name="suite"><br/>
	Ville <input type="text" name="ville"><br/>
	Code Postal <input type="number" name="cp"><br/>
	<br/>
	Ancienneté dans le corps de conférence <input type="number" name="ancConf"><br/>
	Échelon <input type="text" name="echelon"><br/>
	Ancienneté dans l'échelon <input type="number" name="ancEchelon"><br/>
	Activité de Recherche <select name="actRecherche">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	Tâches administratives <select name="tachesAdmin">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	Visibilité <select name="visibilite">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	Deuxième rapporteur <select name="rapp2" type="number">
		<?php
			foreach($rapporteurs as $rapporteur){
				?>
				<option value="<?= $rapporteur->getId(); ?>"><?= htmlentities($rapporteur->getPrenom()." ".$rapporteur->getNom()); ?></option>
				<?php
			}
		?>
	</select><br/>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
