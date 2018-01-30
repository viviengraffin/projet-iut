<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    <title> Page de saisie d'evaluation</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="header.css">
</head>
<body>
<?php load_view("header-user"); ?>
<div="container">
<h2 align="center">Page note</h2>
	<form method="post" action="noteAction">
		<TABLE border="1">
			<TR>
				<TD width="2%">Nom</TD>
					
				<TD width="2%">Prénom </TD>
					
				<TD width="1%">Activité d'administrateurs</TD>
				
				<TD width="1%">Activité d'enseignement</TD>
				
				<TD width="1%">Activité de recherche</TD>
				
				<TD width="1%">Visibilité</TD>
			</TR>
			<?php
			$ids="";
			foreach($dossiers as $dossier){
				if($ids==""){
					$ids.=$dossier->getNum();
				}
				else{
					$ids.=";".$dossier->getNum();
				}
			?>
			<TR>
				<TD width="2%"><?=$dossier->getNom(); ?></TD>
					
				<TD width="2%"><?= $dossier->getPrenom(); ?></TD>
					
				<TD width="2%"><select name="admin<?= $dossier->getNum(); ?>">
					<option>=</option>
					<option>+</option>
					<option>++</option>
				</select></TD>
				<TD><select name="enseign<?= $dossier->getNum(); ?>">
					<option>=</option>
					<option>+</option>
					<option>++</option>
				</select></TD>
				<TD><select name="recherche<?= $dossier->getNum(); ?>">
					<option>=</option>
					<option>+</option>
					<option>++</option>
				</select></TD>
				<TD><select name="visibilite<?= $dossier->getNum(); ?>">
					<option>=</option>
					<option>+</option>
					<option>++</option>
				</select></TD>
				</TR>
				<?php
				}
				?>
		</TABLE>
		<br/><br/>
		<input type="hidden" name="ids" value="<?= $ids; ?>">
		<?= getCsrfObject()->addToken("note")->getHiddenInput(); ?>
		<div style="text-align:center;">
			<input type="submit" value="Valider">
		</div>
    </form>
	<?php load_view("footer"); ?>
</body>
</html>
