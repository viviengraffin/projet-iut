<?php
	if(RapporteurPDO::isConnected()){
		RapporteurPDO::disconnect();
	}
	$CONTROLLER["redirect"]="./";
