<?php

/** Commentaire laissé par l'enseignant, aprés son passage dans une entreprise */
class Commentaire {
	
   //Contenu du commentaire
   private  $_contenu;

    /**
    * Construire un commentaire
    */
    public function __construct ( $contenu){
       
		$this->_contenu = $contenu;
	   
    }

}