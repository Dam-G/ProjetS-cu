<?php

class Patient extends Membre {
 
	private $_data1;
	private $_data2;

	public function __construct($id, $nom, $prenom, $sexe, $date_naissance, $adresse, $email, $droit){
		parent::__construct($id, $nom, $prenom, $sexe, $date_naissance, $adresse, $email, $droit);
		$this->setData1(null);
		$this->setData2(null);
	}


	public function setData1($new_data){
		$this->_data1=$new_data;
	}

	public function setData2($new_data){
		$this->_data2=$new_data;
	}

	public function getData1(){
		return $this->_data1;
	}

	public function getData2(){
		return $this->_data2;
	}

}


?>