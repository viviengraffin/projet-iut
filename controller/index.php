<?php
	
	if(!RapporteurPDO::isConnected()){
		echo $_SERVER["HTTP_HOST"];
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
