<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>

	<?php

		session_start();

		include("config_sql.php");
		include("function.php");

		if (isset($_SESSION['user'])){
			$user=unserialize($_SESSION['user']);
		}
		else header("Location: accueil.php");

		if($user->getDroit()!=2) header("Location: accueil.php");


	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete"><a href="accueil.php" id="liens">ACCUEIL</a> - <a href="statistiques.php" id="liens">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr>
				<td height="800px" width="15%" id="banniere">
				<?php
					include("verif_droit.php");

				?>


				</td>
				<td id="corps">

				<form id="demande_tuteur" action="accueil.php" method="post">
				<label for="numero">Entrez l' e-mail du patient dont vous souhaitez devenir le tuteur : </label>
				<input type="text" name="email" id="email" required><br /><br />
				<input type="submit" name="demande_tuteur" value="Valider">
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
