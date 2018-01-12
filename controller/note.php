<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$dossier=DossierPDO::getDossier($_GET["id"]);
		$rapp=RapporteurPDO::getConnectedUser();
		if(($rapp!=$dossier->getRapporteur1())&&($rapp!=$dossier->getRapporteur2())){
			echo "<b style='color:red;'>Vous n'avez pas le droit de noter ce dossier</b>";
			$CONTROLLER->setView();
		}
		else{
			$form=new Form("note");
		}
	}
	else{
		$CONTROLLER->setView();
	}
