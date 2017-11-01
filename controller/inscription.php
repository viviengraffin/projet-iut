<?php
	
	if(RapporteurPDO::isRoot()){
		$form=new Form("inscription");
	}
	else{
		echo "<b style='color:red;'>Vous n'avez pas la permission d'accéder à cette page</b>";
		$CONTROLLER["view"]="";
	}
