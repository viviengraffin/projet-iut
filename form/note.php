<form method="post" action="noteAction">
	<label>Activité de recherche</label> <select name="recherche">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	<label>Activité Administrateurs</label> <select name="admin">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	<label>Activité d'enseignement</label> <select name="enseign">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/>
	<label>Visibilité</label> <select name="visibilite">
		<option>=</option>
		<option>+</option>
		<option>++</option>
	</select><br/><br/><br/>
	<div style="text-align:center;">
		<input type="submit" value="Valider">
	</div>
	<?= getCsrfObject()->addToken()->getHiddenInput(); ?>
</form>
