<?php
	class Session{
		private static $isStarted=false;
		
		public static function get($name=null){
			if($name===null){
				return($_SESSION);
			}
			else{
				if(!Session::$isStarted){
					Session::start();
				}
				return($_SESSION[$name]);
			}
		}
		public static function set($name,$value){
			if(!Session::$isStarted){
				Session::start();
			}
			$_SESSION[$name]=$value;
		}
		public static function remove($name){
			if(!Session::$isStarted){
				Session::start();
			}
			unset($_SESSION[$name]);
		}
		public static function exist($name){
			if(!Session::$isStarted){
				Session::start();
			}
			return(isset($_SESSION[$name]));
		}
		public static function abort(){
			if(!Session::$isStarted){
				Session::start();
			}
			session_abort();
		}
		public static function destroy(){
			if(!Session::$isStarted){
				Session::start();
			}
			session_destroy();
		}
		public static function start(){
			session_start();
			Session::$isStarted=true;
			session_regenerate_id(true);
		}
	}
