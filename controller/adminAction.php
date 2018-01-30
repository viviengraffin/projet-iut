<?php
	if(RapporteurPDO::isRoot()){
		$form=new Form("admin");
		if($form->isCommitted()){
			$file=new DataFile("config");
			$file->set("nbtour",intval($_POST["nbtour"]));
			$file->set("tour",1);
			$file->update();
			$CONTROLLER->redirect("admin");
		}
	}
