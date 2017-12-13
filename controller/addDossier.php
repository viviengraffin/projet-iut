<?php
	if(RapporteurPDO::isRoot()){
		$res=RapporteurPDO::getList();
		$rapporteurs=array();
		$connected=RapporteurPDO::getConnectedUser();
		foreach($res as $line){
			if($line->getLogin()!=$connected->getLogin()){
				$rapporteurs=array_merge($rapporteurs,array($line));
			}
		}
		$form=new Form("dossier");
		$form->setData(array("rapporteurs"=>$rapporteurs));
	}
	else{
		$CONTROLLER->changeView();
	}
