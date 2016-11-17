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
							//A MODIFIER POO
						/*
							$id=$user->getId();
							$req_proche="SELECT * FROM `handicap`.`proche` WHERE id='$id'";
							$res_proche=$bdd->query($req_proche);
							$proche=$res_proche->fetch();
							$liste_proches=$proche['id_proches'];*/



							/*if(isset($_GET['quitter'])){
								$user=unserialize($_SESSION['user']);
								$id=$user->getId();
								$proche=$_GET['quitter'];
								$new_proches=str_replace($proche, "", $user->getId_proches());
								$req_update="UPDATE `handicap`.`proche` SET id_proches='$new_proches' WHERE id='$id'";
								$res_update=$bdd->query($req_update);
								$user->setId_proches($new_proches);
								$_SESSION['user']=serialize($user);
							}*/

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
										<td>".sql_to_date($infos_patient['date_naissance'])."</td>
										<td><a href='donnees.php?patient=".$value."' title='Consulter les données'>Consulter les données</a></td>
									</tr>
									";
								}

							}
						?>
					</table>

					<br /><br />
					<form id="ajout" action="accueil.php" method="post">
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
