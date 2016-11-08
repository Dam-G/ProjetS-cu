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
		include('verif_form.php');

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




						<div style="margin-left:150px" id="banner">
							<div class="container">
								<section>
									<header class="major">
										

										<?php
				if (isset($_GET['data']) && (isset($_SESSION['user']))){
						echo'<h2>Bienvenue !</h2>
					<span class="byline">Handicap est une application WEB destinée aux personnes handicapées, leurs familles et leurs medecins pour une meilleure communication et un suivi optimal!</span>';
					}

					
				
				else echo'<h2>Bienvenue !</h2>
					<span class="byline">Handicap est une application WEB destinée aux personnes handicapées, leurs familles et leurs medecins pour une meilleure communication et un suivi optimal!</span>
				<br>
				';
				?>


										
									</header>
									<br>
									
								</section>			
							</div>
						</div>

				
			</div>

		<!-- Featured -->
	<div id="services">
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<h2>Nos services</h2>
						
					</header>
					<div class="row no-collapse-1">
						<section class="4u">
							<a href="statisqtiques.php" class="image feature"><img src="images/pic02.jpg" alt=""></a>
							<p>Statistiques</p>
						</section>
						<section class="4u">
							<img src="images/pic03.jpg" alt="">
							<p>Ajouter/modifier les informations du patient</p>
						</section>
						<section class="4u">
							<img src="images/pic04.jpg" alt="">
							<p>Consulter les informations du patient</p>
						</section>
	
					</div>
				</section>
			</div>
	</div>

		<!-- Footer -->

	<?php  include  ('footer.html') ?>
			



			



	</body>
</html>