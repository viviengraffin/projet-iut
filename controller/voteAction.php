<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$csrf=getCsrfObject();
		if($csrf->usePostToken("vote")){
			$ids=explode(";",$_POST["ids"]);
			foreach($ids as $id){
				$valeur=isset($_POST["dossier".$id]);
				$rapp=DossierPDO::getDossier($id);
				DossierPDO::vote(RapporteurPDO::getConnectedUser(),$rapp,$_POST["tour"],$valeur);
				$CONTROLLER->redirect("resultat");
			}
		}
	}
