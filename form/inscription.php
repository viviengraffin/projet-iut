<form action="vote.php" method="post">


<div class="title">

<div align=center>
<br/>
<h2> Inscription</h2>
<span class="Grey">Veuillez remplir les cases ci-dessous :</span>
<br><br/>



<label for="id">Identifiant  * :&nbsp &nbsp &nbsp &nbsp &nbsp</label><input type="texte" name="identifiant" id="id"><br><br>

 <label for="mdp">Mot de passe *: &nbsp &nbsp &nbsp</label><input type="password" name="motdpasse" id="mdp"><br><br>
 <label for="confirmer">Confirmer *: &nbsp &nbsp &nbsp &nbsp <input type="password" name="confirmer" id="confirmer"><br><br>

<label for="prénom">Prénom *:</label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <input type="texte" name="prénom" id="prénom"><br><br>

 <label for="nom">Nom *:</label> &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp <input type="texte" name="nom" id="nom"><br><br>

<label for="adresse">Adresse mail *</label> :&nbsp &nbsp <input type="texte" name="adressemail" id="adresse" ><br><br>

<?= getCsrfObject()->addToken(true)->getHiddenInput(); ?>
 <br>
 <br>
</div>
