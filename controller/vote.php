<?php
	
	if(RapporteurPDO::isRapporteur()){
		$file=new DataFile("config");
		if(($file->isExist())&&($file->get("enabled"))){
			load_model("dossier");
			load_model("dossierPDO");
			$dossiers=DossierPDO::getDossierAVote();
			$nbdossiers=$file->get("nbplaces");
			$time=diffTime($file->get("time"),time());
			$tour=$file->get("tour");
		}
		else{
			$CONTROLLER->setView();
		}
	}
	else{
		$CONTROLLER->setView();
	}
