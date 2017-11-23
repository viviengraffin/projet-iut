<?php
	class DataBase{
		private $pdo;
		private $state;
		const mysql="mysql";
		const pgsql="pgsql";
		
		function __construct($type,$host,$login,$password,$db=""){
			$state=true;
			try{
				if($db==""){
					$dsn=$type.":host=".$host.";";
					$this->pdo=new PDO($dsn,$login,$password);
				}
				else{
					$dsn=$type.":host=".$host.";dbname=".$db.";";
					$this->pdo=new PDO($dsn,$login,$password);
				}
			}
			catch(Exception $e){
				$state=false;
			}
			$this->state=$state;
		}
		public function request($request,$params=null){
			if($this->state){
				if($params==null){
					return($this->pdo->query($request));
				}
				else{
					$prepare=$this->pdo->prepare($request);
					$prepare->execute($params);
					return($prepare);
				}
			}
		}
		public function getState(){
			return($this->state);
		}
	}
