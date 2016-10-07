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

		$db = mysqli_connect("localhost", "root", "")
            or die("Impossible de se connecter : " . mysql_error());

        $res = mysqli_query($db, "SHOW DATABASES");

        $row = mysqli_fetch_assoc($res);

        $bdd = mysqli_select_db($db, 'handicap');
        if (!$bdd) {
            die ('Impossible de selectionner la base de donnees ' . mysql_error());}

        $req="SELECT * FROM `handicap`.`authentification` WHERE pseudo='".$_SESSION['pseudo']."'";
        $result=mysqli_query($db, $req);
        $data=mysqli_fetch_assoc($result);


        $req2="SELECT * FROM `handicap`.`donnees` WHERE id='".$data['id']."'";
        $result2=mysqli_query($db, $req2);
        $data2=mysqli_fetch_assoc($result2);

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
				?>


				</td>
				<td id="corps">
					<?php
					if($_SESSION['droit']!=1) echo "Vous n'avez pas le droit d'accéder à cette page. Veuillez revenir à l'accueil.";
					else{
						echo "<p id='titre'>DONNEES DE ".$_SESSION['pseudo']." :</p>";
						echo "</br></br>
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: ".$data2['nom']."</br>
						    Prénom: ".$data2['prenom']."</br>
						    Date de naissance: ".$data2['date_naissance']."</br>
						</fieldset></br>
						<fieldset id='affichage'>
						    <legend>Dossier médical</legend>
						    Champ1: ".$data2['champ1']."</br>
						    Champ2:".$data2['champ2']."</br>
						    Champ3: ".$data2['champ3']."</br>
						    Champ4: ".$data2['champ4']."</br>
						    Champ5: ".$data2['champ5']."</br>
						</fieldset></br>
						";
						echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
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
