<?php
	class Form{
		private $filename;
		private $data;
		
		function __construct($filename){
			$filename="form/".$filename.".php";
			if(file_exists($filename)){
				$this->filename=$filename;
			}
			else{
				throw new Exception("Ce fichier n'existe pas");
			}
			$this->data=array();
		}
		public function display(){
			$data=$this->data;
			$idata=0;
			$ldata=count($data);
			$dataname=array_keys($data);
			$datavalue=array_values($data);
			while($idata<$ldata){
				eval('$'.$dataname[$idata].'=$datavalue[$idata];');
				$idata++;
			}
			unset($idata);
			unset($ldata);
			unset($datavalue);
			unset($dataname);
			unset($he);
			unset($data);
			include($this->filename);
		}
		public function setData($data){
			$this->data=$data;
		}
		public function isCommitted(){
			$balises=$this->searchBalise();
			$ret=true;
			$i=0;
			$length=count($balises);
			$csrf=getCsrfObject();
			$method="get";
			while(($i<$length)&&($ret)){
				$b=$balises[$i];
				if($b->getBalise()=="form"){
					if(strtolower($b->get("method"))=="post"){
						$ret=$csrf->usePostToken();
						$method="post";
					}
					else{
						$ret=$csrf->useGetToken();
						$method="get";
					}
				}
				else if(((($b->getBalise()=="input")&&($b->get("type")=="file"))||(($b->getBalise()=="input")&&($b->get("type")=="checkbox")))||(($b->has("name"))||($this->has($method,$b->get("name"))))){
					if($b->getBalise()=="input"){
						if($b->get("type")=="file"){
							$ret=$this->verifyFile($b);
						}
						else if($b->get("type")=="number"){
							$ret=$this->verifyNumber($b,$method);
						}
						else if($b->get("type")=="text"){
							$ret=$this->verifyText($b,$method);
						}
					}
					else if($b->getBalise()=="select"){
						$ret=$this->verifySelect($b,$method);
					}
					else{
						if(($b->has("required"))&&($this->get($method,$b->get("name"))=="")){
							$ret=false;
						}
					}
				}
				else{
					$ret=false;
				}
				$i++;
			}
			return($ret);
		}
		private function verifyText($b,$method){
			$ret=true;
			$value=$this->get($method,$b->get("name"));
			if($b->has("size")){
				if(strlen($value)>$b->get("size")){
					$ret=false;
				}
			}
			if($b->has("pregmatch")){
				$res=preg_match($b->get("pregmatch"),$value);
				if($res===0){
					$ret=false;
				}
			}
			return($ret);
		}
		private function verifySelect($b,$method){
			$ret=true;
			$value=$this->get($method,$b->get("name"));
			if($value!=""){
				if($b->has("type")){
					if($b->get("type")=="number"){
						$ret=$this->verifyNumber($b,$method);
					}
					else if($b->get("type")!="text"){
						$ret=false;
					}
				}
				else if($b->has("pregmatch")){
					$res=preg_match($b->get("pregmatch"),$value);
					if($res!==1){
						$ret=false;
					}
				}
				else if(!$b->hasChild()){
					$ret=false;
				}
				else{
					$good=false;
					while(($child=$b->fetchChilds())&&(!$good)){
						if($value==$this->getOptionValue($child)){
							$good=true;
						}
					}
					$ret=$good;
				}
			}
			else if($b->has("required")){
				$ret=false;
			}
			return($ret);
		}
		private function getOptionValue($o){
			if($o->has("value")){
				return($o->get("value"));
			}
			else{
				return($o->get("label"));
			}
		}
		private function verifyNumber($b,$method){
			$ret=true;
			$value=$this->get($method,$b->get("name"));
			if($value!=""){
				if(!$b->has("step")){
					if(($value=="")||($value!=intval($value))){
						$ret=false;
					}
				}
				else if($value==floatval($value)){
					$step=$b->get("step");
					if($value>0){
						$i=0;
						$ret=false;
						while($i<$value){
							if($i==$value){
								$ret=true;
							}
							$i+=$step;
						}
					}
					else if($value!=0){
						$i=0;
						$ret=false;
						while($i>$value){
							if($i==$value){
								$ret=true;
							}
							$i-=$step;
						}
					}
				}
				else{
					$ret=false;
				}
				if($ret){
					if($b->has("min")){
						if($b->get("min")>$value){
							$ret=false;
						}
					}
					if($b->has("max")){
						if($b->get("max")<$value){
							$ret=false;
						}
					}
				}
			}
			else if($b->has("required")){
				$ret=false;
			}
			return($ret);
		}
		private function verifyFile($b){
			$ret=true;
			if(Files::exist($b->get("name"))){
				if(Files::hasError($b->get("name"))){
					$ret=false;
				}
			}
			else if($b->has("required")){
				$ret=false;
			}
			return($ret);
		}
		private function searchBalise(){
			$file=file($this->filename);
			$search="<";
			$seb=">";
			$balise=array("form","input","select","textarea","option");
			$onSelect=false;
			$onOption=false;
			$blength=count($balise);
			$i=0;
			$length=count($file);
			$res=array();
			while($i<$length){
				$j=0;
				$line=$file[$i];
				$llength=strlen($line);
				while($j<$llength){
					$char=substr($line,$j,1);
					if($char==$search){
						if($onOption){
							$k=$j-1;
							$strOptionLabel="";
							$goodOptionLabel=false;
							while(!$goodOptionLabel){
								$chOption=substr($line,$k,1);
								if($chOption==">"){
									$goodOptionLabel=true;
								}
								else{
									$strOptionLabel=$chOption.$strOptionLabel;
									$k--;
								}
							}
							$lastOption->set("label",$strOptionLabel);
						}
						$str="";
						$good=false;
						$ec=false;
						$j++;
						while(($j<$llength)&&(!$good)){
							$char=substr($line,$j,1);
							if((!$ec)&&($char==$seb)){
								$good=true;
							}
							else{
								if($char=="\""){
									$ec=!$ec;
								}
								$str=$str.$char;
								$j++;
							}
						}
						$good2=false;
						$k=0;
						$a=new HTMLInput($str);
						if($a->getBalise()=="select"){
							$onSelect=true;
							$res=array_merge($res,array($a));
						}
						else if($a->getBalise()=="/select"){
							$onSelect=false;
						}
						else if($a->getBalise()=="option"){
							$onOption=true;
							$lastOption=$a;
						}
						else if($a->getBalise()=="/option"){
							$onOption=false;
							if(($lastOption->has("value"))&&(substr($lastOption->get("value"),0,3)=="<?=")){
								
							}
							else{
								$res[count($res)-1]->addChild($lastOption);
							}
							unset($lastOptionLabel);
						}
						else if(!(($a->getBalise()=="input")&&(($a->get("type")=="submit")||($a->get("type")=="reset")))){
							while(($k<$blength)&&(!$good2)){
								if($a->getBalise()==$balise[$k]){
									$res=array_merge($res,array($a));
									$good2=true;
								}
								else{
									$k++;
								}
							}
						}
					}
					$j++;
				}
				$i++;
			}
			return($res);
		}
		private function get($method,$name){
			if($method=="post"){
				return(Data::$post->get($name));
			}
			else{
				return(Data::$get->get($name));
			}
		}
		private function has($method,$name){
			if($method=="post"){
				return(Data::$post->exist($name));
			}
			else{
				return(Data::$get->exist($name));
			}
		}
	}
	class HTMLInput{
		private $attributes;
		private $balise;
		private $childs;
		private $i=0;
		
		function __construct($str){
			$this->childs=array();
			$balise="";
			$i=0;
			$length=strlen($str);
			$good=false;
			while(($i<$length)&&(!$good)){
				$char=substr($str,$i,1);
				if($char!=" "){
					$balise.=$char;
				}
				else{
					$good=true;
				}
				$i++;
			}
			$this->balise=$balise;
			$this->attributes=array();
			$isName=true;
			$ec=false;
			$name="";
			$value="";
			while($i<$length){
				$char=substr($str,$i,1);
				if($isName){
					if($char=="="){
						$isName=false;
						$i++;
					}
					else if($char==" "){
						$this->attributes=array_merge($this->attributes,array($name=>""));
						$name="";
					}
					else{
						$name.=$char;
					}
				}
				else{
					if($char=="\""){
						$isName=true;
						$this->attributes=array_merge($this->attributes,array($name=>$value));
						$name="";
						$value="";
						$i++;
					}
					else{
						$value.=$char;
					}
				}
				$i++;
			}
			if($name!=""){
				$this->attributes=array_merge($this->attributes,array($name=>""));
			}
		}
		public function get($attribute){
			return($this->attributes[$attribute]);
		}
		public function set($attribute,$value){
			$this->attributes[$attribute]=$value;
		}
		public function has($attribute){
			return(isset($this->attributes[$attribute]));
		}
		public function addChild($element){
			$this->childs=array_merge($this->childs,array($element));
		}
		public function hasChild(){
			return(count($this->childs)>0);
		}
		public function fetchChilds(){
			$length=count($this->childs);
			if($this->i>=$length){
				return(false);
			}
			else{
				$ret=$this->childs[$this->i];
				$this->i++;
				return($ret);
			}
		}
		public function getBalise(){
			return($this->balise);
		}
	}
