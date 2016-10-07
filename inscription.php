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
					<form id="authentification" action="accueil.php" method="post">
					CONNEXION</br></br>
					<div>
						<input type="text" name="identifiant" id="identifiant" placeholder="Identifiant" required>
						<input type="password" name="password" id="password" placeholder="Mot de passe" required>
						<input type="submit" id="valid_authentif" value="Valider">
					</div>
					</br>
					<a href="inscription.php">S'incrire</a>
					</form>


				</td>
				<td id="corps">
				<form id="inscription" action="accueil.php" method="post">
					INSCRIPTION</br></br>
					<input type="text" name="pseudo" id="pseudo" placeholder="Choisissez un pseudo" size="50px" required></br></br>
					<label for="type_user">Choisissez le type d'utilisateur</label><br />
			        <select name="type_user" id="type_user">
			            <option value="1">Patient</option>
			            <option value="2">Proche de patient</option>
			            <option value="3">Personnel soignant</option>
			        </select></br></br>
					<input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" size="50px" required></br></br>
					<input type="password" name="verif_passwd" id="verif_passwd" placeholder="Entrez à nouveau le mot de passe" size="50px" required></br></br>
					<input type="submit" id="valid_inscript" value="Valider">
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
