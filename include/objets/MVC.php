<?php
	class MVC{
		private $do;
		private $controller;
		private $view;
		private $da;
		private $defaultController;
		private $defaultView;
		private static $delimiter="/";
		private static $dataText="";
		private static $path;
		private static $d;
		private static $data=array();
		
		function __construct(){
			$this->do=array();
			$this->da=array();
			$this->controller=array();
			$this->view=array();
			$this->defaultController="";
			$this->defaultView="";
			$sn="";
			$i=0;
			$tab=explode("/",$_SERVER["SCRIPT_NAME"]);
			$taille=count($tab);
			while($i<$taille-1){
				if($i==0){
					$slash="";
				}
				else{
					$slash="/";
				}
				$sn.=$slash.$tab[$i];
				$i++;
			}
			MVC::$path=$sn;
			if(isset($_SERVER["REDIRECT_URL"])){
				$tailleSN=strlen($sn)+1;
				$s=substr($_SERVER["REDIRECT_URL"],$tailleSN,strlen($_SERVER["REDIRECT_URL"])-$tailleSN);
				if($s==""){
					MVC::$d="index";
				}
				else{
					$taille=strlen($s);
					$good=false;
					$i=0;
					while(($i<$taille)&&(!$good)){
						$char=substr($s,$i,1);
						if($char=="/"){
							$good=true;
						}
						else{
							MVC::$d=MVC::$d.$char;
							$i++;
						}
					}
					if($good){
						$tailleD=strlen(MVC::$d);
						$data=substr($_SERVER["REDIRECT_URL"],$tailleSN+$i+1,strlen($_SERVER["REDIRECT_URL"])-$i);
						MVC::$data=$data;
						MVC::$dataText=$data;
					}
				}
			}
			else{
				if(isset($_GET["do"])){
					MVC::$d=$_GET["do"];
				}
				else{
					MVC::$d="index";
				}
			}
		}
		public static function getDataText(){
			return(MVC::$dataText);
		}
		public function setDelimiter($delimiter){
			MVC::$delimiter=$delimiter;
		}
		public static function getData(){
			return(MVC::$data);
		}
		public static function getPath(){
			return(MVC::$path);
		}
		public static function getDo(){
			return(MVC::$d);
		}
		public function state($do,$controller,$view="",$data=array()){
			if(gettype($view)=="array"){
				$data=$view;
				$view="";
			}
			if((gettype($do)=="string")&&(gettype($controller)=="string")&&(gettype($view)=="string")&&(gettype($data)=="array")){
				$this->do=array_merge($this->do,array($do));
				$this->controller=array_merge($this->controller,array($controller));
				$this->view=array_merge($this->view,array($view));
				$this->da=array_merge($this->da,array($data));
			}
		}
		public function dstate($controller,$view=""){
			if((gettype($controller)=="string")&&(gettype($view)=="string")){
				$this->defaultController=$controller;
				$this->defaultView=$view;
			}
		}
		public function start(){
			if(gettype(MVC::$data)=="string"){
				MVC::$data=explode(MVC::$delimiter,MVC::$data);
			}
			$do=$this->getDo();
			$this->loadDo($do);
		}
		private function loadDo($do){
			$length=count($this->do);
			$i=0;
			$good=false;
			while(($i<$length)&&(!$good)){
				if($do==$this->do[$i]){
					$this->load($this->controller[$i],$this->view[$i],$this->da[$i]);
					$good=true;
				}
				$i++;
			}
			if((!$good)&&($this->defaultController!="")){
				$this->load($this->defaultController,$this->defaultView);
			}
		}
		private function load($c,$v,$d=array()){
			$CONTROLLER=array();
			$CONTROLLER["name"]=$c;
			$CONTROLLER["datas"]=$d;
			$CONTROLLER["view"]=$v;
			$CONTROLLER["method"]=$_SERVER["REQUEST_METHOD"];
			$CONTROLLER["url"]=$_SERVER["REQUEST_URI"];
			$CONTROLLER["state"]=200;
			$DATA=array();
			$i=0;
			$taille=count($CONTROLLER["datas"]);
			if($taille>0){
				$values=MVC::getData();
				while($i<$taille){
					if(isset($_GET[$d[$i]])){
						$DATA[$d[$i]]=$_GET[$d[$i]];
					}
					else{
						if(isset($values[$i])){
							$DATA[$d[$i]]=$values[$i];
						}
					}
					$i++;
				}
				unset($values);
			}
			unset($i);
			unset($d);
			if(file_exists(get_controller_address($c))){
				include(get_controller_address($c));
				if(isset($CONTROLLER["changeDo"])){
					$this->loadDo($CONTROLLER["changeDo"]);
				}
				else if(isset($CONTROLLER["defaultController"])){
					$this->load($this->defaultController,$this->defaultView);
				}
				else{
					if(isset($CONTROLLER["redirect"])){
						header("location: ".$CONTROLLER["redirect"]);
					}
					else{
						if($CONTROLLER["state"]!=200){
							header("HTTP/1.0 ".$CONTROLLER["state"]." ".$this->get_text_state($CONTROLLER["state"]));
						}
						if($CONTROLLER["view"]!=""){
							include(get_view_address($CONTROLLER["view"]));
						}
					}
				}
			}
			else{
				include(get_view_address($c));
			}
		}
		private function get_text_state($state){
			switch($state){
				case 404:
					return("Not Found");
				break;
			}
		}
	}
