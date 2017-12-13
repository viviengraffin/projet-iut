<?php
	if(RapporteurPDO::isRoot()){
		$form=new Form("admin");
		if($form->isCommitted()){
			$file=new DataFile("config");
			$file->set("numdossier",intval(Data::$post->get("numdossier")));
			$file->set("minut",intval(Data::$post->get("minut")));
			$file->set("second",intval(Data::$post->get("second")));
			$good=true;
			try{
				$file->update();
			}
			catch(DataFileWriteException $e){
				$good=false;
				$content=$e->getContent();
				$filename=$e->getFilename();
				$CONTROLLER->changeView("saveError");
			}
			if($good){
				$CONTROLLER->redirect("admin");
			}
		}
	}
