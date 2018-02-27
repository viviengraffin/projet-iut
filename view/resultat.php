<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <title>Résultat</title>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <link rel="stylesheet" href="header.css">
    </head>
    <body>
       <?php load_view("header-user"); ?>
		<table border="1">
				<thead>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Échelon</th>
					<th>Ancienneté dans l'échelon</th>
					<th>Nbre votants</th>
					<th>N° tour</th>	
				</thead>
				<?php
				foreach($dossiers as $dossier){
					if($dossier->isAccepted()){
						$class=" class='green'";
					}
					else{
						$class="";
					}
					?>
					<tr>
						<td<?= $class; ?>><?= $dossier->getNom(); ?></td>
						<td<?= $class; ?>><?= $dossier->getPrenom(); ?></td>
						<td<?= $class; ?>><?= $dossier->getEchelon(); ?></td>
						<td<?= $class; ?>><?= $dossier->getAncienneteEchelon(); ?> an(s)</td>
						<td<?= $class; ?>><?= $dossier->getNbVotants(); ?></td>
						<td<?= $class; ?>><?= $dossier->getTour(); ?></td>
					</tr>
					<?php
				}
				?>
		</table>
		<br/><br/>
		<?= $bonus; ?>
		<?php load_view("footer"); ?>
    </body>
</html>
