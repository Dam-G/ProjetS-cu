<?php

if (isset($_POST['deconnexion'])) {
	$_SESSION=Array();
	session_destroy();
}

		if (isset($_POST['valid_inscript']) or isset($_POST['valid_authentif']) or (isset($_POST['modif_passwd']))){ //A remplacer par les submit ??

			if(isset($_POST['valid_inscript'])){

				$nom=$_POST['nom'];
				$prenom=$_POST['prenom'];
				$sexe=$_POST['sexe'];
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

					$req2="SELECT * FROM `handicap`.`authentification` WHERE passwd='$passwd_hashe'";
					$reponse2 = $bdd->query($req2);
					$line2=$reponse2->fetch();
					$id = $line2['id'];

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

			else if(isset($_POST['valid_authentif'])){

				$email=$_POST['email'];
				$password=$_POST['password'];
				$req_auth="SELECT * FROM `handicap`.`authentification` WHERE email='$email'";
				$res_auth = $bdd->query($req_auth);
				$line = $res_auth->fetch();
				if(password_verify($password, $line['passwd'])){
					//session_start();
					$id=$line['id'];
					if($line['droit']==1) $table='patient';
					elseif($line['droit']==2) $table='proche';
					else $table='soignant';

					$req_info="SELECT * FROM `handicap`.`".$table."` WHERE id='$id'";
					$res_info=$bdd->query($req_info);
					$info=$res_info->fetch();

					$user=new Membre($id,$info['nom'], $info["prenom"], $info['sexe'], $info['date_naissance'], $info['adresse'], $email, $line['droit']);
					
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
		}

?>