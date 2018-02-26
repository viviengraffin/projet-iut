<?php
	if(RapporteurPDO::isRoot()){
		load_model("dossier");
		load_model("dossierPDO");
		
		$file=new DataFile("config");
		$file->set("enabled",false);
		$file->update();
		$tour=$file->get("tour");
		$nbaccepted=$file->get("nbplaces")-DossierPDO::applyVotes($tour,$file->get("nbplaces"));
		if($nbaccepted==0){
			DossierPDO::clearVotes();
			$file->delete();
			$CONTROLLER->redirect("root");
		}
		else{
			$file->get("nbplaces",$nbaccepted);
			$tour++;
			$file->set("tour",$tour);
			$file->update();
			$CONTROLLER->redirect("admin");
		}
	}
