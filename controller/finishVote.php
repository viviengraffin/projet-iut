<?php
	if(RapporteurPDO::isRoot()){
		load_model("dossier");
		load_model("dossierPDO");
		$file=new DataFile("config");
		DossierPDO::clearVotes();
		$file->delete();
		$CONTROLLER->redirect("root");
	}
