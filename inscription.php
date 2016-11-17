<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Page de test</title>
		<link rel="stylesheet" href="truc.css" />
	</head>
	
	<body>

	<?php

	?>
	   <div id="conteneur">
		<table width="100%">			
			<tr>
				<td colspan="2" height="200px" id="entete" ><a href="accueil.php">ACCUEIL</a> - <a href="statistiques.php">STATISTIQUES PUBLIQUES</a></td>
			</tr>
			<tr >
				<td height="800px" width="15%" id="banniere">
					<?php include("verif_droit.php"); ?>


				</td>
				<td id="corps">
				<form id="inscription" action="accueil.php" method="post">
					INSCRIPTION<br /><br />
					<input type="text" name="nom" id="nom" placeholder="Entrez votre nom" size="50px" required><br /><br />
					<input type="text" name="prenom" id="prenom" placeholder="Entrez votre prenom" size="50px" required><br /><br />
					<label for="sexe">Sexe : </label>
					<select name="sexe" id="sexe">
			            <option value="Female">Féminin</option>
			            <option value="Male">Masculin</option>
			        </select><br /><br />
					<label for="age">Age : </label>
					<select name="age" id="age" required>
			            <?php
			            	for ($i=15; $i < 120; $i++) { 
			            		echo "<option value=$i>$i ans</option>";
			            	}
			            		
			            ?>
			        </select><br /><br />
					<label for="pays_naiss">Pays de naissance : </label>
					<select name="pays_naiss" id="pays_naiss" required>
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
			        <select name="type_user" id="type_user" required>
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


				</td>
			</tr>
			<tr>
				<td colspan="2" height="200px" id="truc4" >Footer</td>
			</tr>
		</table>
	   </div>
	</body>
</html>
