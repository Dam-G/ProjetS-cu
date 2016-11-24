<?php

function date_to_sql($date){
	if (strpos($date, '/')){
		$tab=explode('/', $date);
		$date_retour=$tab[2].'-'.$tab[1].'-'.$tab[0];
	}
	else $date_retour="0000-00-00";

	return $date_retour;
}

function sql_to_date($date){
	$tab=explode('-', $date);
	$date_retour=$tab[2].'/'.$tab[1].'/'.$tab[0];

	return $date_retour;

}

function filtrage($texte){

	$texte=strip_tags($texte);

	$texte=htmlspecialchars($texte);
	
	return $texte;
}



?>
