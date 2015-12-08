<?php

class Stage {
   // Debut d'un stage
   private $_dateDebut =null;
   // Fin d'un stage
   private $_dateFin = null;
   // Titre d'un stage
   private $_titre = null;
   // Description d'un stage
   private $_description = null;
   // Identifiant d'un stage, si il est enregistrer
   private $_id = null;
   
   // L'entreprise qui accueil
   private $_entreprise = null;
   // Enseignant garant du stage
   private $_garantStage = null;
   
   /**
    * Constructeur d'un Stage, 
    * L'id et le garant sont defnit si le stage à déjà été enregistrer.
    */
   public function __construct($dateDebut, $dateFin, $titre, $description, $entreprise){
      // TODO: implement
   }

   /**
    * Enregistre le stage dans la base de donnée.
    * Vérifi si la description et le titre ne contiennent pas de caractéres spéciaux.
    */
   public function enregistrer(){
      // TODO: implement
      return false;
   }

}
