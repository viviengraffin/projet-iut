<?php
	class RapporteurPDO{
		private static $connectName="p_connect";
		
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
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function connection($login,$password){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE login=:login
				AND password=:password
			";
			$data=array("login"=>$login,"password"=>sha512($password));
			$res=$pdo->request($req,$data)->fetch();
			if($res["COUNT(*)"]==1){
				$req="
					SELECT *
					FROM rapporteur
					WHERE login=:login
					AND password=:password
				";
				$res=$pdo->request($req,$data)->fetch();
				$_SESSION[RapporteurPDO::$connectName]=new Rapporteur($res["nom"],$res["prenom"],$res["login"],$password);
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function disconnect(){
			unset($_SESSION[RapporteurPDO::$connectName]);
		}
		public static function getUser(){
			if(isset($_SESSION["p_connect"])){
				return($_SESSION["p_connect"]);
			}
			else{
				return(false);
			}
		}
		public static function isConnected(){
			if(isset($_SESSION[RapporteurPDO::$connectName])){
				return(true);
			}
			else{
				return(false);
			}
		}
	}
