<?php
	class Controller{
		private $name;
		private $view;
		private $methodv;
		private $urlv;
		private $state=200;
		private $loadDefault=false;
		private $redirectv;
		
		function __construct($name,$view){
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
		public function changeView($view){
			$this->view=$view;
		}
		public function loadDefault(){
			$this->loadDefault=true;
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
		public function redirect($url){
			$this->redirectv=$url;
		}
	}
