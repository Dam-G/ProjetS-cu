<?php

include("function.php");
		$user=unserialize($_SESSION['user']);

/*        $req_id="SELECT * FROM `handicap`.`authentification` WHERE id='".$user->getId."'";
        $result_id=$bdd->query($req_id);
        $data=$result_id->fetch();

        $req_datas="SELECT * FROM `handicap`.`` WHERE id='".$data['id']."'";
        $result_datas=$bdd->query($req_datas);
        $data2=$result_datas->fetch();*/

        $date_naissance=sql_to_date($user->getDate_naissance());

					if($user->getDroit()!=1) echo "Vous n'avez pas le droit d'accéder à cette page. Veuillez revenir à l'accueil.";
					else{
						echo "<p id='titre'>DONNEES :</p>";
						echo "<br /><br />
						<fieldset id='affichage'>
						    <legend>Identité</legend>
						    Nom: ".$user->getNom()."<br />
						    Prénom: ".$user->getPrenom()."<br />
						    Sexe: ".$user->getSexe()."<br />
						    Date de naissance: ".$date_naissance."<br />
						    Adresse: ".$user->getAdresse()."<br />
						    E-mail: ".$user->getEmail()."<br />

						</fieldset><br />
						";
						echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
						</form>";
					}
					?>