<?php
	class CSRF{
		private $maxTimeStamp;
		private $limit;
		private $tokenTabName;
		private $tokenTab;
		private $i=0;
		
		function __construct($params=array()){
			if(!isset($params["timeStamp"])){
				$this->maxTimeStamp=10*3600;
			}
			else{
				$this->maxTimeStamp=$params["timeStamp"];
			}
			if(!isset($params["limit"])){
				$this->limit=50;
			}
			else{
				$this->limit=$params["limit"];
			}
			if(!isset($params["tokenTabName"])){
				$this->tokenTabName="_csrf";
			}
			else{
				$this->tokenTabName=$params["tokenTabName"];
			}
			$this->tokenTab=array();
			$i=0;
			if(!Session::exist($this->tokenTabName)){
				Session::set($this->tokenTabName,array());
			}
			$this->tokenTab=Session::get($this->tokenTabName);
		}
		public function clearAllTokens(){
			Session::set($this->tokenTabName,array());
			$this->tokenTab=array();
		}
		public function addToken($name="_csrf",$oneTime=false,$timeout=null){
			if(gettype($name)=="integer"){
				$timeout=$name;
				$name="_csrf";
				
			}
			else if(gettype($name)=="boolean"){
				if(gettype($oneTime)=="integer"){
					$timeout=$oneTime;
					$oneTime=$name;
					$name="_csrf";
				}
				else{
					$oneTime=$name;
					$name="_csrf";
					$timeout=$this->maxTimeStamp;
				}
			}
			else if($timeout===null){
				$timeout=$this->maxTimeStamp;
			}
			$token=$this->getNewToken();
			$length=count($this->tokenTab);
			if($length>$this->limit){
				array_shift($this->tokenTab);
			}
			if($timeout>0){
				$timeout=time()+$timeout;
			}
			$tokenObject=new CSRFToken($name,$token,$timeout);
				echo "<pre>";
				var_dump($this->tokenTab);
				echo "</pre>";
			$this->tokenTab=array_merge($this->tokenTab,array($tokenObject));
			$this->modifySession($this->tokenTab);
			return($tokenObject);
		}
		
		public function usePostToken($name="_csrf"){
			if(isset($_POST[$name])){
				$token=$_POST[$name];
				$token=intval($token);
				$i=0;
				$good=false;
				$length=count($this->tokenTab);
				while(($i<$length)&&(!$good)){
					if(($this->tokenTab[$i]->getName()==$name)&&($this->tokenTab[$i]->getToken()==$token)&&($this->tokenTab[$i]->isValid($this->maxTimeStamp))){
						$good=true;
						if($this->tokenTab[$i]->useOneTime()){
							$this->tokenTab=array_filter($this->tokenTab,function($t) use($token){
								if($t->getToken()!=$token){
									return($t);
								}
							});
						}
					}
					$i++;
				}
				$this->modifySession($this->tokenTab);
				return($good);
			}
			else{
				return(false);
			}
		}
		public function useGetToken($name="_csrf"){
			if(isset($_GET[$name])){
				$token=$_POST[$name];
				$token=intval($token);
				$i=0;
				$good=false;
				$length=count($this->tokenTab);
				while(($i<$length)&&(!$good)){
					if(($this->tokenTab[$i]->getName()==$name)&&($this->tokenTab[$i]->getToken()==$token)&&($this->tokenTab[$i]->isValid($this->maxTimeStamp))){
						$good=true;
						if($this->tokenTab[$i]->useOneTime()){
							$this->tokenTab=array_filter($this->tokenTab,function($t) use($token){
								if($t->getToken()!=$token){
									return($t);
								}
							});
						}
					}
					$i++;
				}
				$this->modifySession($this->tokenTab);
				return($good);
			}
			else{
				return(false);
			}
		}
		public function getHiddenInput(){
			if($this->i<count($this->tokenTab)){
				$actualToken=$this->tokenTab[$this->i];
				$this->i++;
				return($actualToken->getHiddenInput());
			}
		}
		private function getNewToken(){
			return(intval(rand()*1000000000000));
		}
		public function getTokenById($id){
			if(isset($this->tokenTab[$id])){
				return($this->tokenTab[$id]);
			}
		}
		private function modifySession($tokenTab){
			Session::set($this->tokenTabName,$tokenTab);
		}
		private function getSession(){
			return(Session::get($this->tokenTabName));
		}
	}
	
	class CSRFToken{
		private $maxTimeStamp;
		private $token;
		private $name;
		private $oneTime;
		
		function __construct($name,$token,$maxTimeStamp,$oneTime=false){
			$this->token=$token;
			$this->maxTimeStamp=$maxTimeStamp;
			$this->name=$name;
			$this->oneTime=$oneTime;
		}
		public function getToken(){
			return($this->token);
		}
		public function getName(){
			return($this->name);
		}
		public function getMaxTimeStamp(){
			return($this->maxTimeStamp);
		}
		public function isValid(){
			if($this->maxTimeStamp==0){
				return(true);
			}
			else{
				return(time()<=$this->maxTimeStamp);
			}
		}
		public function getHiddenInput(){
			return("<input type='hidden' name='".$this->name."' value='".$this->token."'>");
		}
		public function getVar(){
			return($this->name."=".$this->token);
		}
		public function useOneTime(){
			return($this->oneTime);
		}
	}
	function getCsrfObject(){
		return(new CSRF());
	}
?>
