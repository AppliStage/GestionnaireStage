<?php

include_once "myPDO.include.php";

class Entreprise {
   
   private $numEntreprise ="";
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

   private $entrepreneur; //Observeur de l'objet


    public function __construct(){ }
   
    /**
     * Construit toutes les entreprise d'un entrepreneur
     * @return un tableau d'entreprise.
     */
    public static function creatFromId($entrepreneur){
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
	}
        return $listEntreprise;
    }

    /**
     * Alerte l'observeur qu'une entreprise lui à été attribué
     */
    private function notifyAjoutObs(){
	$this->entrepreneur->notifyAjout($this);
    }

    /**
     * Alerte l'observeur qu'une entreprise à été modifié
     */
    private function notifyUpdateObs(){
	$this->entrepreneur->notifyUpdate($this);
    }

   /** 
    * Ajoute un stage à la liste des offres de l'entreprise
    * @param s
    */
    public function ajouterOffre( $s) {
        $this->stages[] = $s;
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
		$this->notifyUpdateObs();
	}else{

        $req1 = $pdo->prepare(<<<SQL
            INSERT INTO Entreprise (numEntreprise, nom, tel, adresse, typeJuridique,site, ville, pays, SIRET, SIREN, codeAPE, logo, numEntrepreneur,codePostal)
            VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?)
SQL
        );
        $ins = $req1->execute(array($this->nom, $this->tel, $this->adresse, $this->typeJuridique, 
          $this->site, $this->ville, $this->pays, $this->SIRET, $this->SIREN, $this->codeAPE, $this->logo, $this->entrepreneur->getId(), $this->codePostal));
	
	// Si la BD a été modidé, on prévient l'entrepreneur
	if ($ins)
	    $this->notifyAjoutObs();
	}
    }

   
   /** 
    * Supprime l'offre de stage passer en parametre dans l'instance 
    * @param s id du stage à supprimer
    * @return True si l'offre à été supprimer, false sinon.
    */
	public function supprOffre($s) {      
	    unset($this->_stages[$s]);
	}

  //SETTER TO DO: .... 
  // modifie la base de donnée Ou fais appel à save(). On fera appel au moins couteux

  //GETTER TO DO: ....

    public function getNom(){
      return $this->nom;
    }

    public function getId(){
	return $this->numEntreprise;
    }

}
