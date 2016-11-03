<?php

	session_start();

	function nombre($n)
	{
		/*retourne une chaîne de caractère composé d'un nombre aléatoire compris entre 0
		et (10^$n)-1, complété de 5 "0" par la gauche*/
		return str_pad(mt_rand(0,pow(10,$n)-1),$n,'0',STR_PAD_LEFT);
	}

	function image($mot)
	{
		$size = 32;
		$marge=2;
		$font='./master_of_break.ttf';
		$box = imagettfbbox($size, 0, $font, $mot);

		$largeur = $box[2] - $box[0];
		$largeur_lettre = round($largeur/strlen($mot));
		$hauteur = $box[1] - $box[7];
		$img = imagecreate($largeur, $hauteur);
		$blanc = imagecolorallocate($img, 255, 255, 255);
		$noir = imagecolorallocate($img, 0, 0, 0);
		$red = imagecolorallocate($img, 255, 0, 0);
		$blue = imagecolorallocate($img, 0, 0, 255);
		$milieuHauteur = ($hauteur / 2) - 8;
		//imagestring($img, 6, strlen($mot) /2 , $milieuHauteur, $mot, $noir);
		//imagettftext($img, $size, 0,$marge,$hauteur, $noir, $font, $mot);

		for($i = 0; $i < strlen($mot);++$i)
		{
			$l = $mot[$i];
			$angle = mt_rand(-10,10); // Angle au hasard
			imagettftext($img,$size,$angle,($i*$largeur_lettre)+$marge, $hauteur+mt_rand(0,$marge/2),$noir, $font, $l);	
		}

		imagerectangle($img, 1, 1, $largeur - 1, $hauteur - 1, $noir); // La bordure

		 // Flou Gaussien
		$matrix_blur = array(
		array(1,2,1),
		array(2,2,2),
		array(1,2,1));

		imageconvolution($img, $matrix_blur,16,0); // On applique la matrice, avec un diviseur 16

		imageline($img, 2, $milieuHauteur + 10, $largeur - 2, $milieuHauteur , $noir);//Barre noire fixe
		imageline($img, 2,mt_rand(2,$hauteur), $largeur - 2, mt_rand(2,$hauteur), $blue);//Barre noire aléatoire

		//Fond noir hachuré
		for($x = 5; $x < $largeur; $x+=6)
		{
			imageline($img, $x,2,$x-5,$hauteur,$red);
		}




		imagepng($img);
		imagedestroy($img);

	}

	function captcha()
	{
		$mot = nombre(5);
		$_SESSION['captcha'] = $mot;
		image($mot);
	}

	header("Content-type: image/png");
	captcha();

?>