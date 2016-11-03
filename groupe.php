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
		$user=unserialize($_SESSION['user']);

		if(isset($_GET['valid_proche'])){
			$id=$_GET['valid_proche'];
			$id_patient=$user->getId();

			//A MODIFIER POO
			/*
			$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id_patient'";
			$res_patient=$bdd->query($req_patient);
			$infos_patient=$res_patient->fetch();*/

			$liste_demandeurs=$user->getId_demandeurs();

			$req_proche="SELECT * FROM `handicap`.`proche` WHERE id='$id'";
			$res_proche=$bdd->query($req_proche);
			$infos_proche=$res_proche->fetch();

			if(empty($infos_proche['id_proches'])){
				$new_proche=$id_patient;
			}
			else{
				$new_proche=$infos_proche['id_proches']." ".$id_patient;
			}

			$new_demandeurs=str_replace($id, "", $liste_demandeurs);

			$req_update="UPDATE `handicap`.`proche` SET `id_proches`='$new_proche' WHERE id='$id'";
			$update=$bdd->query($req_update);

			$req_update2="UPDATE `handicap`.`patient` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id_patient'";
			$update2=$bdd->query($req_update2);
			$user->setId_demandeurs($new_demandeurs);
			$_SESSION['user']=serialize($user);
		
		}

		if(isset($_GET['refus_proche'])){
			$id=$_GET['refus_proche'];
			$id_patient=$user->getId();

			/*
			$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id_patient'";
			$res_patient=$bdd->query($req_patient);
			$infos_patient=$res_patient->fetch();*/

			$liste_demandeurs=$user->getId_demandeurs();

			$new_demandeurs=str_replace($id, "", $liste_demandeurs);

			$req_update2="UPDATE `handicap`.`patient` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id_patient'";
			$update2=$bdd->query($req_update2);
			$user->setId_demandeurs($new_demandeurs);
			$_SESSION['user']=serialize($user);
		
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
					include("verif_droit.php");

				?>


				</td>
				<td id="corps">

					<p>

					<table>
						<tr>
							<td><b>Nom</b></td>
							<td><b>Prenom</b></td>
							<td><b>Date de naissance</b></td>
							<td><b>Action</b></td>
						</tr>
						<?php
							$id=$user->getId();
							/*
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$infos_patient=$res_patient->fetch();*/

							$liste_demandeurs=$user->getId_demandeurs();

							$demandeurs=explode(" ", $liste_demandeurs);

							foreach ($demandeurs as $value) {
								if(!empty($value)){
									$req_demandeurs="SELECT * FROM `handicap`.`proche` WHERE id='$value'";
									$res_demandeurs=$bdd->query($req_demandeurs);
									$infos_demandeurs=$res_demandeurs->fetch();

									echo "
									<tr>
										<td>".$infos_demandeurs['nom']."</td>
										<td>".$infos_demandeurs['prenom']."</td>
										<td>".sql_to_date($infos_demandeurs['date_naissance'])."</td>
										<td><a href='groupe.php?valid_proche=".$value."' title='Valider'><img width=20px height=20px src='valide.png'></a> <a href='groupe.php?refus_proche=".$value."' title='Refuser'><img width=20px height=20px src='refus.png'></a></td>
									</tr>
									";
								}

							}
						?>
					</table>

				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
