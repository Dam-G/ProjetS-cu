<?php

class Patient extends Membre {
 
	private $_data1;
	private $_data2;
	private $_id_demandeurs;

	public function __construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit, $id_demandeurs){
		parent::__construct($id, $nom, $prenom, $sexe, $age, $pays_naissance, $adresse, $email, $droit);
		$this->setId_demandeurs($id_demandeurs);
		$this->setData1(null);
		$this->setData2(null);
	}


	public function setData1($new_data){
		$this->_data1=$new_data;
	}

	public function setData2($new_data){
		$this->_data2=$new_data;
	}

	public function setId_demandeurs($new_id_demandeurs){
		$this->_id_demandeurs=$new_id_demandeurs;
	}

	public function getData1(){
		return $this->_data1;
	}

	public function getData2(){
		return $this->_data2;
	}

	public function getId_demandeurs(){
		return $this->_id_demandeurs;
	}

}


?>