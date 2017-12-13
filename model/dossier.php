<?php
	class Dossier{
		private $num;
		private $nom;
		private $prenom;
		private $ancienneteEchelon;
		private $ancienneteEnseignement;
		private $echelon;
		private $recherche;
		private $enseignement;
		private $tachesAdmin;
		private $rapporteur1;
		private $rapporteur2;
		
		function __construct($num,$nom,$prenom,$ancienneteEchelon,$ancienneteEnseignement,$echelon,$recherche,$enseignement,$tachesAdmin,$visibilte,$rapporteur1,$rapporteur2){
			$this->num=$num;
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->ancienneteEchelon=$ancienneteEchelon;
			$this->ancienneteEnseignement=$ancienneteEnseignement;
			$this->recherche=$recherche;
			$this->enseignement=$enseignement;
			$this->tachesAdmin=$tachesAdmin;
			$this->visibilite=$visibilite;
			$this->rapporteur1=$rapporteur1;
			$this->rapporteur2=$rapporteur2;
		}
		function __construct($nom,$prenom,$ancienneteEchelon,$ancienneteEnseignement,$echelon){
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->ancienneteEchelon=$ancienneteEchelon;
			$this->ancienneteEnseigement=$ancienneteEnseignement;
			$this->echelon=$echelon;
		}
		public function getNum(){
			return($this->num);
		}
		public function getNom(){
			return($this->nom);
		}
		public function getPrenom(){
			return($this->prenom);
		}
		public function getAncienneteEchelon(){
			return($this->ancienneteEchelon);
		}
		public function getAncienneteEnseignement(){
			return($this->ancienneteEnseignement);
		}
		public function getEchelon(){
			return($this->echelon);
		}
		public function getEnseignement(){
			return($this->enseignement);
		}
		public function getRecherche(){
			return($this->recherche);
		}
		public function getTaches(){
			return($this->tachesAdmin);
		}
		public function getVisibilite(){
			return($this->visibilte);
		}
		public function getRapporteur1(){
			return($this->rapporteur1);
		}
		public function getRapporteur2(){
			return($this->rapporteur2);
		}
	}
