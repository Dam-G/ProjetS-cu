<!DOCTYPE html>
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
				<link rel="stylesheet" href="css/style2.css" />
			</noscript>
			<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
		</head>

	
	<body>

    <?php
    session_start();
    include("config_sql.php");

    ?>

    <!-- Header -->
    <div>

        <div id="header">
            <div class="container" style="width: 600px ;height:30px >

                <!-- Logo -->
                <h1><a href="#" id="logo">Handicap</a></h1>

                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li><a href="accueil.php">Home</a></li>

                    </ul>
                </nav>


                <!-- Banner -->

            </div>
            </div>
        </div>

    <div >

        <div       class="container" style="float:left; width:280px; height: 510px; border-right: 4px solid darkslategray; margin-left:0">
            <div class="row" style="padding-left:0; margin-top:20px;" >
                <div class="col-md-4 col-md-offset-4">
                    <?php
                    include("verif_droit.php");
                    ?>
                    </div>
                </div>
            </div>
                    <?php
                    if((!isset($_SESSION['user'])) || ($user->getDroit()!=1)){
                        echo "Vous n'avez pas le droit  d'accéder à cette page, veuillez revenir à l'accueil.";
                    }
                    else {
                        echo "<form id='inscription' action='accueil.php' method='post'>
					CHANGEMENT DE MOT DE PASSE</br></br>
					<input type='password' name='password' id='password' placeholder='Entrez votre mot de passe' size='50px' required></br></br>
					<input type='password' name='new_passwd' id='new_passwd' placeholder='Entrez votre nouveau mot de passe' size='50px' required></br></br>
					<input type='password' name='confirm_passwd' id='confirm_passwd' placeholder='Entrez à nouveau le mot de passe' size='50px' required></br></br>
					<input type='submit' name='modif_passwd' value='Valider'>
				</form>";
                    }
                    ?>


    </div>
	</body>
</html>
