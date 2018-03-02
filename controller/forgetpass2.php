<?php
	
	if(!RapporteurPDO::isConnected()){
		$form=new Form("forgetpass");
		if($form->isCommitted()){
			$user=RapporteurPDO::getUser($_POST["login"]);
			if(RapporteurPDO::sendRecoveryMail($user,$_POST["mail"])){
				$form=new Form("recMailCode");
				Session::set("mdpuser",$user);
				$CONTROLLER->setView("recMailCode");
			}
		}
	}
