<form method="post" action="inscriptionAction">
	Nom <input type="text" name="nom"><br/>
	Prénom <input type="text" name="prenom"><br/>
	Identifiant <input type="text" name="login"><br/>
	Mot de passe <input type="password" name="password1"><br/>
	Répétez <input type="password" name="password2"><br/>
	Adresse Mail <input type="email" name="mail"><br/>
	<select date-day="test" null no-future-date name="dnaiss" two-char-day></select>
	<select date-month="test" month-label name="mnaiss" two-char-month></select>
	<select date-year="test" limit="t" reverse-year name="ynaiss"></select><br/>
	<input type="submit" value="Valider">
	<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
</form>
