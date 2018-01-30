<?php
	if(RapporteurPDO::isRoot()){
		$file=new DataFile("config");
		if($file->isExist()){
			$CONTROLLER->setView("tourAdmin");
			$form=new Form("tourAdmin");
			
			$nbtour=$file->get("nbtour");
			$tour=$file->get("tour")+1;
		}
		else{
			$form=new Form("admin");
		}
	}
	else{
		$CONTROLLER->view();
	}
