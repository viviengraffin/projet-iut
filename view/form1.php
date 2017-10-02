<!DOCTYPE html>
<html>
	<head>
		<title>Formulaire Exercice 1</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<form method="post" action="resform1">
			Valeur en <select name="dev">
				<option value="F">Francs (F)</option>
				<option value="€">Euro (€)</option>
				<option value="$">Dollar ($)</option>
			</select> <input type="text" name="value"><br/>
			à donner en <select name="devconv">
				<option value="F">Francs (F)</option>
				<option value="€">Euro (€)</option>
				<option value="$">Dollar ($)</option>
			</select><br/>
			<input type="submit" value="Valider">
		</form>
	</body>
</html>
