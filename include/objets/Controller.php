<?php
	class Controller{
		private $name;
		private $view;
		private $methodv;
		private $urlv;
		private $state=200;
		private $loadDefault=false;
		private $redirectv;
		private $pdfv;
		private $filenamepdf;
		
		function __construct($name,$view){
			if($view==""){
				$view=null;
			}
			$this->name=$name;
			$this->view=$view;
			$this->urlv=$_SERVER["REQUEST_URI"];
			$this->methodv=$_SERVER["REQUEST_METHOD"];
		}
		public function changeState($state){
			$this->state=$state;
		}
		public function removeView(){
			$this->view=null;
		}
		public function hasView(){
			return($this->view!==null);
		}
		public function changeView($view=null){
			$this->view=$view;
		}
		public function getView(){
			return(get_view_address($this->view));
		}
		public function loadDefault(){
			$this->loadDefault=true;
		}
		public function getDefault(){
			return($this->loadDefault);
		}
		public function getState(){
			return($this->state);
		}
		public function url(){
			return($this->urlv);
		}
		public function method(){
			return($this->methodv);
		}
		public function redirect($url="./",$die=false){
			if(gettype($url)=="boolean"){
				$die=$url;
				$url="./";
			}
			if($die){
				header("location: ".$url);
				die();
			}
			else{
				$this->redirectv=$url;
			}
		}
		public function hasRedirectAddress(){
			return($this->redirectv!==null);
		}
		public function getRedirectAddress(){
			return($this->redirectv);
		}
		public function hasPdf(){
			return($this->pdfv!==null);
		}
		public function getPdf(){
			return($this->pdfv);
		}
		public function getFilenamePdf(){
			return($this->filenamepdf);
		}
		public function pdf($pdf,$filename="pdf.pdf"){
			$this->pdfv=$pdf;
			$this->filenamepdf=$filename;
		}
	}
