<?php
	if(RapporteurPDO::isConnected()){
		$header="header-user";
		if(RapporteurPDO::isRoot()){
			$header="header-root";
		}
		$form=new Form("changePassword");
	}
	else{
		$CONTROLLER->changeView();
	}
