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
		private $visibilite;
		private $tachesAdmin;
		private $rapporteur1;
		private $rapporteur2;
		private $tour;
		private $nbvotants;
		private $isAccepted_a;
		
		function __construct($nom,$prenom,$ancienneteEchelon,$ancienneteEnseignement,$echelon,$rapporteur1,$rapporteur2){
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->ancienneteEchelon=$ancienneteEchelon;
			$this->ancienneteEnseignement=$ancienneteEnseignement;
			$this->echelon=$echelon;
			$this->rapporteur1=$rapporteur1;
			$this->rapporteur2=$rapporteur2;
		}
		public function getTour(){
			if(!isset($this->tour)){
				$this->tour=DossierPDO::getTour($this);
			}
			return($this->tour);
		}
		public function getNbVotants(){
			if(!isset($this->nbvotants)){
				$this->nbvotants=DossierPDO::getNbVotants($this);
			}
			return($this->nbvotants);
		}
		public function isAccepted(){
			if(!isset($this->isAccepted_a)){
				$this->isAccepted_a=DossierPDO::isAccepted($this);
			}
			return($this->isAccepted_a);
		}
		public function setNotes($recherche,$enseignement,$tachesAdmin,$visibilite){
			$this->recherche=$recherche;
			$this->enseignement=$enseignement;
			$this->tachesAdmin=$tachesAdmin;
			$this->visibilite=$visibilite;
		}
		public function getNote(){
			$res=$this->getNbPlus($this->recherche);
			$res+=$this->getNbPlus($this->enseignement);
			$res+=$this->getNbPlus($this->visibilite);
			$res+=$this->getNbPlus($this->tachesAdmin);
			return($res);
		}
		private function getNbPlus($str){
			$i=0;
			$res=0;
			$length=strlen($str);
			while($i<$length){
				if(substr($str,$i,1)=="+"){
					$res++;
				}
				$i++;
			}
			return($res);
		}
		public function setNum($num){
			$this->num=$num;
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
			return($this->visibilite);
		}
		public function getRapporteur1(){
			return($this->rapporteur1);
		}
		public function getRapporteur2(){
			return($this->rapporteur2);
		}
	}
