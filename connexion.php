<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>

	<?php

		if (isset($_POST['deconnexion'])) {session_destroy();}

		if (isset($_POST['identifiant'])){

				$db = mysqli_connect("localhost", "root", "")
	                or die("Impossible de se connecter : " . mysql_error());

	            $res = mysqli_query($db, "SHOW DATABASES");

	            $row = mysqli_fetch_assoc($res);

	            $bdd = mysqli_select_db($db, 'handicap');
	            if (!$bdd) {
	                die ('Impossible de selectionner la base de donnees ' . mysql_error());

				$id=$_POST['identifiant'];
				$password=$_POST['password'];
				$req="SELECT * FROM `handicap`.`authentification` WHERE pseudo='$id'";
				$reponse = mysqli_query($db, $req);
				$line = mysqli_fetch_assoc($reponse);
				if(password_verify($password, $line['passwd'])){
					session_start();
					$_SESSION['pseudo']=$id;
					$_SESSION['droit']=1;
					header("accueil.php");
					exit;
				}
				else{
					header("accueil.php");
					exit;
				}
			}
		}

	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete" ><a href="accueil.php">ACCUEIL</a> - <a href="statistiques.php">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr>
				<td height="800px" width="15%" id="banniere">
				<?php
					if (!isset($_SESSION['droit'])){
						echo"<form id='authentification' action='connexion.php' method='post'>
						CONNEXION</br></br>
						<div>
							<input type='text' name='identifiant' id='identifiant' placeholder='Identifiant'>
							<input type='password' name='password' id='password' placeholder='Mot de passe'>
							<input type='submit' id='valid_authentif' value='Valider'>
						</div>
						</br>
						<a href='inscription.php'>S'incrire</a>
						</form>";
					}
					else if($_SESSION['droit']==1){
						echo "Bonjour ".$_SESSION['pseudo']."\n
						<form id='deconnexion' action='accueil.php' method='post'>
						<input type='submit' id='deconnexion' value='Se déconnecter'>
						</form>"
						;

					}
				?>
				</td>
				<td id="corps">Ici, prochainement, une présentation de notre site !</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
