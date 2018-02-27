<?php
	
	$form=new Form("forgetpass2");
	if((!RapporteurPDO::isConnected())&&($form->isCommitted())){
		if(RapporteurPDO::isGoodCode($_POST["code"])){
			$form=new Form("resetPass");
			$CONTROLLER->setView("resetPass");
		}
		else{
			$CONTROLLER->redirect("./");
		}
	}
