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

		if (isset($_POST['deconnexion'])) {
			$_SESSION=Array();
			session_destroy();}

		if (isset($_POST['pseudo']) or isset($_POST['identifiant']) or (isset($_POST['new_passwd']))){

				$db = mysqli_connect("localhost", "root", "")
	                or die("Impossible de se connecter : " . mysql_error());

	            $res = mysqli_query($db, "SHOW DATABASES");

	            $row = mysqli_fetch_assoc($res);

	            $bdd = mysqli_select_db($db, 'handicap');
	            if (!$bdd) {
	                die ('Impossible de selectionner la base de donnees ' . mysql_error());
	        }
						


			if(isset($_POST['pseudo'])){

				$pseudo=$_POST['pseudo'];
				$droit=$_POST['type_user'];
				$password=$_POST['password'];
				$verif_passwd=$_POST['verif_passwd'];
				if($password==$verif_passwd){
					$passwd_hashe=password_hash($password, PASSWORD_BCRYPT);
					$req="INSERT INTO `handicap`.`authentification` (`pseudo`,`passwd`,`droit`) VALUES ('$pseudo','$passwd_hashe','$droit')";
					$reponse = mysqli_query($db, $req);
				}
				else{
					echo "Erreur dans le mot de passe";
				}
			}

			else if(isset($_POST['identifiant'])){

				$id=$_POST['identifiant'];
				$password=$_POST['password'];
				$req="SELECT * FROM `handicap`.`authentification` WHERE pseudo='$id'";
				$reponse = mysqli_query($db, $req);
				$line = mysqli_fetch_assoc($reponse);
				if(password_verify($password, $line['passwd'])){
					session_start();
					$_SESSION['pseudo']=$id;
					$_SESSION['droit']=$line['droit'];
				}
				else{
					echo "Erreur d'authentification";
				}
			}

			else if(isset($_POST['new_passwd'])){
				$pseudo=$_SESSION['pseudo'];
				$password=$_POST['password'];
				$new_passwd=$_POST['new_passwd'];
				$confirm_passwd=$_POST['confirm_passwd'];
				$new_passwd_hashe=password_hash($new_passwd, PASSWORD_BCRYPT);
				$req="SELECT * FROM `handicap`.`authentification` WHERE pseudo='$pseudo'";
				$reponse=mysqli_query($db, $req);
				$line=mysqli_fetch_assoc($reponse);
				if((password_verify($password, $line['passwd'])) && ($new_passwd==$confirm_passwd)){
					$req_maj="UPDATE `handicap`.`authentification` SET `passwd`='$new_passwd_hashe' WHERE pseudo='$pseudo'";
					$maj=mysqli_query($db, $req_maj)
						or die ('Impossible de mettre à jour le mot de passe' . mysql_error());
				}
				else{
					echo "Erreur de changement de mot de passe";
				}
			}
		}


	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete"><a href="accueil.php" id="liens">ACCUEIL</a> - <a href="statistiques.php" id="liens">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr>
				<td height="800px" width="15%" id="banniere">
				<?php
					if (!isset($_SESSION['droit'])){
						echo"<form id='authentification' action='accueil.php' method='post'>
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
						<input type='submit' name='deconnexion' value='Se déconnecter'>
						</form>"
						;
						echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
						<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
						</form>";
						echo "</br><p><a href='donnees.php' id='onglet'>Consulter et modifier vos données</a></p>";
						echo "</br><p><a href='politique.php' id='onglet'>Définir la politique de partage</a></p>";

					}
					else if($_SESSION['droit']==2){
						echo "Bonjour ".$_SESSION['pseudo']."\n
						<form id='deconnexion' action='accueil.php' method='post'>
						<input type='submit' name='deconnexion' value='Se déconnecter'>
						</form>"
						;
						echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
						<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
						</form>";
						echo "</br><p><a href='donnees.php' id='onglet'>Consulter les données d'un proche</a></p>";
					}
					else if($_SESSION['droit']==3){
						echo "Bonjour ".$_SESSION['pseudo']."\n
						<form id='deconnexion' action='accueil.php' method='post'>
						<input type='submit' name='deconnexion' value='Se déconnecter'>
						</form>"
						;
						echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
						<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
						</form>";
						echo "</br><p><a href='donnees.php' id='onglet'>Consulter et modifier les données d'un patient</a></p>";
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
