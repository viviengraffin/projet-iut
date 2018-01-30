<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$csrf=getCsrfObject();
		if($csrf->usePostToken("note")){
			$ids=explode(";",$_POST["ids"]);
			foreach($ids as $id){
				$dossier=DossierPDO::getDossier($id);
				$dossier->setNotes($_POST["recherche".$id],$_POST["enseign".$id],$_POST["admin".$id],$_POST["visibilite".$id]);
				DossierPDO::note(RapporteurPDO::getConnectedUser(),$dossier);
				$CONTROLLER->redirect("vote");
			}
		}
	}
	else{
		$CONTROLLER->setView();
	}
