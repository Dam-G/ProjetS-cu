<!DOCTYPE HTML>

<html>
<head>
	<title>Handicap</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.dropotron.min.js"></script>
	<script src="js/skel.min.js"></script>
	<!--<script src="js/skel-layers.min.js"></script> -->
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

		<?php include('header.html') ?>

		<div       class="container" style="float:left; width:280px; height: 510px; border-right: 4px solid darkslategray; margin-left:0">
					<div class="row" style="padding-left:0; margin-top:20px;" >
						<div class="col-md-4 col-md-offset-4">
				<br>
				<br>
				<br>
				<br>
				<br>
				<?php

				include("verif_droit.php");
				?>

				

							</div>
						</div>
					</div>

		</div>


		<div style="margin-left:150px; width:90px" id="banner">
			<div class="container" style="margin-left:270px;width:500px">
				<section>
					<header class="major">
						<h2>Inscription</h2>

						<form id="inscription" action="accueil.php" method="post">
					INSCRIPTION<br /><br />
					<input type="text" name="nom" id="nom" placeholder="Entrez votre nom" size="50px" required><br /><br />
					<input type="text" name="prenom" id="prenom" placeholder="Entrez votre prenom" size="50px" required><br /><br />
					<label for="sexe">Sexe : </label>
					<select name="sexe" id="sexe">
			            <option value="Female">Féminin</option>
			            <option value="Male">Masculin</option>
			        </select><br /><br />
					Entrez votre date de naissance : <input type="date" name="date_naissance" id="date_naissance" size="50px" required><br /><p>Format de la date: jj/mm/aaaa</p>
					<label for="pays_naiss">Pays de naissance : </label>
					<select name="pays_naiss" id="pays_naiss">
			            <?php
			            	include("pays.php");
			            	foreach ($countryCode as $value) {
			            		echo "<option value=$value[3]>$value[3]</option>";
			            	}
			            ?>
			        </select><br /><br />
					<input type="text" name="adresse" id="adresse" placeholder="Entrez votre adresse" size="50px" required><br /><br />
					<input type="text" name="email" id="email" placeholder="Entrez votre adresse e-mail" size="50px" required><br /><br />
					<label for="type_user">Choisissez le type d'utilisateur</label><br /><br />
			        <select name="type_user" id="type_user">
			            <option value="1">Patient</option>
			            <option value="2">Proche de patient</option>
			            <option value="3">Personnel soignant</option>
			        </select><br /><br />
					<input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" size="50px" required><br /><br />
					<input type="password" name="verif_passwd" id="verif_passwd" placeholder="Entrez à nouveau le mot de passe" size="50px" required><br /><br />
					<label for="captcha">Recopiez le mot : <img src="captcha.php" alt="Captcha" /></label><br /><br />
					<input type="text" name="captcha" id="captcha"  required><br /><br />
					<input type="submit" name="valid_inscript" value="Valider">
				</form>





					</header>
					<br>

				</section>
			</div>
		</div>






<!-- Footer -->
<?php include ('footer.html') ?>
</div>






</body>
</html>