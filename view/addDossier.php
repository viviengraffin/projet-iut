<!DOCTYPE html>
<html>
	<head>
		<title>Ajout d'un dossier</title>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="inscription.css">
		<meta name="viewport" content="width=device-width">
		<meta charset="UTF-8">
	</head>
	<body>
		<?php load_view("header"); ?>
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
