<?php

class Patient extends Membre {
 
	private $data1;
	private $data2;

	public function setData1($new_data){
		$this->data1=$new_data;
	}

	public function setData2($new_data){
		$this->data2=$new_data;
	}

	public function getData1(){
		return $this->data1;
	}

	public function getData2(){
		return $this->data2;
	}

}


?>