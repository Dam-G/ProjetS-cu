<?php

class Proche extends Membre {

	private $_tuteur; //booléen qui indique si le proche est tuteur d'un patient
	private $_id_proche; //donne l'id de son proche

	public function __construct($id, $nom, $prenom, $sexe, $date_naissance, $adresse, $email, $droit){
		parent::__construct($id, $nom, $prenom, $sexe, $date_naissance, $adresse, $email, $droit);
		$this->setTuteur(false);
		$this->setIdProche(null);
	}

	public function setTuteur($bool){
		$this->_tuteur=$bool;
	}

	public function getTuteur(){
		return $this->_id_proche;
	}

	public function setIdProche($id_proche){
		$this->_id_proche=$id_proche;
	}

	public function getIdProche(){
		return $this->_id_proche;
	}

}


?>