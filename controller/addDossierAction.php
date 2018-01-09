<?php
	load_model("dossierPDO");
	load_model("dossier");
	
	if(RapporteurPDO::isRoot()){
		$form=new Form("dossier");
		if($form->isCommitted()){
			try{
				$rapp1=RapporteurPDO::getUser(explode(")",explode("(",$_POST["rapp1"])[1])[0]);
				$rapp2=RapporteurPDO::getUser(explode(")",explode("(",$_POST["rapp2"])[1])[0]);
			}
			catch(Exception $e){
				die("Erreur lors de la récupération d'un rapporteur");
			}
			$dossier=new Dossier($_POST["nom"],$_POST["prenom"],$_POST["ancEchelon"],$_POST["ancEnseign"],$_POST["tachesAdmin"],$rapp1,$rapp2);
			DossierPDO::addDossier($dossier);
			$CONTROLLER->redirect("rapporteur");
		}
	}
