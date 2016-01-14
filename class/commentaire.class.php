<?php
include_once 'autoload.inc.php';

/** Commentaire laissé par l'enseignant, aprés son passage dans une entreprise */
class Commentaire {
	
   //Contenu du commentaire
   private $id;
   private $loginEnseignant;
   private $contenu;
   private $dateEnvoi;
   private $numEntreprise;

    /**
    * Construire un commentaire
    */
    public function __construct (){

    }

    /**
     * Usine à commentaire. Construit tous les commentaires d'un entreprise
     * @throws si le parametre n'est pas une instance de la class entreprise
     */
    public static function createFromEntreprise($idEntreprise){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numCommentaire AS 'id', loginEnseignant, contenu, dateEnvoi
          FROM Commentaire
          WHERE numEntreprise= ?
SQL
        );
        $req->execute(array($idEntreprise));
        $listCommentaire = $req->fetchAll(PDO::FETCH_CLASS, "Commentaire");
        return $listCommentaire;
    }

    public function getContenu(){
      return $this->contenu;
    }

    public function getDate(){
      return $this->dateEnvoi;
    }

    public function getNumEnseignant(){
      return $this->loginEnseignant;
    }

    public function getNumEntreprise(){
      return $this->loginEnseignant;
    }    
}