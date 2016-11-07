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

		if($user->getDroit()!=0) header("Location: accueil.php");

		if(isset($_GET['valid_medecin'])){
			$req="UPDATE `handicap`.`authentification` SET `actif`='1' WHERE `id`='".$_GET['valid_medecin']."'";
			$res=$bdd->query($req);
		}
		else if(isset($_GET['refus_medecin'])){
			$id_medecin=$_GET['refus_medecin'];
			$req="DELETE FROM `handicap`.`authentification` WHERE `id`='$id_medecin'";
			$res=$bdd->query($req);
			$req="DELETE FROM `handicap`.`soignant` WHERE `id`='$id_medecin'";
			$res=$bdd->query($req);
		}

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
				<td id="corps"><table>
						<tr>
							<td><b>Nom</b></td>
							<td><b>Prenom</b></td>
							<td><b>Date de naissance</b></td>
							<td><b>Action</b></td>
						</tr>
						<?php

							$req_medecin="SELECT * FROM `handicap`.`authentification` A, `handicap`.`soignant` S WHERE A.`id`=S.`id`AND A.`actif`=0";
							$res_medecin=$bdd->query($req_medecin);
							
							while($liste_medecins=$res_medecin->fetch()){
									echo "
									<tr>
										<td>".$liste_medecins['nom']."</td>
										<td>".$liste_medecins['prenom']."</td>
										<td>".sql_to_date($liste_medecins['date_naissance'])."</td>
										<td><a href='validation.php?valid_medecin=".$liste_medecins['id']."' title='Valider'><img width=20px height=20px src='valide.png'></a> <a href='validation.php?refus_medecin=".$liste_medecins['id']."' title='Refuser'><img width=20px height=20px src='refus.png'></a></td>
									</tr>
									";
							}

						?>
					</table></td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	</body>
</html>