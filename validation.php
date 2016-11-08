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
							<th><b>Nom</b></th>
							<th><b>Prenom</b></th>
							<th><b>Date de naissance</b></th>
							<th><b>Action</b></th>
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