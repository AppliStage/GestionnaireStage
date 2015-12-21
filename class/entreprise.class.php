<?php

class Entreprise {
   
   // Nom de l'entreprise
   private $nom;
   
   // Adresse de l'entreprise
   private $adresse;

   // Téléphone de l'entreprise
   private $tel;

   // Type d'entreprise
   private $type;

   // Liste des commentaire laissé par les enseignants
   private $avis;

   //Liste des offre de l'entreprise.
   private $stages;    
   
   /**
    * Constructeur d'une entreprise,
    * La liste des Avis et des stages sont défini si l'entreprise exist dans la BD.
    */
   public function __construct($nom, $adresse, $tel, $type) {
      
	  $this->nom = $nom;
	  $this->adresse = $adresse;
	  $this->tel = $tel;
	  $this->type = $type;
	  $this->avis = array();
	  $this->stages = array();
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
    * @param s id du stage à supprimer
    * @return True si l'offre à été supprimer, false sinon.
    */
	public function supprOffre($s) {      
      unset($this->_stages[$s]);
	}

}
