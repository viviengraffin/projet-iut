<form method="post" action="forgetpass2">
	<label>Identifiant</label> <input type="text" name="login"><br/>
	<label>Adresse Mail</label> <input type="email" name="mail"><br/><br/>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
