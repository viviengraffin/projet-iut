<?php
	session_start();
	include("include/all.php");
	
	$mvc->state("inscriptionAction","inscriptionAction");
	
	$mvc->state("connexionRapporteur","connexionRapporteur");
	
	$mvc->dstate("error404","error404");
	
	$mvc->start();
