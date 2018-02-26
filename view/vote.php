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
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="header.css">
</head>
<body>
<?php load_view("header-user"); ?>



<br><br><br>
<div >

<div align="right" style="margin-right:130px;">
	<b>Nombre de candidats:</b> &nbsp;&nbsp; <?= $nbdossiers; ?> <br/>
	<b>Nombre de candidats restants:</b> &nbsp; &nbsp; <span id="compteur">0</span><br/>
	<b>Chronomètre:</b>&nbsp;&nbsp; <span chrono-time="<?= $time; ?>" chrono-color-0m10s="orange" chrono-color-0m0s="red">$M:$S</span><br/>
	<b>Tour:</b> <?= $tour ?? ""; ?>

</div>
<br>
    


<form method="post" action="voteAction">
<TABLE align="center" border="1" width="80%">
        <TR>
            <TD align="center" width="10%">Nom</TD>
            <TD align="center" width="10%">Prénom</TD>
            <TD align="center" width="10%">Note</TD>
            <TD align="center" width="10%">
			</TD>
		</TR>
		<?php
			$ids="";
			foreach($dossiers as $dossier){
				if($ids==""){
					$ids.=$dossier->getNum();
				}
				else{
					$ids.=";".$dossier->getNum();
				}
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
   </TABLE><br/><br/>
   <div style="text-align:center;">
	<input type="submit" value="Valider">
   </div>
   <input type="hidden" name="ids" value="<?= $ids; ?>">
   <input type="hidden" name="tour" value"<?= $tour; ?>">
   <?= getCsrfObject()->addToken("vote")->getHiddenInput(); ?>
</form>
<script>
	var nbdossiers=<?= $nbdossiers."\n"; ?>
	var form=document.querySelector("form")
	form.addEventListener("submit",function(e){
		if(compte()<0){
			e.preventDefault()
		}
	})
</script>
<br>
<div align="right">
<?php load_view("footer"); ?>
<script>
	var checkboxs=document.querySelectorAll("input[type=checkbox]")
	var compteur=document.querySelector("span#compteur")
	console.dir(checkboxs)
	checkboxs.forEach(function(checkbox){
		checkbox.addEventListener("click",getFunction(checkbox))
	})
	function getFunction(checkbox){
		return(function(){
			compte()
		})
	}
	compteur.innerText=nbdossiers
	function compte(){
		var compte=nbdossiers
		checkboxs.forEach(function(c){
			if(c.checked){
				compte--
			}
		})
		compteur.innerText=compte
		return(compte)
	}
</script>
<script src="js/chronometre.js"></script>
</div>
</body>
</html>
