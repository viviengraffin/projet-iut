<?php
	
	if(RapporteurPDO::isRoot()){
		$form=new Form("tourAdmin");
		if($form->isCommitted()){
			$file=new DataFile("config");
			
			$date=date("U")+$_POST["minut"]*60+$_POST["second"];
			$file->set("time",$date);
			$file->set("nbdossiers",intval($_POST["nbdossiers"]));
			$file->set("enabled",true);
			$file->update();
			
			$CONTROLLER->redirect("displayTime");
		}
	}
