<?php
	
	if(RapporteurPDO::isRapporteur()){
		$file=new DataFile("config");
		if($file->isExist()){
			load_model("dossier");
			load_model("dossierPDO");
			$dossiers=DossierPDO::getDossierAVote();
			$nbdossiers=$file->get("nbplaces");
			$tour=$file->get("tour");
		}
		else{
			$CONTROLLER->setView();
		}
	}
	else{
		$CONTROLLER->setView();
	}
