<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$dossiers=DossierPDO::getList(RapporteurPDO::getConnectedUser());
	}
	else{
		$CONTROLLER->setView();
	}
