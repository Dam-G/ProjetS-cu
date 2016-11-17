<?php

class Proche extends Membre {

	private $_tuteur; 
	private $_id_proches; //donne l'id de ses proches

	public function __construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit, $tuteur, $id_proches){
		parent::__construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit);
		$this->setId_proches($id_proches);
		$this->setTuteur($tuteur);
	}

	public function setTuteur($bool){
		$this->_tuteur=$bool;
	}

	public function getTuteur(){
		return $this->_tuteur;
	}

	public function setId_proches($id_proches){
		$this->_id_proches=$id_proches;
	}

	public function getId_proches(){
		return $this->_id_proches;
	}

}


?>