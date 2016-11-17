<?php

class Soignant extends Membre{

	private $_specialite;
	private $_id_patients;

	public function __construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit,$id_patients){
		parent::__construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit);
		$this->setSpecialite(null);
		$this->setId_patients($id_patients);
	}

	public function setSpecialite($specialite){
		$this->_specialite=$specialite;
	}

	public function getSpecialite(){
		return $this->_specialite;
	}

	public function setId_patients($id_patients){
		$this->_id_patients=$id_patients;
	}

	public function getId_patients(){
		return $this->_id_patients;
	}

}

?>