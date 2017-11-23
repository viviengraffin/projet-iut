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
		
		function __construct($num,$nom,$prenom,$ancienneteEchelon,$ancienneteEnseignement,$echelon,$recherche,$enseignement,$tachesAdmin,$visibilte){
			$this->num=$num;
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->ancienneteEchelon=$ancienneteEchelon;
			$this->ancienneteEnseignement=$ancienneteEnseignement;
			$this->recherche=$recherche;
			$this->enseignement=$enseignement;
			$this->tachesAdmin=$tachesAdmin;
			$this->visibilite=$visibilite;
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
	}
