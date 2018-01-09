<?php
	class DossierPDO{
		public static function addDossier($dossier){
			$req="
				INSERT INTO dossier(nom,prenom,etat,anc_echelon,anc_enseign,echelon,rapporteur1,rapporteur2)
				VALUES(:nom,:prenom,0,:ancEchelon,:ancEnseign,:echelon,:rapporteur1,:rapporteur2)
			";
			$data=array(
				"nom"=>$dossier->getNom(),
				"prenom"=>$dossier->getPrenom(),
				"ancEchelon"=>$dossier->getAncienneteEchelon(),
				"ancEnseign"=>$dossier->getAncienneteEnseignement(),
				"echelon"=>$dossier->getEchelon(),
				"rapporteur1"=>$dossier->getRapporteur1()->getId(),
				"rapporteur2"=>$dossier->getRapporteur2()->getId()
			);
			$pdo=db::getInstance();
			$pdo->request($req,$data);
		}
		public static function vote($rapporteur,$dossier,$tour){
			$req="
				INSERT INTO vote(rapporteur,dossier,tour)
				VALUES(:rapporteur,:dossier,:tour)
			";
			$data=array(
				"rapporteur"=>$rapporteur->getId(),
				"dossier"=>$dossier->getNum(),
				"tour"=>$tour
			);
			$pdo=db::getInstance();
			$pdo->request($req,$data);
		}
		public static function getDossier($id){
			$req="
				SELECT *
				FROM dossier
				WHERE id=:id
			";
			$db=db::getInstance();
			$res=$db->request($req,array("id"=>$id))->fetch();
			$ret=new Dossier($res["num_dossier"],$res["nom"],$res["prenom"],$res["anc_echelon"],$res["anc_enseign"],$res["echelon"],$res["act_recherche"],$res["act_enseign"],$res["act_admin"],$res["visibilite"],$res["rapporteur1"],$res["rapporteur2"]);
			return($ret);
		}
		public static function note($rapporteur,$dossier){
			$req="
				SELECT *
				FROM dossier
				WHERE num=:num
			";
			$data=array("num"=>$dossier->getNum());
			$pdo=db::getInstance();
			$res=$pdo->request($req,$data);
			$rid=$rapporteur->getId();
			if(($res["rapporteur1"]==$rid)||($res["rapporteur2"]==$rid)){
				if($res["act_recherche"]==""){
					$req="
						UPDATE dossier
						SET act_recherche=:recherche,act_admin=:admin,visibilite=:visibilite,act_enseign=:enseign
						WHERE num=:num
					";
					$data=array(
						"num"=>$dossier->getNum(),
						"recherche"=>$dossier->getRecherche(),
						"admin"=>$dossier->getTaches(),
						"visibilite"=>$dossier->getVisibilite(),
						"act_enseign"=>$dossier->getEnseignement()
					);
					$pdo->request($req,$data);
					return(true);
				}
				else{
					return(false);
				}
			}
			else{
				return(false);
			}
		}
	}
