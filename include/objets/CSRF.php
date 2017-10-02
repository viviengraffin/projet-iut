<?php
	class CSRF{
		private $session;
		private $maxTimeStamp;
		private $limit;
		private $tokenTabName;
		private $i=0;
		
		function __construct(&$session,$limit=50,$tokenTabName="_csrf"){
			if($this->isSession($session)){
				$this->limit=$limit;
				$this->session=$session;
				$this->tokenTabName=$tokenTabName;
			}
			else{
				throw new TypeError("Ceci n'est pas le tableau des variables de session");
			}
		}
		public function clearAllTokens(){
			$this->session[$this->tokenTabName]=[];
		}
		private function isSession(&$session){
			return(get_type($session)=="Array");
		}
		public function addToken($name="_csrf"){
			$token=$this->getNewToken();
			$length=count($this->session[$this->tokenTabName]);
			if($length>=$this->limit){
				$this->session[$this->tokenTabName]=array_shift($this->session->tokenTabName);
			}
			
		}
		
		public function useToken($token,$name="_csrf",$clearAllInTheEnd=true){
			$token=intval($token);
			$i=0;
			$good=false;
			$length=count($this->session[$this->tokenTabName]);
			while(($i<$length)&&(!$good)){
				if(($this->session[$this->tokenTabName][$i]->getName()==$name)&&($this->session[$this->tokenTabName]->getToken()==$token)){
					$good=true;
				}
				$i++;
			}
			if($clearAllInTheEnd){
				$this->clearAllTokens();
			}
			else{
				$this->session[$this->tokenTabName]=array_filter($this->session[$this->tokenTabName],function($t) use($token){
					if($t!=$token){
						return($t);
					}
				});
			}
			return($good);
		}
		public function getHiddenInput(){
			if($this->i<count($this->session[$this->tokenTabName])){
				$actualToken=$this->session[$this->tokenTabName][$this->i];
				$this->i++;
				return("<input type='hidden' name='".$actualToken->getName()."' value='".$actualToken->getToken()."'>");
			}
		}
		private function getNewToken(){
			return(intval(rand()*1000000000000));
		}
	}
	
	class CSRFToken{
		private $maxTimeStamp;
		private $token;
		private $timestamp;
		private $name;
		
		function __construct(string $name,integer $token,integer $maxTimeStamp){
			$this->token=$token;
			$this->maxTimeStamp=$maxTimeStamp;
			$this->name=$name;
		}
		public function getToken(){
			return($this->token);
		}
		public function getName(){
			return($this->name);
		}
		public function isValid(){
			return(mktime()-$this->timestamp<=$this->maxTimeStamp);
		}
	}
?>
