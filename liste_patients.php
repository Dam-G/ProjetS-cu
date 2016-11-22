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

		if (isset($_SESSION['user'])){
			$user=unserialize($_SESSION['user']);
		}
		else header("Location: accueil.php");

		if($user->getDroit()!=3) header("Location: accueil.php");

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
					include("verif_form.php");

				?>


				</td>
				<td id="corps">

					<p>

					<fieldset>
					<legend>Liste des patients</legend>

					<table>
						<tr>
							<td><b>Nom</b></td>
							<td><b>Prenom</b></td>
							<td><b>Age</b></td>
							<td><b>Action</b></td>
						</tr>
						<?php

							if(isset($_GET['suppr'])){
								$user=unserialize($_SESSION['user']);
								$id_patient=$_GET['suppr'];
								$liste_patients=$user->getId_patients();
								$id_medecin=$user->getId();

								$liste_patients2=explode(" ", $liste_patients);

								if(in_array($id_patient, $liste_patients2)){
									$new_liste=str_replace($id_patient, "", $liste_patients);
									$user->setId_patients($new_liste);
									$req="UPDATE `handicap`.`soignant` SET liste_patient='$new_liste' WHERE id='$id_medecin'";
									$res_requete=$bdd->query($req);
									$_SESSION['user']=serialize($user);
								}

							}

							$user=unserialize($_SESSION['user']);

							$liste_patients=$user->getId_patients();

							$patients=explode(" ", $liste_patients);


							foreach ($patients as $value) {
								if(!empty($value)){
									$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$value'";
									$res_patient=$bdd->query($req_patient);
									$infos_patient=$res_patient->fetch();

									echo "
									<tr>
										<td>".$infos_patient['nom']."</td>
										<td>".$infos_patient['prenom']."</td>
										<td>".$infos_patient['age']." ans</td>
										<td><a href='donnees.php?patient=".$value."' title='Consulter les données'>Consulter les données</a>
										<a href='liste_patients.php?suppr=".$value."'>Supprimer ce patient</a></td>
									</tr>
									";
								}

							}
						?>
					</table>
					</fieldset>

					<fieldset>
					<legend>Liste des patients avec tuteurs</legend>

					<table>
						<tr>
							<td><b>Patient</b></td>
							<td><b>Demandeurs</b></td>
							<td><b>Action</b></td>
							<td><b>Tuteur</b></td>
							<td><b>Action</b></td>
						</tr>
						<?php

							if((isset($_GET['valider_tuteur'])) && (isset($_GET['patient_tuteur']))){
								$id_tuteur=$_GET['valider_tuteur'];
								$id_patient=$_GET['patient_tuteur'];
								$id_medecin=$user->getId();
								$patients=$user->getId_patients();
								$liste_patients=explode(" ", $patients);

								$req_demandeurs="SELECT * FROM `handicap`.`tuteurs` WHERE id=$id_patient";
								$res_demandeurs=$bdd->query($req_demandeurs);
								$demandeurs=$res_demandeurs->fetch();
								$liste_demandeurs=$demandeurs['id_demandeurs'];

								if((in_array($id_tuteur, explode(' ', $liste_demandeurs))) && (in_array($id_patient, $liste_patients))){

									$req_proche="UPDATE `handicap`.`proche` SET `tuteur` = $id_patient WHERE id='$id_tuteur'";
									$res_proche=$bdd->query($req_proche);

									$new_demandeurs=str_replace($id_tuteur, "", $liste_demandeurs);
/*
									$req_groupe="SELECT * FROM `handicap`.`tuteurs` WHERE id='$id_patient'";
									$res_groupe=$bdd->query($req_groupe);
									$groupe=$res_groupe->fetch();

									if(empty($groupe['id_tuteur'])){
										$new_membres=$id;
									}
									else{
										$new_membres=$groupe['id_membres']." ".$id;
									}*/

									$req_update2="UPDATE `handicap`.`tuteurs` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id_patient'";
									$update2=$bdd->query($req_update2);
									$req_update3="UPDATE `handicap`.`tuteurs` SET `id_tuteur`=$id_tuteur WHERE id='$id_patient'";
									$res_update3=$bdd->query($req_update3);

								}

							}

							if((isset($_GET['refuser_tuteur'])) && (isset($_GET['patient_tuteur']))){
								$user=unserialize($_SESSION['user']);
								$id_patient=$_GET['patient_tuteur'];
								$id_demandeur=$_GET['refuser_tuteur'];
								$liste_patients=$user->getId_patients();
								$id_medecin=$user->getId();

								$liste_patients2=explode(" ", $liste_patients);

								$req_demandeurs="SELECT * FROM `handicap`.`tuteurs` WHERE id=$id_patient";
								$res_demandeurs=$bdd->query($req_demandeurs);
								$demandeurs=$res_demandeurs->fetch();
								$liste_demandeurs=$demandeurs['id_demandeurs'];

								if(in_array($id_patient, $liste_patients2)){
									$new_liste=str_replace($id_demandeur, "", $liste_demandeurs);
									$req="UPDATE `handicap`.`tuteurs` SET id_demandeurs='$new_liste' WHERE id='$id_patient'";
									$res_requete=$bdd->query($req);
								}

							}

							if((isset($_GET['suppr_tuteur'])) && (isset($_GET['patient_tuteur']))){
								$user=unserialize($_SESSION['user']);
								$id_patient=$_GET['patient_tuteur'];
								$id_tuteur=$_GET['suppr_tuteur'];
								$liste_patients=$user->getId_patients();
								$id_medecin=$user->getId();

								$liste_patients2=explode(" ", $liste_patients);

								$req_verif="SELECT * FROM `handicap`.`tuteurs` WHERE id=$id_patient";
								$res_verif=$bdd->query($req_verif);
								$verif=$res_verif->fetch();

								if((in_array($id_patient, $liste_patients2)) && ($verif['id_tuteur'] == $id_tuteur)){

									$req="UPDATE `handicap`.`proche` SET tuteur=0 WHERE id='$id_tuteur'";
									$res_requete=$bdd->query($req);

									$req2="UPDATE `handicap`.`tuteurs` SET id_tuteur=NULL WHERE id='$id_patient'";
									$res_requete2=$bdd->query($req2);

								}

							}

							$user=unserialize($_SESSION['user']);

							$liste_patients=$user->getId_patients();

							$patients=explode(" ", $liste_patients);

							$i=0;
							$patients_tuteurs;

							foreach ($patients as $value) {
								$req_tuteur="SELECT * FROM `handicap`.`tuteurs` WHERE id='$value'";
								$res_tuteur=$bdd->query($req_tuteur);
								if(!empty($res_tuteur)){
									$patient_tuteurs[$i]=$res_tuteur->fetch();
									$i++;
								}

							}

							foreach ($patient_tuteurs as $value) {
								if(!empty($value)){
									$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='".$value['id']."'";
									$res_patient=$bdd->query($req_patient);
									$infos_patient=$res_patient->fetch();

									if(empty($value['id_tuteur'])){
										$liste_demandeurs=explode(" ", $value['id_demandeurs']);

										foreach ($liste_demandeurs as $demandeur) {
											if(!empty($demandeur)){
												$req_info_demandeur="SELECT * FROM `handicap`.`proche` WHERE id='".$demandeur."'";
												$res_info_demandeur=$bdd->query($req_info_demandeur);
												$info_demandeur=$res_info_demandeur->fetch();
												echo "
												<tr>
													<td>".$infos_patient['prenom']." ".$infos_patient['nom']."</td>
													<td>".$info_demandeur['prenom']." ".$info_demandeur['nom']."</td>
													<td><a href='liste_patients.php?valider_tuteur=".$demandeur."&patient_tuteur=".$value['id']."' title='Valider ce tuteur'><img width=20px height=20px src='valide.png'></a>
													<a href='liste_patients.php?refuser_tuteur=".$demandeur."&patient_tuteur=".$value['id']."' title='Refuser ce tuteur'><img width=20px height=20px src='refus.png'></a></td>
												</tr>
												";
											}
										}	
									}

									else {
										$tuteur=$value['id_tuteur'];
										$req_info_tuteur="SELECT * FROM `handicap`.`proche` WHERE id='".$tuteur."'";
										$res_info_tuteur=$bdd->query($req_info_tuteur);
										$info_tuteur=$res_info_tuteur->fetch();

										echo "
										<tr>
											<td>".$infos_patient['prenom']." ".$infos_patient['nom']."</td>
											<td></td>
											<td></td>
											<td>".$info_tuteur['prenom']." ".$info_tuteur['nom']."</td>
											<td><a href='liste_patients.php?suppr_tuteur=".$tuteur."&patient_tuteur=".$value['id']."'>Supprimer ce tuteur</a></td>
										</tr>
										";

									}

									
								}

							}
						?>
					</table>
					</fieldset>

					<br /><br />
					<form id="ajout" action="liste_patients.php" method="post">
					<label for="numero">Entrez l'email du patient que vous souhaitez ajouter:</label>
					<input type="text" name="email" id="email" required><br /><br />
					<input type="submit" name="ajout_patient" value="Valider">
				</form>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
