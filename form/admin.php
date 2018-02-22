<form method="post" action="adminAction">
	<label>Nombre de places disponibles</label> <input type="number" name="nbplaces">
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
