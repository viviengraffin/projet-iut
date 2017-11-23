<?php
	
	function load_model($model){
		include_once("model/".$model.".php");
	}
	function get_controller_address($controller){
		return("controller/".$controller.".php");
	}
	function get_view_address($view){
		return("view/".$view.".php");
	}
	function get_pdf_address($pdf){
		return("pdf/".$pdf.".php");
	}
	function load_view($view,$data=array()){
		$lengthData=count($data);
		$idata=0;
		$dataname=array_keys($data);
		$datavalue=array_values($data);
		while($idata<$lengthData){
			$adata="$".$dataname[$idata]."=\$datavalue[\$idata];";
			eval($adata);
			$idata++;
		}
		unset($lengthData);
		unset($idata);
		unset($data);
		unset($adata);
		unset($dataname);
		unset($datavalue);
		include(get_view_address($view));
	}
?>
