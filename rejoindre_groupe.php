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
										

										<form id="rejoindre" action="accueil.php" method="post">
					REJOINDRE UN GROUPE<br /><br />
					<label for="numero">Entrez le numero du groupe que vous souhaitez rejoindre : </label>
					<input type="text" name="numero" id="numero" required><br /><br />
					<input type="submit" name="rejoindre_groupe" value="Valider">
				</form>


										
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