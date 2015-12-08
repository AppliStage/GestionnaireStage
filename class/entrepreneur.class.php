<?php

class Entrepreneur extends Utilisateur {
   
   // Liste des entreprises géré par l'entrepreneur
   private $_entreprises;
    
    /**
     * Constructeur d'un entrepreneur
     */
    public function __construct($nom, $prenom, $mail, $adresse) {
	    	$this->nom = $nom;
	    	$this->nom = $prenom;
	    	$this->nom = $mail;
	    	$this->nom = $adresse;
		$_entreprises = array();
		
    }

}
