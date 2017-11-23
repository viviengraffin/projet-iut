<?php
	class DossierPDO{
		public static function addDossier($dossier){
			$req="
				INSERT INTO dossier(nom,prenom,mail,act_enseignant,etat,anc_echelon,anc_enseign,echelon,act_recherche,act_admin,visibilite,act_enseign)
				VALUES(:nom,:prenom,:actEnseign,:ancEchelon,:echelon,:actRecherche,:actAdmin,:visibilite,:actEnseig)
			";
			$data=array(
				"nom"=>$dossier->getNom(),
				"prenom"=>$dossier->getPrenom(),
				"ancEchelon"=>$dossier->getAncienneteEchelon(),
				"ancEnseign"=>$dossier->getAncienneteEnseignement(),
				"echelon"=>$dossier->getEchelon(),
				"actRecherche"=>$dossier->getRecherche(),
				"actAdmin"=>$dossier->getTaches(),
				"visibilite"=>$dossier->getVisibilite(),
				"actEnseign"=>$dossier->getEnseignement()
			);
			$pdo=db::getInstance();
			$pdo->request($req,$data);
		}
		public static function vote($rapporteur,$dossier){
			
		}
		public static function getDossier($id){
			$req="
				SELECT *
				FROM dossier
				WHERE id=:id
			";
			$db=db::getInstance();
			$res=$db->request($req,array("id"=>$id))->fetch();
			$ret=new Dossier($res["num_dossier"],$res["nom"],$res["prenom"],$res["anc_echelon"],$res["anc_enseign"],$res["echelon"],$res["act_recherche"],$res["act_enseign"],$res["act_admin"],$res["visibilite"]);
			return($ret);
		}
	}
