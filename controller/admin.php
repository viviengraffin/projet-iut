<?php
	if(RapporteurPDO::isRoot()){
		$file=new DataFile("config");
		if($file->isExist()){
			$CONTROLLER->setView("tourAdmin");
			$form=new Form("tourAdmin");
			
			$tour=$file->get("tour");
		}
		else{
			$form=new Form("admin");
		}
	}
	else{
		$CONTROLLER->view();
	}
