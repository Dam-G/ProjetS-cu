<?php

if (isset($_POST['deconnexion'])) {
	$_SESSION=Array();
	session_destroy();
}

		if (isset($_POST['pseudo']) or isset($_POST['email']) or (isset($_POST['new_passwd']))){ //A remplacer par les submit ??

			if(isset($_POST['pseudo'])){

				$nom=$_POST['nom'];
				$prenom=$_POST['prenom'];
				$date_naissance=$_POST['date_naissance'];
				$adresse=$_POST['adresse'];
				$email=$_POST['email'];
				$droit=$_POST['type_user'];
				$password=$_POST['password'];
				$verif_passwd=$_POST['verif_passwd'];
				if($password==$verif_passwd){
					$passwd_hashe=password_hash($password, PASSWORD_BCRYPT);
					$req="INSERT INTO `handicap`.`authentification` (`email`,`passwd`,`droit`) VALUES ('$email','$passwd_hashe','$droit')";
					$reponse= $bdd->query($req);

					$req2="SELECT id FROM `handicap`.`authentification` WHERE passwd=$passwd_hashe";
					$reponse2=$bdd->query($req2);
					$id=$reponse2->fetch();

					if($droit==1){
						$req3="INSERT INTO `handicap`.`patient` (`id`, `nom`, `prenom`, `sexe`, `adresse`,`date_naissance`) VALUES ('$id','$nom','$prenom', '$sexe', '$adresse', '$date_naissance')";
						$reponse3=$bdd->query($req3);
					}
					elseif($droit==2){
						//TODO
					}
					else {
						//TODO

					}

					

				}
				else{
					?>
					<script type="text/javascript">alert("Erreur d'inscription");</script>
					<?php
				}
			}

			else if(isset($_POST['email'])){

				$id=$_POST['email'];
				$password=$_POST['password'];
				$req_auth="SELECT * FROM `handicap`.`authentification` WHERE email='$id'";
				$res_auth = $bdd->query($req_auth);
				$line = $res_auth->fetch();
				if(password_verify($password, $line['passwd'])){
					//session_start();

					if($line['droit']==1) $table=patient;
					elseif($line['droit']==2) $table=proche;
					else $table=soignant;

					$req_info="SELECT * FROM `handicap`.`".$table."`";
					$res_info=$bdd->query($res_info_patient);
					$info=$res_info_patient->fetch();

					$user=new Membre($id,$info['nom'], $info["prenom"], $info['sexe'], $info['adresse'], $line['droit']);
					
					$_SESSION['user']=$user;

					/*$_SESSION['pseudo']=$id;
					$_SESSION['droit']=$line['droit'];*/
				}
				else{
					?>
					<script type="text/javascript">alert("Erreur d'authentification");</script>
					<?php
				}
			}

			else if(isset($_POST['new_passwd'])){
				$pseudo=$_SESSION['pseudo'];
				$password=$_POST['password'];
				$new_passwd=$_POST['new_passwd'];
				$confirm_passwd=$_POST['confirm_passwd'];
				$new_passwd_hashe=password_hash($new_passwd, PASSWORD_BCRYPT);
				$req_mdp="SELECT * FROM `handicap`.`authentification` WHERE pseudo='$pseudo'";
				$res_mdp=$bdd->query($req_mdp);
				$line=$res_mdp->fetch();
				if((password_verify($password, $line['passwd'])) && ($new_passwd==$confirm_passwd)){
					$req_maj="UPDATE `handicap`.`authentification` SET `passwd`='$new_passwd_hashe' WHERE pseudo='$pseudo'";
					$maj=$bdd->query($req_maj)
						or die ('Impossible de mettre à jour le mot de passe' . mysql_error());
				}
				else{
					?>
					<script type="text/javascript">alert("Erreur de changement de mot de passe.");</script>
					<?php
				}
			}
		}

?>