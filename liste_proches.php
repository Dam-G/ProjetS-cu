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
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="homepage">

	<?php
		
		session_start();

		include("config_sql.php");
		include("function.php");
		
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
										
<div>
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



							if(isset($_GET['quitter'])){
								$user=unserialize($_SESSION['user']);
								$id=$user->getId();
								$proche=$_GET['quitter'];
								$new_proches=str_replace($proche, "", $user->getId_proches());
								$req_update="UPDATE `handicap`.`proche` SET id_proches='$new_proches' WHERE id='$id'";
								$res_update=$bdd->query($req_update);
								$user->setId_proches($new_proches);
								$_SESSION['user']=serialize($user);
							}

							$user=unserialize($_SESSION['user']);

							$liste_proches=$user->getId_proches();

							$proches=explode(" ", $liste_proches);

							foreach ($proches as $value) {
								if(!empty($value)){
									$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$value'";
									$res_patient=$bdd->query($req_patient);
									$infos_patient=$res_patient->fetch();

									echo "
									<tr>
										<td>".$infos_patient['nom']."</td>
										<td>".$infos_patient['prenom']."</td>
										<td>".sql_to_date($infos_patient['date_naissance'])."</td>
										<td><a href='donnees.php?patient=".$value."' title='Consulter les données'>Consulter les données</a> <a href='liste_proches.php?quitter=".$value."' title='Quitter le groupe'>Quitter le groupe</a></td>
									</tr>
									";
								}

							}
						?>
					</table>
</div>

										
									</header>
									<br>
									
								</section>			
							</div>
						</div>

				
			</div>

		<!-- Featured -->
	

		<!-- Footer -->

	<?php  include  ('footer.html') ?>
			



			



	</body>
</html>