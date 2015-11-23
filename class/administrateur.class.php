<?php

/**Un administrateur n'a pas de constructeur(singleton), il autol */

class Administrateur extends Utilisateur {
   
	public $_stage;
	private $_instance;
    
    private function __construct() {
		
		$_stage = array();
		
	}
	
	public function getInstance() {
		
		if (!isSet($this->_stage)) {
			
			$this->_instance = new Administrateur();
			
		}
		
		return $this->_instance;
		
	}
	
  
	public function valideAffectation( $stage) {
		  
		$this->_stage[] = $stage;
		  
	}
}