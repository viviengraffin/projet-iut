<?php
	if((RapporteurPDO::isRoot())&&(getCsrfObject()->useGetToken())){
		$user=RapporteurPDO::getUser(intval($_GET["id"]));
		RapporteurPDO::removeUser($user);
		$CONTROLLER->redirect("root");
	}
