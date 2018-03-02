<?php
	
	load_model("dossier");
	load_model("dossierPDO");
	
	if(RapporteurPDO::isRapporteur()){
		$header="header-user";
		$dossiers=DossierPDO::getResult();
		$bonus="";
	}
	else if(RapporteurPDO::isRoot()){
		$header="header-root";
		$dossiers=DossierPDO::getResult();
		if(isset($_GET["finish"])){
			$bonus="<center><a href='finishVote'>Finir le vote</a></center>";
		}
		else{
			$bonus="<center><a href='admin'>Tour suivant</a></center>";
		}
	}
	else{
		$CONTROLLER->setView();
	}
