<!DOCTYPE html>
<html>
	<head>
		<title>Erreur lors de la sauvegarde du fichier</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<style>
			body{
				font-family:Arial;
			}
			textarea{
				font-family:"Comic Sans MS";
			}
		</style>
		<h1 style="text-align:center;color:red;">Erreur lors de la sauvegarde du fichier</h1>
		Le fichier <span style="font-weight:bold;"><?= $filename ?></span> n'a pas pu être sauvegardé. Veuillez remplacer le fichier vous même avec le contenu ci-dessous.<br/><br/>
		<textarea style="width:100%;"><?= $content; ?></textarea><br/><br/>
		<div style="text-align:center;">
			<a href="admin">Continuer</a>
		</div>
	</body>
</html>
