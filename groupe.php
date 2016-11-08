<!DOCTYPE HTML>
<!--
	Horizons by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Handicap</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
		
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			
		</noscript>

		<link rel="stylesheet" href="tab.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="homepage">

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

		<!-- Header -->
		<div id="header">

			<?php include ('header.html');?>



				<div       class="container" style="float:left; width:280px; height: 510px; border-right: 4px solid darkslategray; margin-left:0">
					<div class="row" style="padding-left:0; margin-top:20px;" >
						<div class="col-md-4 col-md-offset-4">
				<?php
				include("verif_droit.php");
				?>

				

							</div>
						</div>
					</div>




						<div style="margin-left:150px; width:90px" id="banner">
			<div class="container" style="margin-left:270px;width:500px">
								<section>
									<header class="major">
										
<div style='background: #555555'>
<div >
<fieldset>
										
<legend>Liste des membres</legend>
					<table>
						<tr>
							<th><b>Nom</b></th>
							<th><b>Prenom</b></th>
							<th><b>Date de naissance</b></th>
							<th><b>Action</b></th>
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
					</fieldset>

</div>

<div>
<fieldset>
						<legend>Liste des membres</legend>

					<table>
						<tr>
							<th><b>Nom</b></td>
							<th><b>Prenom</b></th>
							<th><b>Date de naissance</b></th>
							<th><b>Action</b></th>
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
										<td>".sql_to_date($infos_membres['date_naissance'])."</td>
										<td><a href='groupe.php?supprime_proche=".$value."' title='Supprimer'>Supprimer du groupe</a></td>
									</tr>
									";
								}
							}
						?>
					</table>
					</fieldset>
					</div>

										
									</header>
									<br>
									
								</section>			
							</div>
						</div>

				
			</div>
			</div>

		<!-- Featured -->
	

		<!-- Footer -->

	<?php  include  ('footer.html') ?>
			



			



	</body>
</html>