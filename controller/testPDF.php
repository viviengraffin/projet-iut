<?php
	$pdf=new PDF("test");
	$pdf->orientation("L");
	$CONTROLLER->pdf($pdf,"Vald.pdf");
