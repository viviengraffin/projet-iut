<?php
	if(RapporteurPDO::isRoot()){
		load_model("dossier");
		load_model("dossierPDO");
		
		$file=new DataFile("config");
		$file->set("enabled",false);
		$file->update();
		$tour=$file->get("tour");
		$nbplaces=DossierPDO::applyVotes($tour,$file->get("nbplaces"));
		$file->set("nbrapporteur",$GLOBALS["rapps"]);
		if($nbplaces==0){
			$file->set("tour",$tour+1);
			$file->update();
			$CONTROLLER->redirect("resultat?finish");
		}
		else{
			$file->set("nbplaces",$nbplaces);
			$tour++;
			$file->set("tour",$tour);
			$file->update();
			$CONTROLLER->redirect("resultat");
		}
	}
