<?php
	if(RapporteurPDO::isConnected()){
		RapporteurPDO::disconnect();
	}
	getCsrfObject()->clearAllTokens();
	$CONTROLLER->redirect();
