<!DOCTYPE html>
<html>
	<head>
		<title>Note du dossier n° <?= $dossier->getNum(); ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<link rel="stylesheet" href="header.css">
	</head>
	<head>
		<?php load_view("header-user"); ?>
		<table border="1">
			<tr>
				<td>
					NOM
				</td>
				<td>
					<?= $dossier->getNom(); ?>
				</td>
			</tr>
			<tr>
				<td>
					PRÉNOM
				</td>
				<td>
					<?= $dossier->getPrenom(); ?>
				</td>
			</tr>
			<tr>
				<td>
					ANCIENNETÉ ÉCHELON
				</td>
				<td>
					<?= $dossier->getAncienneteEchelon(); ?>
				</td>
			</tr>
			<tr>
				<td>
					ANCIENNETÉ ENSEIGNEMENT
				</td>
				<td>
					<?= $dossier->getAncienneteEnseignement(); ?>
				</td>
			</tr>
			<tr>
				<td>
					ÉCHELON
				</td>
				<td>
					<?= $dossier->getEchelon(); ?>
				</td>
			</tr>
		</table><br/><br/>
		<?= $form->display(); ?>
		<?php load_view("footer"); ?>
	</body>
</html>
