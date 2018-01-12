<?php
	
	if(RapporteurPDO::isRapporteur()){
		load_model("dossier");
		load_model("dossierPDO");
		$dossiers=DossierPDO::getList();
	}
	else{
		$CONTROLLER->setView();
	}
