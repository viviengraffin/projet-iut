<?php
	class Dossier{
		private $num;
		private $nom;
		private $prenom;
		private $ancienneteEchelon;
		private $ancienneteConference;
		private $echelon;
		private $activite;
		private $tachesAdmin;
		private $login;
		private $password;
		
		function __construct($num,$login,$password,$nom,$prenom,$ancienneteEchelon,$ancienneteConference,$echelon,$activite,$tachesAdmin,$issha1=false){
			$this->num=$num;
			$this->login=$login;
			if(!$issha1){
				$this->password=sha512($password);
			}
			else{
				$this->password=$password;
			}
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->ancienneteEchelon=$ancienneteEchelon;
			$this->ancienneteConference=$ancienneteConference;
			$this->activite=$activite;
			$this->tachesAdmin=$tachesAdmin;
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
		public function getAncienneteConference(){
			return($this->ancienneteConference);
		}
		public function getEchelon(){
			return($this->echelon);
		}
		public function getActivite(){
			return($this->activite);
		}
		public function getTaches(){
			return($this->tachesAdmin);
		}
		public function getLogin(){
			return($this->login);
		}
		public function getPassword(){
			return($this->password);
		}
	}
