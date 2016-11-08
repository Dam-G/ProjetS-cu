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
		include('config_sql.php');
		

	?>

		<!-- Header -->
		<div id="header">

			<div> <?php include ('header.html'); ?>  </div>



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
										

										<?php

					if(isset($_SESSION['user'])){

						$user=unserialize($_SESSION['user']);

				        $req_id="SELECT * FROM `handicap`.`authentification` WHERE id='".$user->getId()."'";
				        $result_id=$bdd->query($req_id);
				        $data=$result_id->fetch();

						if($data['droit']==1) $table='patient';
						elseif($data['droit']==2) $table='proche';
						else $table='soignant';

				        $req_datas="SELECT * FROM `handicap`.`".$table."` WHERE id='".$data['id']."'";
				        $result_datas=$bdd->query($req_datas);
				        $data2=$result_datas->fetch();

				    }


					if((!isset($_SESSION['user'])) || ($user->getDroit()!=1)) echo "Vous n'avez pas le droit d'accéder à cette page. Veuillez revenir à l'accueil.";
					else if(isset($_POST['modif'])){
						echo "<p id='titre'>DONNEES DE ".$user->getPrenom()." ".$user->getNom()." :</p>";
						echo "</br></br>
						<form id='donnees' action='modif_donnees.php' method='post'>
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: <input type='text' name='nom' value='".$user->getNom()."' required></br>
						    Prénom: <input type='text' name='prenom' value='".$user->getPrenom()."'required></br>
						    Date de naissance: <input type='date' name='date_naiss' value='".$user->getDate_naissance()."'required></br>
						    Pays de naissance: <input type='text' name='pays_naiss' value='".$user->getPays_naissance()."'required></br>
						    Adresse: <input type='text' name='adresse' value='".$user->getAdresse()."'required></br>
						    E-Mail: <input type='text' name='email' value='".$user->getEmail()."'required></br>
						</fieldset></br>
						<input type='submit' name='valid_modif' value='VALIDER'>
						</form>";
					}
					else if(isset($_POST['valid_modif'])){

						$user->setNom($_POST['nom']);
						$user->setPrenom($_POST['prenom']);
						$user->setDate_naissance($_POST['date_naiss']);
						$user->setAdresse($_POST['adresse']);
						$user->setEmail($_POST['email']);

						$_SESSION['user']=serialize($user);

						$update="UPDATE `handicap`.`patient` SET
						`nom`='".$_POST['nom']."',
						`prenom`='".$_POST['prenom']."',
						`date_naissance`='".$_POST['date_naiss']."',
						`adresse`='".$_POST['adresse']."'
						WHERE `id`='".$user->getId()."'";
						$update2="UPDATE `handicap`.`authentification` SET
						`email`='".$_POST['email']."'
						WHERE `id`='".$user->getId()."';";
						$update_res=$bdd->query($update)
							or die("Impossible de mettre à jour : " . mysql_error());
						$update_res2=$bdd->query($update2)
							or die("Impossible de mettre à jour : " . mysql_error());
						echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
					}
					else if(isset($_POST['suppr'])){
						$req_suppr="DELETE FROM `handicap`.`donnees` WHERE `id`='".$data['id']."'";
						$suppr=$bdd->query($req_suppr)
							or die("Impossible de supprimer : " . mysql_error());
					}
					?>


										
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