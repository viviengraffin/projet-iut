<!DOCTYPE html>
<html>
	<head>
		<title>Espace de gestion</title>
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <link rel="stylesheet" href="header.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header-root"); ?>
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
