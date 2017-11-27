<?php
	if(RapporteurPDO::isRoot()){
		$form=new Form("admin");
		if($form->isCommitted()){
			$file=new DataFile("config");
			$file->set("numdossier",intval(Data::$post->get("numdossier")));
			$file->set("minut",intval(Data::$post->get("minut")));
			$file->set("second",intval(Data::$post->get("second")));
			$file->update();
			$CONTROLLER->redirect("admin");
		}
	}
