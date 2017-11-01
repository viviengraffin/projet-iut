<?php
	
	if(!RapporteurPDO::isConnected()){
		$form=new Form("connection");
	}
	else{
		$CONTROLLER["redirect"]="rapporteur";
	}
