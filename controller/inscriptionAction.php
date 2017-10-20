<?php
	load_model("db");
	load_model("rapporteur");
	load_model("rapporteurPDO");
	if(RapporteurPDO::isRoot()){
		if(isset($_POST["nom"])){
			if($_POST["password1"]==$_POST["password2"]){
				$rapporteur=new Rapporteur($_POST["nom"],$_POST["prenom"],$_POST["login"],$_POST["password1"]);
				if(RapporteurPDO::addRapporteur($rapporteur)){
					echo $_POST["password"];
				}
			}
		}
	}
