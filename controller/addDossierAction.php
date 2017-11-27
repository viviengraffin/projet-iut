<?php
	load_model("dossierPDO");
	load_model("dossier");
	
	
	if(RapporteurPDO::isRoot()){
		$form=new Form("dossier");
		if($form->isCommitted()){
			$dossier=new Dossier(null,$_POST["nom"],$_POST["prenom"],$_POST["ancEchelon"],$_POST["ancEnseign"],$_POST["tachesAdmin"],$_POST["visibilite"],RapporteurPDO::getConnectedUser(),RapporteurPDO::getUser(intval($_POST["rapp2"])));
			DossierPDO::addDossier($dossier);
			$CONTROLLER->redirect("rapporteur");
		}
	}
