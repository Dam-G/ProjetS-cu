<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>


<?php
		include("config_sql.php");
		include("function.php");
		session_start();

		if (isset($_SESSION['user'])){
			$user=unserialize($_SESSION['user']);
	}
		else header("Location: accueil.php");




?>

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

/*        $req_id="SELECT * FROM `handicap`.`authentification` WHERE id='".$user->getId."'";
        $result_id=$bdd->query($req_id);
        $data=$result_id->fetch();

        $req_datas="SELECT * FROM `handicap`.`` WHERE id='".$data['id']."'";
        $result_datas=$bdd->query($req_datas);
        $data2=$result_datas->fetch();*/



					if((!isset($_GET['patient'])) && (!isset($_GET['tutelle']))) {					
				        $age=$user->getAge();
						echo "<p id='titre'>DONNEES :</p>";
						echo "<br /><br />
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: ".$user->getNom()."<br />
						    Prénom: ".$user->getPrenom()."<br />
						    Sexe: ".$user->getSexe()."<br />
						    Age: ".$age." ans<br />
						    Pays de naissance: ".$user->getPays_naissance()."<br />
						    Adresse: ".$user->getAdresse()."<br />
						    E-mail: ".$user->getEmail()."<br />

						</fieldset><br />
						";

						if($user->getDroit()==1){

							$req_sens="SELECT * FROM `handicap`.`privat` WHERE Idp='".$user->getId()."'";
							$res_sens=$bdd->query($req_sens);
							$sens=$res_sens->fetch();

							if(empty($sens['num'])){
								$num='Données non renseignées';
							}
							else $num=$sens['num'];

							if(empty($sens['caractere'])){
								$maladie='Données non renseignées';
							}
							else $maladie=$sens['caractere'];

							echo "
							<fieldset id='affichage'>
							    <legend>Données médicales</legend>
							    Num: ".$num."<br />
							    Maladie: ".$maladie."<br />

							</fieldset><br />
							";
						}

						echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
						</form>";

					}

					else if((isset($_GET['patient'])) && ($user->getDroit()==2)) {

						$id=$_GET['patient'];
						$id_proche=$user->getId();

						$verif=$user->getId_proches();

						$proches=explode(" ", $verif);

						if(!in_array($id, $proches)) echo "Vous ne pouvez pas accéder à cette page, veuillez retourner à l'accueil !";
						else{

							$req_pol="SELECT * FROM `handicap`.`politique` WHERE id=$id";
							$res_pol=$bdd->query($req_pol);
							$pol=$res_pol->fetch();

							
							
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$patient=$res_patient->fetch();
							$age=$patient['age'];
							echo "<p id='titre'>DONNEES DE ".$patient['prenom']." ".$patient['nom'].":</p>";
							echo "<br /><br />
							<fieldset id='affichage'>
							    <legend>Identité</legend>
							    Nom: ".$patient['nom']."<br />
							    Prénom: ".$patient['prenom']."<br />
							    Sexe: ".$patient['sex']."<br />
							    Age: ".$age." ans<br />
							    Pays de naissance: ".$patient['nativecountry']."<br />
							    Adresse: ".$patient['adresse']."<br />
							</fieldset><br />
							";

							if($pol['pol_groupe']==1){

								$req_privat="SELECT * FROM `handicap`.`privat` WHERE Idp='$id'";
								$res_privat=$bdd->query($req_privat);
								$privat=$res_privat->fetch();

								if(empty($privat['num'])){
									$num='Données non renseignées';
								}
								else $num=$privat['num'];

								if(empty($privat['caractere'])){
									$maladie='Données non renseignées';
								}
								else $maladie=$privat['caractere'];

								echo "
								<fieldset id='affichage'>
								    <legend>Données médicales</legend>
								    Num: ".$num."<br />
								    Maladie: ".$maladie."<br />
								</fieldset><br />
								";

							}

						}

					}

					else if((isset($_GET['tutelle'])) && ($user->getDroit()==2)) {

						$id_proche=$user->getId();
						$id=$user->getTuteur();

						//A MODIFIER POO
						/*
						$req_verif="SELECT * FROM `handicap`.`proche` WHERE id='$id_proche'";
						$res_verif=$bdd->query($req_verif);
						$verif=$res_verif->fetch();*/

						if(empty($id)) echo "Vous ne pouvez pas accéder à cette page, veuillez retourner à l'accueil !";
						else{
							
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$patient=$res_patient->fetch();
							$age=$patient['age'];
							echo "<p id='titre'>DONNEES DE ".$patient['prenom']." ".$patient['nom'].":</p>";
							echo "<br /><br />
							<fieldset id='affichage'>
							    <legend>Identité</legend>
							    Nom: ".$patient['nom']."<br />
							    Prénom: ".$patient['prenom']."<br />
							    Sexe: ".$patient['sex']."<br />
							    Age: ".$age." ans<br />
							    Pays de naissance: ".$patient['nativecountry']."<br />
							    Adresse: ".$patient['adresse']."<br />

							</fieldset><br />
							";

							$req_privat="SELECT * FROM `handicap`.`privat` WHERE Idp='$id'";
							$res_privat=$bdd->query($req_privat);
							$privat=$res_privat->fetch();

							if(empty($privat['num'])){
								$num='Données non renseignées';
							}
							else $num=$privat['num'];

							if(empty($privat['caractere'])){
								$maladie='Données non renseignées';
							}
							else $maladie=$privat['caractere'];
	
							echo "
							<fieldset id='affichage'>
							    <legend>Données médicales</legend>
							    Num: ".$num."<br />
							    Maladie: ".$maladie."<br />
							</fieldset><br />
							";

							echo "<form action='modif_donnees.php' method='post'>
							<input type='submit' name='modif_tutelle' value='Modifier/Ajouter des données'>
							<input type='submit' name='suppr' value='Supprimer les données'>
							</form>";

						}

					}

					else if($user->getDroit()==3){

						$id=$_GET['patient'];
						$id_soignant=$user->getId();

						//A MODIFIER POO
						/*
						$req_verif="SELECT * FROM `handicap`.`proche` WHERE id='$id_proche'";
						$res_verif=$bdd->query($req_verif);
						$verif=$res_verif->fetch();*/

						$verif=$user->getId_patients();

						$patients=explode(" ", $verif);

						if(!in_array($id, $patients)) echo "Vous ne pouvez pas accéder à cette page, veuillez retourner à l'accueil !";
						else{

							$req_pol="SELECT * FROM `handicap`.`politique` WHERE id=$id";
							$res_pol=$bdd->query($req_pol);
							$pol=$res_pol->fetch();
							
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$patient=$res_patient->fetch();
							$age=$patient['age'];
							echo "<p id='titre'>DONNEES DE ".$patient['prenom']." ".$patient['nom'].":</p>";
							echo "<br /><br />
							<fieldset id='affichage'>
							    <legend>Identité</legend>
							    Nom: ".$patient['nom']."<br />
							    Prénom: ".$patient['prenom']."<br />
							    Sexe: ".$patient['sex']."<br />
							    Age: ".$age." ans<br />
							    Pays de naissance: ".$patient['nativecountry']."<br />
							    Adresse: ".$patient['adresse']."<br />

							</fieldset><br />
							";

							if($pol['pol_soignant']==1){

								$req_privat="SELECT * FROM `handicap`.`privat` WHERE Idp='$id'";
								$res_privat=$bdd->query($req_privat);
								$privat=$res_privat->fetch();

								if(empty($privat['num'])){
									$num='Données non renseignées';
								}
								else $num=$privat['num'];

								if(empty($privat['caractere'])){
									$maladie='Données non renseignées';
								}
								else $maladie=$privat['caractere'];

								echo "
								<fieldset id='affichage'>
								    <legend>Données médicales</legend>
								    Num: ".$num."<br />
								    Maladie: ".$maladie."<br />
								</fieldset><br />
								";

							}

						}
					}


					?></td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	</body>
</html>
