<?php
	if(RapporteurPDO::isRoot()){
		$form=new Form("inscription");
		if($form->isCommitted()){
			if($_POST["password1"]==$_POST["password2"]){
				$rapporteur=new Rapporteur(Post::get("nom"),Post::get("prenom"),Post::get("login"),Post::get("password1"),array("day"=>Post::get("dnaiss"),"month"=>Post::get("mnaiss"),"year"=>Post::get("ynaiss")),Post::get("mail"));
				if(RapporteurPDO::addRapporteur($rapporteur)){
					echo Post::get("password1");
				}
			}
		}
	}
