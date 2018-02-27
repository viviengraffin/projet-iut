<?php
	
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$dossiers=DossierPDO::getResult();
		$bonus="";
	}
	else if(RapporteurPDO::isRoot()){
		$dossiers=DossierPDO::getResult();
		$bonus="<a href='finishVote'>Finir le vote</a>";
	}
	else{
		$CONTROLLER->setView();
	}
