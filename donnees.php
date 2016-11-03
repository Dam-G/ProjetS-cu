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
		$user=unserialize($_SESSION['user']);

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



					if($user->getDroit()==1){
				        $date_naissance=sql_to_date($user->getDate_naissance());
						echo "<p id='titre'>DONNEES :</p>";
						echo "<br /><br />
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: ".$user->getNom()."<br />
						    Prénom: ".$user->getPrenom()."<br />
						    Sexe: ".$user->getSexe()."<br />
						    Date de naissance: ".$date_naissance."<br />
						    Pays de naissance: ".$user->getPays_naissance()."<br />
						    Adresse: ".$user->getAdresse()."<br />
						    E-mail: ".$user->getEmail()."<br />

						</fieldset><br />
						";
						echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
						</form>";
					}

					else if(($user->getDroit()==2) && (isset($_GET['patient']))){

						$id=$_GET['patient'];
						$id_proche=$user->getId();

						//A MODIFIER POO
						/*
						$req_verif="SELECT * FROM `handicap`.`proche` WHERE id='$id_proche'";
						$res_verif=$bdd->query($req_verif);
						$verif=$res_verif->fetch();*/

						$verif=$user->getId_proches();

						$proches=explode(" ", $verif);

						if(!in_array($id, $proches)) echo "Vous ne pouvez pas accéder à cette page, veuillez retourner à l'accueil !";
						else{
							
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$patient=$res_patient->fetch();
							$date_naissance=sql_to_date($patient['date_naissance']);
							echo "<p id='titre'>DONNEES DE ".$patient['prenom']." ".$patient['nom'].":</p>";
							echo "<br /><br />
							<fieldset id='affichage'>
							    <legend>Identité</legend>
							    Nom: ".$patient['nom']."<br />
							    Prénom: ".$patient['prenom']."<br />
							    Sexe: ".$patient['sex']."<br />
							    Date de naissance: ".$date_naissance."<br />
							    Pays de naissance: ".$patient['nativecountry']."<br />
							    Adresse: ".$patient['adresse']."<br />

							</fieldset><br />
							";

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
