<!DOCTYPE html>
<html>
	<head>
		<title>Erreur 404</title>
		<meta charset="UTF-8">
		<style>
			h1{
				color:red;
			}
		</style>
	</head>
	<body>
		<?php load_view("header"); ?>
		<h1>Erreur 404</h1>
		La page <?= $CONTROLLER["url"]; ?> n'existe pas.
		<?php load_view("footer"); ?>
	</body>
</html>
