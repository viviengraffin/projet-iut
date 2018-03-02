<?php
	
	if(RapporteurPDO::isRapporteur()){
		$file=new DataFile("config");
		if(($file->isExist())&&($file->get("enabled"))){
			$tour=$file->get("tour");
			load_model("dossier");
			load_model("dossierPDO");
			if(!DossierPDO::hasVoted(RapporteurPDO::getConnectedUser(),$tour)){
				$dossiers=DossierPDO::getDossierAVote();
				$nbdossiers=$file->get("nbplaces");
				$time=diffTime($file->get("time"),time());
			}
			else{
				$CONTROLLER->setView("errorVote");
			}
		}
		else{
			$CONTROLLER->setView("errorVote");
		}
	}
	else{
		$CONTROLLER->setView();
	}
