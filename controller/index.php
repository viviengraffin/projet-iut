<?php
	
	if(!RapporteurPDO::isConnected()){
		$form=new Form("connection");
	}
	else{
		if(RapporteurPDO::isRoot()){
			$CONTROLLER->redirect("root",true);
		}
		else{
			$CONTROLLER->redirect("rapporteur",true);
		}
	}
