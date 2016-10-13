<?php

if (isset($_POST['deconnexion'])) {
	$_SESSION=Array();
	session_destroy();
}

		if (isset($_POST['pseudo']) or isset($_POST['identifiant']) or (isset($_POST['new_passwd']))){

			if(isset($_POST['pseudo'])){

				$pseudo=$_POST['pseudo'];
				$droit=$_POST['type_user'];
				$password=$_POST['password'];
				$verif_passwd=$_POST['verif_passwd'];
				if($password==$verif_passwd){
					$passwd_hashe=password_hash($password, PASSWORD_BCRYPT);
					$req="INSERT INTO `handicap`.`authentification` (`pseudo`,`passwd`,`droit`) VALUES ('$pseudo','$passwd_hashe','$droit')";
					$reponse= $bdd->query($req);
				}
				else{
					?>
					<script type="text/javascript">alert("Erreur d'inscription");</script>
					<?php
				}
			}

			else if(isset($_POST['identifiant'])){

				$id=$_POST['identifiant'];
				$password=$_POST['password'];
				$req_auth="SELECT * FROM `handicap`.`authentification` WHERE pseudo='$id'";
				$res_auth = $bdd->query($req_auth);
				$line = $res_auth->fetch();
				if(password_verify($password, $line['passwd'])){
					//session_start();
					$_SESSION['pseudo']=$id;
					$_SESSION['droit']=$line['droit'];
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