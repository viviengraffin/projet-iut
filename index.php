<?php
	session_start();
	include("include/all.php");
	
	$mvc->state("inscriptionAction","inscriptionAction");
	
	$mvc->dstate("error404","error404");
	
	$mvc->start();
