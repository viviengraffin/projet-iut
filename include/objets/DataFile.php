<?php
	class DataFile{
		private $filename;
		private $data;
		private $ismodified=false;
		private $modified;
		
		
		function __construct($filename){
			$this->filename=dirname(__FILE__)."/../../".$filename.".conf";
			$this->modified=array();
			if($this->isReadable()){
				$this->data=unserialize($this->read());
			}
			else if(!$this->isExist()){
				$this->data=array();
			}
			else{
				throw new DataFileReadException("Vous n'avez pas le droit de lire ce fichier.");
			}
		}
		public function set($name,$value,$setNow=false){
			if($setNow){
				$data=$this->data;
				$data[$name]=$value;
				$this->modify($data);
			}
			else{
				if(!$this->ismodified){
					$this->modified=$this->data;
				}
				$this->ismodified=true;
				$this->modified[$name]=$value;
				$this->modify($this->data);
			}
		}
		public function get($name,$getChanges=false){
			if($getChanges){
				return($this->data[$name]);
			}
			else{
				$data=$this->data;
				return($data[$name]);
			}
		}
		public function remove($name,$setNow=false){
			if($setNow){
				$data=$this->data;
				unset($data[$name]);
				$this->modify($data);
			}
			else{
				if(!$this->ismodified){
					$this->modified=$data;
				}
				$this->ismodified=true;
				unset($this->modified[$name]);
			}
		}
		public function has($name,$getChanges=false){
			$data=$this->getAll($getChanges);
			return(isset($data[$name]));
		}
		public function getAll($getChanges=false){
			if($getChanges){
				return($this->modified);
			}
			else{
				return($this->data);
			}
		}
		public function isExist(){
			return(file_exists($this->filename));
		}
		public function isWritable(){
			return((($this->isExist())&&(is_writable($this->filename)))||((!$this->isExist())&&(is_writable(dirname($this->filename)))));
		}
		public function update(){
			if(!$this->modify($this->modified)){
				throw new DataFileWriteException("Vous n'avez pas la permission d'écrire dans ce fichier.",$this->data);
			}
			else{
				$this->data=$this->modified;
				$this->modified=array();
				$this->ismodified=false;
			}
		}
		public function cancelChanges(){
			$this->data=unserialize($this->read());
		}
		public function isReadable(){
			return(is_readable($this->filename));
		}
		public function delete(){
			unlink($this->filename);
		}
		private function modify($value){
			if($this->isWritable()){
				$file=fopen($this->filename,"w");
				fwrite($file,serialize($value));
				fclose($file);
				return(true);
			}
			else{
				return(false);
			}
		}
		private function read(){
			if($this->isExist()){
				$file=fopen($this->filename,"r");
				$res="";
				while(!feof($file)){
					$line=fgets($file);
					$res.=$line;
				}
				fclose($file);
				return($res);
			}
			else{
				return(serialize(array()));
			}
		}
	}
	
	class DataFileException extends Exception{
		
	}
	class DataFileReadException extends DataFileException{
		
	}
	class DataFileWriteException extends DataFileException{
		private $txtData;
	
		function __construct($msg,$data){
			parent::__construct($msg);
			$this->txtData=serialize($data);
		}
		public function getText(){
			return(htmlentities($this->txtData));
		}
	}
