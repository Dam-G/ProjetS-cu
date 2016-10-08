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

        $req_id="SELECT * FROM `handicap`.`authentification` WHERE pseudo='".$_SESSION['pseudo']."'";
        $result_id=$bdd->query($req_id);
        $data=$result_id->fetch();


        $req_datas="SELECT * FROM `handicap`.`donnees` WHERE id='".$data['id']."'";
        $result_datas=$bdd->query($req_datas);
        $data2=$result_datas->fetch();

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
