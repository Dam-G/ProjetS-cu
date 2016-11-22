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

		include("config_sql.php");

		if (isset($_SESSION['user'])){
			$user=unserialize($_SESSION['user']);
		}
		else header("Location: accueil.php");

		if(($user->getDroit()!=1) && ($user->getDroit()!=2)) header("Location: accueil.php");
		if(($user->getDroit()==2) && (empty($user->getTuteur()))) header("Location: accueil.php");


	?>
	   <div id="conteneur">
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
					

						<p id='titre'>POLITIQUE DE PARTAGE :</p>
						</br></br>
						<table>
						<tr><td><b>Données</b></td><td><b>Politique de groupe</b></td><td><b>Politique de soignant</b></td></tr>

						<?php

						if($user->getDroit()==1){


							if(isset($_POST['valid_polit'])){

								$pol_groupe=htmlspecialchars($_POST['handicap_proche']);
								$pol_soignant=htmlspecialchars($_POST['handicap_soignant']);

								$req_pol="UPDATE `handicap`.`politique` SET `pol_groupe`=$pol_groupe, `pol_soignant`=$pol_soignant WHERE id='".$user->getId()."'";
								$res_pol=$bdd->query($req_pol);


								echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
							
							}


							echo "<form id='donnees' action='politique.php' method='post'>";

							$req1="SELECT * FROM `handicap`.`politique` WHERE id='".$user->getId()."'";
							$res1=$bdd->query($req1);
							$politique=$res1->fetch();

							//Pré-sélection du bouton radio de politique de groupe
							if($politique['pol_groupe']==0){
								$groupe_vis="";
								$groupe_non_vis='checked';
							}
							else{
								$groupe_vis='checked';
								$groupe_non_vis="";
							}

							//Pré-sélection du bouton radio de politique de soignant
							if($politique['pol_soignant']==0){
								$soignant_vis="";
								$soignant_non_vis='checked';
							}
							else{
								$soignant_vis='checked';
								$soignant_non_vis="";
							}

							
							echo "<tr><td> Données sensibles </td><td>
							Non visible <input type='radio' name='handicap_proche' value='0' id='handicap_proche' $groupe_non_vis/>
							Visible <input type='radio' name='handicap_proche' value='1' id='handicap_proche' $groupe_vis /></td>
							<td>Non visible <input type='radio' name='handicap_soignant' value='0' id='handicap_proche' $soignant_non_vis />
							Visible <input type='radio' name='handicap_soignant' value='1' id='handicap_proche' $soignant_vis /></td></tr>";
						}

						else if($user->getDroit()==2){


							if(isset($_POST['valid_polit'])){

								$pol_groupe=htmlspecialchars($_POST['handicap_proche']);
								$pol_soignant=htmlspecialchars($_POST['handicap_soignant']);

								$req_pol="UPDATE `handicap`.`politique` SET `pol_groupe`=$pol_groupe, `pol_soignant`=$pol_soignant WHERE id='".$user->getTuteur()."'";
								$res_pol=$bdd->query($req_pol);


								echo "<img width=20px height=20px src='valide.png'>  Données enregistrées";
							
							}


							echo "<form id='donnees' action='politique.php' method='post'>";

							$req1="SELECT * FROM `handicap`.`politique` WHERE id='".$user->getTuteur()."'";
							$res1=$bdd->query($req1);
							$politique=$res1->fetch();

							//Pré-sélection du bouton radio de politique de groupe
							if($politique['pol_groupe']==0){
								$groupe_vis="";
								$groupe_non_vis='checked';
							}
							else{
								$groupe_vis='checked';
								$groupe_non_vis="";
							}

							//Pré-sélection du bouton radio de politique de soignant
							if($politique['pol_soignant']==0){
								$soignant_vis="";
								$soignant_non_vis='checked';
							}
							else{
								$soignant_vis='checked';
								$soignant_non_vis="";
							}

							
							echo "<tr><td> Données sensibles </td><td>
							Non visible <input type='radio' name='handicap_proche' value='0' id='handicap_proche' $groupe_non_vis/>
							Visible <input type='radio' name='handicap_proche' value='1' id='handicap_proche' $groupe_vis /></td>
							<td>Non visible <input type='radio' name='handicap_soignant' value='0' id='handicap_proche' $soignant_non_vis />
							Visible <input type='radio' name='handicap_soignant' value='1' id='handicap_proche' $soignant_vis /></td></tr>";
						}

						?>

						</table>

					
						<input type='submit' name='valid_polit' value='VALIDER'>
						</form>

					<?php


					
					?>

				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
