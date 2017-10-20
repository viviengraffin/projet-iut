<?php
	if($_SESSION["p_connect"]->getLogin()=="root"){
		if(isset($_POST["nom"])){
			load_model("db");
			load_model("rapporteur");
			load_model("rapporteurPDO");
			
			if($_POST["password1"]==$_POST["password2"]){
				$rapporteur=new Rapporteur($_POST["nom"],$_POST["prenom"],$_POST["login"],$_POST["password"]);
				if(RapporteurPDO::addRapporteur($rapporteur)){
					echo $_POST["password"];
				}
			}
		}
	}
