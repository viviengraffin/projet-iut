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
			
			$res=array();
			
			$req="
				SELECT COUNT(*)
				FROM vote
				WHERE tour=:tour
			";
			
			$i=0;
			while($line=$res[$i] ?? false){
				$res[$line["num_dossier"]]=$db->request($req,array("tour"=>$tour));
				$i++;
			}
			
			if($res!=array()){
				$res=arsort($res);
			}
			
			echo "<pre>";
			var_dump($res);
			echo "</pre>";
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
		public static function getNbVotants($dossier){
			$req="
				SELECT COUNT(*)
				FROM vote
				WHERE dossier=:num
			";
			$pdo=db::getInstance();
			$data=array("num"=>$dossier->getNum());
			$res=$pdo->request($req,$data)->fetch();
			return(intval($res["COUNT(*)"]));
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
				if($ligne["act_recherche"]==""){
					$r=new Dossier($ligne["nom"],$ligne["prenom"],$ligne["anc_echelon"],$ligne["anc_enseign"],$ligne["echelon"],RapporteurPDO::getUser(intval($ligne["rapporteur1"])),RapporteurPDO::getUser(intval($ligne["rapporteur2"])));
					$r->setNum($ligne["num_dossier"]);
					$ret=array_merge($ret,array($r));
				}
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
				$r=new Dossier($ligne["nom"],$ligne["prenom"],$ligne["anc_echelon"],$ligne["anc_enseign"],$ligne["echelon"],RapporteurPDO::getUser(intval($ligne["rapporteur1"])),RapporteurPDO::getUser(intval($ligne["rapporteur2"])));
					$r->setNum($ligne["num_dossier"]);
					$ret=array_merge($ret,array($r));
			}
			return($ret);
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
