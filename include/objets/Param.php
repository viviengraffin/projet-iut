<?php
	class Getp{
		public function get($name){
			return($_GET[$name]);
		}
		public function exist($name){
			return(isset($_GET[$name]));
		}
		public function html($name){
			return(htmlentities($_GET[$name]));
		}
		public function hasData(){
			return(count($_GET)>1);
		}
	}
	class Post{
		public function get($name){
			return($_POST[$name]);
		}
		public function exist($name){
			return(isset($_POST[$name]));
		}
		public function html($name){
			return(htmlentities($_POST[$name]));
		}
		public function hasData(){
			return(count($_POST)>0);
		}
	}
	class Files{
		public function get($name){
			return($_FILES[$name]);
		}
		public function exist($name){
			return(isset($_FILES[$name]));
		}
		public function hasData(){
			return(count($_FILES)>0);
		}
		public function tmpName($name){
			return($_FILES[$name]["tmp_name"]);
		}
		public function size($name){
			return($_FILES[$name]["size"]);
		}
		public function hasError($name){
			return($_FILES[$name]["error"]!=UPLOAD_ERR_OK);
		}
		public function ext($name){
			$filename=Files::tmpName($name);
			$lp=strrchr($filename,".");
			$length=strlen($filename);
			return(substr($filename,$lp,$length-$lp));
		}
		public function fileName($name){
			$filename=Files::tmpName($name);
			$lp=strrchr($filename,"/");
			$length=strlen($filename);
			return(substr($filename,$lp,$length-$lp));
		}
		public function move($name,$dest){
			if((Files::exist($name))&&(Files::error($name)==UPLOAD_ERR_OK)){
				return(move_uploaded_file(Files::tmpName($name),$dest));
			}
			else{
				return(false);
			}
		}
	}
	class Data{
		public static $get;
		public static $post;
		public static $files;
		
		public static function init(){
			self::$get=new Getp();
			self::$post=new Post();
			self::$files=new Files();
		}
	}
