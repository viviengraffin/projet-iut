<?php
	
	if(!RapporteurPDO::isConnected()){
		$form=new Form("connection");
		if($form->isCommitted()){
			if(RapporteurPDO::connection($_POST["login"],$_POST["password"],isset($_POST["souvenir"]))){
				if(RapporteurPDO::isRoot()){
					$CONTROLLER->redirect("root");
				}
				else{
					$CONTROLLER->redirect("rapporteur");
				}
			}
			else{
				echo sha256($_POST["password"])."<br/>";
				echo "Mauvais login ou mot de passe";
			}
		}
		else{
			echo "erreur";
		}
	}
	else{
		echo "vous êtes déjà connecté";
		$CONTROLLER->changeView();
	}
