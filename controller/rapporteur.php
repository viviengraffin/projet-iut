<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isConnected()){
		if(!RapporteurPDO::isRapporteur()){
			$CONTROLLER->redirect("root");
		}
		else{
			$dossiers=dossierPDO::getList(RapporteurPDO::getConnectedUser());
		}
	}
	else{
		$CONTROLLER->setView();
	}
