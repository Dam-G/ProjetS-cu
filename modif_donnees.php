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
					else if(isset($_POST['modif'])){
						echo "<p id='titre'>DONNEES DE ".$_SESSION['pseudo']." :</p>";
						echo "</br></br>
						<form id='donnees' action='modif_donnees.php' method='post'>
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: <input type='text' name='nom' value='".$data2['nom']."' required></br>
						    Prénom: <input type='text' name='prenom' value='".$data2['prenom']."'required></br>
						    Date de naissance: <input type='date' name='date_naiss' value='".$data2['date_naissance']."'required></br>
						</fieldset></br>
						<fieldset id='affichage'>
						    <legend>Dossier médical</legend>
						    Champ1: <input type='text' name='champ1' value='".$data2['champ1']."'></br>
						    Champ2: <input type='text' name='champ2' value='".$data2['champ2']."'></br>
						    Champ3: <input type='text' name='champ3' value='".$data2['champ3']."'></br>
						    Champ4: <input type='text' name='champ4' value='".$data2['champ4']."'></br>
						    Champ5: <input type='text' name='champ5' value='".$data2['champ5']."'></br>
						</fieldset></br>
						<input type='submit' name='valid_modif' value='VALIDER'>
						</form>";
					}
					else if(isset($_POST['valid_modif'])){
						$update="UPDATE `handicap`.`donnees` SET
						`nom`='".$_POST['nom']."',
						`prenom`='".$_POST['prenom']."',
						`date_naissance`='".$_POST['date_naiss']."',
						`champ1`='".$_POST['champ1']."',
						`champ2`='".$_POST['champ2']."',
						`champ3`='".$_POST['champ3']."',
						`champ4`='".$_POST['champ4']."',
						`champ5`='".$_POST['champ5']."'
						WHERE `id`='".$data['id']."'";
						$update_res=$bdd->query($update)
							or die("Impossible de mettre à jour : " . mysql_error());
						echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
					}
					else if(isset($_POST['suppr'])){
						$req_suppr="DELETE FROM `handicap`.`donnees` WHERE `id`='".$data['id']."'";
						$suppr=$bdd->query($req_suppr)
							or die("Impossible de supprimer : " . mysql_error());
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
