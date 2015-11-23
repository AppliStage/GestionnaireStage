<?php


class Enseignant extends Utilisateur {
	
   private $_affectations;   
   public $_commentaire;
   
   public function __construct() {
	   
	   $this->_affectations = array();
	   $this->_commentaire = array();
	   
   }
   
   public function deposerCommentaire($e) {
      
	  // à compléter
	  
   }
   
   public static function affecterStage($stage) {
      
	  // à compléter
	  
   }

}