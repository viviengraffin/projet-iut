<!DOCTYPE html>
<html>
	<head>
		<title>Note du dossier n° <?= $dossier->getNum(); ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
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
		</table>
		<?= $form->display(); ?>
		<?php load_footer("footer"); ?>
	</body>
</html>
