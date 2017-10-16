<?php
	session_start();
	include("include/all.php");
	
	$mvc->state("inscription","inscription");
	
	$mvc->dstate("error404","error404");
	
	$mvc->start();
