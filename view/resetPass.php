<!DOCTYPE html>
<html>
	<head>
		<title>Réinitialisation du mot de passe</title>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="header.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header"); ?>
		<?= $form->display(); ?>
		<?php load_view("footer"); ?>
	</body>
</html>
