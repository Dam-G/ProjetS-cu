<?php

class Soignant extends Membre{

	private $_specialite;

	public function __construct($id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $adresse, $email, $droit){
		parent::__construct($id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $adresse, $email, $droit);
		$this->setSpecialite(null);
	}

	public function setSpecialite($specialite){
		$this->_specialite=$specialite;
	}

	public function getSpecialite(){
		return $this->_specialite;
	}

}

?>