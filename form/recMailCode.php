<form method="post" action="forgetpass3">
	<label>Code</label> <input type="number" name="code"><br/>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
