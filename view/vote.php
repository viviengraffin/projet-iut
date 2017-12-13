<!DOCTYPE html>
<html>

	<meta charset="UTF-8">
<head>
	<title> Page vote</title>
	<link rel="stylesheet" href="vote.css">
</head>
<body>

<BODY>
<br><br><br>

<h2>Vote éléctronique </h2>



<br><br><br>
<div >

<div align="right" style="margin-right:130px;">
	Nombre de personnes: &nbsp; &nbsp; <span id="compteur">0</span><br/><br>

  Chronomètre: &nbsp; &nbsp;  <span chrono-time="5m50s" chrono-color-r1m50s="red">$m:$S</span>
</div>
<br>
    



<TABLE align="center" border="1" width="80%">
       
        <TR>
            <TD align="center" width="10%">Nom
            <TD align="center" width="10%">Prénom 
            <TD align="center" width="10%">Etablisement
            <TD align="center" width="10%">Note
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">
            


       <TR>
            <TD align="center" width="10%">Nom
            <TD align="center" width="10%">Prénom
            <TD align="center" width="10%">Etblissement
            <TD align="center" width="10%">Li
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">
  


            	<TR>
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 2
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">
            	<TR>
            <TD align="center"  width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 2
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">
	<TR>
            <TD align="center"  width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 2
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au
 bouton">



	<TR>
            <TD align="center"  width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 2
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">


<TR>
            <TD align="center"  width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 2
            <TD align="center" width="10%">Ligne 2, colonne 1
            <TD align="center" width="10%">Ligne 2, colonne 
            <TD align="center" width="10%">
  
 <INPUT type="checkbox" name="nom" value="valeur attachée au bouton">





</div>
   </TABLE>

<br><br><br><br><br>
<br>
<div align="center">
<input  type="submit" name="confirmer" value="confirmer" >
</div>
<script src="chronometre.js"></script>
<div align="right">
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
