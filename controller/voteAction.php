<?php
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$csrf=getCsrfObject();
		if($csrf->usePostToken("vote")){
			
		}
	}
