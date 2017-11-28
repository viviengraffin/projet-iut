<!DOCTYPE html>
<html>
	<head>
		<title>Espace Administration</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<span chrono-time="<?= $minut; ?>m<?= $second; ?>s" chrono-color-r0m15s="orange" chrono-style-r0m0s="Fin" chrono-color-r0m10s="red" chrono-style-1m0s="$m minutes et $s secondes" chrono-asc>$s secondes</span><br/>
		<span chrono-time="1m5s" chrono-color-0m59s="orange" chrono-style-r0m0s="Fin" chrono-color-r0m10s="red" chrono-style-r0m59s="$s secondes">$m minutes et $s secondes/$mdef minutes et $sdef secondes</span><br/>
		<?php load_view("header"); ?>
		<?= $form->print(); ?>
		<?php load_view("footer"); ?>
		<script src="js/chronometre.js"></script>
	</body>
</html>
