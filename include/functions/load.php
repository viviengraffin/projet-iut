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
	function getVariableValue($value){
		$type=gettype($value);
		if($type=="string"){
				$ret="\"".$value."\"";
				return($ret);
			}
			else if($type=="boolean"){
				if($value){
					$v="true";
				}
				else{
					$v="false";
				}
				return($v);
			}
			else if($type=="array"){
				$keys=array_keys($value);
				$values=array_values($value);
				$i=0;
				$length=count($values);
				$res="array(";
				while($i<$length){
					$tk=$this->getTypeOfData($keys[$i]);
					$tv=$this->getTypeOfData($values[$i]);
					$res.=$this->printValue($keys[$i],$tk)."=>".$this->printValue($values[$i],$tv);
					if($i<$length-1){
						$res.=",";
					}
					$i++;
				}
				$res.=")";
				return($res);
			}
			else{
				return($value);
			}
	}
	function load_view($view,$data=array()){
		$lengthData=count($data);
		$idata=0;
		$dataname=array_keys($data);
		$datavalue=array_values($data);
		while($idata<$lengthData){
			$adata="$".$dataname[$idata]."=".getVariableValue($datavalue[$idata]).";";
			eval($adata);
			$idata++;
		}
		unset($lengthData);
		unset($idata);
		unset($data);
		unset($adata);
		unset($dataname);
		unset($datavalue);
		include("view/".$view.".php");
	}
?>
