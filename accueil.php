<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>

	<?php
		session_start();
		include('config_sql.php');
		include('verif_form.php');

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
				<td id="corps">
				<?php
					if (isset($_GET['data']) && ($_GET['data']=='donnees') && (isset($_SESSION['user']))){
						$user=unserialize($_SESSION['user']);
						if ($user->getDroit()==1) include('donnees.php');
						else  echo'<p>Ici, prochainement, une présentation de notre site !</p>';
					}
					else echo'<p>Ici, prochainement, une présentation de notre site !</p>';
				 ?></td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	</body>
</html>
