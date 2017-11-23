<?php 
	class Vote{
		private $note;
		private $rapporteur;
		private $dossier;
		
		function __construct($dossier,$rapporteur,$note){
			$this->dossier=$dossier;
			$this->rapporteur=$rapporteur;
			$this->note=$note;
		}
		public function getNote(){
			return($this->note);
		}
		public function getRapporteur(){
			return($this->rapporteur);
		}
		public function getDossier(){
			return($this->dossier);
		}
		public function getTab(){
			return(array(""));
		}
	}
