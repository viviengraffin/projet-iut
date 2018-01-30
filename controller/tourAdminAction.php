<?php
	
	if(RapporteurPDO::isRoot()){
		$file=new DataFile("config");
		
		$actMin=date("m");
		$actSec=date("s");
		$actMin+=$_POST["minut"];
		$actSecond+=$_POST["second"];
		$date=date("U",time()+$actMin*60+$actSec);
		$file->set("time",$date,true);
		
		$CONTROLLER->redirect("displayTime");
	}
