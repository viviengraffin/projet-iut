<?php
	class Cookie{
		private static $method="aes256";
		private static $key;
		private static $iv="1234567891234567";
		private static $prefix="1234";
		private static $httponly=false;
		private static $secure=false;
		private static $path=null;
		private static $domain=null;
		private static $file;
		private static $ivbytes;
		
		function __construct(){
			self::$ivbytes=array(
				"aes256"=>16
			);
		}
		public static function get($name,$decrypt=true){
			if((Cookie::$key===null)||(!$decrypt)){
				return(strval($_COOKIE[$name]));
			}
			else{
				$ret=Cookie::decrypt($_COOKIE[$name]);
				if($ret===false){
					throw new CookieException("La clé de cryptage est incorrecte");
				}
				else{
					return($ret);
				}
			}
		}
		public static function set($name,$value,$time=0,$addTime=true,$crypt=true){
			if(($time!=0)&&($addTime)){
				$time=time()+$time;
			}
			if((Cookie::$key===null)||(!$crypt)){
				$cookie=$value;
			}
			else{
				$cookie=Cookie::crypt($value);
			}
			setcookie($name,$cookie,$time,Cookie::$path,Cookie::$domain,Cookie::$secure,Cookie::$httponly);
		}
		private static function crypt($value){
			return(openssl_encrypt(Cookie::$prefix.";;".$value,Cookie::$method,Cookie::$key,false,Cookie::$iv));
		}
		private static function decrypt($value){
			$res=openssl_decrypt($value,Cookie::$method,Cookie::$key,false,Cookie::$iv);
			$tab=explode(";;",$res);
			if($tab[0]==Cookie::$prefix){
				$length=count($tab);
				$i=1;
				$ret="";
				while($i<$length){
					$ret.=$tab[$i];
					$i++;
					if($i!=$length){
						$ret.=";;";
					}
				}
				return($ret);
			}
			else{
				return(false);
			}
		}
		public static function extend($name,$time){
			setcookie($name,strval($_COOKIE[$name]),time()+$time,Cookie::$path,Cookie::$domain,Cookie::$secure,Cookie::$httponly);
		}
		public static function has($name){
			return(isset($_COOKIE[$name]));
		}
		public static function remove($name){
			setcookie($name,"",time()-1);
		}
		public static function setKey($key){
			Cookie::$key=$key;
			if(Cookie::$file!==null){
				Cookie::$file->set("key",$key,true);
			}
		}
		public static function changeKey($keylimit=512){
			Cookie::$key=Cookie::getNewKey($keylimit);
			if(Cookie::$file!==null){
				Cookie::$file->set("key",Cookie::$key,true);
			}
		}
		public static function setIv($iv){
			Cookie::$iv=$iv;
			if(Cookie::$file!==null){
				Cookie::$file->set("iv",$iv,true);
			}
		}
		public static function setPrefix($prefix){
			Cookie::$prefix=$prefix;
			if(Cookie::$file!==null){
				Cookie::$file->set("prefix",$prefix);
			}
		}
		public static function setConfigFile($filename,$keylength=512,$errorController=null,$errorView=null){
			$loadViewInError=false;
			$loadControllerInError=false;
			if(isset($errorController)){
				if(isset($errorView)){
					$loadControllerInError=true;
					$loadViewInError=true;
				}
				else{
					if(file_exists(get_controller_address($errorController))){
						$loadControllerInError=true;
					}
					else{
						$loadViewInError=true;
						$errorView=$errorController;
						$errorController=null;
					}
				}
			}
			$file=new DataFile($filename);
			$res=$file->getAll();
			if(!((isset($res["key"]))&&(isset($res["iv"]))&&(isset($res["prefix"])))){
				$file->set("key",Cookie::getNewKey($keylength));
				$file->set("iv",Cookie::getNewKey(self::$ivbytes[self::$method]));
				$file->set("prefix",Cookie::getNewKey(4));
				try{
					$file->update();
				}
				catch(DataFileWriteException $e){
					$content=$e->getContent();
					$filename=$e->getFilename();
					if($loadControllerInError){
						include(get_controller_address($errorController));
						if($loadViewInError){
							include(get_view_address($errorView));
						}
					}
					else{
						include(get_view_address($errorView));
					}
					die();
				}
				$res=$file->getAll();
			}
			Cookie::$key=$res["key"];
			Cookie::$iv=$res["iv"];
			Cookie::$prefix=$res["prefix"];
			Cookie::$file=$file;
		}
		private static function getNewKey($keylength){
			$key=bin2hex(openssl_random_pseudo_bytes($keylength/2));
			return($key);
		}
		public static function httponly($set=true,$modify=true){
			Cookie::$httponly=$set;
		}
		public static function secure($set=true,$modify=true){
			Cookie::$secure=$set;
		}
		public static function path($path=null){
			Cookie::$path=$path;
		}
		public static function domain($domain=null){
			Cookie::$domain=$domain;
		}
	}
	class CookieException extends Exception{
		
	}
