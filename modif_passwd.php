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

	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete" ><a href="accueil.php">ACCUEIL</a> - <a href="statistiques.php">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr >
				<td height="800px" width="15%" id="banniere">
					<?php
						echo "Bonjour ".$_SESSION['pseudo']."\n
						<form id='deconnexion' action='accueil.php' method='post'>
						<input type='submit' name='deconnexion' value='Se déconnecter'>
						</form>"
						;
						?>

				</td>
				<td id="corps">
				<?php
				if(!isset($_SESSION['pseudo'])){
					echo "Vous n'avez pas le droit  d'accéder à cette page, veuillez revenir à l'accueil.";
				}
				else{
					echo "<form id='inscription' action='accueil.php' method='post'>
					CHANGEMENT DE MOT DE PASSE</br></br>
					<input type='password' name='password' id='password' placeholder='Entrez votre mot de passe' size='50px' required></br></br>
					<input type='password' name='new_passwd' id='new_passwd' placeholder='Entrez votre nouveau mot de passe' size='50px' required></br></br>
					<input type='password' name='confirm_passwd' id='confirm_passwd' placeholder='Entrez à nouveau le mot de passe' size='50px' required></br></br>
					<input type='submit' id='modif_passwd' value='Valider'>
				</form>";
				}
				?>

				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
