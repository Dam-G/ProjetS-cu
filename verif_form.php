<?php

include("function.php");

if (isset($_POST['deconnexion'])) {
	$_SESSION=Array();
	session_destroy();
	setcookie("PHPSESSID", "", time()-3600);
	//Il faut penser à supprimer le cookie !!
}

		if (isset($_POST['valid_inscript']) or isset($_POST['valid_authentif']) or (isset($_POST['modif_passwd'])) or (isset($_POST['rejoindre_groupe']))){ 

			if(isset($_POST['valid_inscript'])){

				$nom=htmlspecialchars($_POST['nom']);
				$prenom=htmlspecialchars($_POST['prenom']);
				$sexe=htmlspecialchars($_POST['sexe']);
				$date_naissance=htmlspecialchars($_POST['date_naissance']);

				//$date_naissance=date_to_sql($date_naissance);

				$pays_naissance=htmlspecialchars($_POST['pays_naiss']);
				$adresse=htmlspecialchars($_POST['adresse']);
				$email=htmlspecialchars($_POST['email']);
				$droit=htmlspecialchars($_POST['type_user']);
				$password=htmlspecialchars($_POST['password']);
				$verif_passwd=htmlspecialchars($_POST['verif_passwd']);
				$captcha = htmlspecialchars($_POST['captcha']);
				$code=mt_rand();

				//Requête pour récupérer la liste des adresse emails dans notre bdd
				$req_emails="SELECT * FROM `handicap`.`authentification`";
				$emails=$bdd->query($req_emails);

				$EXISTE=0;

				while (($donnees = $emails->fetch()) && !$EXISTE){
					if ($donnees['email']==$email) $EXISTE=1;//Si on utilise déjà l'adresse email, le flag EXISTE devient vrai
				}
				

				if(($password==$verif_passwd) && ($_SESSION['captcha']==$captcha) && (!$EXISTE)){

					$passwd_hashe=password_hash($password, PASSWORD_BCRYPT);
					$req="INSERT INTO `handicap`.`authentification` (`email`,`passwd`,`droit`,`actif`, `code`) VALUES ('$email','$passwd_hashe','$droit',1,'$code')";
					$reponse= $bdd->query($req);

					$req2="SELECT * FROM `handicap`.`authentification` WHERE passwd='$passwd_hashe'";
					$reponse2 = $bdd->query($req2);
					$line2=$reponse2->fetch();
					$id = $line2['id'];

					if($droit==1){
						$req3="INSERT INTO `handicap`.`patient` (`id`, `nom`, `prenom`, `sex`, `adresse`,`date_naissance`, `nativecountry`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance', '$pays_naissance')";
						$reponse3=$bdd->query($req3);
					}

					elseif($droit==2){
						$req3="INSERT INTO `handicap`.`proche` (`id`, `nom`, `prenom`, `sex`, `adresse`,`date_naissance`, `nativecountry`, `tuteur`, `id_proches`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance', '$pays_naissance', 0, null)";
						$reponse3=$bdd->query($req3);
					}
					else {
						//TODO

					}

					echo '<script>alert("Inscription validée !");</script>';

					//MAIL //TOFINISH
					/*
					$objet="Confirmation de votre inscription";
					$contenu='
						<html>
						<head>
						   <title>Vous vous êtes inscrit sur la site de gestion du handicap.</title>
						</head>
						<body>
						   <p>Bonjour Mr/Mme '.$nom.'</p>
						   <p>Pour valider votre inscription et activer votre compte, veuillez cliquer sur le lien pour valider.</p>
						   <a href="localhost/ProjetSecu/active.php?code='.$code.'">localhost/ProjetSecu/active.php?code='.$code.'</a>
						</body>
						</html>';
					$entetes =
					'Content-type: text/html; charset=utf-8' . "\r\n" .
					'From: email@domain.fr' . "\r\n" .
					'Reply-To: email@domain.fr' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					//Envoi du mail
					mail($email, $objet, $contenu, $entetes);

					*/

				}
				else{
					?>
					<script type="text/javascript">alert("Erreur d'inscription");</script>
					<?php
				}
			}

			else if(isset($_POST['valid_authentif'])){

				$email=$_POST['email'];
				$password=$_POST['password'];
				$req_auth="SELECT * FROM `handicap`.`authentification` WHERE email='$email'";
				$res_auth = $bdd->query($req_auth);
				$line = $res_auth->fetch();
				if((password_verify($password, $line['passwd'])) && ($line['actif']==1)){
					//session_start();
					$id=$line['id'];
					if($line['droit']==1) $table='patient';
					elseif($line['droit']==2) $table='proche';
					else $table='soignant';

					$req_info="SELECT * FROM `handicap`.`".$table."` WHERE id='$id'";
					$res_info=$bdd->query($req_info);
					$info=$res_info->fetch();

					if($line['droit']==1) {

						$user=new Patient($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit'], $info['id_demandeurs']);

					}
					elseif($line['droit']==2) {

						$user=new Proche($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit'], $info['id_proches']);

					}
					else {

						$user=new Soignant($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit']);

					}

					$_SESSION['user']=serialize($user);

					/*$_SESSION['pseudo']=$id;
					$_SESSION['droit']=$line['droit'];*/
				}
				else{
					?>
					<script type="text/javascript">alert("Erreur d'authentification");</script>
					<?php
				}
			}

			else if(isset($_POST['modif_passwd'])){
				$user=unserialize($_SESSION['user']);
				$id=$user->getId();
				$password=$_POST['password'];
				$new_passwd=$_POST['new_passwd'];
				$confirm_passwd=$_POST['confirm_passwd'];
				$new_passwd_hashe=password_hash($new_passwd, PASSWORD_BCRYPT);
				$req_mdp="SELECT * FROM `handicap`.`authentification` WHERE id='$id'";
				$res_mdp=$bdd->query($req_mdp);
				$line=$res_mdp->fetch();
				if((password_verify($password, $line['passwd'])) && ($new_passwd==$confirm_passwd)){
					$req_maj="UPDATE `handicap`.`authentification` SET `passwd`='$new_passwd_hashe' WHERE id='$id'";
					$maj=$bdd->query($req_maj)
						or die ('Impossible de mettre à jour le mot de passe' . mysql_error());
				}
				else{
					?>
					<script type="text/javascript">alert("Erreur de changement de mot de passe.");</script>
					<?php
				}
			}

			else if(isset($_POST['rejoindre_groupe'])){
				$user=unserialize($_SESSION['user']);
				$user_id=$user->getId();
				$id=htmlspecialchars($_POST['numero']);
				$req_droit="SELECT * FROM `handicap`.`authentification` WHERE id='$id'";
				$info_droit=$bdd->query($req_droit);
				$droit=$info_droit->fetch();
				$droit = $droit['droit'];

				if($droit==1){
					$req_patient="SELECT * FROM `handicap`.`patient` WHERE id='$id'";
					$patient=$bdd->query($req_patient);
					$info_patient=$patient->fetch();

					if(empty($info_patient['id_demandeurs'])){
						$new_demandeurs=$user_id;
					}
					else{
						$new_demandeurs=$info_patient['id_demandeurs']." ".$user_id;
					}

					$req_update="UPDATE `handicap`.`patient` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id'";
					$update=$bdd->query($req_update);
					?>
					<script type="text/javascript">alert("Demande envoyée. En attente de validation.");</script>
					<?php
				}
			}
		}

?>