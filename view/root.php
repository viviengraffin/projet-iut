<!DOCTYPE html>
<html>
	<head>
		<title>Espace de gestion</title>
		<link rel="stylesheet" href="style.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header"); ?>
		<a href="changePassword">Changer de mot de passe</a><br/>
		<a href="inscription">Ajouter des rapporteurs</a><br/>
		<a href="disconnect">Déconnexion</a><br/>
		<br/><br/>
		<?php
			foreach($rapporteurs as $rapporteur){
				?>
				<a href="deleteRapporteur?id=<?= $rapporteur->getId(); ?>&<?= $token->getStringUrl(); ?>"><?= $rapporteur->getPrenom()." ".$rapporteur->getNom(); ?></a><br/>
				<?php
			}
		?>
		<?php load_view("footer"); ?>
	</body>
</html>
