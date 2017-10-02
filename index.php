<?php
	session_start();
	include("include/all.php");
	
	$mvc->state("form1","form1");
	$mvc->state("resform1","resform1","resform1");
	$mvc->state("testdf","testdf");
	
	$mvc->dstate("error404","error404");
	
	$mvc->start();
