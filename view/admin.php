<!DOCTYPE html>
<html>
	<head>
		<title>Espace Administration</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<span chrono-minut="0" chrono-second="11" chrono-color-0m59s="orange" chrono-color-0m10s="red" chrono-style-0m59s="$s secondes"chrono-style-0m0s="Fini">$m et $s secondes</span><br/>
		<span chrono-minut="0" chrono-second="12" chrono-color-0m59s="purple" chrono-color-0m0s="red" chrono-style-0m0s="Terminé">$M:$S</span>
		<?php load_view("header"); ?>
		<?= $form->print(); ?>
		<?php load_view("footer"); ?>
		<script src="js/chronometre.js"></script>
	</body>
</html>
