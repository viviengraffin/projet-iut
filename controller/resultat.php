<?php
	
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$dossiers=DossierPDO::getResult();
	}
	else{
		$CONTROLLER->setView();
	}
