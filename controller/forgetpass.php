<?php
	if(RapporteurPDO::isConnected()){
		$CONTROLLER->view();
	}
	else{
		$form=new Form("forgetpass");
	}
