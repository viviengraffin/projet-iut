<?php
	class RapporteurPDO{
		private static $connectName="p_connect";
		private static $cookieTime=24*3600*365;
		
		public static function addRapporteur($rapporteur){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE login=?
			";
			$res=$pdo->request($req,array($rapporteur->getLogin()))->fetch()["COUNT(*)"];
			echo "<pre>";
			var_dump($res);
			if($res==0){
				$req="
					INSERT INTO rapporteur(nom,prenom,login,password,addr_mail)
					VALUES(:nom,:prenom,:login,:password,:mail)
				";
				$pdo->request($req,$rapporteur->getTab());
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function sendRecoveryMail($user,$mail){
			if($user->getMail()==$mail){
				$send=new Mail(true);
				ob_clean();
				load_view("",[]);
				$message=ob_get_clean();
				$send->message($message);
				return(true);
			}
			else{
				return(false);
			}
		}
		/*
		public static function getUserWithName($username){
			$usernames=self::getTableOfName($username);
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE prenom=?
				AND nom=?
			";
			$good=false;
			$length=count($usernames);
			$pdo=db::getInstance();
			while(($i<$length)&&(!$good)){
				$res=$pdo->request($req,$usernames[$i]);
				if($res["COUNT(*)"]>0){
					$req="
						SELECT *
						FROM rapporteur
						WHERE prenom=?
						AND nom=?
					";
					$res=$pdo->request($req,$usernames[$i])->fetch();
					
				}
				$i++;
			}
		}
		private static function getTableOfName($username){
			$words=explode(" ",$username);
			$i=1;
			$length=count($words);
			$res=array($username);
			$good=false;
			$j=0;
			$lastBinString="";
			while($j<$length){
				$lastBinString="1".$lastBinString;
				$j++;
			}
			unset($j);
			while($good){
				$binString=self::setStringLength(decbin($i),$length);
				if($binString==$lastBinString){
					$good=true;
				}
				else{
					$j=1;
					$r=array($words[0],"");
					$isR0=true;
					$isgood=false;
					while($j<$length){
						if($isR0){
							if($binString[$j-1]=="1"){
								$isgood=true;
								$r[1]=$words[$j];
							}
							else{
								$r[0]=" ".$words[$j];
							}
						}
						else{
							if($binString[$j-1]=="1"){
								$isgood=false;
							}
							else{
								$r[1].=" ".$words[$j];
							}
						}
						$j++;
					}
					if($isgood){
						$res=array_merge($res,array($r));
					}
				}
				$i++;
			}
		}
		private static function setStringLength($str,$length){
			$actualLength=strlen($str);
			$i=$actualLength-1;
			if($actualLength<$length){
				while($i<$length){
					$str="0".$str;
					$i++;
				}
				return($str);
			}
			else{
				return($str);
			}
		}
		*/
		private static function connectionCookie($login,$password){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE login=:login
				AND password=:password
			";
			$data=array("login"=>$login,"password"=>$password);
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
		public static function connection($login,$password,$souvenir=false){
			if(RapporteurPDO::connectionCookie($login,RapporteurPDO::hash($password))){
				if($souvenir){
					RapporteurPDO::setCookie($login,$password);
				}
				return(true);
			}
			else{
				return(false);
			}
		}
		public static function disconnect(){
			if(Cookie::has(RapporteurPDO::$connectName)){
				Cookie::remove(RapporteurPDO::$connectName);
			}
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
				$ret=new Rapporteur($res["nom"],$res["prenom"],$res["login"],$res["password"],$res["addr_mail"],true);
				$ret->setId($res["id"]);
				return($ret);
			}
		}
		public static function getList(){
			$req="
				SELECT *
				FROM rapporteur
				WHERE login!='root'
			";
			$pdo=db::getInstance();
			$res=$pdo->request($req);
			$ret=array();
			while($line=$res->fetch()){
				$r=new Rapporteur($line["nom"],$line["prenom"],$line["login"],$line["password"],$line["addr_mail"]);
				$r->setId($line["id"]);
				$ret=array_merge($ret,array($r));
			}
			return($ret);
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
				if(Cookie::has(RapporteurPDO::$connectName)){
					Cookie::extend(RapporteurPDO::$connectName,RapporteurPDO::$cookieTime);
				}
				return(true);
			}
			else{
				if(Cookie::has(RapporteurPDO::$connectName)){
					$good=true;
					try{
						$res=explode("----",Cookie::get(RapporteurPDO::$connectName));
					}
					catch(Exception $e){
						Cookie::remove(RapporteurPDO::$connectName);
						$good=false;
					}
					if($good){
						if(RapporteurPDO::getSecurityHash()==$res[2]){
							if(RapporteurPDO::connectionCookie($res[0],$res[1])){
								Cookie::extend(RapporteurPDO::$connectName,RapporteurPDO::$cookieTime);
								return(true);
							}
							else{
								Cookie::remove(RapporteurPDO::$connectName);
								return(false);
							}
						}
						else{
							Cookie::remove(RapporteurPDO::$connectName);
							return(false);
						}
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
		private static function getSecurityHash(){
			$browser=getBrowser();
			return(RapporteurPDO::hash($browser["name"].$browser["platform"].$_SERVER["HTTP_ACCEPT_LANGUAGE"]));
		}
		public static function changePassword($user,$oldpassword,$newpassword){
			$pdo=db::getInstance();
			$req="
				SELECT COUNT(*)
				FROM rapporteur
				WHERE id=:id
				AND password=:password
			";
			$data=array("id"=>$user->getId(),"password"=>RapporteurPDO::hash($oldpassword));
			$res=$pdo->request($req,$data)->fetch()["COUNT(*)"];
			if($res==1){
				$req="
					UPDATE rapporteur
					SET password=:password
					WHERE id=:id
				";
				$data=array("password"=>RapporteurPDO::hash($newpassword),"id"=>$user->getId());
				$pdo->request($req,$data);
				if(Cookie::has(RapporteurPDO::$connectName)){
					RapporteurPDO::setCookie($user->getLogin(),$newpassword);
				}
				return(true);
			}
			else{
				return(false);
			}
		}
		private static function hash($str){
			return(sha256($str));
		}
		public static function removeUser($user){
			if($user->getLogin()!="root"){
				$req="
					DELETE FROM rapporteur
					WHERE id=:id
				";
				$data=array("id"=>$user->getId());
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
		public static function isRapporteur(){
			if(RapporteurPDO::isConnected()){
				return(RapporteurPDO::getConnectedUser()->getLogin()!="root");
			}
			else{
				return(false);
			}
		}
		private static function setCookie($login,$password){
			Cookie::set(RapporteurPDO::$connectName,$login."----".RapporteurPDO::hash($password)."----".RapporteurPDO::getSecurityHash(),RapporteurPDO::$cookieTime);
		}
	}
