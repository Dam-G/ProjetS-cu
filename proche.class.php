<?php

class Proche extends Membre {

	private $_tuteur; //booléen qui indique si le proche est tuteur d'un patient
	private $_id_proches; //donne l'id de ses proches

	public function __construct($id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $adresse, $email, $droit, $id_proches){
		parent::__construct($id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $adresse, $email, $droit);
		$this->setId_proches($id_proches);
		$this->setTuteur(false);
	}

	public function setTuteur($bool){
		$this->_tuteur=$bool;
	}

	public function getTuteur(){
		return $this->_id_proche;
	}

	public function setId_proches($id_proches){
		$this->_id_proches=$id_proches;
	}

	public function getId_proches(){
		return $this->_id_proches;
	}

}


?>