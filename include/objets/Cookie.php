<?php
	class Cookie{
		public static function get($name){
			return(strval($_COOKIE[$name]));
		}
		public static function set($name,$value,$time){
			setcookie($name,$value,time()+$time);
		}
		public static function remove($name){
			Cookie::set($name,"",-1);
		}
	}
