<?php
	if(RapporteurPDO::isConnected()){
		$form=new Form("changePassword");
		if($form->isCommitted()){
			if(Post::get("newPassword1")==Post::get("newPassword2")){
				if(RapporteurPDO::changePassword(RapporteurPDO::getConnectedUser(),Post::get("actPassword"),Post::get("newPassword1"))){
					RapporteurPDO::getConnectedUser()->setPassword(Post::get("newPassword1"));
					echo "mot de passe changé";
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
