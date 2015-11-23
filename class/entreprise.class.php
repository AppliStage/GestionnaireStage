<?php

class Entreprise {
   
   // Nom de l'entreprise
   private $_nom;
   
   // Adresse de l'entreprise
   private $_adresse;
   // Téléphone de l'entreprise
   
   private $_tel;
   // Type d'entreprise
   
   private $_type;
   // Liste des commentaire laissé par les enseignants
   
   private $_avis;   
   private $_stages;    
   
   /**
    * Constructeur d'un entrepris,
    * La liste des Avis et des stages sont défini si l'entreprise exist dans la BD.
    */
   function __construct($nom, $adresse, $tel, $type) {
      
	  $this->_nom = $nom;
	  $this->_adresse = $adresse;
	  $this->_tel = $tel;
	  $this->_type = $type;
	  $this->_avis = array();
	  $this->_stages = array();
	  
   }
   
   /** 
    * Ajoute un stage à la liste des offres de l'entreprise
    * @param s
    */
   public function ajouterOffre( $s) {
      
	  $this->_stages[] = $s;
	  
   }
   
   /** 
    * Supprime l'offre de stage passer en parametre 
    * @param s stage à supprimer
    * @return True si l'offre à été supprimer, false sinon.
    */
	public function supprOffre( $s) {
      
      //apres
	  
	}

}