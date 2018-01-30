<?php
	
	if(RapporteurPDO::isRapporteur()){
		load_model("dossier");
		load_model("dossierPDO");
		$dossiers=DossierPDO::getDossierAVote();
		$nbdossiers=1;
		$tour=0;
	}
	else{
		$CONTROLLER->setView();
	}
