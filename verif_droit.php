<?php

					if (!isset($_SESSION['user'])){
						echo"<form id='authentification' action='accueil.php' method='post'>
						CONNEXION</br></br>
						<div>
							<input type='text' name='email' id='email' placeholder='Adresse e-mail'>
							<input type='password' name='password' id='password' placeholder='Mot de passe'>
							<input type='submit' name='valid_authentif' value='Valider'>
						</div>
						</br>
						<a href='inscription.php'>S'incrire</a>
						</form>";
					}

					else{

						$user=unserialize($_SESSION['user']);

						if($user->getDroit()==1){
							echo "Bonjour ".$user->getPrenom()." ".$user->getNom()."\n
							<form id='deconnexion' action='accueil.php' method='post'>
							<input type='submit' name='deconnexion' value='Se déconnecter'>
							</form>"
							;
							echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
							<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
							</form>";
							echo "</br><p><a href='accueil.php?data=donnees' id='onglet'>Consulter et modifier vos données</a></p>";
							echo "</br><p><a href='politique.php' id='onglet'>Définir la politique de partage</a></p>";

						}
						else if($_SESSION['user']->getDroit()==2){
							echo "Bonjour ".$_SESSION['user']->getPrenom()." ".$_SESSION['user']->getNom()."\n
							<form id='deconnexion' action='accueil.php' method='post'>
							<input type='submit' name='deconnexion' value='Se déconnecter'>
							</form>"
							;
							echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
							<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
							</form>";
							echo "</br><p><a href='donnees.php' id='onglet'>Consulter les données d'un proche</a></p>";
						}
						else if($_SESSION['user']->getDroit()==3){
							echo "Bonjour ".$_SESSION['user']->getPrenom()." ".$_SESSION['user']->getNom()."\n
							<form id='deconnexion' action='accueil.php' method='post'>
							<input type='submit' name='deconnexion' value='Se déconnecter'>
							</form>"
							;
							echo "<form id='modif_passwd' action='modif_passwd.php' method='post'>
							<input type='submit' name='modif_passwd' value='Modifier mot de passe'>
							</form>";
							echo "</br><p><a href='donnees.php' id='onglet'>Consulter et modifier les données d'un patient</a></p>";
						}

					}


?>