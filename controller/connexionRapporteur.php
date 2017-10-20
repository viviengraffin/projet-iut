<?php
	if(isset($_POST["login"])&&(isset($_POST["password"]))){
		load_model("db");
		load_model("rapporteurPDO");
		
		$c=rapporteurPDO::connect($_POST["login"],$_POST["password"]);
		if($c===false){
			$CONTROLLER["redirect"]="connection"
		}
		else{
			$_SESSION["rapporteur"]=$c;
		}
	}
