<form method="post" action="adminAction">
	<label>Nombre de dossier</label> <input type="number" name="numdossier" value="<?= $numdossier; ?>" min="0"><br/>
	<label>Chronomètre</label> <input type="number" name="minut" value="<?= $minut; ?>" min="0"> : <input type="number" name="second" value="<?= $second; ?>" min="0" max="59"><br/><br/><br/><br/>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
