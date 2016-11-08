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
		include("config_sql.php");
		include("function.php");
		session_start();
		$user=unserialize($_SESSION['user']);

	?>

		<!-- Header -->
		<div id="header">

			<?php include ('header.html')?>



				<div       class="container" style="float:left; width:280px; height: 510px; border-right: 4px solid darkslategray; margin-left:0">
					<div class="row" style="padding-left:0; margin-top:20px;" >
						<div class="col-md-4 col-md-offset-4">
				<?php
				include("verif_droit.php");
				?>

				

							</div>
						</div>
					</div>




						<div style="margin-left:150px" id="banner">
							<div class="container">
								<section>
									<header class="major">
										
<?php
				include("verif_droit.php");
				?>
				</td>
				<td id="corps">
				<?php

/*        $req_id="SELECT * FROM `handicap`.`authentification` WHERE id='".$user->getId."'";
        $result_id=$bdd->query($req_id);
        $data=$result_id->fetch();

        $req_datas="SELECT * FROM `handicap`.`` WHERE id='".$data['id']."'";
        $result_datas=$bdd->query($req_datas);
        $data2=$result_datas->fetch();*/



					if($user->getDroit()==1){
				        $date_naissance=sql_to_date($user->getDate_naissance());
						echo "<p id='titre'>DONNEES :</p>";
						echo "<br /><br />
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: ".$user->getNom()."<br />
						    Prénom: ".$user->getPrenom()."<br />
						    Sexe: ".$user->getSexe()."<br />
						    Date de naissance: ".$date_naissance."<br />
						    Pays de naissance: ".$user->getPays_naissance()."<br />
						    Adresse: ".$user->getAdresse()."<br />
						    E-mail: ".$user->getEmail()."<br />

						</fieldset><br />
						";
						echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
						</form>";
					}

					else if(($user->getDroit()==2) && (isset($_GET['patient']))){

						$id=$_GET['patient'];
						$id_proche=$user->getId();

						//A MODIFIER POO
						/*
						$req_verif="SELECT * FROM `handicap`.`proche` WHERE id='$id_proche'";
						$res_verif=$bdd->query($req_verif);
						$verif=$res_verif->fetch();*/

						$verif=$user->getId_proches();

						$proches=explode(" ", $verif);

						if(!in_array($id, $proches)) echo "Vous ne pouvez pas accéder à cette page, veuillez retourner à l'accueil !";
						else{
							
							$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
							$res_patient=$bdd->query($req_patient);
							$patient=$res_patient->fetch();
							$date_naissance=sql_to_date($patient['date_naissance']);
							echo "<p id='titre'>DONNEES DE ".$patient['prenom']." ".$patient['nom'].":</p>";
							echo "<br /><br />
							<fieldset id='affichage'>
							    <legend>Identité</legend>
							    Nom: ".$patient['nom']."<br />
							    Prénom: ".$patient['prenom']."<br />
							    Sexe: ".$patient['sex']."<br />
							    Date de naissance: ".$date_naissance."<br />
							    Pays de naissance: ".$patient['nativecountry']."<br />
							    Adresse: ".$patient['adresse']."<br />

							</fieldset><br />
							";

						}

					}


					?>
										
				


										
									</header>
									<br>
									
								</section>			
							</div>
						</div>
</div>
				</div>
			</div>

		<!-- Featured -->
	

		<!-- Footer -->

	<?php  include  ('footer.html')?>
			



			


</div>

	</body>
</html>