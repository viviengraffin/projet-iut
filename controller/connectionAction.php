<?php
	
	if(!RapporteurPDO::isConnected()){
		$form=new Form("connection");
		if($form->isCommitted()){
			if(RapporteurPDO::connection($_POST["login"],$_POST["password"])){
				echo "<pre>";
				var_dump(RapporteurPDO::getConnectedUser());
				echo "</pre>";
			}
			else{
				echo sha512($_POST["password"])."<br/>";
				echo "Mauvais login ou mot de passe";
			}
		}
		else{
			echo "erreur";
		}
	}
	else{
		echo "vous êtes déjà connecté";
		$CONTROLLER["view"]="";
	}
