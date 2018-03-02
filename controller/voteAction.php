<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$file=new DataFile("config");
		if(($file->isExist())&&($file->get("enabled"))){
			$tour=$file->get("tour");
			if(!DossierPDO::hasVoted(RapporteurPDO::getConnectedUser(),$tour)){
				$csrf=getCsrfObject();
				if($csrf->usePostToken("vote")){
					$ids=explode(";",$_POST["ids"]);
					foreach($ids as $id){
						$valeur=isset($_POST["dossier".$id]);
						if($valeur){
							$rapp=DossierPDO::getDossier($id);
							DossierPDO::vote(RapporteurPDO::getConnectedUser(),$rapp,$_POST["tour"]);
						}
					}
					$CONTROLLER->redirect("resultat");
				}
			}
		}
	}
