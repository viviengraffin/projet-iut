<!DOCTYPE html>
<html>
	<head>
		<title>Ajout d'un dossier</title>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="inscription.css">
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <link rel="stylesheet" href="header.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header-root"); ?>
		<h2>Ajout de dossier</h2>
		<?= $form->display(); ?>
		<?php load_view("footer"); ?>
		<script>
			var form=document.querySelector("form")
			var inputs=form.querySelectorAll("input,textarea,select")
			var labels=form.querySelectorAll("label")
			labels.forEach(function(label){
				label.style.left="150px"
			})
			inputs.forEach(function(input){
				input.style.left="500px"
			})
		</script>
	</body>
</html>
