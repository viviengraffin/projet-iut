<?php
	$file=new DataFile("test.php");
	$file->set("ok",array(1,2));
	$file->set("tableau_associatif",array("wesh"=>"alors","je_suis"=>"un_ovni"));
	$file->update();
