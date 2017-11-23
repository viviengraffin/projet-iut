<?php
	use Spipu\Html2Pdf;
	
	class PDF{
		private $filename;
		private $orientationv="P";
		private $formatv="A4";
		private $localev="en";
		private $defaultFontv="Arial";
		private static $h2pi=false;
		
		
		function __construct($filename){
			if(!self::$h2pi){
				include("html2pdf/vendor/tecnickcom/tcpdf/tcpdf.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Html2Pdf.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Locale.php");
				include("html2pdf/vendor/spipu/html2pdf/src/MyPdf.php");
				include("html2pdf/vendor/spipu/html2pdf/src/CssConverter.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/TextParser.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/Css.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/TagParser.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/HtmlLexer.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/Html.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/Token.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Parsing/Node.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Extension/ExtensionInterface.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Extension/CoreExtension.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/TagInterface.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/AbstractTag.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/AbstractDefaultTag.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Bookmark.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Big.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/B.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/I.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Cite.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Span.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/U.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Label.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Samp.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Small.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Strong.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Sup.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Sub.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Ins.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Font.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Em.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/S.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Del.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Exception/Html2PdfException.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Tag/Address.php");
				include("html2pdf/vendor/spipu/html2pdf/src/Exception/HtmlParsingException.php");
				self::$h2pi=true;
			}
			$this->filename=$filename;
		}
		public function orientation($o){
			$this->orientationv=$o;
		}
		public function locale($l){
			$this->localev=$l;
		}
		public function defaultFont($d){
			$this->defaultFontv=$d;
		}
		public function output($data=array(),$filename="pdf.pdf"){
			if(gettype($data)=="string"){
				$filename=$data;
				$data=array();
			}
			$dataname=array_keys($data);
			$datavalue=array_values($data);
			$i=0;
			$length=count($data);
			while($i<$length){
				eval('$'.$dataname[$i].'=$datavalue[$i];');
				$i++;
			}
			unset($dataname);
			unset($datavalue);
			unset($i);
			unset($length);
			unset($data);
			ob_start();
			include(get_pdf_address($this->filename));
			$content=ob_get_clean();
			$content=str_replace("<center>","<div style='text-align:center;'>",$content);
			$content=str_replace("</center>","</div>",$content);
			$pdf=new Spipu\Html2Pdf\HTML2PDF($this->orientationv,$this->formatv,$this->localev);
			$pdf->setDefaultFont($this->defaultFontv);
			$pdf->writeHTML($content);
			ob_end_clean();
			$pdf->output($filename);
		}
	}
