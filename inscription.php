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
			            <option value="F">Féminin</option>
			            <option value="H">Masculin</option>
			        </select><br /><br />
					Entrez votre date de naissance : <input type="date" name="date_naissance" id="date_naissance" size="50px" required><br /><p>Format de la date: jj/mm/aaaa</p>
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
