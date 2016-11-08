<?php

$user=unserialize($_SESSION['user']);

/*        $req_id="SELECT * FROM `handicap`.`authentification` WHERE id='".$user->getId."'";
        $result_id=$bdd->query($req_id);
        $data=$result_id->fetch();

        $req_datas="SELECT * FROM `handicap`.`` WHERE id='".$data['id']."'";
        $result_datas=$bdd->query($req_datas);
        $data2=$result_datas->fetch();*/

if($user->getDroit()!=1) echo "Vous n'avez pas le droit d'accéder à cette page. Veuillez revenir à l'accueil.";
else{
    echo " <div style='background: #555555'>
   <h2 id='titre'> Données :</h2>";
    echo "<br />
						<fieldset id='affichage' >
						    <h2 >Identité </h2>
						    <h3>
						    <br/>
						    Nom: ".$user->getNom()."<br />
						    Prénom: ".$user->getPrenom()."<br />
						    Sexe: ".$user->getSexe()."<br />
						    Date de naissance: ".$user->getDate_naissance()."<br />
						    Adresse: ".$user->getAdresse()."<br />
						    E-mail: ".$user->getEmail()."<br /> </h3>

						</fieldset><br />
						";
    echo "<form action='modif_donnees.php' method='post'>
						<input type='submit' name='modif' value='Modifier/Ajouter des données'>
						<input type='submit' name='suppr' value='Supprimer les données'>
						</form>
						</div>";
}
?>