<?php
	if(RapporteurPDO::isConnected()){
		$form=new Form("changePassword");
	}
	else{
		$CONTROLLER->changeView();
	}
