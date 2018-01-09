<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$dossier=DossierPDO::getDossier($_GET["id"]);
		
	}
	else{
		$CONTROLLER->setView();
	}
