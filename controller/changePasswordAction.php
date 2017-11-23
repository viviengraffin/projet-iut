<?php
	if(RapporteurPDO::isConnected()){
		$form=new Form("changePassword");
		if($form->isCommitted()){
			if(Data::$post->get("newPassword1")==Data::$post->get("newPassword2")){
				if(RapporteurPDO::changePassword(RapporteurPDO::getConnectedUser(),Data::$post->get("actPassword"),Data::$post->get("newPassword1"))){
					RapporteurPDO::getConnectedUser()->setPassword(Data::$post->get("newPassword1"));
					$CONTROLLER->redirect();
				}
				else{
					echo "echec";
				}
			}
			else{
				echo "mot de passes différents";
			}
		}
		else{
			echo "où sont les données ?";
		}
	}
	else{
		
	}
