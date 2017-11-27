<?php
	if(RapporteurPDO::isRoot()){
		$file=new DataFile("config");
		if($file->isExist()){
			$numdossier=$file->get("numdossier");
			$minut=$file->get("minut");
			$second=$file->get("second");
		}
		else{
			$numdossier="";
			$minut=0;
			$second=0;
		}
		$form=new Form("admin");
		$form->setData([
			"numdossier"=>$numdossier,
			"minut"=>$minut,
			"second"=>$second
		]);
	}
