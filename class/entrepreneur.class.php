<?php

class Entrepreneur extends Utilisateur {
   
   // Liste des entreprises géré par l'entrepreneur
   private $_entreprises;
    
    /**
     * Constructeur d'un entrepreneur
     */
    public function __construct($nom, $prenom, $mail, $adresse) {
        
		super($nom, $prenom, $mail, $adresse);
        $_entreprises = array();
		
    }

}