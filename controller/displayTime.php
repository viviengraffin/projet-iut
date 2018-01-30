<?php
	
	if(RapporteurPDO::isRoot()){
		$file=new DataFile("config");
		$time=$file->get("time");
		$time=diffTime($time,time());
	}
	else{
		$CONTROLLER->setView();
	}
