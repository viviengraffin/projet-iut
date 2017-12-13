<?php
	if(!RapporteurPDO::isConnected()){
		$CONTROLLER->view();
	}
	else{
		$compte=RapporteurPDO::getConnectedUser();
	}
