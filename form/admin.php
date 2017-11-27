<form method="post" action="adminAction">
	Nombre de dossier <input type="number" name="numdossier" value="<?= $numdossier; ?>" min="0"><br/>
	Chronomètre <input type="number" name="minut" value="<?= $minut; ?>" min="0"> <input type="number" name="second" value="<?= $second; ?>" min="0" max="59"><br/>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
