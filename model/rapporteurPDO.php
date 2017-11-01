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
			$res=$pdo->request($req,array($rapporteur->getLogin()))->fetch()["COUNT(*)"];
			if($res==0){
				$req="
					INSERT INTO rapporteur(nom,prenom,login,password,addr_mail,date_naiss)
					VALUES(:nom,:prenom,:login,:password,:mail,:dateNaiss)
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
					SELECT id,nom,prenom,login,addr_mail,DAY(date_naiss),MONTH(date_naiss),YEAR(date_naiss)
					FROM rapporteur
					WHERE login=:login
					AND password=:password
				";
				$res=$pdo->request($req,$data)->fetch();
				Session::set(RapporteurPDO::$connectName,new Rapporteur($res["nom"],$res["prenom"],$res["login"],$password,$res["addr_mail"],array("day"=>$res["DAY(date_naiss)"],"month"=>$res["MONTH(date_naiss)"],"year"=>$res["YEAR(date_naiss)"])));
				$c=Session::get(RapporteurPDO::$connectName);
				$c->setId($res["id"]);
				Session::set(RapporteurPDO::$connectName,$c);
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function disconnect(){
			Session::remove(RapporteurPDO::$connectName);
		}
		public static function getUser($id){
			if(gettype($id)=="string"){
				$req="
					SELECT id,nom,prenom,login,password,addr_mail,DAY(date_naiss),MONTH(date_naiss),YEAR(date_naiss)
					FROM rapporteur
					WHERE login=?
				";
			}
			else if(gettype($id)=="integer"){
				$req="
					SELECT id,nom,prenom,login,password,addr_mail,DAY(date_naiss),MONTH(date_naiss),YEAR(date_naiss)
					FROM rapporteur
					WHERE id=?
				";
			}
			$pdo=db::getInstance();
			$res=$pdo->request($req,array($id));
			if($res=$res->fetch()){
				$ret=new Rapporteur($res["nom"],$res["prenom"],$res["login"],$res["password"],array("day"=>$res["DAY(date_naiss)"],"month"=>$res["MONTH(date_naiss)"],"year"=>$res["YEAR(date_naiss)"]),$res["addr_mail"],true);
				$ret->setId($res["id"]);
				return($ret);
			}
		}
		public static function getConnectedUser(){
			if(Session::exist(RapporteurPDO::$connectName)){
				return(Session::get(RapporteurPDO::$connectName));
			}
			else{
				return(false);
			}
		}
		public static function isConnected(){
			if(Session::exist(RapporteurPDO::$connectName)){
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function changePassword($user,$oldpassword,$newpassword){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE id=:id
				AND password=:password
			";
			$data=array("id"=>$user->getId(),"password"=>sha512($oldpassword));
			$res=$pdo->request($req,$data)->fetch()["COUNT(*)"];
			if($res==1){
				$req="
					UPDATE rapporteur
					SET password=:password
					WHERE id=:id
				";
				$data=array("password"=>sha512($newpassword),"id"=>$user->getId());
				$pdo->request($req,$data);
				return(true);
			}
			else{
				return(false);
			}
		}
		private static function hash($str){
			return(sha512($str));
		}
		public static function removeUser($user){
			if($user->getLogin()!="root"){
				$req="
					DELETE FROM rapporteur
					WHERE id=:id
				";
				$data=array($user->getId());
				db::getInstance()->request($req,$data);
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function isRoot(){
			if(RapporteurPDO::isConnected()){
				return(RapporteurPDO::getConnectedUser()->getLogin()=="root");
			}
			else{
				return(false);
			}
		}
	}
