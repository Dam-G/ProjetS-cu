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
						echo '</br></br>
						<form id="donnees" action="modif_donnees.php" method="post">
						<fieldset id="affichage">
						    <legend>Identité</legend>
						    Nom: <input type="text" name="nom" value="'.$user->getNom().'" required></br>
						    Prénom: <input type="text" name="prenom" value="'.$user->getPrenom().'" required></br>
						    <label for="age">Age : </label>
							<select name="age" id="age" value="'.$user->getAge().'" required>';
					            
					            	for ($i=15; $i < 120; $i++) {
					            		if ($i==$user->getAge()) echo "<option selected='selected' value=$i>$i ans</option>";
					            		else echo "<option value=$i>$i ans</option>";
					            	}
					            		
					     echo'
					        </select><br />
						    Pays de naissance: <input type="text" name="pays_naiss" value="'.$user->getPays_naissance().'" required></br>
						    Adresse: <input type="text" name="adresse" value="'.$user->getAdresse().'" required></br>
						    E-Mail: <input type="text" name="email" value="'.$user->getEmail().'" required></br>
						</fieldset></br>';

						if($user->getDroit()==1){

							$req_sens="SELECT * FROM `handicap`.`privat` WHERE Idp='".$user->getId()."'";
							$res_sens=$bdd->query($req_sens);
							$sens=$res_sens->fetch();

							echo '<fieldset id="affichage">
							    <legend>Données médicales</legend>
							    Num: <input type="text" name="num" value="'.$sens['num'].'" ></br>
							    Maladie: <input type="text" name="maladie" value="'.$sens['caractere'].'"></br></fieldset></br>';
						}
						   
						echo "<input type='submit' name='valid_modif' value='VALIDER'>
						</form>";
					}
					else if(isset($_POST['valid_modif'])){

						$nom=filtrage($_POST['nom']);
						$prenom=filtrage($_POST['prenom']);
						$age=filtrage($_POST['age']);
						$adresse=filtrage($_POST['adresse']);
						$email=filtrage($_POST['email']);
						$pays_naiss=filtrage($_POST['pays_naiss']);

						$user->setNom($nom);
						$user->setPrenom($prenom);
						$user->setAge($age);
						$user->setAdresse($adresse);
						$user->setEmail($email);
						$user->setPays_naissance($pays_naiss);

						$_SESSION['user']=serialize($user);

						$adresse=addslashes($adresse);
						$nom=addslashes($nom);
						$prenom=addslashes($prenom);
						$pays_naiss=addslashes($pays_naiss);

						$update="UPDATE `handicap`.`".$table."` SET
						`nom`='$nom',
						`prenom`='$prenom',
						`age`='$age',
						`adresse`='$adresse',
						`nativecountry`='$pays_naiss'
						WHERE `id`='".$user->getId()."'";
						$update2="UPDATE `handicap`.`authentification` SET
						`email`='$email'
						WHERE `id`='".$user->getId()."';";

						if($user->getDroit()==1){
							$num=filtrage($_POST['num']);
							$num=addslashes($num);
							$maladie=filtrage($_POST['maladie']);
							$maladie=addslashes($maladie);

							$update3="UPDATE `handicap`.`privat` SET
							`num`='$num',
							`caractere`='$maladie'
							WHERE `Idp`='".$user->getId()."';";

							$update_res3=$bdd->query($update3)
								or die("Impossible de mettre à jour : " . mysql_error());
						}

						$update_res=$bdd->query($update)
							or die("Impossible de mettre à jour : " . mysql_error());
						$update_res2=$bdd->query($update2)
							or die("Impossible de mettre à jour : " . mysql_error());
						echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
					}


					else if(isset($_POST['modif_tutelle'])){
						$id=$user->getTuteur();
						if(empty($id)){ header("Location: accueil.php"); exit();}
						else{
							$req_infos="SELECT * FROM `handicap`.`patient` WHERE id=$id";
							$res_infos=$bdd->query($req_infos);
							$infos_patient=$res_infos->fetch();

							$req_infos2="SELECT * FROM `handicap`.`authentification` WHERE id=$id";
							$res_infos2=$bdd->query($req_infos2);
							$infos_patient2=$res_infos2->fetch();

							echo "<p id='titre'>DONNEES DE ".$infos_patient['prenom']." ".$infos_patient['nom']." :</p>";
							echo '</br></br>
							<form id="donnees" action="modif_donnees.php" method="post">
							<fieldset id="affichage">
							    <legend>Identité</legend>
							    Nom: <input type="text" name="nom" value="'.$infos_patient['nom'].'" required></br>
							    Prénom: <input type="text" name="prenom" value="'.$infos_patient['prenom'].'" required></br>
							    <label for="age">Age : </label>
								<select name="age" id="age" value="'.$infos_patient['age'].'" required>';
						            
						            	for ($i=15; $i < 120; $i++) {
						            		if ($i==$infos_patient['age']) echo "<option selected='selected' value=$i>$i ans</option>";
						            		else echo "<option value=$i>$i ans</option>";
						            	}
						            		
						     echo'
						        </select><br />
							    Pays de naissance: <input type="text" name="pays_naiss" value="'.$infos_patient['nativecountry'].'" required></br>
							    Adresse: <input type="text" name="adresse" value="'.$infos_patient['adresse'].'" required></br>
							    E-Mail: <input type="text" name="email" value="'.$infos_patient2['email'].'" required></br>
							</fieldset></br>';

							$req_sens="SELECT * FROM `handicap`.`privat` WHERE Idp='$id'";
							$res_sens=$bdd->query($req_sens);
							$sens=$res_sens->fetch();

							echo '<fieldset id="affichage">
							    <legend>Données médicales</legend>
							    Num: <input type="text" name="num" value="'.$sens['num'].'" ></br>
							    Maladie: <input type="text" name="maladie" value="'.$sens['caractere'].'"></br></fieldset></br>

							<input type="submit" name="valid_modif_tutelle" value="VALIDER">
							</form>';
						}
					}

					else if(isset($_POST['valid_modif_tutelle'])){

						$id=$user->getTuteur();
						if(empty($id)){ header("Location: accueil.php"); exit();}
						else{

							$nom=addslashes(filtrage($_POST['nom']));
							$prenom=addslashes(filtrage($_POST['prenom']));
							$age=filtrage($_POST['age']);
							$adresse=addslashes(filtrage($_POST['adresse']));
							$email=filtrage($_POST['email']);
							$pays_naiss=addslashes(filtrage($_POST['pays_naiss']));

							$num=filtrage($_POST['num']);
							$maladie=addslashes(filtrage($_POST['maladie']));

							$update="UPDATE `handicap`.`patient` SET
							`nom`='".$nom."',
							`prenom`='".$prenom."',
							`age`='".$age."',
							`adresse`='".$adresse."',
							`nativecountry`='".$pays_naiss."'
							WHERE `id`='".$id."'";

							$update2="UPDATE `handicap`.`authentification` SET
							`email`='".$email."'
							WHERE `id`='".$id."';";

							$update3="UPDATE `handicap`.`privat` SET
							`num`='$num',
							`caractere`='$maladie'
							WHERE `Idp`='$id';";

							$update_res=$bdd->query($update)
								or die("Impossible de mettre à jour : " . mysql_error());
							$update_res2=$bdd->query($update2)
								or die("Impossible de mettre à jour : " . mysql_error());
							$update_res3=$bdd->query($update3)
								or die("Impossible de mettre à jour : " . mysql_error());
							echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
						}
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
