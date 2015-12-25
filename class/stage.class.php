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
   public function __construct(){
      
   }

   public static getAll($entreprise){

   }

   /**
    * Enregistre le stage dans la base de donnée.
    * Vérifi si la description et le titre ne contiennent pas de caractéres spéciaux.
    */
   public function save(){
        $pdo = myPDO::getInstance();

        //Vérifie si l'entreprise exite pas déjà.
        $req = $pdo->prepare(<<<SQL
          SELECT 'a'
          FROM Entreprise
          WHERE SIRET = ?
SQL
      );
        $req->execute(array($this->SIRET));
        if($req->fetch() != false){

            $req = $pdo->prepare(<<<SQL
              UPDATE Stage
              SET titre, dateFin, dateDebut, description, domain, nbPoste, gratification
              WHERE numEntreprise = ?
              AND titre = ?
              AND dateFin= ? 
              AND  dateDebut= ? 
              AND  description= ? 
              AND domaine= ? AND  nbPoste = ? 
              AND gratification= ?
SQL
            );
            $update = $req->execute(array($this->entreprise->getId(), $this->titre, $this->dateFin, $this->dateDebut, 
            $this->description, $this->domaine, $this->nbPoste, $this->gratification ) );
  
            if($update)
              $this->notifyObs();

        }else{

          $req1 = $pdo->prepare(<<<SQL
              INSERT INTO Stage (numStage, titre, dateFin, dateDebut, description, domain, nbPoste, gratification, numEntreprise)
              VALUES('',?,?,?,?,?,?,?,?)
SQL
          );
          $ins = $req1->execute(array( $this->titre, $this->dateFin, $this->dateDebut, 
            $this->description, $this->domaine, $this->nbPoste, $this->gratification, $this->entreprise->getId()) );
    
            // Si la BD a été modidé, on prévient l'entrepreneur
            if ($ins)
                $this->notifyObs();
        }
   }

}
