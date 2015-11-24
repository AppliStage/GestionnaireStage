<?php



class Enseignant extends Utilisateur {
	
   private $_affectations;   
   public $_commentaire;
   
   /**
    * Constructeur d'un enseignant
    */
   
   public function __construct() {
	   
	 
	   $this->_affectations = array();
	   $this->_commentaire = array();
	   
   }
   
   /**
    * Ajoute un commentaire à la liste de commentaires.
    * @param Commentaire $e
    */
   public function deposerCommentaire($e) {
      
	  $this->_commentaire[] = $e;
	  
   }
   
   /**
    * Ajoute un stage à la liste de stages.
    * @param Stage $stage
    */
   public static function affecterStage($stage) {
      
	  $this->_affectations[] = $stage;
	  
   }

}