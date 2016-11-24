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

		if (isset($_SESSION['user'])){
			$user=unserialize($_SESSION['user']);
		}
		else header("Location: accueil.php");

		if($user->getDroit()!=1) header("Location: accueil.php");

		if(isset($_GET['valid_proche'])){
			$id=$_GET['valid_proche'];
			$id_patient=$user->getId();

			$liste_demandeurs=$user->getId_demandeurs();

			if(in_array($id, explode(' ', $liste_demandeurs))){

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

				$req_groupe="SELECT * FROM `handicap`.`groupes` WHERE id='$id_patient'";
				$res_groupe=$bdd->query($req_groupe);
				$groupe=$res_groupe->fetch();

				if(empty($groupe['id_membres'])){
					$new_membres=$id;
				}
				else{
					$new_membres=$groupe['id_membres']." ".$id;
				}

				$req_update="UPDATE `handicap`.`proche` SET `id_proches`='$new_proche' WHERE id='$id'";
				$update=$bdd->query($req_update);

				$req_update2="UPDATE `handicap`.`groupes` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id_patient'";
				$update2=$bdd->query($req_update2);
				$req_update3="UPDATE `handicap`.`groupes` SET `id_membres`='$new_membres' WHERE id='$id_patient'";
				$res_update3=$bdd->query($req_update3);
				$user->setId_demandeurs($new_demandeurs);
				$_SESSION['user']=serialize($user);
			}
		
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

			$req_update2="UPDATE `handicap`.`groupes` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id_patient'";
			$update2=$bdd->query($req_update2);
			$user->setId_demandeurs($new_demandeurs);
			$_SESSION['user']=serialize($user);
		
		}

		if(isset($_GET['supprime_proche'])){
			$id=$_GET['supprime_proche'];
			$id_patient=$user->getId();

			
			$req_groupe="SELECT * FROM `handicap`.`groupes` WHERE id='$id_patient'";
			$res_groupe=$bdd->query($req_groupe);
			$groupe=$res_groupe->fetch();

			$req_membre="SELECT * FROM `handicap`.`proche` WHERE id='$id'";
			$res_membre=$bdd->query($req_membre);
			$membre=$res_membre->fetch();

			$liste_membres=$groupe['id_membres'];
			$liste_proches=$membre['id_proches'];

			if(in_array($id, explode(' ', $liste_membres))){

				$new_membres=str_replace($id, "", $liste_membres);
				$new_proches=str_replace($id_patient, "", $liste_proches);

				$req_update2="UPDATE `handicap`.`groupes` SET `id_membres`='$new_membres' WHERE id='$id_patient'";
				$update2=$bdd->query($req_update2);

				$req_update3="UPDATE `handicap`.`proche` SET `id_proches`='$new_proches' WHERE id='$id'";
				$update3=$bdd->query($req_update3);
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
					include("verif_droit.php");

				?>


				</td>
				<td id="corps">

					<p>

					<fieldset>
						<legend>Liste des demandeurs</legend>

					<table>
						<tr>
							<td><b>Nom</b></td>
							<td><b>Prenom</b></td>
							<td><b>Age</b></td>
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
										<td>".$infos_demandeurs['age']." ans</td>
										<td><a href='groupe.php?valid_proche=".$value."' title='Valider'><img width=20px height=20px src='valide.png'></a> <a href='groupe.php?refus_proche=".$value."' title='Refuser'><img width=20px height=20px src='refus.png'></a></td>
									</tr>
									";
								}

							}
						?>
					</table>
					</fieldset>

					<fieldset>
						<legend>Liste des membres</legend>

					<table>
						<tr>
							<td><b>Nom</b></td>
							<td><b>Prenom</b></td>
							<td><b>Age</b></td>
							<td><b>Action</b></td>
						</tr>
						<?php
							$id=$user->getId();
							
							$req_groupe="SELECT * FROM `handicap`.`groupes` WHERE id='$id'";
							$res_groupe=$bdd->query($req_groupe);
							$groupe=$res_groupe->fetch();

							$liste_membres=$groupe['id_membres'];

							$membres=explode(" ", $liste_membres);

							foreach ($membres as $value) {
								if(!empty($value)){
									$req_membres="SELECT * FROM `handicap`.`proche` WHERE id='$value'";
									$res_membres=$bdd->query($req_membres);
									$infos_membres=$res_membres->fetch();

									echo "
									<tr>
										<td>".$infos_membres['nom']."</td>
										<td>".$infos_membres['prenom']."</td>
										<td>".$infos_membres['age']." ans</td>
										<td><a href='groupe.php?supprime_proche=".$value."' title='Supprimer'>Supprimer du groupe</a></td>
									</tr>
									";
								}

							}
						?>
					</table>
					</fieldset>

				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
