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

		if(!isset($_SESSION['user'])) header("Location: accueil.php");


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

						$user=unserialize($_SESSION['user']);

						if($user->getDroit()==1) $table='patient';
						elseif($user->getDroit()==2) $table='proche';
						else $table='soignant';

					if(isset($_POST['modif'])){
						echo "<p id='titre'>DONNEES DE ".$user->getPrenom()." ".$user->getNom()." :</p>";
						echo "</br></br>
						<form id='donnees' action='modif_donnees.php' method='post'>
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: <input type='text' name='nom' value='".$user->getNom()."' required></br>
						    Prénom: <input type='text' name='prenom' value='".$user->getPrenom()."'required></br>
						    <label for='age'>Age : </label>
							<select name='age' id='age' value='".$user->getAge()."' required>";
					            
					            	for ($i=15; $i < 120; $i++) {
					            		if ($i==$user->getAge()) echo "<option selected='selected' value=$i>$i ans</option>";
					            		else echo "<option value=$i>$i ans</option>";
					            	}
					            		
					     echo'
					        </select><br />
						    Pays de naissance: <input type="text" name="pays_naiss" value="'.$user->getPays_naissance().'" required></br>
						    Adresse: <input type="text" name="adresse" value="'.$user->getAdresse().'" required></br>
						    E-Mail: <input type="text" name="email" value="'.$user->getEmail().'" required></br>
						</fieldset></br>
						<input type="submit" name="valid_modif" value="VALIDER">
						</form>';
					}
					else if(isset($_POST['valid_modif'])){

						$user->setNom($_POST['nom']);
						$user->setPrenom($_POST['prenom']);
						$user->setAge($_POST['age']);
						$user->setAdresse($_POST['adresse']);
						$user->setEmail($_POST['email']);
						$user->setPays_naissance($_POST['pays_naiss']);

						$_SESSION['user']=serialize($user);

						$update="UPDATE `handicap`.`".$table."` SET
						`nom`='".htmlspecialchars($_POST['nom'])."',
						`prenom`='".htmlspecialchars($_POST['prenom'])."',
						`age`='".htmlspecialchars($_POST['age'])."',
						`adresse`='".addslashes(htmlspecialchars($_POST['adresse']))."',
						`nativecountry`='".htmlspecialchars($_POST['pays_naiss'])."'
						WHERE `id`='".$user->getId()."'";
						$update2="UPDATE `handicap`.`authentification` SET
						`email`='".htmlspecialchars($_POST['email'])."'
						WHERE `id`='".$user->getId()."';";
						$update_res=$bdd->query($update)
							or die("Impossible de mettre à jour : " . mysql_error());
						$update_res2=$bdd->query($update2)
							or die("Impossible de mettre à jour : " . mysql_error());
						echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
					}
					else if(isset($_POST['suppr'])){
						$req_suppr="DELETE FROM `handicap`.`donnees` WHERE `id`='".$user->getId()."'";
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
