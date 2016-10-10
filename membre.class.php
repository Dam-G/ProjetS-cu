<?php

class Membre {
	
	protected $_id;
	protected $_nom;
	protected $_prenom;
	protected $_sexe;
	protected $_adresse;
	protected $_droit;

	public function setAdresse($new_adresse){
		this->$_adresse=$new_adresse;
	}

	public function getAdresse(){
		return this->$_adresse;
	}

	public function getNom(){
		return this->$_nom;
	}

	public function getPrenom(){
		return this->$_prenom;
	}

	public function getSexe(){
		return this->$_sexe;
	}

	public function getDroit(){
		return this->$_droit;
	}

	public function __construct($id, $nom, $prenom, $sexe, $adresse, $droit){
		this->$_id=$id;
		this->$_nom=$nom;
		this->$_prenom=$prenom;
		this->$_sexe=$sexe;
		this->$_adresse=$adresse;
		this->$_droit=$droit;
	}

}

?>