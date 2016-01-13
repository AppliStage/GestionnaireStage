<?php

/** Commentaire laissé par l'enseignant, aprés son passage dans une entreprise */
class Commentaire {
	
   //Contenu du commentaire
   private  $contenu;
   private $dateEnvoi;
   private $Enseignant;

    /**
    * Construire un commentaire
    */
    public function __construct ($nom, $contenu, $date){
	     $this->enseignant = $nom;
       $$this->contenu = $contenu;
       $this->dateEnvoi = $date;
    }

    public function getContenu(){
      return $this->contenu;
    }

    public function getDate(){
      return $this->dateEnvoi;
    }

    public function getEnseignant(){
      return $this->loginEnseignant;
    }
}