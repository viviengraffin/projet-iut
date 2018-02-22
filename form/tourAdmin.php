<form method="post" action="tourAdminAction">
	<label>Chronomètre</label> <input type="number" name="minut" min="0">:<input type="number" name="second" min="0" max="59"><br/>
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
</form>
