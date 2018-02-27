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
		public static function applyVotes($tour,$nbplaces){
			$db=db::getInstance();
			/*
			$req="
				SELECT *
				FROM dossier
				WHERE etat=0
			";
			
			$dossiers=$db->request($req);
			
			$resd=array();
			
			while($dossier=$dossiers->fetch()){
				if($dossier["act_recherche"]!=""){
					$resd=array_merge($resd,array($dossier));
				}
			}
			*/
			$res=array();
			
			$req="
				SELECT *
				FROM vote
				WHERE tour=:tour
			";
			
			$r=$db->request($req,array("tour"=>$tour));
			if(gettype($r)!="boolean"){
				$votants=array();
				
				while($line=$r->fetch()){
					if(isset($res[$line["dossier"]])){
						$res[$line["dossier"]]++;
					}
					else{
						$res[$line["dossier"]]=1;
					}
					$good=false;
					$i=0;
					while((!$good)&&($i<count($votants))){
						$good=$line["rapporteur"]==$votants[$i];
						$i++;
					}
					if(!$good){
						$votants=array_merge($votants,array($line["rapporteur"]));
					}
				}
				
				
				$maj=count($votants)/2;
				$keys=array_keys($res);
				$length=count($keys);
				$nbd=$nbplaces;
				$i=0;
				
				
				while($i<$length){
					if($res[$keys[$i]]>$maj){
						DossierPDO::promove($keys[$i]);
						$nbd--;
					}
					$i++;
				}
			}
			else{
				$nbd=$nbplaces;
			}
			return($nbd);
		}
		public static function getNbVotants($dossier){
			$num=$dossier->getNum();
			$req="
				SELECT MAX(tour)
				FROM vote
				WHERE dossier=:dossier
			";
			$data=array("dossier"=>$num);
			$db=db::getInstance();
			$tour=$db->request($req,$data)->fetch()["MAX(tour)"];
			$req="
				SELECT COUNT(*)
				FROM vote
				WHERE dossier=:dossier
				AND tour=:tour
			";
			$data=array("tour"=>$tour,"dossier"=>$num);
			return($db->request($req,$data)->fetch()["COUNT(*)"]);
		}
		private static function promove($dossier){
			$req="
				UPDATE dossier
				SET etat=1
				WHERE num_dossier=:dossier
			";
			$db=db::getInstance();
			$db->request($req,array("dossier"=>$dossier));
		}
		public static function clearVotes(){
			$req="
				DELETE FROM vote
			";
			db::getInstance()->request($req);
		}
		public static function isAccepted($dossier){
			$req="
				SELECT etat
				FROM dossier
				WHERE num_dossier=:num
			";
			$data=array("num"=>$dossier->getNum());
			$pdo=db::getInstance();
			$res=$pdo->request($req,$data)->fetch();
			return($res["etat"]==1);
		}
		public static function vote($rapporteur,$dossier,$tour){
			$file=new DataFile("config");
			if($tour==$file->get("tour")){
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
		//		$pdo->request($req,array("num"=>$dossier->getNum()));
			}
		}
		public static function getTour($dossier){
			$req="
				SELECT MAX(tour)
				FROM vote
				WHERE dossier=:num
			";
			$pdo=db::getInstance();
			$data=array("num"=>$dossier->getNum());
			$res=$pdo->request($req,$data)->fetch();
			return(intval($res["MAX(tour)"]));
		}
		public static function getDossierAVote(){
			$req="
				SELECT *
				FROM dossier
				WHERE etat=0
			";
			$pdo=db::getInstance();
			$res=$pdo->request($req);
			$ret=array();
			while($ligne=$res->fetch()){
				$r=new Dossier($ligne["nom"],$ligne["prenom"],$ligne["anc_echelon"],$ligne["anc_enseign"],$ligne["echelon"],RapporteurPDO::getUser(intval($ligne["rapporteur1"])),RapporteurPDO::getUser(intval($ligne["rapporteur2"])));
				$r->setNum($ligne["num_dossier"]);
				$r->setNotes($ligne["act_recherche"],$ligne["act_enseign"],$ligne["act_admin"],$ligne["visibilite"]);
				if($ligne["act_recherche"]!=""){
					$ret=array_merge($ret,array($r));
				}
			}
			return($ret);
		}
		public static function getList($rapp){
			$req="
				SELECT *
				FROM dossier
				WHERE rapporteur1=:rapp
				OR rapporteur2=:rapp
			";
			$data=array("rapp"=>$rapp->getId());
			$pdo=db::getInstance();
			$res=$pdo->request($req,$data);
			$ret=array();
			while($ligne=$res->fetch()){
				$r=new Dossier($ligne["nom"],$ligne["prenom"],$ligne["anc_echelon"],$ligne["anc_enseign"],$ligne["echelon"],RapporteurPDO::getUser(intval($ligne["rapporteur1"])),RapporteurPDO::getUser(intval($ligne["rapporteur2"])));
				$r->setNum($ligne["num_dossier"]);
				$ret=array_merge($ret,array($r));
			}
			return($ret);
		}
		public static function getResult(){
			$req="
				SELECT *
				FROM dossier
				WHERE etat!=0
			";
			$pdo=db::getInstance();
			$res=$pdo->request($req);
			$ret=array();
			while($ligne=$res->fetch()){
				if(dossierPDO::isPromovedInActualVote($ligne["num_dossier"])){
					$r=new Dossier($ligne["nom"],$ligne["prenom"],$ligne["anc_echelon"],$ligne["anc_enseign"],$ligne["echelon"],RapporteurPDO::getUser(intval($ligne["rapporteur1"])),RapporteurPDO::getUser(intval($ligne["rapporteur2"])));
					$r->setNum($ligne["num_dossier"]);
					$ret=array_merge($ret,array($r));
				}
			}
			return($ret);
		}
		private static function isPromovedInActualVote($dossier){
			$req="
				SELECT COUNT(*)
				FROM vote
				WHERE dossier=:dossier
			";
			$db=db::getInstance();
			$res=$db->request($req,array("dossier"=>$dossier))->fetch()["COUNT(*)"];
			return($res>0);
		}
		public static function getDossier($id){
			$req="
				SELECT *
				FROM dossier
				WHERE num_dossier=:id
			";
			$db=db::getInstance();
			$res=$db->request($req,array("id"=>$id))->fetch();
			$ret=new Dossier($res["nom"],$res["prenom"],$res["anc_echelon"],$res["anc_enseign"],$res["echelon"],RapporteurPDO::getUser(intval($res["rapporteur1"])),RapporteurPDO::getUser(intval($res["rapporteur2"])));
			$ret->setNum($res["num_dossier"]);
			if($res["act_recherche"]!==null){
				$ret->setNotes($res["act_recherche"],$res["act_enseign"],$res["act_admin"],$res["visibilite"]);
			}
			return($ret);
		}
		public static function note($rapporteur,$dossier){
			$req="
				SELECT *
				FROM dossier
				WHERE num_dossier=:num
			";
			$data=array("num"=>$dossier->getNum());
			$pdo=db::getInstance();
			$res=$pdo->request($req,$data)->fetch();
			$rid=$rapporteur->getId();
			echo "<pre>";
			var_dump($res);
			var_dump($rid);
			echo "</pre>";
			if(($res["rapporteur1"]==$rid)||($res["rapporteur2"]==$rid)){
				if(($res["act_recherche"]=="")||($res["act_recherche"]==null)){
					$req="
						UPDATE dossier
						SET act_recherche=:recherche,act_admin=:admin,visibilite=:visibilite,act_enseign=:enseign
						WHERE num_dossier=:num
					";
					$data=array(
						"num"=>$dossier->getNum(),
						"recherche"=>$dossier->getRecherche(),
						"admin"=>$dossier->getTaches(),
						"visibilite"=>$dossier->getVisibilite(),
						"enseign"=>$dossier->getEnseignement()
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
