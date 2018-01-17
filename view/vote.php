<!DOCTYPE html>
<html>

	<meta charset="UTF-8">
<head>
	<title> Page vote</title>
	<link rel="stylesheet" href="vote.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<link rel="stylesheet" href="header.css">
</head>
<body>
<?php load_view("header-user"); ?>



<br><br><br>
<div >

<div align="right" style="margin-right:130px;">
	Nombre de personnes: &nbsp; &nbsp; <span id="compteur">0</span><br/><br>

  Chronomètre: &nbsp; &nbsp;  <span chrono-time="5m50s" chrono-color-r1m50s="red">$m:$S</span>
</div>
<br>
    



<TABLE align="center" border="1" width="80%">
       
        <TR>
            <TD align="center" width="10%">Nom</TD>
            <TD align="center" width="10%">Prénom</TD>
            <TD align="center" width="10%">Note</TD>
            <TD align="center" width="10%">
			</TD>
		</TR>
		<?php
			foreach($dossiers as $dossier){
				?>
				<TR>
					<TD align="center" width="10%"><?= $dossier->getNom(); ?></TD>
					<TD align="center" width="10%"><?= $dossier->getPrenom(); ?></TD>
					<TD align="center" width="10%"><?= $dossier->getNote(); ?></TD>
					<TD align="center" width="10%">
						<INPUT type="checkbox" name="dossier<?= $dossier->getNum(); ?>">
					</TD>
				</TR>
				<?php
			}
		?>
   </TABLE>

<br><br><br><br><br>
<br>
<div align="center">
<input  type="submit" name="confirmer" value="confirmer" >
</div>
<script src="js/chronometre.js"></script>
<div align="right">
<?php load_view("footer"); ?>
<script>
	var checkboxs=document.querySelectorAll("input[type=checkbox]")
	var compteur=document.querySelector("span#compteur")
	console.dir(checkboxs)
	checkboxs.forEach(function(checkbox){
		checkbox.addEventListener("click",function(){
			var compte=0
			checkboxs.forEach(function(checkbox){
				if(checkbox.checked){
					compte++
				}
				
			})
			compteur.innerText=compte
		})
	})
</script>
</div>
</body>
</html>
