<?php
require_once 'commentaire.class.php';
include_once "myPDO.include.php";
require_once 'stage.class.php';
require_once "autoload.inc.php";

class Entreprise {
   
   private $numEntreprise ;
   private $nom;
   private $tel;
   private $adresse;
   private $typeJuridique;
   private $site;
   private $ville;
   private $pays;
   private $SIRET;
   private $SIREN;
   private $codeAPE;
   private $logo;
   private $avis = array(); // Liste des commentaire laissé par les enseignants
   private $stages =  array(); //Liste des offre de l'entreprise.
   private $codePostal;

   private $entrepreneur = null; //Observeur de l'objet


    public function __construct(){ }
   
    /**
     * Construit toutes les entreprise d'un entrepreneur
     * @return un tableau d'entreprise.
     */
    public static function creatFromEntrepreneur($entrepreneur){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numEntreprise, nom, tel, adresse, typeJuridique,site, ville, pays, SIRET, SIREN, codeAPE, logo, numEntrepreneur,codePostal
          FROM Entreprise
          WHERE numEntrepreneur = ?
SQL
        );
        $req->execute(array( $entrepreneur->getId() ));
      	$listEntreprise = $req->fetchAll(PDO::FETCH_CLASS, "Entreprise");

      	//Chaques entreprise crée a comme observeur l'entrepreneur passer en parametre
      	foreach($listEntreprise as $entreprise){
      		$entreprise->entrepreneur = $entrepreneur;
          $entreprise->stage = Stage::creatFromEntreprise($entreprise);

          //Création d'un stage
          $req1 = $pdo->prepare(<<<SQL
            SELECT nom, prenom, contenu, dateEnvoi 
            FROM Enseignant e, Commentaire c
            WHERE e.loginEnseignant = c.loginEnseignant
            AND numEntreprise = ?
SQL
          );
          $req1->execute(array($entrepreneur->getId()));
          $entreprise->avis = Commentaire::createFromEntreprise($entreprise->getId());       
      	}
        return $listEntreprise;
    }




   /**
    * Construi un stage en fonction de son identifiant
    * @param le numero de stage 
    * @return une instance de stage
    */
   public static function creatFromId($id){
        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numEntreprise, nom, tel, adresse, typeJuridique,site, ville, pays, SIRET, SIREN, codeAPE, logo, numEntrepreneur,codePostal
          FROM Entreprise
          WHERE numEntreprise= ?
SQL
        );
        $req->execute(array($id));
        $req->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
        if(($entreprise = $req->fetch()) != null){
          $entreprise->stage = Stage::creatFromEntreprise($entreprise);

          $req1 = $pdo->prepare(<<<SQL
            SELECT nom, prenom, contenu, dateEnvoi 
            FROM Enseignant e, Commentaire c
            WHERE e.loginEnseignant = c.loginEnseignant
            AND numEntreprise = ?
SQL
          );
          $req1->execute(array($id));
          $entreprise->avis = Commentaire::createFromEntreprise($entreprise->getId());
          return $entreprise;
        }
        return null;
  }





    /**
     * Alerte l'observeur qu'une entreprise lui à été attribué
     */
    private function notifyObs(){
      $this->entrepreneur->notify();
    }

    /**
     * Sauvegarde l'entreprise dans la base de donnée, si l'entreprise 
     * n'exite pas encore, sinon elle met à jour les données qu'elle contient.
     * @return true si l'entreprise à été enregisté, false sinon
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
    	        UPDATE Entreprise
    	        SET nom, tel, adresse, typeJuridique,site, ville, pays, SIRET, SIREN, codeAPE, logo, numEntrepreneur,codePostal
    	        WHERE nom = ? 
    	        AND tel= ? 
    	        AND  adresse= ? 
    	        AND  typeJuridique= ? 
    	        AND site= ? AND  ville= ? 
    	        AND  pays= ? AND  SIRET= ? 
    	        AND  SIREN= ? AND  codeAPE= ? 
    	        AND  logo= ? AND  numEntrepreneur= ? 
    	        AND codePostal= ?
SQL
            );
            $update = $req->execute(array($this->nom, $this->tel, $this->adresse, $this->typeJuridique, 
          $this->site, $this->ville, $this->pays, $this->SIRET, $this->SIREN, $this->codeAPE, $this->logo, $this->entrepreneur->getId(), $this->codePostal));
	
      	    if($update)
      		    $this->notifyObs();

	      }else{

          $req1 = $pdo->prepare(<<<SQL
              INSERT INTO Entreprise (numEntreprise, nom, tel, adresse, typeJuridique,site, ville, pays, SIRET, SIREN, codeAPE, logo, numEntrepreneur,codePostal)
              VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?)
SQL
          );
          $ins = $req1->execute(array($this->nom, $this->tel, $this->adresse, $this->typeJuridique, 
            $this->site, $this->ville, $this->pays, $this->SIRET, $this->SIREN, $this->codeAPE, $this->logo, (int)$this->entrepreneur->getId(), $this->codePostal));
  	
          	// Si la BD a été modidé, on prévient l'entrepreneur
          	if ($ins)
          	    $this->notifyObs();
      	}
    }




  /**
   * Réinitialise la lites de stage de l'objet courrant
   * @param L'entreprise rajouté
   */
  public function notify(){
    //$this->notifyObs();
    $this->stage = Stage::creatFromEntreprise($this);
  }






   /** 
    * Supprime l'offre de stage passer en parametre dans l'instance 
    * @param s id du stage à supprimer
    * @return True si l'offre à été supprimer, false sinon.
    */
	public function supprOffre($s) {      
	    unset($this->stages[$s]);
	}

  //SETTER TO DO: .... 
  // modifie la base de donnée Ou fais appel à save(). On fera appel au moins couteux

  public function setNom($nom){
    $this->nom = $nom;
	}

  public function setTel($tel){
    $this->tel = $tel;
  }

  public function setAdresse($adresse){
    $this->adresse = $adresse;
  }

  public function setTypeJuridique($type){
    $this->typeJuridique = $type;
  }

  public function setSite($site){
    $this->site = $site;
  }

  public function setPays($pays){
    $this->pays = $pays;
  }

  public function setSIRET($s){
    $this->SIRET = $s;
  }

  public function setSIREN($s){
    $this->SIREN = $s;
  }

  public function setCodeAPE($c){
    $this->codeAPE = $c;
  }

  public function setLogo($logo){
    $this->logo = $logo;
  }

  public function setVille($ville){
    $this->ville = $ville;
  }

  public function setCodePostal($c){
    $this->codePostal = $c;
  }

  public function setEntrepreneur($c){
    $this->entrepreneur = $c;
  }



  //GETTER TO DO: ....  /////////////////////////////////////////////////////

    public function getNom(){
      return $this->nom;
    }

    public function getId(){
	   return $this->numEntreprise;
    }

  public function getTel(){
    return $this->tel ;
  }

  public function getAdresse(){
    return $this->adresse;
  }

  public function getTypeJuridique(){
    return $this->typeJuridique ;
  }

  public function getSite(){
    return $this->site ;
  }

  public function getPays(){
    return $this->pays ;
  }

  public function getSIRET(){
    return $this->SIRET ;
  }

  public function getSIREN(){
    return $this->SIREN;
  }

  public function getCodeAPE(){
    return $this->codeAPE ;
  }

  public function getLogo(){
    return $this->logo;
  }

  public function getVille(){
    return $this->ville ;
  }

  public function getCodePostal(){
    return $this->codePostal;
  }

  public function getEntrepreneur(){
    return $this->entrepreneur ;
  }

  public function getAvis(){
    return $this->avis;
  }

}
