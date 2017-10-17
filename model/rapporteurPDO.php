<?php
	class RapporteurPDO{
		public static function addRapporteur($rapporteur){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE login=?
			";
			$res=$db->request($req,array($rapporteur->getLogin()))->fetch()["COUNT(*)"];
			if($res==0){
				$req="
					INSERT INTO rapporteur(nom,prenom,login,password)
					VALUES(:nom,:prenom,:login,:password)
				";
				$pdo->request($req,$rapporteur->getTab());
			}
			else{
				return(false);
			}
		}
	}
