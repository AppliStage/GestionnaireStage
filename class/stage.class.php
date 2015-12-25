<?php
include_once "entreprise.class.php";

class Stage {
   // Titre d'un stage
   private $titre;
   // Debut d'un stage
   private $dateDebut;
   // Fin d'un stage
   private $dateFin;
   // Description d'un stage
   private $description;
   // Identifiant d'un stage, si il est enregistrer
   private $id;
   //Domaine du stage
   private $domaine;
   // L'entreprise qui accueil
   private $entreprise;
   // Enseignant garant du stage
   private $gratification;
   
   /**
    * Constructeur d'un Stage, 
    */
   public function __construct(){ }


   /**
    * Construit tous les stages d'une entreprise
    * @param un objet entreprise
    * @return un Array()
    */
   public static getAll($entreprise){
      if (is_object($entreprise) && $entreprise instanceof Entreprise){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numStage AS 'id', titre, dateFin, dateDebut, description, domain, nbPoste, gratification, numEntreprise
          FROM Stage
          WHERE numEntreprise = ?
SQL
        );
        $req->execute(array( $this->entreprise->getId() ));
        $listEntreprise = $req->fetchAll(PDO::FETCH_CLASS, "Entreprise");

        //Chaques entreprise crée a comme observeur l'entrepreneur passer en parametre
        foreach($listEntreprise as $entreprise){
          $entreprise->entrepreneur = $entrepreneur;
        }
        return $listEntreprise;
      }
      else 
        throw wrongEntryException();
   }

   /**
    * Enregistre le stage dans la base de donnée.
    * 
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
