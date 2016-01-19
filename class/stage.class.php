<?php
include_once "entreprise.class.php";
include_once "myPDO.include.php";

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
   private $id = null;
   //Domaine du stage
   private $domaine;
   // Enseignant garant du stage
   private $gratification;
   //Nombre de postes
   private $nbPoste;

   private $dateCreation;

   //Observeur sur l'objet
   private $entreprise = null;
   



   /**
    * Constructeur d'un Stage, 
    */
   public function __construct(){ }





   /**
    * Construit tous les stages d'une entreprise
    * @param un objet entreprise
    * @return un Array()
    */
   public static function creatFromEntreprise($entreprise){
      if (is_object($entreprise) && $entreprise instanceof Entreprise){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numStage AS 'id', titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, numEntreprise, dateCreation
          FROM Stage
          WHERE numEntreprise = ?
SQL
        );
        $req->execute(array($entreprise->getId() ));
        $listStage = $req->fetchAll(PDO::FETCH_CLASS, "Stage");

        //Chaques entreprise crée a comme observeur l'entrepreneur passer en parametre
        foreach($listStage as $stage){
          $stage->entreprise = $entreprise;
        }
        return $listStage;
      }
      else 
        throw wrongEntryException("Le parametre n'est pas une instance de la class Stage");
   }




   /**
    * Construi un stage en fonction de son identifiant
    * @param le numero de stage 
    * @return une instance de stage
    */
   public static function creatFromId($id){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numStage AS 'id', titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, numEntreprise AS 'entreprise', dateCreation
          FROM Stage
          WHERE numStage = ?
SQL
        );
        $req->execute(array($id));
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        return $req->fetch();
  }





   /**
    * Enregistre le stage dans la base de donnée.
    * 
    */
   public function save(){
        $pdo = myPDO::getInstance();

        //Vérifie si le stage exite pas déjà.
        if($this->id != null){

            $req = $pdo->prepare(<<<SQL
              UPDATE Stage
              SET titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, dateCreation
              WHERE numEntreprise = ?
              AND titre = ?
              AND dateFin= ? 
              AND  dateDebut= ? 
              AND  description= ? 
              AND domaine= ? AND  nbPoste = ? 
              AND gratification= ?
              AND dateCreation = now()
SQL
            );
            $update = $req->execute(array($this->entreprise->getId(), $this->titre, $this->dateFin, $this->dateDebut, 
            $this->description, $this->domaine, $this->nbPoste, $this->gratification) );
  
            if($update)
              $this->notifyObs();

        }else{

          $req1 = $pdo->prepare(<<<SQL
              INSERT INTO Stage (numStage, titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, numEntreprise, dateCreation)
              VALUES('',?,?,?,?,?,?,?,?, now())
SQL
          );
          $ins = $req1->execute(array( $this->titre, $this->dateFin, $this->dateDebut, 
            $this->description, $this->domaine, $this->nbPoste, $this->gratification, $this->entreprise->getId() ));
    
            // Si la BD a été modidé, on prévient l'entrepreneur
            if ($ins)
                $this->notifyObs();
        }
   }



    /**
     * Alerte l'observeur qu'une entreprise lui à été attribué
     */
    private function notifyObs(){
      $this->entreprise->notify();
    }


    //Setter
    public function setTitre($titre){
      $this->titre = $titre;
    }

    public function setDateFin($f){
      $this->dateFin= $f;
    }

    public function setDateDebut($d){
      $this->dateDebut = $d;
    }

    public function setDescription($f){
      $this->description = $f;
    }

    public function setDomaine($d){
      $this->domaine = $d;
    }

    public function setNbPoste($d){
      $this->nbPoste = $d;
    }

    public function setGratification($d){
      $this->gratification = $d;
    }

    public function setEntreprise($d){
      $this->entreprise = $d;
    }

    //Getter//////////////////////////////////////////////////////////////////////


    public function getId(){
      return $this->id ;
    }

    public function getTitre(){
      return $this->titre ;
    }

    public function getDateFin(){
      return $this->dateFin ;
    }

    public function getDate(){
      return $this->dateCreation ;
    }

    public function getDateDebut(){
      return $this->dateDebut ;
    }

    public function getDateCreation(){
      return $this->dateCreation ;
    }

    public function getDescription(){
      return $this->description ;
    }

    public function getDomaine(){
      return $this->domaine ;
    }

    public function getNbPoste(){
      return $this->nbPoste ;
    }

    public function getGratification(){
      return $this->gratification;
    }

    public function getEntreprise(){
      return $this->entreprise ;
    }

}
