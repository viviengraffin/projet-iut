<?php
	class Getp{
		public static function get($name){
			return($_GET[$name]);
		}
		public static function exist($name){
			return(isset($_GET[$name]));
		}
		public static function html($name){
			return(htmlentities($_GET[$name]));
		}
		public static function hasData(){
			return(count($_GET)>1);
		}
	}
	class Post{
		public static function get($name){
			return($_POST[$name]);
		}
		public static function exist($name){
			return(isset($_POST[$name]));
		}
		public static function html($name){
			return(htmlentities($_POST[$name]));
		}
		public static function hasData(){
			return(count($_POST)>0);
		}
	}
	class Files{
		public static function get($name){
			return($_FILES[$name]);
		}
		public static function exist($name){
			return(isset($_FILES[$name]));
		}
		public static function hasData(){
			return(count($_FILES)>0);
		}
		public static function tmpName($name){
			return($_FILES[$name]["tmp_name"]);
		}
		public static function size($name){
			return($_FILES[$name]["size"]);
		}
		public static function hasError($name){
			return($_FILES[$name]["error"]!=UPLOAD_ERR_OK);
		}
		public static function ext($name){
			$filename=Files::tmpName($name);
			$lp=strrchr($filename,".");
			$length=strlen($filename);
			return(substr($filename,$lp,$length-$lp));
		}
		public static function fileName($name){
			$filename=Files::tmpName($name);
			$lp=strrchr($filename,"/");
			$length=strlen($filename);
			return(substr($filename,$lp,$length-$lp));
		}
		public static function move($name,$dest){
			if((Files::exist($name))&&(Files::error($name)==UPLOAD_ERR_OK)){
				return(move_uploaded_file(Files::tmpName($name),$dest));
			}
			else{
				return(false);
			}
		}
	}
