<?php
	class Rapporteur{
		private $id;
		private $nom;
		private $prenom;
		private $login;
		private $password;
		private $dateNaiss;
		private $mail;
		
		function __construct($nom,$prenom,$login,$password,$dateNaiss,$mail,$issha1=false){
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->login=$login;
			$this->dateNaiss=$dateNaiss;
			$this->mail=$mail;
			if(!$issha1){
				$this->password=sha512($password);
			}
			else{
				$this->password=$password;
			}
		}
		public function setId($id){
			$this->id=$id;
		}
		public function setPassword($password,$issha=false){
			if(!$issha){
				$password=sha512($password);
			}
			$this->password=$password;
		}
		public function getId(){
			return($this->id);
		}
		public function getNom(){
			return($this->nom);
		}
		public function getPrenom(){
			return($this->prenom);
		}
		public function getLogin(){
			return($this->login);
		}
		public function getPassword(){
			return($this->password);
		}
		public function getTab(){
			return(array("nom"=>$this->nom,"prenom"=>$this->prenom,"login"=>$this->login,"password"=>$this->password,"mail"=>$this->mail,"dateNaiss"=>$this->dateNaiss["year"]."-".$this->dateNaiss["month"]."-".$this->dateNaiss["day"]));
		}
		public function getDateNaiss(){
			return($this->dateNaiss);
		}
		public function getMail(){
			return($this->mail);
		}
	}
