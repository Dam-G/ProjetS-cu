<?php

include("function.php");

if (isset($_POST['deconnexion'])) {
	$_SESSION=Array();
	session_destroy();
	setcookie("PHPSESSID", "", time()-3600);
	//Il faut penser à supprimer le cookie !!
}

	/*	if (isset($_POST['valid_inscript']) or isset($_POST['valid_authentif']) or (isset($_POST['modif_passwd'])) or (isset($_POST['rejoindre_groupe']))){ */

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

				if (filter_var($email, FILTER_VALIDATE_EMAIL)) $VALIDE=1; //On regarde si c'est une adresse mail valide
				else $VALIDE=0;

				//Requête pour récupérer la liste des adresse emails dans notre bdd
				$req_emails="SELECT * FROM `handicap`.`authentification`";
				$emails=$bdd->query($req_emails);

				$EXISTE=0;

				while (($donnees = $emails->fetch()) && !$EXISTE){
					if ($donnees['email']==$email) $EXISTE=1;//Si on utilise déjà l'adresse email, le flag EXISTE devient vrai
				}
				

				if(($password==$verif_passwd) && ($_SESSION['captcha']==$captcha) && (!$EXISTE) && $VALIDE){

					$passwd_hashe=password_hash($password, PASSWORD_BCRYPT);

					if($droit==3) $actif=0; //Si c'est un medecin, l'admin doit activer le compte
					else $actif=1;

					$req="INSERT INTO `handicap`.`authentification` (`email`,`passwd`,`droit`,`actif`, `code`) VALUES ('$email','$passwd_hashe','$droit','$actif','$code')";
					$reponse= $bdd->query($req);

					$req2="SELECT * FROM `handicap`.`authentification` WHERE passwd='$passwd_hashe'";
					$reponse2 = $bdd->query($req2);
					$line2=$reponse2->fetch();
					$id = $line2['id'];

					if($droit==1){
						$req3="INSERT INTO `handicap`.`patient` (`id`, `nom`, `prenom`, `sex`, `adresse`,`date_naissance`, `nativecountry`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance', '$pays_naissance')";
						$reponse3=$bdd->query($req3);

						$req4="INSERT INTO `handicap`.`groupes` (`id`, `id_demandeurs`, `id_membres`) VALUES ('$id', null, null)";
						$reponse4=$bdd->query($req4);
					}

					elseif($droit==2){
						$req3="INSERT INTO `handicap`.`proche` (`id`, `nom`, `prenom`, `sex`, `adresse`,`date_naissance`, `nativecountry`, `tuteur`, `id_proches`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance', '$pays_naissance', 0, null)";
						$reponse3=$bdd->query($req3);
					}
					else {
						$req3="INSERT INTO `handicap`.`soignant` (`id`, `nom`, `prenom`, `sex`, `adresse`,`date_naissance`, `nativecountry`, `specialite`, `liste_patient`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance', '$pays_naissance', null, null)";
						$reponse3=$bdd->query($req3);
						//TODO

					}

					if ($droit==3) echo '<script>alert("Inscription validée, un administrateur doit maintenant activer votre compte");</script>';
					else echo '<script>alert("Inscription validée !");</script>';

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
					elseif($line['droit']==3) $table='soignant';

					if (isset($table)){
						$req_info="SELECT * FROM `handicap`.`".$table."` WHERE id='$id'";
						$res_info=$bdd->query($req_info);
						$info=$res_info->fetch();
					}

					if ($line['droit']==0){
						$user=new Membre($id,null, null, null, null, null, null, $email, $line['droit']);
					}
					else if($line['droit']==1) {

						$req_groupe="SELECT * FROM `handicap`.`groupes` WHERE id='$id'";
						$res_groupe=$bdd->query($req_groupe);
						$groupe=$res_groupe->fetch();

						$user=new Patient($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit'], $groupe['id_demandeurs']);

					}
					else if($line['droit']==2) {

						$user=new Proche($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit'], $info['id_proches']);

					}
					else {

						$user=new Soignant($id,$info['nom'], $info["prenom"], $info['sex'], $info['date_naissance'], $info['nativecountry'], $info['adresse'], $email, $line['droit'], $info['liste_patient']);

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
					$req_patient="SELECT * FROM `handicap`.`groupes` WHERE id='$id'";
					$patient=$bdd->query($req_patient);
					$info_patient=$patient->fetch();

					if(empty($info_patient['id_demandeurs'])){
						$new_demandeurs=$user_id;
					}
					else{
						$new_demandeurs=$info_patient['id_demandeurs']." ".$user_id;
					}

					if(!in_array($user_id, explode(' ', $info_patient['id_demandeurs']))){//Pour éviter qu'un proche fasse plusieurs fois une même demande
						$req_update="UPDATE `handicap`.`groupes` SET `id_demandeurs`='$new_demandeurs' WHERE id='$id'";
						$update=$bdd->query($req_update);}
					?>
					<script type="text/javascript">alert("Demande envoyée. En attente de validation.");</script>
					<?php
				}
			}

			else if (isset($_POST['ajout_patient'])){
				$user=unserialize($_SESSION['user']);
				$id_medecin=$user->getID();
				$email_patient=$_POST['email'];
				$req_id="SELECT * FROM `handicap`.`authentification` WHERE email LIKE '$email_patient'";
				$res=$bdd->query($req_id);
				$info=$res->fetch();
				$id_patient=$info['id'];

				$req2="SELECT * FROM `handicap`.`soignant` WHERE id='$id_medecin'";
				$res2=$bdd->query($req2);
				$liste_pat=$res2->fetch();
				$liste_patient=$liste_pat['liste_patient'];

				if(empty($liste_pat['liste_patient'])){
					echo "<script>alert('true');</script>";
					$new_liste_patient=$id_patient;
				}
				else $new_liste_patient=$liste_patient." ".$id_patient;


				$user->setId_patients($new_liste_patient);

				//echo "<script>alert('".$user->getId_patients()."');</script>";

				$req_ajout_patient="UPDATE `handicap`.`soignant` SET `liste_patient`='$new_liste_patient' WHERE id='$id_medecin'";
				$res=$bdd->query($req_ajout_patient);
			}
		//}

?>