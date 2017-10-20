<?php
	class DataFile{
		private $filename;
		private $dataname=array();
		private $datavalue=array();
		private $datatype=array();
		private $remove=array();
		private $onerrorofwrite;
		private static $authorized_types=array("integer","double","boolean","string","array");
		
		function __construct($filename,$onerror=false){
			$this->filename=$filename;
			$this->onerrorofwrite=$onerror;
		}
		public function get($name,$getChanges=false){
			if((file_exists($this->filename))&&($this->isReadable())){
				include($this->filename);
				if(isset($tab[$name])){
					if($getChanges){
						$tab2=$this->getChanges();
						if(isset($tab2[$name])){
							return($tab2[$name]);
						}
						else if(!$this->isRemoved($name)){
							return($tab[$name]);
						}
					}
					else{
						return($tab[$name]);
					}
				}
				else if($getChanges){
					$tab=$this->getChanges();
					if(isset($tab[$name])){
						return($tab[$name]);
					}
				}
			}
		}
		public function getAll($getChanges=false){
			if((file_exists($this->filename))&&($this->isReadable())){
				include($this->filename);
				if($getChanges){
					$tab2=$this->getChanges();
					$tab=array_merge($tab,$tab2);
					$i=0;
					$length=count($this->remove);
					while($i<$length){
						if(isset($tab[$this->remove[$i]])){
							unset($tab[$this->remove[$i]]);
						}
						$i++;
					}
				}
				return($tab);
			}
		}
		public function set($name,$value,$setNow=false){
			$type=$this->getTypeOfData($value);
			if(($this->isAuthorizedType($type))&&($this->getTypeOfData($name)=="string")){
				if($setNow){
					if($this->isWritable()){
						$this->applyChanges(array($name),array($value),array($type),array());
					}
				}
				else{
					$this->dataname=array_merge($this->dataname,array($name));
					$this->datavalue=array_merge($this->datavalue,array($value));
					$this->datatype=array_merge($this->datatype,array($type));
				}
			}
		}
		public function remove($name,$setNow=false){
			if($setNow){
				if($this->isWritable()){
					$this->applyChanges(array(),array(),array(),array($name));
				}
			}
			else{
				$this->remove=array_merge($this->remove,array($name));
			}
		}
		public function cancelChanges(){
			$this->datavalue=array();
			$this->dataname=array();
			$this->datatype=array();
			$this->remove=array();
		}
		private function getChanges(){
			$i=0;
			$length=count($this->dataname);
			$ret=array();
			while($i<$length){
				$ret=array_merge($ret,array($this->dataname[$i]=>$this->datavalue[$i]));
				$i++;
			}
			return($ret);
		}
		public function update(){
			$mod=$this->applyChanges($this->dataname,$this->datavalue,$this->datatype,$this->remove);
			$this->dataname=array();
			$this->datavalue=array();
			$this->datatype=array();
			$this->remove=array();
			if(isset($mod)){
				return($mod);
			}
			else{
				return("");
			}
		}
		public function delete(){
			unlink($this->filename);
		}
		public function isExist(){
			return(file_exists($this->filename));
		}
		private function getTypeOfData($value){
			return(gettype($value));
		}
		private function applyChanges($dataname,$datavalue,$datatype,$remove){
			$modification=$this->getModification($dataname,$datavalue,$datatype,$remove);
			if($this->isWritable()){
				$file=fopen($this->filename,"w+");
				fwrite($file,$modification);
				fclose($file);
			}
			else if($this->onerrorofwrite){
				return($modification);
			}
		}
		private function getModification(&$dataname,&$datavalue,&$datatype,&$remove){
			if(file_exists($this->filename)){
				$file=$this->read();
			}
			else{
				$file=array("<?php\r\n","\$tab=array();\r\n","\r\n","?>");
			}
			$modification=array("<?php\r\n","\$tab=array();\r\n");
			$i=2;
			$length=count($file);
			while($i<$length){
				$lineInfo=$this->readThisLine($file[$i]);
				if($lineInfo!==null){
					$ism=$this->isInModification($lineInfo["name"],$dataname,$remove);
					switch($ism){
						case "s":
						break;
						case "r":
						break;
						default:
							$modification=array_merge($modification,array($file[$i]));
					}
				}
				$i++;
			}
			$i=0;
			$length=count($dataname);
			while($i<$length){
				$modification=array_merge($modification,$this->setInModification($dataname[$i],$datavalue[$i],$datatype[$i]));
				$i++;
			}
			$length=count($modification);
			$ret="";
			$i=0;
			while($i<$length){
				$ret=$ret.$modification[$i];
				$i++;
			}
			return($ret);
		}
		private function setInModification($name,$value,$type){
			return(array("\$tab[\"".$name."\"]=".$this->printValue($value,$type).";\r\n"));
		}
		private function printValue($value,$type){
			if($type=="string"){
				$ret="\"".$value."\"";
				return($ret);
			}
			else if($type=="boolean"){
				if($value){
					$v="true";
				}
				else{
					$v="false";
				}
				return($v);
			}
			else if($type=="array"){
				$keys=array_keys($value);
				$values=array_values($value);
				$i=0;
				$length=count($values);
				$res="array(";
				while($i<$length){
					$tk=$this->getTypeOfData($keys[$i]);
					$tv=$this->getTypeOfData($values[$i]);
					$res.=$this->printValue($keys[$i],$tk)."=>".$this->printValue($values[$i],$tv);
					if($i<$length-1){
						$res.=",";
					}
					$i++;
				}
				$res.=")";
				return($res);
			}
			else{
				return($value);
			}
		}
		private function isAuthorizedType(&$type){
			$at=DataFile::$authorized_types;
			$i=0;
			$length=count($at);
			while($i<$length){
				if($type==$at[$i]){
					return(true);
				}
				$i++;
			}
			return(false);
		}
		private function isRemoved($name){
			$i=0;
			$length=count($this->remove);
			while($i<$length){
				if($name==$this->remove[$i]){
					return(true);
				}
				$i++;
			}
			return(false);
		}
		private function read(){
			$file=fopen($this->filename,"r");
			$ret=array();
			while(!feof($file)){
				$line=fgets($file);
				$ret=array_merge($ret,array($line));
			}
			fclose($file);
			unset($line);
			return($ret);
		}
		private function readThisLine(&$line){
			$ret=array();
			$length=strlen($line);
			if($length>6){
				$name="";
				$i=6;
				$good=false;
				while((!$good)&&($i<$length)){
					if($line[$i]=="\""){
						$good=true;
					}
					else{
						$name=$name.$line[$i];
					}
					$i++;
				}
				$i=$i+2;
				$good=false;
				$value="";
				while($i<$length-1){
					$value=$value.$line[$i];
					$i++;
				}
				return(array("name"=>$name,"value"=>$value));
			}
		}
		private function isInModification(&$name,&$dataname,&$remove){
			$i=0;
			$length=count($dataname);
			while($i<$length){
				if($name==$dataname[$i]){
					return("s");
				}
				$i++;
			}
			$i=0;
			$length=count($remove);
			while($i<$length){
				if($name==$remove[$i]){
					$j=0;
					$r=array();
					while($j<$length){
						if($j!=$i){
							$r=array_merge($r,array($remove[$j]));
						}
						$j++;
					}
					$remove=$r;
					return("r");
				}
				$i++;
			}
			return("u");
		}
		public function isWritable(){
			return((($this->isExist())&&(is_writable($this->filename)))||((!$this->isExist())&&(is_writable(dirname($this->filename)))));
		}
		public function isReadable(){
			return(is_readable($this->filename));
		}
	}
