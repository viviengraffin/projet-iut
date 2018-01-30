<?php
	class db{
		private static $db=null;
		
		public static function getInstance(){
			if(db::$db===null){
				db::$db=new DataBase("mysql","localhost","root","vivien","projet_iut");
				if(!db::$db->getState()){
					die("Erreur lors de la connexion à la base de données");
				}
			}
			return(db::$db);
		}
	}
	class csrfi{
		public static function getInstance(){
			return(new CSRF());
		}
	}
	
	function diffTime($a,$b){
		$sec=$a-$b;
		$min=0;
		$good=false;
		while(!$good){
			if($sec>=60){
				$sec-=60;
				$min++;
			}
			else{
				$good=true;
			}
		}
		return($min."m".$sec."s");
	}
