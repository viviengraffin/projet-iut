<!DOCTYPE html>
<html>
	<head>
		<title>Index</title>
		<link rel="stylesheet" href="style.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header"); ?>
		<?= $form->display(); ?>
		<br/><br/>
		<a href="forgetpass">Mot de passe oublié</a>
		<?php load_view("footer"); ?>
	</body>
</html>
