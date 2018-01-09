<?php
	
	if(RapporteurPDO::isRapporteur()){
		load_model("dossier");
		load_model("dossierPDO");
		
		$rapp=RapporteurPDO::getUser(intval($_GET["id"]));
		if(!$rapp->hasNote()){
			$form=new Form("vote");
		}
		else{
			echo "<b style='color:red;'>Ce dossier a été noté par un autre rapporteur</b>";
			$CONTROLLER->setView();
		}
	}
	else{
		$CONTROLLER->setView();
	}
