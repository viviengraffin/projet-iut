<?php
	
	if(Session::exist("mdpoublie")){
		$form=new Form("resetPassword");
		if($form->isCommitted()){
			if($_POST["pass1"]==$_POST["pass2"]){
				RapporteurPDO::resetPassword(Session::get("mdpuser"),$_POST["pass1"]);
				$CONTROLLER->redirect("./");
			}
			else{
				echo "Les mots de passes sont différents";
			}
		}
	}
