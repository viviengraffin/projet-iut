<form method="post" action="adminAction">
	<label>Nombre de tours</label> <input type="number" name="nbtour">
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
