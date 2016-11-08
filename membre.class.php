<?php

class Membre {
	
	protected $_id;
	protected $_nom;
	protected $_prenom;
	protected $_sexe;
	protected $_date_naissance;
	protected $_pays_naissance;
	protected $_adresse;
	protected $_email;
	protected $_droit;

	public function setAdresse($new_adresse){
		$this->_adresse=$new_adresse;
	}

	public function getAdresse(){
		return $this->_adresse;
	}

	public function setId($new_id){
		$this->_id=$new_id;
	}

	public function getId(){
		return $this->_id;
	}

	public function setNom($new_nom){
		$this->_nom=$new_nom;
	}

	public function getNom(){
		return $this->_nom;
	}

	public function setPrenom($new_prenom){
		$this->_prenom=$new_prenom;
	}

	public function getPrenom(){
		return $this->_prenom;
	}

	public function getSexe(){
		return $this->_sexe;
	}

	public function setDate_naissance($new_date_naissance){
		$this->_date_naissance=$new_date_naissance;
	}

	public function getDate_naissance(){
		return $this->_date_naissance;
	}

	public function setPays_naissance($new_pays_naissance){
		$this->_pays_naissance=$new_pays_naissance;
	}

	public function getPays_naissance(){
		return $this->_pays_naissance;
	}

	public function getDroit(){
		return $this->_droit;
	}

	public function setEmail($new_email){
		$this->_email=$new_email;
	}

	public function getEmail(){
		return $this->_email;
	}

	public function __construct($id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $adresse, $email, $droit){
		$this->_id=$id;
		$this->_nom=$nom;
		$this->_prenom=$prenom;
		$this->_sexe=$sexe;
		$this->_date_naissance=$date_naissance;
		$this->_pays_naissance=$pays_naissance;
		$this->_adresse=$adresse;
		$this->_email=$email;
		$this->_droit=$droit;
	}

}

?>