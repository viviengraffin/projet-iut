<?php
	
	$form=new Form("recMailCode");
	if((!RapporteurPDO::isConnected())&&($form->isCommitted())){
		if(RapporteurPDO::isGoodCode($_POST["code"])){
			$form=new Form("resetPassword");
			Session::set("mdpoublie",true);
			$CONTROLLER->setView("resetPass");
		}
		else{
			$CONTROLLER->redirect("./");
		}
	}
