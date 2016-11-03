<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>

	<?php

	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete" ><a href="accueil.php">ACCUEIL</a> - <a href="statistiques.php">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr >
				<td height="800px" width="15%" id="banniere">
					<?php include("verif_droit.php"); ?>


				</td>
				<td id="corps">
				<form id="rejoindre" action="accueil.php" method="post">
					REJOINDRE UN GROUPE<br /><br />
					<label for="numero">Entrez le numero du groupe que vous souhaitez rejoindre : </label>
					<input type="text" name="numero" id="numero" required><br /><br />
					<input type="submit" name="rejoindre_groupe" value="Valider">
				</form>


				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
