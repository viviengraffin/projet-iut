<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$form=new Form("note");
		if($form->isCommitted()){
			$dossier=DossierPDO::getDossier($_GET["id"]);
			$dossier->setNotes($_POST["recherche"],$_POST["enseign"],$_POST["admin"],$_POST["visibilite"]);
			DossierPDO::note(RapporteurPDO::getConnectedUser(),$dossier);
		}
	}
	else{
		$CONTROLLER->setView();
	}
