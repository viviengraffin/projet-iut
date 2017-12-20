<!DOCTYPE html>
<html>
	<head>
		<title>Compte <?= $compte->getLogin(); ?></title>
		<link rel="stylesheet" href="style.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view($header); ?>
		<a href="changePassword">Changer le mot de passe</a>
		<?php load_view("footer"); ?>
	</body>
</html>
