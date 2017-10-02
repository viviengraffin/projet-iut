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
?>