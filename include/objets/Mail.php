<?php
	class Mail{
		private $messagev=null;
		private $destv=null;
		private $subjectv=null;
		private $fromv=null;
		private $ccv=null;
		private $ishtml;
		
		function __construct($ishtml=false){
			$this->ishtml=$ishtml;
		}
		public function message($message){
			if(PHP_OS=="Linux"){
				$this->messagev=$message;
			}
			else{
				$this->message=str_replace("\n.","\n..",$message);
			}
		}
		public function destination($dest){
			$this->destv=$dest;
		}
		public function subject($subject){
			$this->subjectv=$sbject;
		}
		public function from($addr){
			$this->fromv=$addr;
		}
		public function Cc($cc){
			$this->ccv=$cc;
		}
		public function send(){
			return(mail($this->destv,$this->subjectv,$this->messagev));
		}
	}
