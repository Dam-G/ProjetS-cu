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
