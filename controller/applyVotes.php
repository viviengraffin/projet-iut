<?php
	if(RapporteurPDO::isRoot()){
		load_model("dossier");
		load_model("dossierPDO");
		
		$file=new DataFile("config");
		$file->set("enabled",false);
		$file->update();
		$tour=$file->get("tour");
		$nbplaces=DossierPDO::applyVotes($tour,$file->get("nbplaces"));
		if($nbplaces==0){
			$CONTROLLER->redirect("resultat");
		}
		else{
			$file->set("nbplaces",$nbplaces);
			$tour++;
			$file->set("tour",$tour);
			$file->update();
			$CONTROLLER->redirect("admin");
		}
	}
